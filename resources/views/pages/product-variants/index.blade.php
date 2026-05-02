@extends('layouts.app')

@section('title', 'Varian Produk')

@section('content')
<div class="section-body">
    <div class="col-12 bg-white">
        <h1>Varian Produk</h1>
        <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard</a><span>/ Varian Produk</span></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-tags mr-2" style="color:#6777ef;"></i>Daftar Varian Produk</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Varian
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table(['class' => 'table table-striped table-hover w-100']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Add Modal ──────────────────────────────────────────────── --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle text-primary mr-1"></i> Tambah Varian Produk</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="max-height:75vh;overflow-y:auto;">
                <form id="add-form" autocomplete="off">
                    @csrf
                    {{-- Produk --}}
                    <div class="section-title font-weight-bold text-primary mb-2"><i class="fas fa-box mr-1"></i> Informasi Produk</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Brand <span class="text-danger">*</span></label>
                                <select class="form-control" id="brand_id" onchange="loadProducts(this.value, 'product_id')">
                                    <option value="">-- Pilih Brand --</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="brand_id_err"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Produk <span class="text-danger">*</span></label>
                                <select class="form-control" id="product_id">
                                    <option value="">-- Pilih produk --</option>
                                </select>
                                <div class="invalid-feedback" id="product_id_err"></div>
                            </div>
                        </div>
                    </div>

                    {{-- SKU --}}
                    <div class="form-group">
                        <label>SKU <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sku" placeholder="Contoh: ABC-KP-RED-M">
                        <small class="text-muted">Kode unik untuk setiap varian (Stock Keeping Unit)</small>
                        <div class="invalid-feedback" id="sku_err"></div>
                    </div>

                    <hr class="my-3">

                    {{-- Parameter Varian --}}
                    <div class="section-title font-weight-bold text-primary mb-2"><i class="fas fa-sliders-h mr-1"></i> Parameter Varian <small class="text-muted font-weight-normal">(semua opsional)</small></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Warna</label>
                                <select class="form-control" id="color_id">
                                    <option value="">-- Pilih Warna --</option>
                                    @foreach($colors as $item)
                                        <option value="{{ $item->id }}">{{ $item->color_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ukuran</label>
                                <select class="form-control" id="size_id">
                                    <option value="">-- Pilih Ukuran --</option>
                                    @foreach($sizes as $item)
                                        <option value="{{ $item->id }}">{{ $item->size_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Material</label>
                                <select class="form-control" id="material_id">
                                    <option value="">-- Pilih Material --</option>
                                    @foreach($materials as $item)
                                        <option value="{{ $item->id }}">{{ $item->material_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Potongan</label>
                                <select class="form-control" id="fit_id">
                                    <option value="">-- Pilih Tipe Potongan --</option>
                                    @foreach($fits as $item)
                                        <option value="{{ $item->id }}">{{ $item->fit_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Lengan</label>
                                <select class="form-control" id="sleeve_id">
                                    <option value="">-- Pilih Tipe Lengan --</option>
                                    @foreach($sleeves as $item)
                                        <option value="{{ $item->id }}">{{ $item->sleeve_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Leher</label>
                                <select class="form-control" id="collar_id">
                                    <option value="">-- Pilih Tipe Leher --</option>
                                    @foreach($collars as $item)
                                        <option value="{{ $item->id }}">{{ $item->collar_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Motif/Pola</label>
                                <select class="form-control" id="pattern_id">
                                    <option value="">-- Pilih Motif/Pola --</option>
                                    @foreach($patterns as $item)
                                        <option value="{{ $item->id }}">{{ $item->pattern_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" id="gender_id">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    @foreach($genders as $item)
                                        <option value="{{ $item->id }}">{{ $item->gender_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    {{-- Inventori --}}
                    <div class="section-title font-weight-bold text-primary mb-2"><i class="fas fa-warehouse mr-1"></i> Inventori</div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Satuan</label>
                                <select class="form-control" id="unit_id">
                                    <option value="">-- Pilih Satuan --</option>
                                    @foreach($units as $item)
                                        <option value="{{ $item->id }}">{{ $item->unit_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                    <input type="number" class="form-control" id="price" placeholder="0" min="0">
                                </div>
                                <div class="invalid-feedback d-block" id="price_err"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="stock" placeholder="0" min="0">
                                <div class="invalid-feedback" id="stock_err"></div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    {{-- Gambar --}}
                    <div class="section-title font-weight-bold text-primary mb-2"><i class="fas fa-images mr-1"></i> Gambar Produk <small class="text-muted font-weight-normal">(opsional, bisa lebih dari satu)</small></div>
                    <div id="add-image-preview-wrap" class="d-flex flex-wrap mb-2" style="gap:8px;min-height:40px;"></div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="$('#add_image_input').click()">
                            <i class="fas fa-plus mr-1"></i> Tambah Gambar
                        </button>
                        <small class="text-muted ml-2">Format: JPG, PNG, WEBP — Maks. 2MB per file</small>
                    </div>
                    <input type="file" id="add_image_input" multiple accept="image/*" class="d-none">
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                <button type="button" class="btn btn-primary" onclick="save()"><i class="fas fa-save mr-1"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Edit Modal ─────────────────────────────────────────────── --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-pencil-alt text-warning mr-1"></i> Edit Varian Produk</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="max-height:75vh;overflow-y:auto;">
                <form id="edit-form" autocomplete="off">
                    @csrf
                    <input type="hidden" id="mvid">
                    {{-- Produk --}}
                    <div class="section-title font-weight-bold text-primary mb-2"><i class="fas fa-box mr-1"></i> Informasi Produk</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Brand <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_brand_id" onchange="loadProducts(this.value, 'edit_product_id')">
                                    <option value="">-- Pilih Brand --</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Produk <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_product_id">
                                    <option value="">-- Pilih produk --</option>
                                </select>
                                <div class="invalid-feedback" id="edit_product_id_err"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>SKU <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_sku">
                        <div class="invalid-feedback" id="edit_sku_err"></div>
                    </div>

                    <hr class="my-3">

                    <div class="section-title font-weight-bold text-primary mb-2"><i class="fas fa-sliders-h mr-1"></i> Parameter Varian <small class="text-muted font-weight-normal">(semua opsional)</small></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Warna</label>
                                <select class="form-control" id="edit_color_id">
                                    <option value="">-- Pilih Warna --</option>
                                    @foreach($colors as $item)
                                        <option value="{{ $item->id }}">{{ $item->color_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ukuran</label>
                                <select class="form-control" id="edit_size_id">
                                    <option value="">-- Pilih Ukuran --</option>
                                    @foreach($sizes as $item)
                                        <option value="{{ $item->id }}">{{ $item->size_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Material</label>
                                <select class="form-control" id="edit_material_id">
                                    <option value="">-- Pilih Material --</option>
                                    @foreach($materials as $item)
                                        <option value="{{ $item->id }}">{{ $item->material_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Potongan</label>
                                <select class="form-control" id="edit_fit_id">
                                    <option value="">-- Pilih Tipe Potongan --</option>
                                    @foreach($fits as $item)
                                        <option value="{{ $item->id }}">{{ $item->fit_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Lengan</label>
                                <select class="form-control" id="edit_sleeve_id">
                                    <option value="">-- Pilih Tipe Lengan --</option>
                                    @foreach($sleeves as $item)
                                        <option value="{{ $item->id }}">{{ $item->sleeve_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Leher</label>
                                <select class="form-control" id="edit_collar_id">
                                    <option value="">-- Pilih Tipe Leher --</option>
                                    @foreach($collars as $item)
                                        <option value="{{ $item->id }}">{{ $item->collar_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Motif/Pola</label>
                                <select class="form-control" id="edit_pattern_id">
                                    <option value="">-- Pilih Motif/Pola --</option>
                                    @foreach($patterns as $item)
                                        <option value="{{ $item->id }}">{{ $item->pattern_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" id="edit_gender_id">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    @foreach($genders as $item)
                                        <option value="{{ $item->id }}">{{ $item->gender_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="section-title font-weight-bold text-primary mb-2"><i class="fas fa-warehouse mr-1"></i> Inventori</div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Satuan</label>
                                <select class="form-control" id="edit_unit_id">
                                    <option value="">-- Pilih Satuan --</option>
                                    @foreach($units as $item)
                                        <option value="{{ $item->id }}">{{ $item->unit_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                    <input type="number" class="form-control" id="edit_price" min="0">
                                </div>
                                <div class="invalid-feedback d-block" id="edit_price_err"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_stock" min="0">
                                <div class="invalid-feedback" id="edit_stock_err"></div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    {{-- Gambar --}}
                    <div class="section-title font-weight-bold text-primary mb-2"><i class="fas fa-images mr-1"></i> Gambar Produk <small class="text-muted font-weight-normal">(opsional, bisa lebih dari satu)</small></div>
                    <div id="edit-existing-images" class="d-flex flex-wrap mb-2" style="gap:8px;min-height:40px;">
                        <p class="text-muted small my-auto">Memuat gambar...</p>
                    </div>
                    <div id="edit-image-preview-wrap" class="d-flex flex-wrap mb-2" style="gap:8px;"></div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="$('#edit_image_input').click()">
                            <i class="fas fa-plus mr-1"></i> Tambah Gambar Baru
                        </button>
                        <small class="text-muted ml-2">Format: JPG, PNG, WEBP — Maks. 2MB per file</small>
                    </div>
                    <input type="file" id="edit_image_input" multiple accept="image/*" class="d-none">
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                <button type="button" class="btn btn-primary" onclick="update()"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
{{-- ── View Images Modal ───────────────────────────────────── --}}
<div class="modal fade" id="viewImagesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewImagesModalTitle">
                    <i class="fas fa-images text-primary mr-1"></i> Galeri Gambar Varian
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="view-images-gallery" class="d-flex flex-wrap justify-content-start" style="gap:12px;min-height:80px;align-items:flex-start;">
                    <p class="text-muted small my-auto">Memuat gambar...</p>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <small class="text-muted mr-auto"><i class="fas fa-info-circle mr-1"></i> Klik gambar untuk melihat ukuran penuh</small>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('stisla-assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <style>
        .dt-empty-state { padding: 48px 24px; text-align: center; }
        .dt-empty-icon { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #6777ef22, #6777ef11); border: 2px dashed #6777ef55; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .dt-empty-icon i { font-size: 32px; color: #6777ef; opacity: .7; }
        .dt-empty-title { font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .dt-empty-desc { font-size: 13px; color: #9ca3af; line-height: 1.6; margin-bottom: 0; }
        #product-variants-table tbody td.dataTables_empty { padding: 0 !important; border: none !important; }
        .section-title { font-size: 13px; text-transform: uppercase; letter-spacing: .5px; }
        .img-thumb-wrap { position: relative; width: 80px; height: 80px; flex-shrink: 0; }
        .img-thumb-wrap img { width: 100%; height: 100%; object-fit: cover; border-radius: 6px; border: 1px solid #dee2e6; }
        .img-thumb-wrap .img-remove-btn {
            position: absolute; top: -6px; right: -6px;
            width: 20px; height: 20px; border-radius: 50%;
            background: #e3342f; border: none; color: #fff;
            font-size: 11px; line-height: 20px; text-align: center;
            cursor: pointer; padding: 0;
        }
        .img-thumb-wrap .img-primary-badge {
            position: absolute; bottom: 2px; left: 2px;
            background: #6777ef; color: #fff;
            font-size: 9px; padding: 1px 4px; border-radius: 3px;
        }
        /* Gallery modal */
        .gallery-item {
            position: relative;
            width: 140px; height: 140px;
            flex-shrink: 0;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #dee2e6;
            cursor: pointer;
            transition: border-color .2s, transform .2s;
        }
        .gallery-item:hover { border-color: #6777ef; transform: scale(1.03); }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .gallery-item .gallery-primary-badge {
            position: absolute; top: 6px; left: 6px;
            background: #6777ef; color: #fff;
            font-size: 10px; font-weight: 600;
            padding: 2px 6px; border-radius: 4px;
        }
        .gallery-item .gallery-overlay {
            position: absolute; inset: 0;
            background: rgba(0,0,0,0); display: flex;
            align-items: center; justify-content: center;
            transition: background .2s;
        }
        .gallery-item:hover .gallery-overlay { background: rgba(0,0,0,.25); }
        .gallery-item .gallery-overlay i { color: #fff; font-size: 22px; opacity: 0; transition: opacity .2s; }
        .gallery-item:hover .gallery-overlay i { opacity: 1; }
    </style>
@endpush

@push('script')
    <script src="{{ asset('stisla-assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    {{ $dataTable->scripts() }}
    <script>
        const PRODUCTS_BY_BRAND_URL      = '{{ route('products.by-brand', ':id') }}';
        const DELETE_IMAGE_URL           = '{{ route('product-variant-images.destroy', ':id') }}';

        /* ── Pending images state ──────────────────────────────── */
        let addPendingImages  = [];   // File[] untuk modal tambah
        let editPendingImages = [];   // File[] untuk modal edit

        $(document).ready(function () {
            $('#addModal').on('hidden.bs.modal', resetAddForm);
            $('#editModal').on('hidden.bs.modal', function () {
                editPendingImages = [];
                $('#edit-image-preview-wrap').empty();
                $('#edit_image_input').val('');
            });
            $(document).on('draw.dt', '#product-variants-table', function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

            /* ── File input listeners ───────────────────────────── */
            $('#add_image_input').on('change', function () {
                Array.from(this.files).forEach(f => appendPendingPreview(f, 'add'));
                this.value = '';
            });
            $('#edit_image_input').on('change', function () {
                Array.from(this.files).forEach(f => appendPendingPreview(f, 'edit'));
                this.value = '';
            });
        });

        /* ── Helpers ───────────────────────────────────────────── */
        function setLoad(s) {
            s === 'load'
                ? Swal.fire({ title: 'Memuat data...', allowOutsideClick: false, didOpen: () => Swal.showLoading() })
                : Swal.close();
        }
        function swalAlert(s, m) {
            Swal.fire({ icon: s, title: s === 'success' ? 'Berhasil!' : 'Gagal!', text: m, showConfirmButton: true });
        }

        /* ── Image preview helpers ─────────────────────────────── */
        function appendPendingPreview(file, mode) {
            const arr     = mode === 'add' ? addPendingImages : editPendingImages;
            const idx     = arr.length;
            const wrapId  = mode === 'add' ? 'add-image-preview-wrap' : 'edit-image-preview-wrap';
            arr.push(file);

            const reader = new FileReader();
            reader.onload = e => {
                const html = `
                    <div class="img-thumb-wrap" id="${mode}-pending-${idx}">
                        <img src="${e.target.result}" alt="">
                        <button type="button" class="img-remove-btn" onclick="removePending('${mode}', ${idx})" title="Hapus">×</button>
                    </div>`;
                $('#' + wrapId).append(html);
            };
            reader.readAsDataURL(file);
        }

        function removePending(mode, idx) {
            const arr = mode === 'add' ? addPendingImages : editPendingImages;
            arr[idx] = null;
            $(`#${mode}-pending-${idx}`).remove();
        }

        function buildFormData(prefix) {
            const p  = prefix ? prefix + '_' : '';
            const fd = new FormData();
            fd.append('_token',      '{{ csrf_token() }}');
            fd.append('product_id',  $('#' + p + 'product_id').val()   ?? '');
            fd.append('sku',         ($('#' + p + 'sku').val()         ?? '').trim());
            fd.append('color_id',    $('#' + p + 'color_id').val()     ?? '');
            fd.append('size_id',     $('#' + p + 'size_id').val()      ?? '');
            fd.append('material_id', $('#' + p + 'material_id').val()  ?? '');
            fd.append('fit_id',      $('#' + p + 'fit_id').val()       ?? '');
            fd.append('sleeve_id',   $('#' + p + 'sleeve_id').val()    ?? '');
            fd.append('collar_id',   $('#' + p + 'collar_id').val()    ?? '');
            fd.append('pattern_id',  $('#' + p + 'pattern_id').val()   ?? '');
            fd.append('gender_id',   $('#' + p + 'gender_id').val()    ?? '');
            fd.append('unit_id',     $('#' + p + 'unit_id').val()      ?? '');
            fd.append('price',       $('#' + p + 'price').val()        ?? 0);
            fd.append('stock',       $('#' + p + 'stock').val()        ?? 0);

            const pending = prefix === 'edit' ? editPendingImages : addPendingImages;
            pending.filter(f => f !== null).forEach(f => fd.append('images[]', f));

            return fd;
        }

        function validateFields(prefix) {
            const p      = prefix ? prefix + '_' : '';
            let   valid  = true;
            const pid    = $('#' + p + 'product_id').val();
            const sku    = ($('#' + p + 'sku').val() ?? '').trim();
            const price  = $('#' + p + 'price').val();
            const stock  = $('#' + p + 'stock').val();

            if (!pid) { $('#' + p + 'product_id').addClass('is-invalid'); $('#' + p + 'product_id_err').text('Produk harus dipilih.'); valid = false; }
            else       { $('#' + p + 'product_id').removeClass('is-invalid'); }
            if (!sku)  { $('#' + p + 'sku').addClass('is-invalid'); $('#' + p + 'sku_err').text('SKU tidak boleh kosong.'); valid = false; }
            else       { $('#' + p + 'sku').removeClass('is-invalid'); }
            if (price === '' || Number(price) < 0) { $('#' + p + 'price_err').text('Harga harus diisi.'); valid = false; }
            else                                   { $('#' + p + 'price_err').text(''); }
            if (stock === '') { $('#' + p + 'stock').addClass('is-invalid'); $('#' + p + 'stock_err').text('Stok harus diisi.'); valid = false; }
            else              { $('#' + p + 'stock').removeClass('is-invalid'); }

            return valid;
        }

        /* ── Products dropdown ─────────────────────────────────── */
        function loadProducts(brandId, targetId) {
            const $t = $('#' + targetId);
            $t.html('<option value="">Memuat...</option>');
            if (!brandId) { $t.html('<option value="">-- Pilih produk --</option>'); return; }
            $.get(PRODUCTS_BY_BRAND_URL.replace(':id', brandId), data => {
                let opts = '<option value="">-- Pilih Produk --</option>';
                data.forEach(p => { opts += `<option value="${p.id}">${p.product_name}</option>`; });
                $t.html(opts);
            }).fail(() => $t.html('<option value="">Gagal memuat produk</option>'));
        }

        /* ── Reset add form ────────────────────────────────────── */
        function resetAddForm() {
            $('#add-form select, #add-form input').val('').removeClass('is-invalid');
            $('[id$="_err"]').text('');
            $('#product_id').html('<option value="">-- Pilih produk --</option>');
            addPendingImages = [];
            $('#add-image-preview-wrap').empty();
            $('#add_image_input').val('');
        }

        /* ── CRUD ──────────────────────────────────────────────── */
        function save() {
            if (!validateFields('')) return;
            setLoad('load');
            $.ajax({
                url: '{{ route('product-variants.store') }}',
                method: 'POST',
                data: buildFormData(''),
                processData: false,
                contentType: false,
                success: function (r) {
                    setLoad('close');
                    if (r.status === 'failed') { swalAlert('error', r.message); }
                    else { $('#addModal').modal('hide'); $('#product-variants-table').DataTable().ajax.reload(); swalAlert('success', 'Varian berhasil ditambahkan.'); }
                },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan.'); }
            });
        }

        function edit(id) {
            $('#mvid').val(id);
            if (!id) { swalAlert('error', 'Terjadi kesalahan'); return; }
            setLoad('load');
            $.ajax({
                url: '{{ route('product-variants.edit', ':id') }}'.replace(':id', id),
                method: 'GET', dataType: 'json',
                success: function (r) {
                    setLoad('close');
                    const d = r.data;

                    /* basic fields */
                    const brandId = d.product?.brand_id ?? '';
                    $('#edit_brand_id').val(brandId);
                    if (brandId) {
                        $.get(PRODUCTS_BY_BRAND_URL.replace(':id', brandId), products => {
                            let opts = '<option value="">-- Pilih Produk --</option>';
                            products.forEach(p => { opts += `<option value="${p.id}">${p.product_name}</option>`; });
                            $('#edit_product_id').html(opts).val(d.product_id);
                        });
                    }
                    $('#edit_sku').val(d.sku);
                    $('#edit_color_id').val(d.color_id     ?? '');
                    $('#edit_size_id').val(d.size_id       ?? '');
                    $('#edit_material_id').val(d.material_id ?? '');
                    $('#edit_fit_id').val(d.fit_id         ?? '');
                    $('#edit_sleeve_id').val(d.sleeve_id   ?? '');
                    $('#edit_collar_id').val(d.collar_id   ?? '');
                    $('#edit_pattern_id').val(d.pattern_id ?? '');
                    $('#edit_gender_id').val(d.gender_id   ?? '');
                    $('#edit_unit_id').val(d.unit_id       ?? '');
                    $('#edit_price').val(d.price);
                    $('#edit_stock').val(d.stock);

                    /* existing images */
                    const $wrap = $('#edit-existing-images').empty();
                    if (d.images && d.images.length > 0) {
                        d.images.forEach(img => {
                            $wrap.append(`
                                <div class="img-thumb-wrap" id="existing-img-${img.id}">
                                    <img src="${img.url}" alt="">
                                    ${img.is_primary ? '<span class="img-primary-badge">Utama</span>' : ''}
                                    <button type="button" class="img-remove-btn"
                                        onclick="deleteExistingImage('${img.encrypted_id}', ${img.id})"
                                        title="Hapus gambar ini">×</button>
                                </div>`);
                        });
                    } else {
                        $wrap.html('<p class="text-muted small my-auto">Belum ada gambar</p>');
                    }

                    editPendingImages = [];
                    $('#edit-image-preview-wrap').empty();
                    $('#editModal').modal('show');
                },
                error: function () { setLoad('close'); swalAlert('error', 'Terjadi kesalahan saat mengambil data'); }
            });
        }

        function update() {
            if (!validateFields('edit')) return;
            const mvid = $('#mvid').val();
            const fd   = buildFormData('edit');
            fd.append('_method', 'PUT');
            setLoad('load');
            $.ajax({
                url: '{{ route('product-variants.update', ':id') }}'.replace(':id', mvid),
                method: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                success: function (r) {
                    setLoad('close');
                    if (r.status === 'failed') { swalAlert('error', r.message); }
                    else { $('#editModal').modal('hide'); $('#product-variants-table').DataTable().ajax.reload(); swalAlert('success', 'Varian berhasil diubah!'); }
                },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan.'); }
            });
        }

        function deleteExistingImage(encryptedId, rawId) {
            Swal.fire({
                icon: 'warning', title: 'Hapus Gambar?',
                text: 'Gambar akan dihapus permanen.',
                showCancelButton: true,
                confirmButtonColor: '#e3342f', cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
            }).then(result => {
                if (!result.isConfirmed) return;
                $.ajax({
                    url: DELETE_IMAGE_URL.replace(':id', encryptedId),
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                    success: function (r) {
                        if (r.status === 'success') {
                            $(`#existing-img-${rawId}`).remove();
                            if ($('#edit-existing-images').children().length === 0) {
                                $('#edit-existing-images').html('<p class="text-muted small my-auto">Belum ada gambar</p>');
                            }
                        } else { swalAlert('error', r.message); }
                    },
                    error: function (xhr) { swalAlert('error', xhr.responseJSON?.message ?? 'Gagal menghapus gambar.'); }
                });
            });
        }

        function delete_variant(id) {
            $.ajax({
                url: '{{ route('product-variants.destroy', ':id') }}'.replace(':id', id),
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                success: function () { setLoad('close'); $('#product-variants-table').DataTable().ajax.reload(); swalAlert('success', 'Varian berhasil dihapus.'); },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan.'); }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                icon: 'warning', title: 'Hapus Varian?',
                text: 'Semua gambar varian ini juga akan ikut terhapus!',
                showCancelButton: true,
                confirmButtonColor: '#e3342f', cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
            }).then(r => { if (r.isConfirmed) delete_variant(id); });
        }

        /* ── Gallery viewer ────────────────────────────────────── */
        function viewImages(encryptedId) {
            const $gallery = $('#view-images-gallery');
            $('#viewImagesModalTitle').html('<i class="fas fa-images text-primary mr-1"></i> Galeri Gambar Varian');
            $gallery.html('<p class="text-muted small my-auto"><i class="fas fa-spinner fa-spin mr-1"></i> Memuat gambar...</p>');
            $('#viewImagesModal').modal('show');

            $.ajax({
                url: '{{ route('product-variants.edit', ':id') }}'.replace(':id', encryptedId),
                method: 'GET',
                dataType: 'json',
                success: function (r) {
                    const d      = r.data;
                    const images = d.images ?? [];

                    $('#viewImagesModalTitle').html(
                        '<i class="fas fa-images text-primary mr-1"></i> Galeri Gambar — <span class="text-secondary">' + (d.sku ?? '') + '</span>'
                    );

                    $gallery.empty();

                    if (images.length === 0) {
                        $gallery.html('<div class="w-100 text-center py-4 text-muted"><i class="fas fa-image fa-2x mb-2 d-block"></i>Varian ini belum memiliki gambar.</div>');
                        return;
                    }

                    images.forEach(function (img) {
                        $gallery.append(
                            '<div class="gallery-item" onclick="window.open(\'' + img.url + '\', \'_blank\')" title="Buka gambar penuh">' +
                                '<img src="' + img.url + '" alt="">' +
                                (img.is_primary ? '<span class="gallery-primary-badge">Utama</span>' : '') +
                                '<div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>' +
                            '</div>'
                        );
                    });
                },
                error: function () {
                    $gallery.html('<p class="text-danger small my-auto"><i class="fas fa-exclamation-circle mr-1"></i>Gagal memuat gambar.</p>');
                }
            });
        }
    </script>
@endpush
