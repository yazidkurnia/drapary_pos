<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StockMovement;
use App\Models\VariantSizeStock;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Proses checkout dari keranjang POS.
     *
     * @param array $payload {
     *   cart: [{pid, vid, sizeId, name, price, qty, sku, label}],
     *   subtotal, tax, discount, total,
     *   payment_method, amount_paid, change_amount,
     *   customer_name, notes
     * }
     */
    public function checkout(array $payload, int $cashierId): Order
    {
        return DB::transaction(function () use ($payload, $cashierId) {
            $this->validateStock($payload['cart']);

            $order = Order::create([
                'order_number'    => Order::generateOrderNumber(),
                'cashier_id'      => $cashierId,
                'customer_name'   => $payload['customer_name'] ?? null,
                'subtotal'        => $payload['subtotal'],
                'tax_amount'      => $payload['tax'],
                'discount_amount' => $payload['discount'],
                'total_amount'    => $payload['total'],
                'payment_method'  => $payload['payment_method'],
                'amount_paid'     => $payload['amount_paid'],
                'change_amount'   => $payload['change_amount'],
                'notes'           => $payload['notes'] ?? null,
                'status'          => 'paid',
            ]);

            foreach ($payload['cart'] as $item) {
                OrderItem::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item['vid'],
                    'size_id'            => $item['sizeId'],
                    'product_name'       => $item['name'],
                    'variant_label'      => $item['label'],
                    'sku'                => $item['sku'],
                    'size_name'          => $item['sizeName'] ?? '',
                    'unit_price'         => $item['price'],
                    'qty'                => $item['qty'],
                    'subtotal'           => $item['price'] * $item['qty'],
                ]);

                // Kurangi stok
                VariantSizeStock::where('product_variant_id', $item['vid'])
                    ->where('size_id', $item['sizeId'])
                    ->decrement('stock', $item['qty']);

                // Catat pergerakan stok
                StockMovement::create([
                    'product_variant_id' => $item['vid'],
                    'size_id'            => $item['sizeId'],
                    'type'               => 'sale',
                    'qty'                => -$item['qty'],
                    'reference_type'     => Order::class,
                    'reference_id'       => $order->id,
                    'notes'              => "Order #{$order->order_number}",
                    'created_by'         => $cashierId,
                ]);
            }

            return $order->load('items');
        });
    }

    /** Validasi stok semua item sebelum transaksi dimulai. */
    private function validateStock(array $cart): void
    {
        foreach ($cart as $item) {
            $sizeStock = VariantSizeStock::where('product_variant_id', $item['vid'])
                ->where('size_id', $item['sizeId'])
                ->value('stock') ?? 0;

            if ($sizeStock < $item['qty']) {
                throw new \RuntimeException(
                    "Stok \"{$item['name']} / {$item['sizeName']}\" tidak mencukupi. " .
                    "Tersedia: {$sizeStock}, diminta: {$item['qty']}."
                );
            }
        }
    }
}
