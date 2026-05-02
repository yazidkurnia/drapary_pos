@extends('layouts.app')
@php use Illuminate\Support\Facades\Storage; @endphp

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
        </div>

        {{-- Brand Pills (diambil dari DB) --}}
        <div class="d-flex flex-nowrap overflow-auto pb-2 mb-3 category-scroll">
            <button class="btn btn-primary btn-sm rounded-pill px-3 mr-2 cat-btn flex-shrink-0"
                    data-category="all">
                <i class="fas fa-th-large mr-1"></i> Semua
            </button>
            @foreach($brands as $brand)
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3 mr-2 cat-btn flex-shrink-0"
                    data-category="{{ $brand->id }}">
                {{ $brand->brand_name }}
            </button>
            @endforeach
        </div>

        {{-- Stats + View Toggle --}}
        <div class="d-flex align-items-center mb-3">
            <span class="badge badge-pill badge-success mr-2">{{ $products->count() }}</span>
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
            @php
                $variants    = $product->variants;
                $firstVar    = $variants->first();

                /* Gambar utama: ambil primary image dari varian pertama */
                $heroImg = null;
                if ($firstVar) {
                    $heroImgObj = $firstVar->images->firstWhere('is_primary', 1) ?? $firstVar->images->first();
                    $heroImg    = $heroImgObj ? Storage::url($heroImgObj->image_path) : null;
                }
                $heroImg = $heroImg ?? 'https://placehold.co/600x400/e4e6fc/6777ef?text=No+Image';

                /* Stok & harga dari varian pertama */
                $firstStock = $firstVar?->stock ?? 0;
                $firstPrice = $firstVar?->price ?? 0;
                $firstSku   = $firstVar?->sku   ?? '-';

                /* JSON semua varian untuk JavaScript */
                $variantsJson = $variants->map(function ($v) {
                    $img    = $v->images->firstWhere('is_primary', 1) ?? $v->images->first();
                    $imgUrl = $img ? Storage::url($img->image_path) : null;
                    $label  = collect([$v->color?->color_name, $v->size?->size_name])
                                ->filter()->join(' / ') ?: $v->sku;
                    return [
                        'id'        => $v->id,
                        'sku'       => $v->sku,
                        'price'     => (float) $v->price,
                        'stock'     => $v->stock,
                        'label'     => $label,
                        'image_url' => $imgUrl,
                    ];
                })->values()->toArray();
            @endphp

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-4 product-col"
                 data-category="{{ $product->brand_id ?? 'all' }}"
                 data-name="{{ strtolower($product->product_name) }}"
                 data-sku="{{ $variants->pluck('sku')->map(fn($s)=>strtolower($s))->join(' ') }}"
                 style="animation:fadeInUp .35s ease both;animation-delay:{{ $index * 0.04 }}s">

                <div class="card product-card h-100 border-0 shadow-sm"
                     data-variants='@json($variantsJson)'>

                    {{-- Gambar Produk --}}
                    <div class="product-img-wrap position-relative">
                        <img src="{{ $heroImg }}"
                             alt="{{ $product->product_name }}"
                             class="card-img-top product-img"
                             loading="lazy">

                        {{-- Badge Stok (diperbarui JS saat pilih varian) --}}
                        @if (!$variants->isEmpty())
                            @if ($firstStock > 5)
                                <span class="badge badge-pill badge-success product-badge-stock">In Stock</span>
                            @elseif ($firstStock > 0)
                                <span class="badge badge-pill badge-warning product-badge-stock">Stok Tipis</span>
                            @else
                                <span class="badge badge-pill badge-danger product-badge-stock">Habis</span>
                            @endif
                        @else
                            <span class="badge badge-pill badge-secondary product-badge-stock">Belum Ada Varian</span>
                        @endif

                        {{-- Badge Brand --}}
                        <span class="badge badge-pill badge-primary product-badge-cat">
                            {{ Str::limit($product->brand?->brand_name ?? 'Umum', 10) }}
                        </span>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body p-3 d-flex flex-column">

                        {{-- SKU varian aktif + Brand --}}
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <small class="text-muted product-sku-label" style="font-size:.68rem;font-weight:600;">
                                {{ $firstSku }}
                            </small>
                            <span class="badge badge-light" style="font-size:.62rem;">
                                {{ Str::limit($product->brand?->brand_name ?? 'Umum', 10) }}
                            </span>
                        </div>

                        {{-- Nama Produk --}}
                        <h6 class="card-title font-weight-bold text-dark text-truncate mb-1">
                            {{ $product->product_name }}
                        </h6>

                        {{-- Deskripsi --}}
                        <p class="card-text small text-muted mb-2" style="line-height:1.45;">
                            {{ Str::limit($product->description, 55) }}
                        </p>

                        {{-- Varian Thumbnails --}}
                        @if ($variants->isNotEmpty())
                            <div class="variant-thumb-row mb-3">
                                @foreach ($variants as $vIdx => $variant)
                                @php
                                    $vImg    = $variant->images->firstWhere('is_primary', 1) ?? $variant->images->first();
                                    $vImgUrl = $vImg ? Storage::url($vImg->image_path) : null;
                                    $vLabel  = collect([$variant->color?->color_name, $variant->size?->size_name])
                                                 ->filter()->join(' / ') ?: $variant->sku;
                                @endphp
                                <button type="button"
                                        class="variant-thumb {{ $vIdx === 0 ? 'selected' : '' }}"
                                        data-variant-index="{{ $vIdx }}"
                                        title="{{ $vLabel }} — Rp {{ number_format($variant->price, 0, ',', '.') }}"
                                        {{ $variant->stock === 0 ? 'data-sold-out=1' : '' }}>
                                    @if ($vImgUrl)
                                        <img src="{{ $vImgUrl }}" alt="{{ $vLabel }}" loading="lazy">
                                    @else
                                        <span class="variant-thumb-fallback">
                                            {{ Str::upper(Str::substr($vLabel, 0, 2)) }}
                                        </span>
                                    @endif
                                    @if ($variant->stock === 0)
                                        <span class="variant-sold-overlay"></span>
                                    @endif
                                </button>
                                @endforeach
                            </div>
                        @else
                            <p class="small text-muted mb-3">
                                <i class="fas fa-info-circle mr-1"></i> Belum ada varian
                            </p>
                        @endif

                        {{-- Harga + Qty + Tombol Tambah --}}
                        <div class="d-flex align-items-center justify-content-between mt-auto product-card-footer">
                            <div>
                                <small class="d-block text-muted"
                                       style="font-size:.63rem;text-transform:uppercase;letter-spacing:.4px;">
                                    Harga
                                </small>
                                <span class="h6 mb-0 font-weight-bold text-primary product-price-label">
                                    {{ $firstVar ? 'Rp ' . number_format($firstPrice, 0, ',', '.') : '—' }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center">
                                {{-- Qty Stepper — disabled jika tidak ada varian --}}
                                <div class="input-group input-group-sm qty-stepper mr-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary btn-sm px-2 qty-dec"
                                                type="button"
                                                {{ $variants->isEmpty() ? 'disabled' : '' }}>−</button>
                                    </div>
                                    <input type="number"
                                           class="form-control form-control-sm text-center px-0 qty-input"
                                           value="1" min="1" max="99"
                                           {{ $variants->isEmpty() ? 'disabled' : '' }}>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-sm px-2 qty-inc"
                                                type="button"
                                                {{ $variants->isEmpty() ? 'disabled' : '' }}>+</button>
                                    </div>
                                </div>
                                {{-- Tombol Tambah --}}
                                @php
                                    $btnDisabled = $variants->isEmpty() || (int) $firstStock === 0;
                                    $btnTitle    = $variants->isEmpty()
                                        ? 'Produk belum memiliki varian'
                                        : ((int) $firstStock === 0 ? 'Stok habis' : 'Tambah ke Keranjang');
                                @endphp
                                <button class="btn btn-icon btn-sm add-cart-btn {{ $btnDisabled ? 'btn-cart-disabled' : 'btn-primary shadow-primary' }}"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->product_name }}"
                                        title="{{ $btnTitle }}"
                                        {{ $btnDisabled ? 'disabled' : '' }}
                                        style="border-radius:10px;width:34px;height:34px;">
                                    <i class="fas {{ $variants->isEmpty() ? 'fa-ban' : 'fa-cart-plus' }}"></i>
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
    <aside class="pos-cart" id="posCart">

        {{-- Mobile: Drag Indicator --}}
        <div class="cart-drag-indicator d-md-none"></div>

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
            <div class="d-flex align-items-center" style="gap:6px;">
                <button class="btn btn-icon cart-mobile-close d-md-none" id="mobileCartClose" title="Tutup">
                    <i class="fas fa-chevron-down" style="font-size:.8rem;"></i>
                </button>
                <button class="btn btn-icon cart-clear-btn" id="clearCartBtn" title="Kosongkan Keranjang">
                    <i class="fas fa-trash-alt" style="font-size:.8rem;"></i>
                </button>
            </div>
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

            {{-- Ringkasan Harga — kompak --}}
            <div class="cart-summary mb-2">
                <div class="d-flex justify-content-between cart-summary-row">
                    <span class="cart-muted">Subtotal</span>
                    <span class="text-white" id="summarySubtotal">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between cart-summary-row">
                    <span class="cart-muted">PPN (11%)</span>
                    <span class="text-white" id="summaryTax">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between cart-summary-row"
                     id="discountRow" style="display:none!important;">
                    <span class="text-success">Diskon</span>
                    <span class="font-weight-bold text-success" id="summaryDiscount">-Rp 0</span>
                </div>
                <hr class="cart-divider my-2">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="font-weight-600 text-white" style="font-size:.82rem;">Total</span>
                    <span class="font-weight-bold text-white cart-total-value" id="summaryTotal">Rp 0</span>
                </div>
            </div>

            {{-- Metode Pembayaran — inline, lebih kompak --}}
            <ul class="nav nav-pills nav-fill pay-nav mb-2">
                <li class="nav-item">
                    <a class="nav-link active pay-method" data-method="cash" href="#">
                        <i class="fas fa-money-bill-wave mr-1"></i><small>Tunai</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pay-method" data-method="transfer" href="#">
                        <i class="fas fa-university mr-1"></i><small>Transfer</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pay-method" data-method="qris" href="#">
                        <i class="fas fa-qrcode mr-1"></i><small>QRIS</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pay-method" data-method="card" href="#">
                        <i class="fas fa-credit-card mr-1"></i><small>Kartu</small>
                    </a>
                </li>
            </ul>

            {{-- Voucher — collapsible, tersembunyi secara default --}}
            <div class="mb-2">
                <button class="cart-voucher-link" id="voucherToggleBtn" type="button">
                    <i class="fas fa-tag mr-1"></i>
                    <span id="voucherToggleText">Gunakan kode promo</span>
                    <i class="fas fa-chevron-down ml-auto" id="voucherChevron"></i>
                </button>
                <div id="voucherPanel" style="display:none; margin-top:8px;">
                    <div class="input-group input-group-sm">
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
                </div>
            </div>

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

