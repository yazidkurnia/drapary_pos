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
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                <button type="button" class="btn btn-primary" onclick="update()"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
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
    </style>
@endpush

@push('script')
    <script src="{{ asset('stisla-assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    {{ $dataTable->scripts() }}
    <script>
        const PRODUCTS_BY_BRAND_URL = '{{ route('products.by-brand', ':id') }}';

        $(document).ready(function () {
            $('#addModal').on('hidden.bs.modal', resetAddForm);
            $(document).on('draw.dt', '#product-variants-table', function () { $('[data-toggle="tooltip"]').tooltip(); });
        });

        function resetAddForm() {
            $('#add-form select, #add-form input').val('').removeClass('is-invalid');
            $('[id$="_err"]').text('');
            $('#product_id').html('<option value="">-- Pilih produk --</option>');
        }

        function setLoad(s) { s === 'load' ? Swal.fire({ title: 'Memuat data...', allowOutsideClick: false, didOpen: () => Swal.showLoading() }) : Swal.close(); }
        function swalAlert(s, m) { Swal.fire({ icon: s, title: s === 'success' ? 'Berhasil!' : 'Gagal!', text: m, showConfirmButton: true }); }

        function loadProducts(brandId, targetId) {
            const $target = $('#' + targetId);
            $target.html('<option value="">Memuat...</option>');
            if (!brandId) { $target.html('<option value="">-- Pilih produk --</option>'); return; }
            $.get(PRODUCTS_BY_BRAND_URL.replace(':id', brandId), function (data) {
                let opts = '<option value="">-- Pilih Produk --</option>';
                data.forEach(p => { opts += `<option value="${p.id}">${p.product_name}</option>`; });
                $target.html(opts);
            }).fail(() => $target.html('<option value="">Gagal memuat produk</option>'));
        }

        function collectData(prefix) {
            const p = prefix ? prefix + '_' : '';
            return {
                _token:      '{{ csrf_token() }}',
                product_id:  $('#' + p + 'product_id').val(),
                sku:         $('#' + p + 'sku').val().trim(),
                color_id:    $('#' + p + 'color_id').val()    || null,
                size_id:     $('#' + p + 'size_id').val()     || null,
                material_id: $('#' + p + 'material_id').val() || null,
                fit_id:      $('#' + p + 'fit_id').val()      || null,
                sleeve_id:   $('#' + p + 'sleeve_id').val()   || null,
                collar_id:   $('#' + p + 'collar_id').val()   || null,
                pattern_id:  $('#' + p + 'pattern_id').val()  || null,
                gender_id:   $('#' + p + 'gender_id').val()   || null,
                unit_id:     $('#' + p + 'unit_id').val()     || null,
                price:       $('#' + p + 'price').val(),
                stock:       $('#' + p + 'stock').val(),
            };
        }

        function validateData(data, prefix) {
            const p = prefix ? prefix + '_' : '';
            let valid = true;
            if (!data.product_id) {
                $('#' + p + 'product_id').addClass('is-invalid');
                $('#' + p + 'product_id_err').text('Produk harus dipilih.');
                valid = false;
            } else { $('#' + p + 'product_id').removeClass('is-invalid'); }
            if (!data.sku) {
                $('#' + p + 'sku').addClass('is-invalid');
                $('#' + p + 'sku_err').text('SKU tidak boleh kosong.');
                valid = false;
            } else { $('#' + p + 'sku').removeClass('is-invalid'); }
            if (data.price === '' || data.price < 0) {
                $('#' + p + 'price_err').text('Harga harus diisi.');
                valid = false;
            } else { $('#' + p + 'price_err').text(''); }
            if (data.stock === '') {
                $('#' + p + 'stock').addClass('is-invalid');
                $('#' + p + 'stock_err').text('Stok harus diisi.');
                valid = false;
            } else { $('#' + p + 'stock').removeClass('is-invalid'); }
            return valid;
        }

        function save() {
            const data = collectData('');
            if (!validateData(data, '')) return;
            setLoad('load');
            $.ajax({
                url: '{{ route('product-variants.store') }}', method: 'POST', data: data,
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
                    const brandId = d.product?.brand_id ?? '';
                    $('#edit_brand_id').val(brandId);

                    // Load products for brand, then set selected product
                    if (brandId) {
                        $.get(PRODUCTS_BY_BRAND_URL.replace(':id', brandId), function (products) {
                            let opts = '<option value="">-- Pilih Produk --</option>';
                            products.forEach(p => { opts += `<option value="${p.id}">${p.product_name}</option>`; });
                            $('#edit_product_id').html(opts).val(d.product_id);
                        });
                    }

                    $('#edit_sku').val(d.sku);
                    $('#edit_color_id').val(d.color_id   ?? '');
                    $('#edit_size_id').val(d.size_id     ?? '');
                    $('#edit_material_id').val(d.material_id ?? '');
                    $('#edit_fit_id').val(d.fit_id       ?? '');
                    $('#edit_sleeve_id').val(d.sleeve_id ?? '');
                    $('#edit_collar_id').val(d.collar_id ?? '');
                    $('#edit_pattern_id').val(d.pattern_id ?? '');
                    $('#edit_gender_id').val(d.gender_id ?? '');
                    $('#edit_unit_id').val(d.unit_id     ?? '');
                    $('#edit_price').val(d.price);
                    $('#edit_stock').val(d.stock);
                    $('#editModal').modal('show');
                },
                error: function () { setLoad('close'); swalAlert('error', 'Terjadi kesalahan saat mengambil data'); }
            });
        }

        function update() {
            const data = collectData('edit');
            if (!validateData(data, 'edit')) return;
            const mvid = $('#mvid').val();
            data._method = 'PUT';
            setLoad('load');
            $.ajax({
                url: '{{ route('product-variants.update', ':id') }}'.replace(':id', mvid), method: 'POST', data: data,
                success: function (r) {
                    setLoad('close');
                    if (r.status === 'failed') { swalAlert('error', r.message); }
                    else { $('#editModal').modal('hide'); $('#product-variants-table').DataTable().ajax.reload(); swalAlert('success', 'Varian berhasil diubah!'); }
                },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan.'); }
            });
        }

        function delete_variant(id) {
            $.ajax({
                url: '{{ route('product-variants.destroy', ':id') }}'.replace(':id', id), method: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                success: function () { setLoad('close'); $('#product-variants-table').DataTable().ajax.reload(); swalAlert('success', 'Varian berhasil dihapus.'); },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan.'); }
            });
        }

        function confirmDelete(id) {
            Swal.fire({ icon: 'warning', title: 'Hapus Varian?', text: 'Data yang dihapus tidak dapat dikembalikan!', showCancelButton: true, confirmButtonColor: '#e3342f', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
                .then((r) => { if (r.isConfirmed) delete_variant(id); });
        }
    </script>
@endpush
