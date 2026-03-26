@extends('layouts.app')

@section('title', 'Point of Sale')

@section('content')

{{-- ============================================================
     POS BODY
============================================================ --}}
<div class="section-body">
<div class="pos-wrapper">

    {{-- =====================================================
         KIRI — Katalog Produk
    ===================================================== --}}
    <div class="pos-catalog d-flex flex-column">

        {{-- Top Bar: Search + Pelanggan --}}
        <div class="d-flex align-items-center mb-3 pos-topbar">
            <div class="input-group flex-fill">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                </div>
                <input type="text"
                       id="productSearch"
                       class="form-control border-left-0"
                       placeholder="Cari produk atau kode SKU... (Ctrl+K)">
            </div>

            <div class="input-group ml-2 pos-customer-select">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0">
                        <i class="fas fa-user text-muted"></i>
                    </span>
                </div>
                <select class="form-control border-left-0" id="customerSelect">
                    <option value="">Pelanggan Umum</option>
                    <option value="1">Ahmad Rizky (Member)</option>
                    <option value="2">Siti Rahma (VIP)</option>
                    <option value="3">Budi Santoso (Member)</option>
                </select>
            </div>
        </div>

        {{-- Kategori Pills --}}
        <div class="d-flex flex-nowrap overflow-auto pb-2 mb-3 category-scroll">
            <button class="btn btn-primary btn-sm rounded-pill px-3 mr-2 cat-btn flex-shrink-0"
                    data-category="all">
                <i class="fas fa-th-large mr-1"></i> Semua
            </button>
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 mr-2 cat-btn flex-shrink-0"
                    data-category="fabrics">
                <i class="fas fa-layer-group mr-1"></i> Kain
            </button>
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 mr-2 cat-btn flex-shrink-0"
                    data-category="threads">
                <i class="fas fa-circle-notch mr-1"></i> Benang
            </button>
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 mr-2 cat-btn flex-shrink-0"
                    data-category="buttons">
                <i class="fas fa-dot-circle mr-1"></i> Kancing
            </button>
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 mr-2 cat-btn flex-shrink-0"
                    data-category="tools">
                <i class="fas fa-tools mr-1"></i> Alat
            </button>
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 mr-2 cat-btn flex-shrink-0"
                    data-category="accessories">
                <i class="fas fa-gem mr-1"></i> Aksesori
            </button>
        </div>

        {{-- Stats + View Toggle --}}
        <div class="d-flex align-items-center mb-3">
            <span class="badge badge-pill badge-success mr-2">{{ count($products) }}</span>
            <small class="text-muted">produk tersedia</small>
            <div class="ml-auto">
                <button class="btn btn-sm btn-icon btn-outline-primary rounded view-toggle active"
                        id="gridViewBtn" title="Tampilan Grid">
                    <i class="fas fa-th"></i>
                </button>
                <button class="btn btn-sm btn-icon btn-outline-secondary rounded ml-1 view-toggle"
                        id="listViewBtn" title="Tampilan List">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>

        {{-- Grid Produk --}}
        <div class="row flex-fill product-grid-area" id="productGrid">

            @foreach ($products as $index => $product)
            @php $stock = $product['stock'] ?? 10; @endphp

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4 product-col"
                 data-category="{{ $product['category'] ?? 'fabrics' }}"
                 data-name="{{ strtolower($product['name']) }}"
                 data-sku="{{ strtolower($product['sku'] ?? '') }}"
                 style="animation:fadeInUp .35s ease both;animation-delay:{{ $index * 0.04 }}s">

                <div class="card product-card h-100 border-0 shadow-sm">

                    {{-- Gambar Produk --}}
                    <div class="product-img-wrap position-relative">
                        <img src="{{ $product['image'] }}"
                             alt="{{ $product['name'] }}"
                             class="card-img-top product-img"
                             loading="lazy">

                        {{-- Badge Stok --}}
                        @if ($stock > 5)
                            <span class="badge badge-pill badge-success product-badge-stock">In Stock</span>
                        @elseif ($stock > 0)
                            <span class="badge badge-pill badge-warning product-badge-stock">Stok Tipis</span>
                        @else
                            <span class="badge badge-pill badge-danger product-badge-stock">Habis</span>
                        @endif

                        {{-- Badge Kategori --}}
                        <span class="badge badge-pill badge-primary product-badge-cat">
                            {{ $product['category'] ?? 'Kain' }}
                        </span>

                        {{-- Overlay Quick View --}}
                        <div class="product-overlay d-flex align-items-center justify-content-center">
                            <button class="btn btn-sm btn-light btn-icon rounded-circle shadow-sm"
                                    title="Quick View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body p-3 d-flex flex-column">

                        {{-- SKU + Kategori --}}
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <small class="text-muted font-weight-600" style="font-size:.68rem;">
                                {{ $product['sku'] ?? 'SKU-001' }}
                            </small>
                            <span class="badge badge-light" style="font-size:.62rem;">
                                {{ Str::limit($product['category'] ?? 'Kain', 10) }}
                            </span>
                        </div>

                        {{-- Nama --}}
                        <h6 class="card-title font-weight-bold text-dark text-truncate mb-1">
                            {{ $product['name'] }}
                        </h6>

                        {{-- Deskripsi --}}
                        <p class="card-text small text-muted mb-3" style="line-height:1.45;">
                            {{ Str::limit($product['description'], 50) }}
                        </p>

                        {{-- Pilihan Satuan & Warna --}}
                        <div class="form-row mb-3">
                            <div class="col-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text px-2">
                                            <i class="fas fa-ruler-horizontal" style="font-size:.65rem;"></i>
                                        </span>
                                    </div>
                                    <select class="form-control form-control-sm border-left-0" name="unit">
                                        <option>Meter</option>
                                        <option>Roll</option>
                                        <option>Yard</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text px-2">
                                            <i class="fas fa-palette" style="font-size:.65rem;"></i>
                                        </span>
                                    </div>
                                    <select class="form-control form-control-sm border-left-0" name="color">
                                        <option>Merah</option>
                                        <option>Biru</option>
                                        <option>Hijau</option>
                                        <option>Hitam</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Harga + Qty + Tombol Tambah --}}
                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <div>
                                <small class="d-block text-muted"
                                       style="font-size:.63rem;text-transform:uppercase;letter-spacing:.4px;">
                                    Harga
                                </small>
                                <span class="h6 mb-0 font-weight-bold text-primary">
                                    Rp {{ number_format($product['price'] ?? 75000, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center">
                                {{-- Qty Stepper --}}
                                <div class="input-group input-group-sm qty-stepper mr-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary btn-sm px-2 qty-dec"
                                                type="button">−</button>
                                    </div>
                                    <input type="number"
                                           class="form-control form-control-sm text-center px-0 qty-input"
                                           value="1" min="1" max="99">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-sm px-2 qty-inc"
                                                type="button">+</button>
                                    </div>
                                </div>
                                {{-- Tombol Tambah --}}
                                <button class="btn btn-primary btn-icon btn-sm shadow-primary add-cart-btn"
                                        data-product-id="{{ $product['id'] ?? $index }}"
                                        data-product-name="{{ $product['name'] }}"
                                        data-product-price="{{ $product['price'] ?? 75000 }}"
                                        title="Tambah ke Keranjang"
                                        style="border-radius:10px;width:34px;height:34px;">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>

                    </div>{{-- /card-body --}}
                </div>{{-- /card --}}
            </div>{{-- /product-col --}}
            @endforeach

            {{-- Empty State (komponen Stisla) --}}
            <div class="col-12 empty-state" id="emptyState" style="display:none;">
                <div class="empty-state-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h2>Produk Tidak Ditemukan</h2>
                <p class="lead">Coba kata kunci lain atau pilih kategori berbeda.</p>
                <button class="btn btn-primary mt-2" onclick="POS.resetSearch()">
                    <i class="fas fa-redo mr-2"></i> Reset Pencarian
                </button>
            </div>

        </div>{{-- /productGrid --}}
    </div>{{-- /pos-catalog --}}


    {{-- =====================================================
         KANAN — Panel Keranjang (Dark)
    ===================================================== --}}
    <aside class="pos-cart">

        {{-- Cart Header --}}
        <div class="cart-head d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="cart-icon-box mr-3">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div>
                    <h5 class="mb-0 font-weight-bold text-white" style="font-size:.95rem;">
                        Keranjang
                    </h5>
                    <small class="cart-muted">
                        <span id="cartCountLabel">0</span> item
                    </small>
                </div>
            </div>
            <button class="btn btn-icon cart-clear-btn" id="clearCartBtn" title="Kosongkan Keranjang">
                <i class="fas fa-trash-alt" style="font-size:.8rem;"></i>
            </button>
        </div>

        {{-- Area Item Keranjang --}}
        <div class="cart-items-area" id="cartItemsArea">

            {{-- Empty State Keranjang (komponen Stisla) --}}
            <div class="empty-state cart-empty-state" id="cartEmpty">
                <div class="empty-state-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h2>Keranjang Kosong</h2>
                <p class="lead">
                    Klik <i class="fas fa-cart-plus"></i> pada produk<br>untuk menambahkan item
                </p>
            </div>

            {{-- Daftar Item (diisi oleh JS) --}}
            <div id="cartItemsList"></div>

        </div>{{-- /cart-items-area --}}

        {{-- Footer: Summary + Payment --}}
        <div class="cart-footer">

            {{-- Input Voucher --}}
            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text cart-input-addon">
                        <i class="fas fa-tag"></i>
                    </span>
                </div>
                <input type="text"
                       id="couponInput"
                       class="form-control cart-input"
                       placeholder="Kode Voucher / Diskon">
                <div class="input-group-append">
                    <button class="btn cart-coupon-btn" id="couponApplyBtn">
                        Terapkan
                    </button>
                </div>
            </div>

            {{-- Ringkasan Harga --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="cart-muted" style="font-size:.8rem;">Subtotal</span>
                    <span class="font-weight-600 text-white" style="font-size:.8rem;" id="summarySubtotal">
                        Rp 0
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="cart-muted" style="font-size:.8rem;">PPN (11%)</span>
                    <span class="font-weight-600 text-white" style="font-size:.8rem;" id="summaryTax">
                        Rp 0
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-2" id="discountRow" style="display:none!important;">
                    <span class="text-success" style="font-size:.8rem;">Diskon</span>
                    <span class="font-weight-bold text-success" style="font-size:.8rem;" id="summaryDiscount">
                        -Rp 0
                    </span>
                </div>
                <hr class="cart-divider my-2">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-white">Total</span>
                    <span class="h5 mb-0 font-weight-bold text-white" id="summaryTotal">Rp 0</span>
                </div>
            </div>

            {{-- Metode Pembayaran (nav pills Bootstrap) --}}
            <ul class="nav nav-pills nav-fill pay-nav mb-3">
                <li class="nav-item">
                    <a class="nav-link active pay-method" data-method="cash" href="#">
                        <i class="fas fa-money-bill-wave d-block mb-1"></i>
                        <small>Tunai</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pay-method" data-method="transfer" href="#">
                        <i class="fas fa-university d-block mb-1"></i>
                        <small>Transfer</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pay-method" data-method="qris" href="#">
                        <i class="fas fa-qrcode d-block mb-1"></i>
                        <small>QRIS</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pay-method" data-method="card" href="#">
                        <i class="fas fa-credit-card d-block mb-1"></i>
                        <small>Kartu</small>
                    </a>
                </li>
            </ul>

            {{-- Tombol Checkout --}}
            <button class="btn btn-primary btn-lg btn-block btn-checkout shadow-primary"
                    id="checkoutBtn" disabled>
                <span class="d-flex align-items-center justify-content-between w-100">
                    <span>
                        <i class="fas fa-arrow-right mr-2"></i> Proses Pembayaran
                    </span>
                    <span class="badge badge-light font-weight-bold ml-2" id="checkoutTotal">
                        Rp 0
                    </span>
                </span>
            </button>

        </div>{{-- /cart-footer --}}
    </aside>{{-- /pos-cart --}}

</div>{{-- /pos-wrapper --}}
</div>{{-- /section-body --}}

@endsection

@push('style')
<style>
    /* ============================================================
       POS — Custom styles
       (hanya untuk hal yang tidak tersedia di Stisla/Bootstrap 4)
       ============================================================ */

    /* ----- Layout Utama ----- */
    .pos-wrapper {
        display: flex;
        height: calc(100vh - 160px);
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, .08);
    }

    /* ----- Katalog (kiri) ----- */
    .pos-catalog {
        flex: 1;
        min-width: 0;
        overflow: hidden;
        padding: 20px;
        background: #fff;
        border-radius: 12px 0 0 12px;
    }

    .pos-topbar { gap: 10px; }

    .pos-customer-select { max-width: 220px; }

    /* Scroll kategori — sembunyikan scrollbar */
    .category-scroll { gap: 6px; }
    .category-scroll::-webkit-scrollbar { height: 3px; }
    .category-scroll::-webkit-scrollbar-thumb {
        background: #e4e6fc;
        border-radius: 4px;
    }

    /* Grid produk — scroll internal */
    .product-grid-area {
        overflow-y: auto;
        align-content: start;
        scrollbar-width: thin;
        scrollbar-color: #e4e6fc transparent;
        margin: 0 -8px;
    }
    .product-grid-area::-webkit-scrollbar { width: 5px; }
    .product-grid-area::-webkit-scrollbar-thumb {
        background: #e4e6fc;
        border-radius: 6px;
    }

    /* ----- Product Card ----- */
    .product-card {
        border-radius: 12px !important;
        border: 1.5px solid #e4e6fc !important;
        overflow: hidden;
        transition: transform .25s ease, box-shadow .25s ease, border-color .2s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 40px rgba(0, 0, 0, .1) !important;
        border-color: var(--primary-color, #6777ef) !important;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Gambar produk */
    .product-img-wrap {
        overflow: hidden;
        aspect-ratio: 4 / 3;
        background: #f5f6ff;
    }
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .4s ease;
    }
    .product-card:hover .product-img { transform: scale(1.07); }

    /* Badge posisi absolut di atas gambar */
    .product-badge-stock {
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: .62rem;
    }
    .product-badge-cat {
        position: absolute;
        bottom: 10px;
        right: 10px;
        font-size: .6rem;
        opacity: .92;
    }

    /* Overlay hover pada gambar */
    .product-overlay {
        position: absolute;
        inset: 0;
        background: rgba(34, 39, 80, .42);
        opacity: 0;
        transition: opacity .25s;
        backdrop-filter: blur(2px);
    }
    .product-card:hover .product-overlay { opacity: 1; }

    /* Qty stepper — hilangkan panah number input */
    .qty-stepper { width: 82px; }
    .qty-input { -moz-appearance: textfield; }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }
    .qty-stepper .form-control { border-left: none; border-right: none; }

    /* Tombol Add to Cart */
    .add-cart-btn { transition: transform .2s, background .2s; }
    .add-cart-btn:hover  { transform: scale(1.1); }
    .add-cart-btn:active { transform: scale(.9); }
    .add-cart-btn.added  {
        background-color: #47c363 !important;
        border-color: #47c363 !important;
    }

    /* ----- Keranjang (kanan, dark) ----- */
    .pos-cart {
        width: 360px;
        flex-shrink: 0;
        background: #13151f;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border-radius: 0 12px 12px 0;
    }

    /* Header keranjang */
    .cart-head {
        padding: 18px 20px 14px;
        border-bottom: 1px solid rgba(255, 255, 255, .07);
        flex-shrink: 0;
    }
    .cart-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(103, 119, 239, .2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6777ef;
        font-size: 1rem;
    }
    .cart-muted { color: #787f96; font-size: .78rem; }

    /* Tombol kosongkan keranjang */
    .cart-clear-btn {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, .1) !important;
        color: #787f96;
        border-radius: 8px;
        width: 34px;
        height: 34px;
        transition: all .2s;
    }
    .cart-clear-btn:hover {
        color: #fc544b;
        border-color: rgba(252, 84, 75, .4) !important;
        background: rgba(252, 84, 75, .12) !important;
    }

    /* Area scroll item */
    .cart-items-area {
        flex: 1;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, .07) transparent;
    }
    .cart-items-area::-webkit-scrollbar { width: 4px; }
    .cart-items-area::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, .08);
        border-radius: 4px;
    }

    /* Empty state keranjang (override warna Stisla untuk dark bg) */
    .cart-empty-state { padding: 44px 24px; }
    .cart-empty-state .empty-state-icon {
        background: rgba(255, 255, 255, .05);
    }
    .cart-empty-state .empty-state-icon i { color: #3a3f52; }
    .cart-empty-state h2 { color: #787f96; font-size: .95rem; }
    .cart-empty-state .lead { color: #4a4f62; font-size: .78rem; }

    /* Row item keranjang */
    .cart-item-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, .06);
        transition: background .15s;
        animation: slideIn .3s ease;
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(8px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    .cart-item-row:hover { background: rgba(255, 255, 255, .04); }

    .cart-item-thumb {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
        background: #1e2132;
    }
    .cart-item-name {
        font-size: .82rem;
        font-weight: 700;
        color: #e2e4ef;
        margin: 0 0 2px;
    }
    .cart-item-variant { font-size: .7rem; color: #787f96; margin: 0 0 6px; }
    .cart-item-price   { font-size: .85rem; font-weight: 700; color: #e2e4ef; }

    /* Tombol qty di keranjang */
    .cart-qty-btn {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        border: 1px solid rgba(255, 255, 255, .12);
        background: transparent;
        color: #787f96;
        font-size: .9rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all .15s;
        flex-shrink: 0;
    }
    .cart-qty-btn:hover {
        background: rgba(103, 119, 239, .2);
        border-color: #6777ef;
        color: #a0acf5;
    }
    .cart-qty-display {
        font-size: .82rem;
        font-weight: 700;
        color: #e2e4ef;
        min-width: 20px;
        text-align: center;
    }

    /* Tombol hapus item */
    .cart-remove-btn {
        border: none;
        background: none;
        color: #4a4f62;
        font-size: .72rem;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 3px;
        transition: all .15s;
    }
    .cart-remove-btn:hover {
        color: #fc544b;
        background: rgba(252, 84, 75, .1);
    }

    /* Footer keranjang */
    .cart-footer {
        padding: 14px 20px;
        border-top: 1px solid rgba(255, 255, 255, .06);
        background: #0f111a;
        flex-shrink: 0;
    }

    /* Input voucher dark */
    .cart-input {
        background: #1a1d2e !important;
        border-color: rgba(255, 255, 255, .1) !important;
        color: #e2e4ef !important;
    }
    .cart-input:focus {
        border-color: #6777ef !important;
        box-shadow: 0 0 0 .2rem rgba(103, 119, 239, .25) !important;
    }
    .cart-input::placeholder { color: #4a4f62 !important; }
    .cart-input-addon {
        background: #1a1d2e !important;
        border-color: rgba(255, 255, 255, .1) !important;
        color: #787f96 !important;
        border-right: none !important;
    }
    .cart-coupon-btn {
        background: transparent !important;
        border-color: rgba(255, 255, 255, .15) !important;
        color: #a0a8c0 !important;
        font-size: .78rem;
    }
    .cart-coupon-btn:hover {
        background: #6777ef !important;
        border-color: #6777ef !important;
        color: #fff !important;
    }

    /* Garis pemisah summary */
    .cart-divider { border-color: rgba(255, 255, 255, .07); }

    /* Metode pembayaran (nav pills dark) */
    .pay-nav .nav-link {
        color: #787f96;
        font-size: .68rem;
        padding: 8px 4px;
        border-radius: 10px;
        border: 1.5px solid rgba(255, 255, 255, .08);
        background: #1a1d2e;
        transition: all .2s;
        margin: 0 2px;
    }
    .pay-nav .nav-link:hover {
        border-color: #6777ef;
        color: #a0acf5;
        background: rgba(103, 119, 239, .1);
    }
    .pay-nav .nav-link.active {
        background: rgba(103, 119, 239, .22);
        border-color: #6777ef;
        color: #c4bcff;
    }

    /* Tombol checkout */
    .btn-checkout {
        border-radius: 10px !important;
        font-weight: 700;
        font-size: .82rem;
        letter-spacing: .4px;
        min-height: 48px;
        background: linear-gradient(135deg, #6777ef, #9fa8f5) !important;
        border: none !important;
        transition: all .25s;
    }
    .btn-checkout:disabled { opacity: .4 !important; }
    .btn-checkout:not(:disabled):hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(103, 119, 239, .4) !important;
    }

    /* ----- Responsive ----- */
    @media (max-width: 1024px) {
        .pos-wrapper {
            flex-direction: column;
            height: auto;
            overflow: visible;
        }
        .pos-catalog {
            overflow: visible;
            border-radius: 12px 12px 0 0;
        }
        .product-grid-area { overflow: visible; }
        .pos-cart {
            width: 100%;
            border-radius: 0 0 12px 12px;
        }
    }
    @media (max-width: 576px) {
        .pos-customer-select { max-width: 100%; }
        .pos-topbar { flex-direction: column; }
    }
</style>
@endpush

@push('script')
<script>
$(document).ready(function () {
    'use strict';

    /* ============================================================
       KONSTANTA & STATE
    ============================================================ */
    const TAX_RATE   = 0.11;
    const COUPONS    = { 'HEMAT10': 10000, 'DISKON20': 20000, 'VIP50': 50000 };
    const cart       = [];
    let   activeDiscount = 0;

    /* ============================================================
       REFERENSI DOM
    ============================================================ */
    const $cartCountLabel  = $('#cartCountLabel');
    const $cartEmpty       = $('#cartEmpty');
    const $cartItemsList   = $('#cartItemsList');
    const $checkoutBtn     = $('#checkoutBtn');
    const $checkoutTotal   = $('#checkoutTotal');
    const $summarySubtotal = $('#summarySubtotal');
    const $summaryTax      = $('#summaryTax');
    const $summaryTotal    = $('#summaryTotal');
    const $summaryDiscount = $('#summaryDiscount');
    const $discountRow     = $('#discountRow');
    const $productSearch   = $('#productSearch');
    const $productGrid     = $('#productGrid');
    const $emptyState      = $('#emptyState');

    /* ============================================================
       HELPER
    ============================================================ */
    function fmt(n) {
        return 'Rp ' + Math.round(n).toLocaleString('id-ID');
    }

    function toast(type, msg) {
        iziToast[type]({
            title   : type === 'success' ? 'Berhasil' : 'Gagal',
            message : msg,
            position: 'topRight',
            timeout : 2500,
        });
    }

    /* ============================================================
       LOGIKA KERANJANG
    ============================================================ */
    function findItem(pid, unit, color) {
        return cart.find(i => i.pid === pid && i.unit === unit && i.color === color);
    }

    function addToCart($col) {
        const pid   = $col.find('.add-cart-btn').data('product-id').toString();
        const name  = $col.find('.add-cart-btn').data('product-name');
        const price = parseFloat($col.find('.add-cart-btn').data('product-price')) || 0;
        const qty   = parseInt($col.find('.qty-input').val()) || 1;
        const unit  = $col.find('select[name="unit"]').val();
        const color = $col.find('select[name="color"]').val();
        const img   = $col.find('.product-img').attr('src') || '';

        const existing = findItem(pid, unit, color);
        existing
            ? (existing.qty += qty)
            : cart.push({ pid, name, price, qty, unit, color, img });

        renderCart();
    }

    function updateQty(pid, unit, color, delta) {
        const item = findItem(pid, unit, color);
        if (!item) return;
        item.qty = Math.max(1, item.qty + delta);
        renderCart();
    }

    function removeItem(pid, unit, color) {
        const idx = cart.findIndex(i => i.pid === pid && i.unit === unit && i.color === color);
        if (idx > -1) { cart.splice(idx, 1); renderCart(); }
    }

    function clearCart() {
        cart.length  = 0;
        activeDiscount = 0;
        $('#couponInput').val('');
        $discountRow.hide();
        renderCart();
    }

    function renderCart() {
        const totalItems = cart.reduce((s, i) => s + i.qty, 0);
        $cartCountLabel.text(totalItems);

        if (!cart.length) {
            $cartEmpty.show();
            $cartItemsList.html('');
            $checkoutBtn.prop('disabled', true);
        } else {
            $cartEmpty.hide();
            $checkoutBtn.prop('disabled', false);

            const rows = cart.map(item => `
                <div class="cart-item-row">
                    <img src="${item.img}" alt="${item.name}"
                         class="cart-item-thumb rounded"
                         onerror="this.style.display='none'">
                    <div class="flex-fill" style="min-width:0;">
                        <p class="cart-item-name text-truncate mb-0">${item.name}</p>
                        <p class="cart-item-variant mb-1">${item.unit} · ${item.color}</p>
                        <div class="d-flex align-items-center">
                            <button class="cart-qty-btn"
                                    onclick="POS.updateQty('${item.pid}','${item.unit}','${item.color}',-1)">
                                −
                            </button>
                            <span class="cart-qty-display mx-2">${item.qty}</span>
                            <button class="cart-qty-btn"
                                    onclick="POS.updateQty('${item.pid}','${item.unit}','${item.color}',1)">
                                +
                            </button>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end ml-2" style="flex-shrink:0;gap:8px;">
                        <span class="cart-item-price">${fmt(item.price * item.qty)}</span>
                        <button class="cart-remove-btn"
                                onclick="POS.removeItem('${item.pid}','${item.unit}','${item.color}')">
                            <i class="fas fa-times-circle"></i> Hapus
                        </button>
                    </div>
                </div>
            `).join('');

            $cartItemsList.html(rows);
        }

        updateSummary();
    }

    function updateSummary() {
        const sub   = cart.reduce((s, i) => s + i.price * i.qty, 0);
        const tax   = sub * TAX_RATE;
        const total = Math.max(0, sub + tax - activeDiscount);

        $summarySubtotal.text(fmt(sub));
        $summaryTax.text(fmt(tax));
        $summaryTotal.text(fmt(total));
        $checkoutTotal.text(fmt(total));

        if (activeDiscount > 0) {
            $discountRow.css('display', 'flex');
            $summaryDiscount.text('-' + fmt(activeDiscount));
        }
    }

    /* ============================================================
       SEARCH & FILTER KATEGORI
    ============================================================ */
    function filterProducts() {
        const q   = $productSearch.val().toLowerCase().trim();
        const cat = $('.cat-btn.btn-primary').data('category') || 'all';
        let visible = 0;

        $('.product-col').each(function () {
            const matchSearch = !q
                || $(this).data('name').includes(q)
                || ($(this).data('sku') || '').toString().includes(q);
            const matchCat = cat === 'all' || $(this).data('category') === cat;

            if (matchSearch && matchCat) { $(this).show(); visible++; }
            else                          { $(this).hide(); }
        });

        $emptyState.toggle(visible === 0);
    }

    /* ============================================================
       EVENT BINDING
    ============================================================ */

    // Tombol Tambah ke Keranjang
    $(document).on('click', '.add-cart-btn', function (e) {
        e.stopPropagation();
        const $col = $(this).closest('.product-col');
        addToCart($col);

        const $btn = $(this);
        $btn.addClass('added').html('<i class="fas fa-check"></i>');
        setTimeout(() => {
            $btn.removeClass('added').html('<i class="fas fa-cart-plus"></i>');
        }, 700);

        toast('success', $(this).data('product-name') + ' ditambahkan ke keranjang');
    });

    // Qty stepper di katalog
    $(document).on('click', '.qty-dec', function (e) {
        e.stopPropagation();
        const $inp = $(this).closest('.qty-stepper').find('.qty-input');
        $inp.val(Math.max(1, parseInt($inp.val() || 1) - 1));
    });
    $(document).on('click', '.qty-inc', function (e) {
        e.stopPropagation();
        const $inp = $(this).closest('.qty-stepper').find('.qty-input');
        $inp.val(Math.min(99, parseInt($inp.val() || 1) + 1));
    });

    // Filter kategori
    $(document).on('click', '.cat-btn', function () {
        $('.cat-btn')
            .removeClass('btn-primary')
            .addClass('btn-outline-primary');
        $(this)
            .removeClass('btn-outline-primary')
            .addClass('btn-primary');
        filterProducts();
    });

    // Search input
    $productSearch.on('input', filterProducts);

    // Keyboard shortcut Ctrl+K / Cmd+K → fokus search
    $(document).on('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            $productSearch.focus();
        }
    });

    // Kosongkan keranjang
    $('#clearCartBtn').on('click', function () {
        if (!cart.length) return;
        if (confirm('Kosongkan semua item di keranjang?')) clearCart();
    });

    // Terapkan voucher
    $('#couponApplyBtn').on('click', function () {
        const code = $('#couponInput').val().trim().toUpperCase();
        if (COUPONS[code]) {
            activeDiscount = COUPONS[code];
            updateSummary();
            toast('success', `Voucher "${code}" berhasil — Diskon ${fmt(activeDiscount)}`);
        } else if (code) {
            toast('error', 'Kode voucher tidak valid');
        }
    });

    // Metode pembayaran
    $(document).on('click', '.pay-method', function (e) {
        e.preventDefault();
        $('.pay-method').removeClass('active');
        $(this).addClass('active');
    });

    // View toggle Grid / List
    $('#gridViewBtn').on('click', function () {
        $('.view-toggle').removeClass('active btn-outline-primary').addClass('btn-outline-secondary');
        $(this).addClass('active btn-outline-primary').removeClass('btn-outline-secondary');
        $('.product-col').attr('class', function (_, c) {
            return c.replace(/col-\S+/g, '');
        }).addClass('col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4 product-col');
    });

    $('#listViewBtn').on('click', function () {
        $('.view-toggle').removeClass('active btn-outline-primary').addClass('btn-outline-secondary');
        $(this).addClass('active btn-outline-primary').removeClass('btn-outline-secondary');
        $('.product-col').attr('class', function (_, c) {
            return c.replace(/col-\S+/g, '');
        }).addClass('col-12 mb-4 product-col');
    });

    // Checkout
    $('#checkoutBtn').on('click', function () {
        if (!cart.length) return;
        const sub    = cart.reduce((s, i) => s + i.price * i.qty, 0);
        const total  = Math.max(0, sub * (1 + TAX_RATE) - activeDiscount);
        const method = $('.pay-method.active').data('method') || 'cash';
        const payload = { cart, total, method };

        console.log('Checkout →', payload);

        // → Ganti dengan AJAX ke controller:
        // $.post('/pos/checkout', payload, ...)

        toast('success', `Pembayaran ${fmt(total)} via ${method.toUpperCase()} berhasil!`);
    });

    /* ============================================================
       EXPOSE GLOBAL — untuk onclick inline di HTML cart
    ============================================================ */
    window.POS = {
        updateQty,
        removeItem,
        resetSearch() {
            $productSearch.val('');
            $('.cat-btn').removeClass('btn-primary').addClass('btn-outline-primary');
            $('.cat-btn[data-category="all"]').removeClass('btn-outline-primary').addClass('btn-primary');
            filterProducts();
        },
    };

});
</script>
@endpush