@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="section-body">

    {{-- Page Header --}}
    <div class="col-12 bg-white mb-3 pb-2 pt-2">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="mb-0">Riwayat Transaksi</h1>
                <div class="breadcrumb-item active">
                    <a href="{{ url('dashboard') }}">Dashboard</a>
                    <span>/ Transaksi</span>
                </div>
            </div>
            <div class="text-right">
                <div class="text-muted small" id="periodLabel">Memuat...</div>
                <div class="text-muted" style="font-size:.72rem;" id="periodSub"></div>
            </div>
        </div>
    </div>

    {{-- ── Summary Cards ──────────────────────────────────────── --}}
    <div class="row mb-4" id="summaryCards">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
            <div class="card summary-card summary-card-blue">
                <div class="card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="summary-card-info">
                        <div class="summary-card-label">Total Transaksi</div>
                        <div class="summary-card-value" id="sc-count">—</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
            <div class="card summary-card summary-card-green">
                <div class="card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="summary-card-info">
                        <div class="summary-card-label">Total Pendapatan</div>
                        <div class="summary-card-value" id="sc-revenue">—</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
            <div class="card summary-card summary-card-orange">
                <div class="card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="summary-card-info">
                        <div class="summary-card-label">Rata-rata / Transaksi</div>
                        <div class="summary-card-value" id="sc-avg">—</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
            <div class="card summary-card summary-card-purple">
                <div class="card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="summary-card-info">
                        <div class="summary-card-label">Item Terjual</div>
                        <div class="summary-card-value" id="sc-items">—</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Payment Breakdown + Tab ─────────────────────────────── --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">

                {{-- Card Header: Tabs + Payment Breakdown --}}
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
                    {{-- Tab Nav --}}
                    <ul class="nav nav-pills period-tabs mb-0" id="periodTabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-period="daily">
                                <i class="fas fa-calendar-day mr-1"></i> Hari Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-period="weekly">
                                <i class="fas fa-calendar-week mr-1"></i> Minggu Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-period="monthly">
                                <i class="fas fa-calendar-alt mr-1"></i> Bulan Ini
                            </a>
                        </li>
                    </ul>

                    {{-- Payment Breakdown Badges --}}
                    <div id="paymentBreakdown" class="d-flex flex-wrap align-items-center" style="gap:6px;">
                        <small class="text-muted mr-1">Metode:</small>
                        <span class="text-muted small payment-bd-placeholder">Memuat...</span>
                    </div>
                </div>

                {{-- DataTable --}}
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover w-100 mb-0" id="transactionsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="40">No</th>
                                    <th>Nomor Nota</th>
                                    <th>Waktu</th>
                                    <th>Kasir</th>
                                    <th>Pelanggan</th>
                                    <th>Item</th>
                                    <th>Total</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th width="60" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

