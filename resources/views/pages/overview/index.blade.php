@extends('layouts.app')

@section('title', 'Overview')

@section('content')

<div class="section-header bg-white my-3 px-3 py-3">
{{-- Greeting Bar --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap" style="gap:12px;">
        <div>
            <h2 class="section-title" id="greetingText">—</h2>
            <p class="section-lead mb-0" id="todayDate">—</p>
        </div>
        <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
            <div class="input-group input-group-sm" style="width:190px;">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0">
                        <i class="fas fa-calendar-alt text-muted"></i>
                    </span>
                </div>
                <select class="form-control form-control-sm border-left-0" id="periodSelect">
                    <option value="7">7 Hari Terakhir</option>
                    <option value="30" selected>30 Hari Terakhir</option>
                    <option value="90">3 Bulan</option>
                    <option value="365">1 Tahun</option>
                </select>
            </div>
            <button class="btn btn-primary btn-sm btn-icon icon-left shadow-primary" id="exportBtn">
                <i class="fas fa-download"></i> Export
            </button>
            <button class="btn btn-outline-secondary btn-sm btn-icon" id="refreshBtn" title="Refresh">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>
</div>

<div class="section-body">

    {{-- ROW 1 : STAT CARDS --}}
    <div class="row">

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
            <div class="ov-card ov-card--blue" style="animation-delay:.05s">
                <div class="ov-card__bg-icon"><i class="fas fa-chart-line"></i></div>
                <div class="ov-card__body">
                    <p class="ov-card__label">Total Pendapatan</p>
                    <h3 class="ov-card__value">Rp 48,2 Jt</h3>
                    <div class="d-flex align-items-center" style="gap:7px;">
                        <span class="ov-badge ov-badge--up"><i class="fas fa-arrow-up"></i> 12.4%</span>
                        <small class="ov-card__vs">vs bulan lalu</small>
                    </div>
                </div>
                <div class="ov-card__spark"><canvas id="sparkRevenue"></canvas></div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
            <div class="ov-card ov-card--green" style="animation-delay:.1s">
                <div class="ov-card__bg-icon"><i class="fas fa-receipt"></i></div>
                <div class="ov-card__body">
                    <p class="ov-card__label">Total Transaksi</p>
                    <h3 class="ov-card__value">1.284</h3>
                    <div class="d-flex align-items-center" style="gap:7px;">
                        <span class="ov-badge ov-badge--up"><i class="fas fa-arrow-up"></i> 8.7%</span>
                        <small class="ov-card__vs">vs bulan lalu</small>
                    </div>
                </div>
                <div class="ov-card__spark"><canvas id="sparkTxn"></canvas></div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
            <div class="ov-card ov-card--orange" style="animation-delay:.15s">
                <div class="ov-card__bg-icon"><i class="fas fa-boxes"></i></div>
                <div class="ov-card__body">
                    <p class="ov-card__label">Produk Terjual</p>
                    <h3 class="ov-card__value">3.890</h3>
                    <div class="d-flex align-items-center" style="gap:7px;">
                        <span class="ov-badge ov-badge--up"><i class="fas fa-arrow-up"></i> 5.2%</span>
                        <small class="ov-card__vs">vs bulan lalu</small>
                    </div>
                </div>
                <div class="ov-card__spark"><canvas id="sparkProduct"></canvas></div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
            <div class="ov-card ov-card--red" style="animation-delay:.2s">
                <div class="ov-card__bg-icon"><i class="fas fa-wallet"></i></div>
                <div class="ov-card__body">
                    <p class="ov-card__label">Rata-rata Transaksi</p>
                    <h3 class="ov-card__value">Rp 37.580</h3>
                    <div class="d-flex align-items-center" style="gap:7px;">
                        <span class="ov-badge ov-badge--down"><i class="fas fa-arrow-down"></i> 3.1%</span>
                        <small class="ov-card__vs">vs bulan lalu</small>
                    </div>
                </div>
                <div class="ov-card__spark"><canvas id="sparkAvg"></canvas></div>
            </div>
        </div>

    </div>

    {{-- ROW 2 : REVENUE CHART + KATEGORI --}}
    <div class="row">

        <div class="col-xl-8 col-lg-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex align-items-start justify-content-between flex-wrap" style="gap:10px;">
                        <div>
                            <h4 class="card-title">Grafik Pendapatan</h4>
                            <p class="section-lead mb-0">Pendapatan &amp; transaksi harian (30 hari terakhir)</p>
                        </div>
                        <div class="d-flex align-items-center flex-wrap" style="gap:12px;">
                            <div class="ov-legend-item">
                                <span class="ov-legend-dot" style="background:#6777ef;"></span>
                                <small class="text-muted">Pendapatan</small>
                            </div>
                            <div class="ov-legend-item">
                                <span class="ov-legend-dot" style="background:#47c363;"></span>
                                <small class="text-muted">Transaksi</small>
                            </div>
                            <div class="btn-group btn-group-sm" id="periodToggle">
                                <button class="btn btn-primary btn-round active" data-period="daily">Hari</button>
                                <button class="btn btn-outline-secondary btn-round" data-period="weekly">Minggu</button>
                                <button class="btn btn-outline-secondary btn-round" data-period="monthly">Bulan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="ov-chart-main"><canvas id="revenueChart"></canvas></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Penjualan per Kategori</h4>
                    <p class="section-lead mb-0">Distribusi produk bulan ini</p>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="ov-chart-donut mx-auto"><canvas id="categoryChart"></canvas></div>
                    <div class="ov-cat-legend mt-3" id="categoryLegend"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- ROW 3 : JAM TERSIBUK + METODE BAYAR --}}
    <div class="row">

        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <h4 class="card-title">Jam Tersibuk</h4>
                            <p class="section-lead mb-0">Volume transaksi per jam hari ini</p>
                        </div>
                        <span class="badge badge-warning badge-pill px-3 py-2" style="font-size:.72rem;">
                            <i class="fas fa-fire mr-1"></i> Peak: 10–11
                        </span>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="ov-chart-bar"><canvas id="hourlyChart"></canvas></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Metode Pembayaran</h4>
                    <p class="section-lead mb-0">Preferensi pembayaran pelanggan</p>
                </div>
                <div class="card-body d-flex align-items-center" style="gap:20px;">
                    <div class="ov-chart-polar flex-shrink-0"><canvas id="paymentChart"></canvas></div>
                    <div class="flex-fill" id="paymentLegend"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- ROW 4 : TOP PRODUK + TRANSAKSI TERAKHIR --}}
    <div class="row">

        <div class="col-xl-5 col-lg-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="card-title">Produk Terlaris</h4>
                            <p class="section-lead mb-0">Top 5 berdasarkan omzet</p>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body" id="topProductsList"></div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="card-title">Transaksi Terakhir</h4>
                            <p class="section-lead mb-0">10 transaksi terbaru hari ini</p>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="ov-thead">
                                <tr>
                                    <th class="pl-4">ID</th>
                                    <th>Pelanggan</th>
                                    <th>Item</th>
                                    <th>Metode</th>
                                    <th>Waktu</th>
                                    <th class="pr-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody id="recentTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ROW 5 : STOK ALERT + KASIR + TARGET --}}
    <div class="row">

        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-exclamation-triangle text-warning mr-2"></i>Stok Hampir Habis
                        </h4>
                        <span class="badge badge-pill badge-danger px-2">5</span>
                    </div>
                </div>
                <div class="card-body" id="lowStockList"></div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Performa Kasir</h4>
                    <p class="section-lead mb-0">Transaksi per kasir hari ini</p>
                </div>
                <div class="card-body" id="cashierList"></div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Target Bulan Ini</h4>
                    <p class="section-lead mb-0">Progress menuju target penjualan</p>
                </div>
                <div class="card-body">
                    <div class="ov-gauge-wrap"><canvas id="targetChart"></canvas></div>
                    <div class="mt-2">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Tercapai</small>
                            <small class="font-weight-bold text-primary">Rp 48,2 Jt</small>
                        </div>
                        <div class="progress ov-progress">
                            <div class="progress-bar bg-primary" id="targetBar" style="width:0%;"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Target: Rp 75 Jt</small>
                            <small class="font-weight-bold text-primary" id="targetPct">64%</small>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="ov-mini-stat">
                                <div class="ov-mini-stat__icon" style="background:#e8fdf0;color:#47c363;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <div class="ov-mini-stat__val">19 hari</div>
                                    <div class="ov-mini-stat__lbl">Tersisa</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="ov-mini-stat">
                                <div class="ov-mini-stat__icon" style="background:#fff4e0;color:#ffa426;">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <div>
                                    <div class="ov-mini-stat__val">Rp 1,4 Jt</div>
                                    <div class="ov-mini-stat__lbl">Butuh/hari</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>{{-- /section-body --}}