{{-- Mobile: Cart Overlay + FAB --}}
<div id="mobileCartOverlay" class="mobile-cart-overlay"></div>
<button class="mobile-cart-fab d-md-none" id="mobileCartFab" aria-label="Lihat Keranjang">
    <i class="fas fa-shopping-bag"></i>
    <span class="mobile-fab-badge" id="mobileFabBadge">0</span>
</button>

@endsection

@push('style')
<link rel="stylesheet" href="{{ asset('stisla-assets/modules/izitoast/css/iziToast.min.css') }}">
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

    /* ----- Variant Thumbnails ----- */
    .variant-thumb-row {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 6px;
        scrollbar-width: none;
        padding-bottom: 2px;
    }
    .variant-thumb-row::-webkit-scrollbar { display: none; }

    .variant-thumb {
        position: relative;
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        border-radius: 8px;
        border: 2px solid #e4e6fc;
        background: #f5f6ff;
        overflow: hidden;
        padding: 0;
        cursor: pointer;
        transition: border-color .18s, transform .15s, box-shadow .18s;
    }
    .variant-thumb:hover {
        border-color: #6777ef;
        transform: scale(1.1);
    }
    .variant-thumb.selected {
        border-color: #6777ef;
        box-shadow: 0 0 0 3px rgba(103, 119, 239, .22);
        transform: scale(1.06);
    }
    .variant-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        pointer-events: none;
    }
    .variant-thumb-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .6rem;
        font-weight: 700;
        color: #6777ef;
        background: #e8eafd;
        letter-spacing: .5px;
        pointer-events: none;
    }
    /* Overlay sold-out di atas thumbnail */
    .variant-sold-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, .48);
        pointer-events: none;
    }
    .variant-sold-overlay::after {
        content: '✕';
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, .85);
        font-size: .75rem;
        font-weight: 700;
    }
    /* Thumbnail sold-out: cursor tidak allowed */
    .variant-thumb[data-sold-out] { cursor: not-allowed; opacity: .75; }

    /* Tombol Add to Cart */
    .add-cart-btn { transition: transform .2s, background .2s; }
    .add-cart-btn:not(:disabled):hover  { transform: scale(1.1); }
    .add-cart-btn:not(:disabled):active { transform: scale(.9); }
    .add-cart-btn.added  {
        background-color: #47c363 !important;
        border-color: #47c363 !important;
    }

    /* State: tidak ada varian */
    .btn-cart-disabled {
        background: #e4e6fc !important;
        border-color: #e4e6fc !important;
        color: #a0a8c0 !important;
        cursor: not-allowed !important;
        box-shadow: none !important;
        opacity: 1 !important;
    }

    /* Qty stepper ketika disabled */
    .qty-stepper .btn:disabled {
        background: #f5f6ff !important;
        border-color: #e4e6fc !important;
        color: #c4c9e2 !important;
        cursor: not-allowed !important;
        opacity: 1 !important;
    }
    .qty-stepper input:disabled {
        background: #f5f6ff !important;
        color: #c4c9e2 !important;
        cursor: not-allowed !important;
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
    .cart-muted { color: #787f96; font-size: .73rem; }

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
        padding: 10px 16px;
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
        width: 40px;
        height: 40px;
        border-radius: 7px;
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
        padding: 11px 16px 14px;
        border-top: 1px solid rgba(255, 255, 255, .06);
        background: #0f111a;
        flex-shrink: 0;
    }

    /* Summary ringkas */
    .cart-summary-row {
        font-size: .73rem;
        padding: 2px 0;
    }
    .cart-total-value {
        font-size: 1.05rem;
        letter-spacing: -.3px;
    }

    /* Voucher toggle link */
    .cart-voucher-link {
        display: flex;
        align-items: center;
        width: 100%;
        background: transparent;
        border: none;
        color: #5a6078;
        font-size: .72rem;
        padding: 0;
        cursor: pointer;
        gap: 0;
        transition: color .15s;
        line-height: 1.6;
    }
    .cart-voucher-link:hover { color: #a0acf5; }
    .cart-voucher-link #voucherChevron {
        font-size: .6rem;
        transition: transform .2s;
        margin-left: auto;
    }
    .cart-voucher-link.open #voucherChevron { transform: rotate(180deg); }

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
        font-size: .66rem;
        padding: 6px 4px;
        border-radius: 8px;
        border: 1.5px solid rgba(255, 255, 255, .08);
        background: #1a1d2e;
        transition: all .2s;
        margin: 0 2px;
        line-height: 1.3;
        display: flex;
        align-items: center;
        justify-content: center;
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

    /* ─── Mobile FAB ──────────────────────────────────────────── */
    .mobile-cart-fab {
        position: fixed;
        bottom: 22px;
        right: 20px;
        width: 56px;
        height: 56px;
        padding: 0;
        border-radius: 50% !important;
        background: linear-gradient(135deg, #6777ef, #9fa8f5) !important;
        border: none !important;
        color: #fff !important;
        font-size: 1.2rem;
        z-index: 1048;
        box-shadow: 0 6px 20px rgba(103, 119, 239, .55);
        display: flex !important;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
    }
    .mobile-cart-fab:hover  { box-shadow: 0 8px 28px rgba(103, 119, 239, .7); }
    .mobile-cart-fab:active { transform: scale(.92); }

    .mobile-fab-badge {
        position: absolute;
        top: -1px;
        right: -1px;
        background: #fc544b;
        color: #fff;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
        pointer-events: none;
        transition: transform .2s;
    }
    .mobile-fab-badge.bump { transform: scale(1.4); }

    /* ─── Mobile Overlay ──────────────────────────────────────── */
    .mobile-cart-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .52);
        z-index: 1049;
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
    }
    .mobile-cart-overlay.active { display: block; animation: fadeOverlay .25s ease; }
    @keyframes fadeOverlay { from { opacity: 0; } to { opacity: 1; } }

    /* ─── Cart Drag Indicator ─────────────────────────────────── */
    .cart-drag-indicator {
        width: 38px;
        height: 4px;
        border-radius: 2px;
        background: rgba(255, 255, 255, .18);
        margin: 10px auto 0;
        flex-shrink: 0;
    }

    /* ─── Cart Mobile Close ───────────────────────────────────── */
    .cart-mobile-close {
        background: transparent !important;
        border: 1px solid rgba(255, 255, 255, .12) !important;
        color: #787f96 !important;
        border-radius: 8px;
        width: 34px !important;
        height: 34px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all .2s;
    }
    .cart-mobile-close:hover {
        color: #fff !important;
        background: rgba(255, 255, 255, .1) !important;
    }

    /* ─── Body scroll lock when drawer open ──────────────────── */
    body.pos-cart-open { overflow: hidden; }

    /* ─── Responsive ──────────────────────────────────────────── */

    /* ≥1200px — Desktop full */
    @media (min-width: 1200px) {
        .pos-customer-select { max-width: 230px; }
    }

    /* 992–1199px — Desktop medium: cart lebih sempit */
    @media (min-width: 992px) and (max-width: 1199px) {
        .pos-cart { width: 300px; }
        .pos-customer-select { max-width: 190px; }
    }

    /* 768–991px — Tablet: side-by-side, cart ramping */
    @media (min-width: 768px) and (max-width: 991px) {
        .pos-wrapper       { height: calc(100vh - 130px); }
        .pos-cart          { width: 260px; }
        .pos-catalog       { padding: 14px; }
        .pos-customer-select { max-width: 148px; }
        .cart-head         { padding: 14px 16px 12px; }
        .cart-footer       { padding: 12px 14px; }
        .qty-stepper       { width: 76px !important; }
        .pay-nav .nav-link { padding: 6px 2px; font-size: .64rem; }
    }

    /* <768px — Mobile: layout stack + cart sebagai bottom-sheet drawer */
    @media (max-width: 767px) {
        /* Wrapper menjadi halaman penuh */
        .pos-wrapper {
            flex-direction: column;
            height: auto !important;
            overflow: visible;
            border-radius: 0;
            box-shadow: none;
        }
        .pos-catalog {
            overflow: visible;
            border-radius: 0;
            padding: 12px 14px;
            padding-bottom: 90px; /* ruang untuk FAB */
        }
        .product-grid-area {
            overflow: visible;
            margin: 0; /* hapus negative-margin agar tidak overflow */
        }

        /* Cart sebagai fixed bottom-sheet */
        .pos-cart {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100% !important;
            max-height: 88vh;
            height: auto;
            border-radius: 20px 20px 0 0;
            transform: translateY(106%);
            transition: transform .35s cubic-bezier(.4, 0, .2, 1);
            z-index: 1050;
        }
        .pos-cart.cart-open { transform: translateY(0); }

        /* Batasi tinggi area item agar footer selalu terlihat */
        .cart-items-area { max-height: 38vh; }

        /* Product card footer: stack harga di atas, qty+tombol di bawah */
        .product-card-footer {
            flex-direction: column;
            align-items: stretch !important;
            gap: 8px;
        }
        .product-card-footer > .d-flex.align-items-center {
            justify-content: space-between;
        }
        .product-card-footer .qty-stepper { flex: 1; max-width: 110px; }
        .product-card-footer .add-cart-btn {
            width: 44px !important;
            height: 44px !important;
            border-radius: 10px !important;
        }

        /* Qty stepper lebih touch-friendly */
        .qty-dec, .qty-inc { min-width: 32px !important; min-height: 32px !important; }
    }

    /* <576px — Ponsel kecil: topbar vertikal, pills lebih kecil */
    @media (max-width: 575px) {
        .pos-topbar { flex-direction: column; gap: 8px; }
        .pos-customer-select { max-width: 100%; margin-left: 0 !important; }

        .cat-btn { font-size: .7rem !important; padding: .25rem .65rem !important; }

        .pay-nav .nav-link       { padding: 6px 2px; }
        .pay-nav .nav-link small { font-size: .6rem; }

        /* Sembunyikan deskripsi produk di ponsel untuk menghemat ruang */
        .product-card .card-text { display: none !important; }
    }
