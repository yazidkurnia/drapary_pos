<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function store(Request $request)
    {
        $request->validate([
            'cart'                 => 'required|array|min:1',
            'cart.*.vid'           => 'required|integer|exists:product_variants,id',
            'cart.*.sizeId'        => 'required|integer|exists:sizes,id',
            'cart.*.name'          => 'required|string',
            'cart.*.label'         => 'required|string',
            'cart.*.sizeName'      => 'required|string',
            'cart.*.sku'           => 'required|string',
            'cart.*.price'         => 'required|numeric|min:0',
            'cart.*.qty'           => 'required|integer|min:1',
            'subtotal'             => 'required|numeric|min:0',
            'tax'                  => 'required|numeric|min:0',
            'discount'             => 'required|numeric|min:0',
            'total'                => 'required|numeric|min:0',
            'payment_method'       => 'required|in:cash,transfer,qris,card',
            'amount_paid'          => 'required|numeric|min:0',
            'change_amount'        => 'required|numeric|min:0',
        ]);

        try {
            $order = $this->orderService->checkout(
                $request->all(),
                auth()->id()
            );

            return response()->json([
                'status'       => 'success',
                'message'      => 'Pembayaran berhasil',
                'order_id'     => $order->id,
                'order_number' => $order->order_number,
            ]);
        } catch (\RuntimeException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 422);
        }
    }

    public function show(Order $order)
    {
        $order->load(['cashier', 'items']);

        return response()->json([
            'status' => 'success',
            'data'   => $order,
        ]);
    }
}