@endsection

@push('style')
<style>
/* ============================================================
   OVERVIEW — Custom styles (melengkapi Stisla + Bootstrap 4)
   ============================================================ */

/* ── Stat Cards ────────────────────────────────────────── */
.ov-card {
    position: relative;
    overflow: hidden;
    border-radius: 14px;
    padding: 22px 20px 14px;
    min-height: 128px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 6px 24px rgba(0,0,0,.09);
    transition: transform .25s ease, box-shadow .25s ease;
    animation: ovFadeUp .45s ease both;
}
.ov-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,.13); }

.ov-card--blue   { background: linear-gradient(135deg, #6777ef 0%, #98a5ff 100%); }
.ov-card--green  { background: linear-gradient(135deg, #47c363 0%, #7de899 100%); }
.ov-card--orange { background: linear-gradient(135deg, #ffa426 0%, #ffc46b 100%); }
.ov-card--red    { background: linear-gradient(135deg, #fc544b 0%, #ff8d87 100%); }

.ov-card__bg-icon {
    position: absolute;
    right: -12px;
    top: -8px;
    font-size: 6rem;
    opacity: .1;
    color: white;
    pointer-events: none;
    line-height: 1;
}
.ov-card__body  { position: relative; z-index: 1; }
.ov-card__label {
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .9px;
    color: rgba(255,255,255,.82);
    margin: 0 0 5px;
}
.ov-card__value {
    font-size: 1.55rem;
    font-weight: 900;
    color: white;
    letter-spacing: -.5px;
    margin: 0 0 10px;
}
.ov-card__vs { font-size: .68rem; color: rgba(255,255,255,.72); }
.ov-card__spark {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 48px;
    opacity: .28;
}

.ov-badge {
    font-size: .65rem;
    font-weight: 800;
    padding: 3px 9px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}
.ov-badge--up   { background: rgba(255,255,255,.25); color: white; }
.ov-badge--down { background: rgba(0,0,0,.15); color: rgba(255,255,255,.9); }

@keyframes ovFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Chart Containers ──────────────────────────────────── */
.ov-chart-main  { position: relative; height: 268px; }
.ov-chart-donut { width: 175px; height: 175px; position: relative; }
.ov-chart-bar   { position: relative; height: 218px; }
.ov-chart-polar { width: 175px; height: 175px; position: relative; }
.ov-gauge-wrap  { position: relative; height: 148px; }

/* ── Legend ────────────────────────────────────────────── */
.ov-legend-item { display: flex; align-items: center; gap: 6px; }
.ov-legend-dot  { width: 10px; height: 10px; border-radius: 3px; display: inline-block; flex-shrink: 0; }

.ov-cat-legend { display: flex; flex-direction: column; gap: 7px; }
.ov-cat-legend__row { display: flex; align-items: center; }
.ov-cat-legend__dot { width: 9px; height: 9px; border-radius: 3px; flex-shrink: 0; margin-right: 7px; }
.ov-cat-legend__name { font-size: .77rem; font-weight: 700; color: #34395e; min-width: 70px; flex-shrink: 0; }
.ov-cat-legend__bar-wrap { flex: 1; height: 5px; background: #f0f2f8; border-radius: 4px; margin: 0 8px; }
.ov-cat-legend__bar { height: 100%; border-radius: 4px; transition: width .6s ease; }
.ov-cat-legend__pct { font-size: .7rem; font-weight: 700; color: #98a6ad; min-width: 28px; text-align: right; }

/* ── Payment Legend ────────────────────────────────────── */
.ov-pay-row + .ov-pay-row { margin-top: 10px; }
.ov-pay-icon  { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .82rem; flex-shrink: 0; }
.ov-pay-name  { font-size: .8rem; font-weight: 700; color: #34395e; margin: 0 0 1px; }
.ov-pay-count { font-size: .68rem; color: #98a6ad; margin: 0; }
.ov-pay-amount{ font-size: .8rem; font-weight: 800; color: #34395e; margin: 0; }
.ov-pay-pct   { font-size: .68rem; color: #98a6ad; margin: 0; }

/* ── Top Products ──────────────────────────────────────── */
.ov-product-row {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 9px 0;
    border-bottom: 1px solid #f5f6fa;
    animation: ovFadeUp .4s ease both;
}
.ov-product-row:last-child { border-bottom: none; }

.ov-rank         { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .72rem; font-weight: 900; flex-shrink: 0; }
.ov-rank--1      { background: linear-gradient(135deg,#ffd700,#ffb300); color: white; }
.ov-rank--2      { background: linear-gradient(135deg,#b0bec5,#78909c); color: white; }
.ov-rank--3      { background: linear-gradient(135deg,#ff7043,#ff5722); color: white; }
.ov-rank--other  { background: #f0f2f8; color: #98a6ad; }

.ov-product-img     { width: 42px; height: 42px; border-radius: 10px; object-fit: cover; flex-shrink: 0; background: #f0f2f8; }
.ov-product-name    { font-size: .8rem; font-weight: 700; color: #34395e; margin: 0 0 3px; }
.ov-product-cat     { font-size: .68rem; color: #98a6ad; margin: 0; }
.ov-product-revenue { font-size: .82rem; font-weight: 900; color: #6777ef; margin: 0; }
.ov-product-qty     { font-size: .68rem; color: #98a6ad; margin: 0; }

/* ── Recent Table ──────────────────────────────────────── */
.ov-thead th {
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #98a6ad;
    background: #fafbff;
    border-top: none;
    padding: 10px 12px;
}
#recentTableBody td {
    font-size: .8rem;
    vertical-align: middle;
    padding: 9px 12px;
    border-color: #f5f6fa;
}
.ov-txn-id     { font-family: 'Courier New', monospace; font-size: .7rem; color: #98a6ad; }
.ov-txn-name   { font-weight: 700; }
.ov-txn-item   { font-size: .76rem; color: #6b7280; }
.ov-txn-time   { font-size: .72rem; color: #98a6ad; }
.ov-txn-amount { font-weight: 900; }

.ov-pay-badge    { font-size: .62rem; padding: 3px 9px; border-radius: 50px; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; display: inline-block; }
.ov-pb--cash     { background: #e8fdf0; color: #1a7a44; }
.ov-pb--qris     { background: #eeeeff; color: #3c52d6; }
.ov-pb--transfer { background: #fff4e0; color: #9c5e00; }
.ov-pb--card     { background: #fde8f0; color: #c0194c; }

/* ── Low Stock ─────────────────────────────────────────── */
.ov-stock-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f5f6fa; }
.ov-stock-row:last-child { border-bottom: none; }
.ov-stock-icon { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: .85rem; }
.ov-stock-icon--critical { background: #fde8e8; color: #fc544b; }
.ov-stock-icon--low      { background: #fff4e0; color: #ffa426; }
.ov-stock-name { font-size: .78rem; font-weight: 700; color: #34395e; margin: 0 0 1px; }
.ov-stock-sku  { font-size: .65rem; color: #98a6ad; margin: 0; }
.ov-stock-qty  { font-size: .88rem; font-weight: 900; }
.ov-stock-lbl  { font-size: .62rem; color: #98a6ad; }

/* ── Cashier ───────────────────────────────────────────── */
.ov-cashier-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f5f6fa; }
.ov-cashier-row:last-child { border-bottom: none; }
.ov-cashier-av   { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: .75rem; flex-shrink: 0; color: white; }
.ov-cashier-name { font-size: .8rem; font-weight: 700; color: #34395e; margin: 0 0 4px; }
.ov-cashier-bar-wrap { height: 5px; background: #f0f2f8; border-radius: 4px; }
.ov-cashier-bar  { height: 100%; border-radius: 4px; }
.ov-cashier-txn  { font-size: .72rem; font-weight: 800; flex-shrink: 0; margin-left: auto; }

/* ── Target Mini Stat ──────────────────────────────────── */
.ov-progress { height: 8px; border-radius: 50px; background: #f0f2f8; }
.ov-progress .progress-bar { border-radius: 50px; transition: width 1.2s ease .4s; }

.ov-mini-stat       { display: flex; align-items: center; gap: 8px; background: #f9fafb; border-radius: 10px; padding: 10px; }
.ov-mini-stat__icon { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: .75rem; flex-shrink: 0; }
.ov-mini-stat__val  { font-size: .8rem; font-weight: 900; color: #34395e; line-height: 1.2; }
.ov-mini-stat__lbl  { font-size: .62rem; color: #98a6ad; }
</style>
@endpush

@push('script')
<script src="{{ asset('stisla-assets/modules/chart3.min.js') }}"></script>
<script>
(function () {
    'use strict';

    /* ── Helpers ──────────────────────────────────────────── */
    const fmt  = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
    const fmtK = n => n >= 1e6 ? 'Rp ' + (n / 1e6).toFixed(1) + ' Jt' : 'Rp ' + (n / 1e3).toFixed(0) + ' Rb';
    const rand = (a, b) => Math.floor(Math.random() * (b - a + 1)) + a;
    const pick = arr => arr[Math.floor(Math.random() * arr.length)];

    Chart.defaults.font.family = "'Nunito', 'Source Sans Pro', sans-serif";
    Chart.defaults.plugins.legend.display = false;

    const C = {
        blue  : '#6777ef',
        green : '#47c363',
        orange: '#ffa426',
        red   : '#fc544b',
        teal  : '#00bcd4',
        pink  : '#e91e63',
        muted : '#98a6ad',
        grid  : 'rgba(0,0,0,.04)',
    };

    /* ── Greeting ─────────────────────────────────────────── */
    (function () {
        const h    = new Date().getHours();
        const sapa = h < 11 ? 'Selamat pagi' : h < 15 ? 'Selamat siang' : h < 18 ? 'Selamat sore' : 'Selamat malam';
        document.getElementById('greetingText').innerHTML = sapa + ', <span class="text-primary">Admin</span> 👋';
        document.getElementById('todayDate').textContent  = new Date().toLocaleDateString('id-ID', {
            weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
        });
    }());

    /* ── 1. Sparkline ─────────────────────────────────────── */
    function buildSparkline(id, data) {
        const el = document.getElementById(id);
        if (!el) return;
        new Chart(el, {
            type: 'line',
            data: {
                labels: data.map((_, i) => i),
                datasets: [{
                    data,
                    borderColor: 'rgba(255,255,255,.75)',
                    borderWidth: 2,
                    fill: true,
                    backgroundColor: 'rgba(255,255,255,.18)',
                    tension: .4,
                    pointRadius: 0,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: { tooltip: { enabled: false } },
                scales: { x: { display: false }, y: { display: false } },
            },
        });
    }

    buildSparkline('sparkRevenue', [18, 22, 19, 28, 25, 30, 27, 35, 32, 40, 38, 48]);
    buildSparkline('sparkTxn',     [40, 55, 48, 62, 58, 70, 65, 80, 75, 88, 82, 95]);
    buildSparkline('sparkProduct', [120, 145, 132, 168, 155, 180, 170, 200, 190, 215, 205, 230]);
    buildSparkline('sparkAvg',     [35, 38, 34, 40, 37, 42, 39, 45, 41, 38, 36, 38]);

    /* ── 2. Revenue Chart (Line + Bar) ────────────────────── */
    const DAY_LABELS = Array.from({ length: 30 }, (_, i) => {
        const d = new Date();
        d.setDate(d.getDate() - (29 - i));
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });
    const REV_DATA = Array.from({ length: 30 }, () => rand(900000, 3200000));
    const TXN_DATA = Array.from({ length: 30 }, () => rand(15, 85));

    const rCtx  = document.getElementById('revenueChart').getContext('2d');
    const rGrad = rCtx.createLinearGradient(0, 0, 0, 268);
    rGrad.addColorStop(0, 'rgba(103,119,239,.22)');
    rGrad.addColorStop(1, 'rgba(103,119,239,.01)');

    const revenueChart = new Chart(rCtx, {
        data: {
            labels: DAY_LABELS,
            datasets: [
                {
                    type: 'line',
                    label: 'Pendapatan',
                    data: REV_DATA,
                    borderColor: C.blue,
                    borderWidth: 2.5,
                    backgroundColor: rGrad,
                    fill: true,
                    tension: .4,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: C.blue,
                    yAxisID: 'yRev',
                },
                {
                    type: 'bar',
                    label: 'Transaksi',
                    data: TXN_DATA,
                    backgroundColor: 'rgba(71,195,99,.2)',
                    borderColor: 'rgba(71,195,99,.5)',
                    borderWidth: 1,
                    borderRadius: 4,
                    yAxisID: 'yTxn',
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(34,39,80,.92)',
                    titleColor: '#fff',
                    bodyColor: 'rgba(255,255,255,.72)',
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: ctx => ctx.datasetIndex === 0
                            ? '  Pendapatan: ' + fmt(ctx.raw)
                            : '  Transaksi: '  + ctx.raw + ' trx',
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { color: C.muted, font: { size: 10 }, maxTicksLimit: 10 },
                },
                yRev: {
                    position: 'left',
                    grid: { color: C.grid },
                    border: { display: false },
                    ticks: { color: C.muted, font: { size: 10 }, callback: v => fmtK(v) },
                },
                yTxn: {
                    position: 'right',
                    grid: { display: false },
                    border: { display: false },
                    ticks: { color: C.muted, font: { size: 10 } },
                },
            },
        },
    });

    document.getElementById('periodToggle').addEventListener('click', function (e) {
        const btn = e.target.closest('[data-period]');
        if (!btn) return;

        this.querySelectorAll('[data-period]').forEach(b => {
            b.classList.remove('active', 'btn-primary');
            b.classList.add('btn-outline-secondary');
        });
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('active', 'btn-primary');

        const period = btn.dataset.period;
        const count  = period === 'daily' ? 30 : period === 'weekly' ? 12 : 6;
        const factor = period === 'daily' ? 1  : period === 'weekly' ? 7  : 30;

        revenueChart.data.labels = Array.from({ length: count }, (_, i) =>
            period === 'daily'  ? DAY_LABELS[DAY_LABELS.length - count + i] :
            period === 'weekly' ? 'W' + (count - i) :
                                  'Bln ' + (count - i)
        );
        revenueChart.data.datasets[0].data = Array.from({ length: count }, () => rand(900000 * factor, 3200000 * factor));
        revenueChart.data.datasets[1].data = Array.from({ length: count }, () => rand(15 * factor, 85 * factor));
        revenueChart.update();
    });

    /* ── 3. Kategori Donut ────────────────────────────────── */
    const CATEGORIES = [
        { name: 'Kain',     pct: 38, color: C.blue   },
        { name: 'Benang',   pct: 24, color: C.green  },
        { name: 'Aksesori', pct: 18, color: C.orange },
        { name: 'Alat',     pct: 12, color: C.teal   },
        { name: 'Kancing',  pct: 8,  color: C.pink   },
    ];

    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: CATEGORIES.map(c => c.name),
            datasets: [{
                data: CATEGORIES.map(c => c.pct),
                backgroundColor: CATEGORIES.map(c => c.color),
                borderWidth: 0,
                hoverOffset: 6,
            }],
        },
        options: {
            cutout: '72%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(34,39,80,.92)',
                    titleColor: '#fff',
                    bodyColor: 'rgba(255,255,255,.72)',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.raw + '%' },
                },
            },
        },
    });

    const maxPct = Math.max(...CATEGORIES.map(c => c.pct));
    document.getElementById('categoryLegend').innerHTML = CATEGORIES.map(c => `
        <div class="ov-cat-legend__row">
            <span class="ov-cat-legend__dot" style="background:${c.color};"></span>
            <span class="ov-cat-legend__name">${c.name}</span>
            <div class="ov-cat-legend__bar-wrap">
                <div class="ov-cat-legend__bar" style="width:${(c.pct / maxPct * 100).toFixed(0)}%; background:${c.color};"></div>
            </div>
            <span class="ov-cat-legend__pct">${c.pct}%</span>
        </div>`).join('');

    /* ── 4. Hourly Bar ────────────────────────────────────── */
    const HOURS       = ['08','09','10','11','12','13','14','15','16','17','18','19','20'];
    const HOURLY_DATA = [12, 28, 67, 82, 55, 44, 60, 73, 58, 41, 35, 22, 14];

    new Chart(document.getElementById('hourlyChart'), {
        type: 'bar',
        data: {
            labels: HOURS.map(h => h + '.00'),
            datasets: [{
                data: HOURLY_DATA,
                backgroundColor: HOURLY_DATA.map(v =>
                    v >= 80 ? C.blue : v >= 50 ? C.blue + '99' : C.blue + '3a'
                ),
                borderRadius: 6,
                borderSkipped: false,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(34,39,80,.92)',
                    titleColor: '#fff',
                    bodyColor: 'rgba(255,255,255,.72)',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: { label: ctx => ' ' + ctx.raw + ' transaksi' },
                },
            },
            scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { color: C.muted, font: { size: 10 } } },
                y: { grid: { color: C.grid },  border: { display: false }, ticks: { color: C.muted, font: { size: 10 } } },
            },
        },
    });

    /* ── 5. Payment Polar Area ────────────────────────────── */
    const PAYMENTS = [
        { method: 'Tunai',    icon: 'fas fa-money-bill-wave', color: C.green,  bg: '#e8fdf0', pct: 42, amount: 20265000, count: 539 },
        { method: 'QRIS',     icon: 'fas fa-qrcode',          color: C.blue,   bg: '#eeeeff', pct: 31, amount: 14957500, count: 398 },
        { method: 'Transfer', icon: 'fas fa-university',      color: C.orange, bg: '#fff4e0', pct: 17, amount:  8202500, count: 218 },
        { method: 'Kartu',    icon: 'fas fa-credit-card',     color: C.red,    bg: '#fde8f0', pct: 10, amount:  4825000, count: 129 },
    ];

    new Chart(document.getElementById('paymentChart'), {
        type: 'polarArea',
        data: {
            labels: PAYMENTS.map(p => p.method),
            datasets: [{
                data: PAYMENTS.map(p => p.pct),
                backgroundColor: PAYMENTS.map(p => p.color + 'aa'),
                borderColor    : PAYMENTS.map(p => p.color),
                borderWidth: 1.5,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(34,39,80,.92)',
                    titleColor: '#fff',
                    bodyColor: 'rgba(255,255,255,.72)',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.raw + '%' },
                },
            },
            scales: {
                r: { grid: { color: C.grid }, ticks: { display: false }, pointLabels: { display: false } },
            },
        },
    });

    document.getElementById('paymentLegend').innerHTML = PAYMENTS.map(p => `
        <div class="ov-pay-row d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center" style="gap:9px; min-width:0;">
                <div class="ov-pay-icon" style="background:${p.bg}; color:${p.color};">
                    <i class="${p.icon}"></i>
                </div>
                <div>
                    <p class="ov-pay-name">${p.method}</p>
                    <p class="ov-pay-count">${p.count} transaksi</p>
                </div>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="ov-pay-amount">${fmtK(p.amount)}</p>
                <p class="ov-pay-pct">${p.pct}%</p>
            </div>
        </div>`).join('');

    /* ── 6. Top Products ──────────────────────────────────── */
    const TOP_PRODUCTS = [
        { rank: 1, name: 'Kain Batik Tulis Solo', cat: 'Kain',   revenue: 12800000, qty: 69,  img: 'https://images.unsplash.com/photo-1609234656388-0ff363383899?w=84&q=65' },
        { rank: 2, name: 'Kain Sutra Premium',    cat: 'Kain',   revenue:  9600000, qty: 128, img: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=84&q=65' },
        { rank: 3, name: 'Gunting Jahit PRO',     cat: 'Alat',   revenue:  7500000, qty: 60,  img: 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=84&q=65' },
        { rank: 4, name: 'Kain Denim 14oz',       cat: 'Kain',   revenue:  5700000, qty: 60,  img: 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=84&q=65' },
        { rank: 5, name: 'Benang Wool Merino',    cat: 'Benang', revenue:  3850000, qty: 110, img: 'https://images.unsplash.com/photo-1612198188060-c7c2a3b66eae?w=84&q=65' },
    ];
    const rankCls = r => r === 1 ? 'ov-rank--1' : r === 2 ? 'ov-rank--2' : r === 3 ? 'ov-rank--3' : 'ov-rank--other';

    document.getElementById('topProductsList').innerHTML = TOP_PRODUCTS.map((p, i) => `
        <div class="ov-product-row" style="animation-delay:${i * .07}s;">
            <div class="ov-rank ${rankCls(p.rank)}">${p.rank}</div>
            <img src="${p.img}" alt="${p.name}" class="ov-product-img rounded" onerror="this.style.display='none'">
            <div class="flex-fill" style="min-width:0;">
                <p class="ov-product-name text-truncate">${p.name}</p>
                <p class="ov-product-cat">
                    <span class="badge badge-light badge-pill">${p.cat}</span>
                </p>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="ov-product-revenue">${fmtK(p.revenue)}</p>
                <p class="ov-product-qty">${p.qty} terjual</p>
            </div>
        </div>`).join('');

    /* ── 7. Recent Transactions ───────────────────────────── */
    const CUST_LIST = ['Ahmad Rizky','Siti Rahma','Budi Santoso','Dewi Lestari','Rizal F.','Anisa P.','Hendra T.','Nurul H.'];
    const PROD_LIST = ['Kain Sutra','Benang Wool','Kancing Mutiara','Gunting Jahit','Kain Batik','Resleting YKK'];
    const PAY_KEYS  = ['cash','qris','transfer','card'];
    const PAY_LBL   = { cash:'Tunai', qris:'QRIS', transfer:'Transfer', card:'Kartu' };
    const PAY_CLS   = { cash:'ov-pb--cash', qris:'ov-pb--qris', transfer:'ov-pb--transfer', card:'ov-pb--card' };

    const transactions = Array.from({ length: 10 }, (_, i) => {
        const method = pick(PAY_KEYS);
        const t      = new Date();
        t.setMinutes(t.getMinutes() - i * rand(3, 18));
        return {
            id      : 'TXN-' + String(10000 + rand(0, 9999)).slice(-5),
            customer: pick(CUST_LIST),
            product : pick(PROD_LIST),
            method,
            time    : t.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }),
            amount  : rand(35000, 450000),
        };
    });

    document.getElementById('recentTableBody').innerHTML = transactions.map(t => `
        <tr>
            <td class="pl-4"><span class="ov-txn-id">${t.id}</span></td>
            <td><span class="ov-txn-name">${t.customer}</span></td>
            <td><span class="ov-txn-item">${t.product}</span></td>
            <td><span class="ov-pay-badge ${PAY_CLS[t.method]}">${PAY_LBL[t.method]}</span></td>
            <td><span class="ov-txn-time"><i class="far fa-clock mr-1"></i>${t.time}</span></td>
            <td class="pr-4 text-right"><span class="ov-txn-amount">${fmt(t.amount)}</span></td>
        </tr>`).join('');

    /* ── 8. Low Stock ─────────────────────────────────────── */
    const LOW_STOCK = [
        { name: 'Resleting YKK 30cm', sku: 'RYK-007', qty: 3,  level: 'critical' },
        { name: 'Kancing Mutiara',    sku: 'KMT-003', qty: 5,  level: 'critical' },
        { name: 'Benang Bordir Poly', sku: 'BBP-006', qty: 8,  level: 'low'      },
        { name: 'Jarum Mesin',        sku: 'JMS-012', qty: 10, level: 'low'      },
        { name: 'Kain Tile Premium',  sku: 'KTP-019', qty: 12, level: 'low'      },
    ];

    document.getElementById('lowStockList').innerHTML = LOW_STOCK.map(s => `
        <div class="ov-stock-row">
            <div class="ov-stock-icon ov-stock-icon--${s.level}">
                <i class="fas fa-${s.level === 'critical' ? 'exclamation' : 'exclamation-triangle'}"></i>
            </div>
            <div style="min-width:0;">
                <p class="ov-stock-name text-truncate">${s.name}</p>
                <p class="ov-stock-sku">${s.sku}</p>
            </div>
            <div class="text-right flex-shrink-0">
                <div class="ov-stock-qty ${s.level === 'critical' ? 'text-danger' : 'text-warning'}">${s.qty}</div>
                <div class="ov-stock-lbl">tersisa</div>
            </div>
        </div>`).join('');

    /* ── 9. Cashier Performance ───────────────────────────── */
    const CASHIERS = [
        { name: 'Kasir Utama', ini: 'KU', color: '#6777ef', txn: 284 },
        { name: 'Sinta Dewi',  ini: 'SD', color: '#47c363', txn: 217 },
        { name: 'Arif Rahman', ini: 'AR', color: '#ffa426', txn: 183 },
        { name: 'Putri Ayu',   ini: 'PA', color: '#fc544b', txn: 142 },
    ];
    const maxTxn = Math.max(...CASHIERS.map(c => c.txn));

    document.getElementById('cashierList').innerHTML = CASHIERS.map(c => `
        <div class="ov-cashier-row">
            <div class="ov-cashier-av" style="background:${c.color};">${c.ini}</div>
            <div class="flex-fill" style="min-width:0;">
                <p class="ov-cashier-name">${c.name}</p>
                <div class="ov-cashier-bar-wrap">
                    <div class="ov-cashier-bar" style="width:${(c.txn / maxTxn * 100).toFixed(0)}%; background:${c.color};"></div>
                </div>
            </div>
            <span class="ov-cashier-txn" style="color:${c.color};">${c.txn} trx</span>
        </div>`).join('');

    /* ── 10. Target Gauge ─────────────────────────────────── */
    const TARGET   = 75000000;
    const ACHIEVED = 48250000;
    const PCT      = parseFloat((ACHIEVED / TARGET * 100).toFixed(1));

    const gCtx  = document.getElementById('targetChart').getContext('2d');
    const gGrad = gCtx.createLinearGradient(0, 0, 160, 0);
    gGrad.addColorStop(0, '#6777ef');
    gGrad.addColorStop(1, '#98a5ff');

    new Chart(gCtx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [ACHIEVED, TARGET - ACHIEVED],
                backgroundColor: [gGrad, '#f0f2f8'],
                borderWidth: 0,
                hoverOffset: 0,
            }],
        },
        options: {
            cutout: '78%',
            rotation: -90,
            circumference: 180,
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200, easing: 'easeOutQuart' },
            plugins: { legend: { display: false }, tooltip: { enabled: false } },
        },
        plugins: [{
            id: 'gaugeLabel',
            afterDatasetDraw(chart) {
                const { ctx, chartArea: { width, top, height } } = chart;
                const cx = width / 2, cy = top + height * .88;
                ctx.save();
                ctx.textAlign = 'center';
                ctx.font      = 'bold 20px Nunito, sans-serif';
                ctx.fillStyle = '#34395e';
                ctx.fillText(PCT + '%', cx, cy - 8);
                ctx.font      = '11px Nunito, sans-serif';
                ctx.fillStyle = '#98a6ad';
                ctx.fillText('dari target', cx, cy + 12);
                ctx.restore();
            },
        }],
    });

    setTimeout(function () {
        const bar = document.getElementById('targetBar');
        const pct = document.getElementById('targetPct');
        if (bar) bar.style.width = PCT + '%';
        if (pct) pct.textContent = PCT + '%';
    }, 100);

    /* ── 11. Controls ─────────────────────────────────────── */
    document.getElementById('refreshBtn').addEventListener('click', function () {
        const icon = this.querySelector('i');
        icon.classList.add('fa-spin');
        setTimeout(function () { icon.classList.remove('fa-spin'); }, 1200);
    });

    document.getElementById('exportBtn').addEventListener('click', function () {
        if (typeof iziToast !== 'undefined') {
            iziToast.info({ title: 'Export', message: 'Laporan sedang disiapkan...', position: 'topRight', timeout: 2500 });
        }
    });

}());
</script>
@endpush