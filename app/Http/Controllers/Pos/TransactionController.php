<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    private const PAYMENT_LABELS = [
        'cash'     => 'Tunai',
        'transfer' => 'Transfer',
        'qris'     => 'QRIS',
        'card'     => 'Kartu',
    ];

    private const PAYMENT_COLORS = [
        'cash'     => 'success',
        'transfer' => 'info',
        'qris'     => 'primary',
        'card'     => 'warning',
    ];

    public function index()
    {
        return view('pages.transactions.index');
    }

    /** AJAX endpoint untuk DataTable — difilter berdasarkan period */
    public function data(Request $request)
    {
        $query = Order::with('cashier')
                      ->withCount('items')
                      ->orderByDesc('created_at');

        $this->applyPeriodFilter($query, $request->get('period', 'daily'));

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('cashier_name', fn($r) => e($r->cashier?->name ?? '-'))
            ->addColumn('customer',     fn($r) => e($r->customer_name ?? 'Pelanggan Umum'))
            ->addColumn('items_label',  fn($r) => $r->items_count . ' item')
            ->addColumn('total_fmt',    fn($r) => 'Rp ' . number_format($r->total_amount, 0, ',', '.'))
            ->addColumn('time_fmt',     fn($r) => Carbon::parse($r->created_at)->format('H:i'))
            ->addColumn('date_fmt',     fn($r) => Carbon::parse($r->created_at)->format('d M Y'))
            ->addColumn('payment_badge', function ($r) {
                $label = self::PAYMENT_LABELS[$r->payment_method] ?? $r->payment_method;
                $color = self::PAYMENT_COLORS[$r->payment_method] ?? 'secondary';
                return '<span class="badge badge-' . $color . '">' . $label . '</span>';
            })
            ->addColumn('status_badge', function ($r) {
                return $r->status === 'paid'
                    ? '<span class="badge badge-success">Lunas</span>'
                    : '<span class="badge badge-danger">Batal</span>';
            })
            ->addColumn('action', fn($r) =>
                '<button class="btn btn-sm btn-icon btn-outline-primary"
                         onclick="viewOrder(' . $r->id . ')"
                         title="Lihat Detail">
                     <i class="fas fa-eye"></i>
                 </button>'
            )
            ->rawColumns(['payment_badge', 'status_badge', 'action'])
            ->make(true);
    }

    /** AJAX endpoint untuk summary cards */
    public function summary(Request $request)
    {
        $period = $request->get('period', 'daily');

        $q = Order::where('status', 'paid');
        $this->applyPeriodFilter($q, $period);
        $orders = $q->get();

        $orderIds = $orders->pluck('id');

        $totalItems = $orderIds->isNotEmpty()
            ? OrderItem::whereIn('order_id', $orderIds)->sum('qty')
            : 0;

        $revenue  = $orders->sum('total_amount');
        $count    = $orders->count();
        $average  = $count > 0 ? ($revenue / $count) : 0;

        $paymentBreakdown = $orders->groupBy('payment_method')
            ->map(fn($g) => [
                'count'  => $g->count(),
                'total'  => $g->sum('total_amount'),
                'label'  => self::PAYMENT_LABELS[$g->first()->payment_method] ?? '-',
                'color'  => self::PAYMENT_COLORS[$g->first()->payment_method] ?? 'secondary',
            ])->values();

        return response()->json([
            'count'              => $count,
            'revenue'            => $revenue,
            'revenue_fmt'        => 'Rp ' . number_format($revenue, 0, ',', '.'),
            'average'            => $average,
            'average_fmt'        => 'Rp ' . number_format($average, 0, ',', '.'),
            'total_items'        => $totalItems,
            'payment_breakdown'  => $paymentBreakdown,
            'period_label'       => $this->periodLabel($period),
        ]);
    }

    /** AJAX endpoint untuk detail order */
    public function show(Order $order)
    {
        $order->load(['cashier', 'items']);

        return response()->json([
            'status' => 'success',
            'data'   => array_merge($order->toArray(), [
                'total_fmt'       => 'Rp ' . number_format($order->total_amount,   0, ',', '.'),
                'subtotal_fmt'    => 'Rp ' . number_format($order->subtotal,       0, ',', '.'),
                'tax_fmt'         => 'Rp ' . number_format($order->tax_amount,     0, ',', '.'),
                'discount_fmt'    => 'Rp ' . number_format($order->discount_amount,0, ',', '.'),
                'paid_fmt'        => 'Rp ' . number_format($order->amount_paid,    0, ',', '.'),
                'change_fmt'      => 'Rp ' . number_format($order->change_amount,  0, ',', '.'),
                'payment_label'   => self::PAYMENT_LABELS[$order->payment_method] ?? $order->payment_method,
                'date_fmt'        => Carbon::parse($order->created_at)->format('d M Y, H:i'),
            ]),
        ]);
    }

    private function applyPeriodFilter($query, string $period): void
    {
        match ($period) {
            'weekly'  => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'monthly' => $query->whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year),
            default   => $query->whereDate('created_at', today()),
        };
    }

    private function periodLabel(string $period): string
    {
        return match ($period) {
            'weekly'  => now()->startOfWeek()->format('d M') . ' – ' . now()->endOfWeek()->format('d M Y'),
            'monthly' => now()->format('F Y'),
            default   => now()->format('d F Y'),
        };
    }
}