{{-- ── Order Detail Modal ─────────────────────────────────── --}}
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-receipt text-primary mr-2"></i>
                    Detail Transaksi
                    <small class="text-muted font-weight-normal ml-2" id="od-number"></small>
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" id="orderDetailBody">
                <div class="text-center py-4">
                    <i class="fas fa-spinner fa-spin text-primary fa-2x"></i>
                    <p class="text-muted mt-2 small">Memuat detail...</p>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-outline-primary btn-sm" id="printOrderBtn">
                    <i class="fas fa-print mr-1"></i> Cetak Struk
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="{{ asset('stisla-assets/modules/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<style>
    /* ── Summary Cards ─────────────────────────────────────── */
    .summary-card {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }
    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,.1) !important;
    }
    .summary-card .card-body {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 18px 20px;
    }
    .summary-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .summary-card-label {
        font-size: .73rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .summary-card-value {
        font-size: 1.3rem;
        font-weight: 700;
        line-height: 1.2;
    }

    /* Color variants */
    .summary-card-blue   { background: linear-gradient(135deg, #667eea, #764ba2); }
    .summary-card-green  { background: linear-gradient(135deg, #43e97b, #38f9d7); }
    .summary-card-orange { background: linear-gradient(135deg, #f7971e, #ffd200); }
    .summary-card-purple { background: linear-gradient(135deg, #f093fb, #f5576c); }

    .summary-card-blue   .summary-card-icon   { background: rgba(255,255,255,.2); color: #fff; }
    .summary-card-green  .summary-card-icon   { background: rgba(255,255,255,.2); color: #fff; }
    .summary-card-orange .summary-card-icon   { background: rgba(255,255,255,.2); color: #fff; }
    .summary-card-purple .summary-card-icon   { background: rgba(255,255,255,.2); color: #fff; }

    .summary-card-blue   .summary-card-label,
    .summary-card-blue   .summary-card-value  { color: rgba(255,255,255,.92); }
    .summary-card-green  .summary-card-label,
    .summary-card-green  .summary-card-value  { color: rgba(0,60,40,.85); }
    .summary-card-orange .summary-card-label,
    .summary-card-orange .summary-card-value  { color: rgba(80,40,0,.85); }
    .summary-card-purple .summary-card-label,
    .summary-card-purple .summary-card-value  { color: rgba(255,255,255,.92); }

    /* ── Period Tabs ───────────────────────────────────────── */
    .period-tabs .nav-link {
        font-size: .8rem;
        border-radius: 8px;
        color: #6c757d;
        padding: 6px 14px;
        transition: all .15s;
    }
    .period-tabs .nav-link:hover  { background: #f0f1ff; color: #6777ef; }
    .period-tabs .nav-link.active {
        background: #6777ef;
        color: #fff;
        box-shadow: 0 3px 10px rgba(103,119,239,.35);
    }

    /* ── Payment Breakdown badges ──────────────────────────── */
    .payment-bd-item {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f8f9ff;
        border: 1px solid #e4e6fc;
        border-radius: 20px;
        padding: 2px 10px;
        font-size: .72rem;
        font-weight: 600;
    }
    .payment-bd-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* ── DataTable tweaks ──────────────────────────────────── */
    #transactionsTable thead th {
        border-top: none;
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: #9ca3af;
        font-weight: 600;
    }
    #transactionsTable tbody td {
        vertical-align: middle;
        font-size: .83rem;
    }
    .order-number-cell {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: #374151;
        font-size: .8rem;
    }
    .time-cell-main  { font-weight: 600; color: #374151; font-size: .82rem; }
    .time-cell-sub   { font-size: .7rem; color: #9ca3af; }
    .cashier-cell    { font-size: .8rem; font-weight: 500; }
    .customer-cell   { font-size: .78rem; color: #6c757d; }
    .total-cell      { font-weight: 700; color: #6777ef; font-size: .85rem; }

    /* Empty state */
    .dataTables_empty { padding: 0 !important; }
    .dt-empty-state   { padding: 48px 24px; text-align: center; }
    .dt-empty-icon    {
        width: 72px; height: 72px; border-radius: 50%;
        background: #f0f1ff; border: 2px dashed #c7cdf8;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
    }
    .dt-empty-icon i  { font-size: 28px; color: #6777ef; opacity: .7; }

    /* ── Order Detail Modal ────────────────────────────────── */
    .od-info-row {
        display: flex; justify-content: space-between;
        padding: 5px 0; border-bottom: 1px solid #f0f1f7;
        font-size: .83rem;
    }
    .od-info-row:last-child { border-bottom: none; }
    .od-info-label  { color: #9ca3af; }
    .od-info-value  { font-weight: 600; color: #374151; }
    .od-item-row {
        display: flex; justify-content: space-between;
        align-items: flex-start; padding: 8px 0;
        border-bottom: 1px solid #f5f6ff; font-size: .83rem;
    }
    .od-item-row:last-child { border-bottom: none; }
    .od-item-name   { font-weight: 600; color: #374151; }
    .od-item-sub    { font-size: .72rem; color: #9ca3af; }
    .od-item-price  { font-weight: 700; color: #6777ef; white-space: nowrap; margin-left: 8px; }
    .od-total-row   { display: flex; justify-content: space-between; padding: 6px 0; font-size: .85rem; }
    .od-grand-total { font-size: 1rem; font-weight: 700; color: #6777ef; }
    .od-section-title {
        font-size: .7rem; text-transform: uppercase; letter-spacing: .5px;
        font-weight: 700; color: #9ca3af; margin-bottom: 8px; margin-top: 14px;
    }

    /* Spinner loading state */
    .summary-skeleton {
        background: linear-gradient(90deg, rgba(255,255,255,.2) 25%, rgba(255,255,255,.35) 50%, rgba(255,255,255,.2) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.2s infinite;
        border-radius: 4px; height: 28px; width: 80%;
    }
    @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
</style>
@endpush

@push('script')
<script src="{{ asset('stisla-assets/modules/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(document).ready(function () {
    'use strict';

    const DATA_URL    = '{{ route('transactions.data') }}';
    const SUMMARY_URL = '{{ route('transactions.summary') }}';
    const SHOW_URL    = '{{ route('transactions.show', ':id') }}';

    const PAYMENT_COLORS_MAP = {
        success: '#28a745', info: '#17a2b8', primary: '#6777ef', warning: '#ffc107', secondary: '#6c757d'
    };

    let currentPeriod = 'daily';
    let dtTable       = null;
    let currentOrder  = null;

    /* ── DataTable init ──────────────────────────────────── */
    function initTable(period) {
        if (dtTable) {
            dtTable.ajax.url(DATA_URL + '?period=' + period).load();
            return;
        }

        dtTable = $('#transactionsTable').DataTable({
            processing : true,
            serverSide : true,
            ajax       : { url: DATA_URL + '?period=' + period, type: 'GET' },
            columns    : [
                { data: 'DT_RowIndex',    orderable: false, searchable: false, width: '40px' },
                { data: 'order_number',   render: (d) => `<span class="order-number-cell">${d}</span>` },
                { data: 'time_fmt',       orderable: false, searchable: false,
                  render: (d, _, row) => `<div class="time-cell-main">${d}</div><div class="time-cell-sub">${row.date_fmt}</div>` },
                { data: 'cashier_name',   orderable: false, searchable: false,
                  render: (d) => `<span class="cashier-cell">${d}</span>` },
                { data: 'customer',       orderable: false, searchable: false,
                  render: (d) => `<span class="customer-cell">${d}</span>` },
                { data: 'items_label',    orderable: false, searchable: false, className: 'text-center' },
                { data: 'total_fmt',      orderable: false, searchable: false,
                  render: (d) => `<span class="total-cell">${d}</span>` },
                { data: 'payment_badge',  orderable: false, searchable: false },
                { data: 'status_badge',   orderable: false, searchable: false },
                { data: 'action',         orderable: false, searchable: false, className: 'text-center' },
            ],
            order       : [[1, 'desc']],
            language    : {
                processing : '<div class="text-center py-3"><i class="fas fa-spinner fa-spin text-primary mr-2"></i>Memuat data...</div>',
                emptyTable : `<div class="dt-empty-state">
                                <div class="dt-empty-icon"><i class="fas fa-receipt"></i></div>
                                <h6 class="font-weight-600 text-muted">Belum ada transaksi</h6>
                                <p class="text-muted small">Tidak ada transaksi pada periode yang dipilih.</p>
                              </div>`,
                zeroRecords: `<div class="dt-empty-state">
                                <div class="dt-empty-icon"><i class="fas fa-search"></i></div>
                                <h6 class="font-weight-600 text-muted">Data tidak ditemukan</h6>
                              </div>`,
                search            : '',
                searchPlaceholder : 'Cari nomor nota, kasir...',
                lengthMenu        : 'Tampilkan _MENU_ data',
                info              : 'Menampilkan _START_–_END_ dari _TOTAL_ transaksi',
                infoEmpty         : 'Tidak ada data',
                paginate          : { first:'&laquo;', last:'&raquo;', next:'&rsaquo;', previous:'&lsaquo;' },
            },
            pageLength  : 15,
            lengthMenu  : [[10, 15, 25, 50], [10, 15, 25, 50]],
            dom         : "<'row align-items-center'<'col-sm-6'l><'col-sm-6'f>>" +
                          "<'row'<'col-sm-12'tr>>" +
                          "<'row align-items-center mt-3'<'col-sm-5'i><'col-sm-7'p>>",
        });
    }

    /* ── Summary cards ───────────────────────────────────── */
    function loadSummary(period) {
        setCardSkeleton();
        $.getJSON(SUMMARY_URL + '?period=' + period, function (data) {
            $('#sc-count').text(data.count);
            $('#sc-revenue').text(data.revenue_fmt);
            $('#sc-avg').text(data.count > 0 ? data.average_fmt : '—');
            $('#sc-items').text(data.total_items);
            $('#periodLabel').text(periodTitle(period));
            $('#periodSub').text(data.period_label);
            renderPaymentBreakdown(data.payment_breakdown);
        });
    }

    function setCardSkeleton() {
        ['sc-count','sc-revenue','sc-avg','sc-items'].forEach(id => {
            $('#' + id).html('<div class="summary-skeleton"></div>');
        });
    }

    function renderPaymentBreakdown(breakdown) {
        const $bd = $('#paymentBreakdown').empty();
        $bd.append('<small class="text-muted mr-1">Metode:</small>');
        if (!breakdown || !breakdown.length) {
            $bd.append('<span class="text-muted small">—</span>');
            return;
        }
        breakdown.forEach(m => {
            const dot = PAYMENT_COLORS_MAP[m.color] || '#999';
            $bd.append(`
                <span class="payment-bd-item">
                    <span class="payment-bd-dot" style="background:${dot};"></span>
                    ${m.label} <strong>${m.count}×</strong>
                </span>`);
        });
    }

    function periodTitle(period) {
        return { daily:'Hari Ini', weekly:'Minggu Ini', monthly:'Bulan Ini' }[period] || '';
    }

    /* ── Tab click ───────────────────────────────────────── */
    $('#periodTabs .nav-link').on('click', function (e) {
        e.preventDefault();
        if ($(this).hasClass('active')) return;

        $('#periodTabs .nav-link').removeClass('active');
        $(this).addClass('active');

        currentPeriod = $(this).data('period');
        loadSummary(currentPeriod);
        initTable(currentPeriod);
    });

    /* ── Order Detail ────────────────────────────────────── */
    window.viewOrder = function (id) {
        const url = SHOW_URL.replace(':id', id);
        $('#orderDetailBody').html(
            '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-primary fa-2x"></i>' +
            '<p class="text-muted mt-2 small">Memuat detail...</p></div>'
        );
        $('#od-number').text('');
        $('#orderDetailModal').modal('show');

        $.getJSON(url, function (res) {
            const d = res.data;
            currentOrder = d;

            $('#od-number').text(d.order_number);
            $('#printOrderBtn').off('click').on('click', () => printOrderDetail(d));

            /* Build detail HTML */
            const methodColors = { cash:'success', transfer:'info', qris:'primary', card:'warning' };
            const mColor = methodColors[d.payment_method] || 'secondary';

            const itemsHtml = (d.items || []).map(item => `
                <div class="od-item-row">
                    <div>
                        <div class="od-item-name">${item.product_name}</div>
                        <div class="od-item-sub">${item.variant_label} / ${item.size_name} &nbsp;×${item.qty}</div>
                    </div>
                    <div class="od-item-price">Rp ${Number(item.subtotal).toLocaleString('id-ID')}</div>
                </div>`).join('');

            const changeRow = d.payment_method === 'cash'
                ? `<div class="od-total-row"><span class="text-muted">Kembalian</span><span class="font-weight-700 text-success">${d.change_fmt}</span></div>`
                : '';

            $('#orderDetailBody').html(`
                <div class="od-section-title"><i class="fas fa-info-circle mr-1"></i> Informasi Transaksi</div>
                <div class="od-info-row"><span class="od-info-label">Tanggal</span><span class="od-info-value">${d.date_fmt}</span></div>
                <div class="od-info-row"><span class="od-info-label">Kasir</span><span class="od-info-value">${d.cashier?.name ?? '—'}</span></div>
                <div class="od-info-row"><span class="od-info-label">Pelanggan</span><span class="od-info-value">${d.customer_name ?? 'Pelanggan Umum'}</span></div>
                <div class="od-info-row"><span class="od-info-label">Metode Bayar</span>
                    <span><span class="badge badge-${mColor}">${d.payment_label}</span></span>
                </div>
                ${d.notes ? `<div class="od-info-row"><span class="od-info-label">Catatan</span><span class="od-info-value">${d.notes}</span></div>` : ''}

                <div class="od-section-title mt-3"><i class="fas fa-list mr-1"></i> Item (${(d.items||[]).length})</div>
                <div>${itemsHtml}</div>

                <div class="od-section-title"><i class="fas fa-calculator mr-1"></i> Ringkasan</div>
                <div class="od-total-row"><span class="text-muted">Subtotal</span><span>${d.subtotal_fmt}</span></div>
                <div class="od-total-row"><span class="text-muted">PPN (11%)</span><span>${d.tax_fmt}</span></div>
                ${Number(d.discount_amount) > 0
                    ? `<div class="od-total-row"><span class="text-success">Diskon</span><span class="text-success">-${d.discount_fmt}</span></div>`
                    : ''}
                <hr class="my-2">
                <div class="od-total-row"><span class="font-weight-700">Total</span><span class="od-grand-total">${d.total_fmt}</span></div>
                <div class="od-total-row"><span class="text-muted">Dibayar (${d.payment_label})</span><span>${d.paid_fmt}</span></div>
                ${changeRow}
            `);
        }).fail(() => {
            $('#orderDetailBody').html('<p class="text-danger text-center py-3">Gagal memuat detail transaksi.</p>');
        });
    };

    /* ── Print struk dari detail modal ──────────────────── */
    function printOrderDetail(d) {
        const items = (d.items || []).map(item => `
            <div style="margin-bottom:5px;">
                <div style="font-weight:600;">${item.product_name}</div>
                <div style="font-size:10px;color:#666;">${item.variant_label} / ${item.size_name}</div>
                <div style="display:flex;justify-content:space-between;">
                    <span>${item.qty} × Rp ${Number(item.unit_price).toLocaleString('id-ID')}</span>
                    <span>Rp ${Number(item.subtotal).toLocaleString('id-ID')}</span>
                </div>
            </div>`).join('');

        const changeRow = d.payment_method === 'cash'
            ? `<div style="display:flex;justify-content:space-between;font-weight:700;color:#2d7a2d;">
                 <span>Kembalian</span><span>${d.change_fmt}</span></div>`
            : '';

        const win = window.open('', '_blank', 'width=400,height=650');
        win.document.write(`<!DOCTYPE html><html><head>
            <meta charset="UTF-8"><title>Struk ${d.order_number}</title>
            <style>
                body{font-family:'Courier New',monospace;font-size:12px;padding:12px;max-width:300px;margin:0 auto;}
                .center{text-align:center;} .bold{font-weight:700;} .muted{color:#666;font-size:10px;}
                .row{display:flex;justify-content:space-between;margin:3px 0;}
                .divider{border:none;border-top:1px dashed #999;margin:6px 0;}
                .total{font-size:14px;font-weight:700;}
            </style></head><body>
            <div class="center bold" style="font-size:14px;">{{ config('app.name') }}</div>
            <div class="center muted">Point of Sale</div>
            <div class="center muted">${d.order_number}</div>
            <div class="center muted">${d.date_fmt}</div>
            <div class="center muted">Kasir: ${d.cashier?.name ?? '—'}</div>
            <hr class="divider">
            ${items}
            <hr class="divider">
            <div class="row"><span>Subtotal</span><span>${d.subtotal_fmt}</span></div>
            <div class="row"><span>PPN 11%</span><span>${d.tax_fmt}</span></div>
            ${Number(d.discount_amount) > 0 ? `<div class="row" style="color:green"><span>Diskon</span><span>-${d.discount_fmt}</span></div>` : ''}
            <hr class="divider">
            <div class="row total"><span>TOTAL</span><span>${d.total_fmt}</span></div>
            <div class="row"><span>Bayar (${d.payment_label})</span><span>${d.paid_fmt}</span></div>
            ${changeRow}
            <hr class="divider">
            <div class="center muted">Terima kasih telah berbelanja!</div>
            <script>window.onload=function(){window.print();window.close();}<\/script>
        </body></html>`);
        win.document.close();
    }

    /* ── Init ────────────────────────────────────────────── */
    loadSummary('daily');
    initTable('daily');
});
</script>
@endpush