</style>
@endpush

@push('script')
<script src="{{ asset('stisla-assets/modules/izitoast/js/iziToast.min.js') }}"></script>
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
    function findItem(pid, vid) {
        // vid bisa string (dari onclick) atau number (dari JSON) — pakai == agar keduanya cocok
        return cart.find(i => i.pid === pid && i.vid == vid);
    }

    function addToCart($col) {
        const $thumb    = $col.find('.variant-thumb.selected');
        const variants  = $col.find('.product-card').data('variants') || [];
        const idx       = parseInt($thumb.data('variant-index'));
        const v         = variants[idx];

        if (!v) { toast('error', 'Pilih varian terlebih dahulu'); return; }
        if (v.stock === 0) { toast('error', 'Stok varian ini habis'); return; }

        const pid  = $col.find('.add-cart-btn').data('product-id').toString();
        const name = $col.find('.add-cart-btn').data('product-name');
        const qty  = parseInt($col.find('.qty-input').val()) || 1;
        const img  = $col.find('.product-img').attr('src') || '';

        const existing = findItem(pid, v.id);
        if (existing) {
            existing.qty += qty;
        } else {
            cart.push({ pid, vid: v.id, name, price: v.price, qty, sku: v.sku, label: v.label, img });
        }

        renderCart();
    }

    function updateQty(pid, vid, delta) {
        const item = findItem(pid, vid);
        if (!item) return;
        item.qty = Math.max(1, item.qty + delta);
        renderCart();
    }

    function removeItem(pid, vid) {
        const idx = cart.findIndex(i => i.pid === pid && i.vid == vid);
        if (idx > -1) { cart.splice(idx, 1); renderCart(); }
    }

    function clearCart() {
        cart.length    = 0;
        activeDiscount = 0;
        $('#couponInput').val('');
        $discountRow.hide();
        /* Reset voucher panel & label */
        $('#voucherPanel').slideUp(150);
        $('#voucherToggleBtn').removeClass('open').css('color', '');
        $('#voucherToggleText').text('Gunakan kode promo');
        renderCart();
    }

    function renderCart() {
        const totalItems = cart.reduce((s, i) => s + i.qty, 0);
        $cartCountLabel.text(totalItems);

        /* Update FAB badge */
        const $fab = $('#mobileFabBadge');
        $fab.text(totalItems);
        if (totalItems > 0) {
            $fab.addClass('bump');
            setTimeout(() => $fab.removeClass('bump'), 250);
        }

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
                        <p class="cart-item-variant mb-1">${item.label || item.sku}</p>
                        <div class="d-flex align-items-center">
                            <button class="cart-qty-btn"
                                    onclick="POS.updateQty('${item.pid}','${item.vid}',-1)">
                                −
                            </button>
                            <span class="cart-qty-display mx-2">${item.qty}</span>
                            <button class="cart-qty-btn"
                                    onclick="POS.updateQty('${item.pid}','${item.vid}',1)">
                                +
                            </button>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end ml-2" style="flex-shrink:0;gap:8px;">
                        <span class="cart-item-price">${fmt(item.price * item.qty)}</span>
                        <button class="cart-remove-btn"
                                onclick="POS.removeItem('${item.pid}','${item.vid}')">
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

    // Klik variant thumbnail — pilih varian & perbarui tampilan kartu
    $(document).on('click', '.variant-thumb', function (e) {
        e.stopPropagation();
        const $thumb   = $(this);
        const $col     = $thumb.closest('.product-col');
        const variants = $col.find('.product-card').data('variants') || [];
        const idx      = parseInt($thumb.data('variant-index'));
        const v        = variants[idx];
        if (!v) return;

        // Tandai selected
        $col.find('.variant-thumb').removeClass('selected');
        $thumb.addClass('selected');

        // Perbarui gambar utama jika tersedia
        if (v.image_url) $col.find('.product-img').attr('src', v.image_url);

        // Perbarui label SKU & harga
        $col.find('.product-sku-label').text(v.sku);
        $col.find('.product-price-label').text('Rp ' + v.price.toLocaleString('id-ID'));

        // Perbarui badge stok
        const $badge = $col.find('.product-badge-stock');
        if (v.stock > 5) {
            $badge.attr('class', 'badge badge-pill badge-success product-badge-stock').text('In Stock');
        } else if (v.stock > 0) {
            $badge.attr('class', 'badge badge-pill badge-warning product-badge-stock').text('Stok Tipis');
        } else {
            $badge.attr('class', 'badge badge-pill badge-danger product-badge-stock').text('Habis');
        }

        // Aktif/non-aktif tombol tambah + ubah class & icon sesuai stok
        const $addBtn   = $col.find('.add-cart-btn');
        const outOfStock = v.stock === 0;
        $addBtn.prop('disabled', outOfStock)
               .attr('title', outOfStock ? 'Stok habis' : 'Tambah ke Keranjang')
               .html('<i class="fas fa-cart-plus"></i>')
               .toggleClass('btn-cart-disabled', outOfStock)
               .toggleClass('btn-primary shadow-primary', !outOfStock);

        // Aktif/non-aktif qty stepper
        $col.find('.qty-dec, .qty-inc').prop('disabled', outOfStock);
        $col.find('.qty-input').prop('disabled', outOfStock);
    });

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
        Swal.fire({
            icon: 'warning',
            title: 'Kosongkan Keranjang?',
            text: 'Semua item akan dihapus dari keranjang.',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Kosongkan',
            cancelButtonText: 'Batal',
        }).then(result => { if (result.isConfirmed) clearCart(); });
    });

    // Toggle panel voucher
    $('#voucherToggleBtn').on('click', function () {
        const $panel   = $('#voucherPanel');
        const isOpen   = $panel.is(':visible');
        $panel.slideToggle(200);
        $(this).toggleClass('open', !isOpen);
        if (!isOpen) setTimeout(() => $('#couponInput').focus(), 220);
    });

    // Terapkan voucher
    $('#couponApplyBtn').on('click', function () {
        const code = $('#couponInput').val().trim().toUpperCase();
        if (COUPONS[code]) {
            activeDiscount = COUPONS[code];
            updateSummary();
            /* Tunjukkan status terapkan di toggle */
            $('#voucherToggleText').text(`Promo "${code}" aktif ✓`);
            $('#voucherToggleBtn').css('color', '#47c363');
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
       MOBILE CART DRAWER
    ============================================================ */
    const $posCart       = $('#posCart');
    const $mobileOverlay = $('#mobileCartOverlay');

    function openCartDrawer() {
        $posCart.addClass('cart-open');
        $mobileOverlay.addClass('active');
        $('body').addClass('pos-cart-open');
    }

    function closeCartDrawer() {
        $posCart.removeClass('cart-open');
        $mobileOverlay.removeClass('active');
        $('body').removeClass('pos-cart-open');
    }

    $('#mobileCartFab').on('click', openCartDrawer);
    $('#mobileCartClose').on('click', closeCartDrawer);
    $mobileOverlay.on('click', closeCartDrawer);

    // Tutup drawer otomatis saat resize ke desktop
    $(window).on('resize', function () {
        if ($(this).width() >= 768) closeCartDrawer();
    });

    /* ============================================================
       EXPOSE GLOBAL — untuk onclick inline di HTML cart
    ============================================================ */
    window.POS = {
        updateQty : (pid, vid, delta) => updateQty(pid, vid, delta),
        removeItem: (pid, vid)        => removeItem(pid, vid),
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