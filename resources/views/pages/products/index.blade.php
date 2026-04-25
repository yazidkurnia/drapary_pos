@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="section-body">
    <div class="col-12 bg-white">
        <h1>Daftar Produk</h1>
        <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard</a><span>/ Daftar Produk</span></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-box-open mr-2" style="color:#6777ef;"></i>Daftar Produk</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Produk
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

{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle text-primary mr-1"></i> Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="add-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label>Brand <span class="text-danger">*</span></label>
                        <select class="form-control" id="brand_id">
                            <option value="">-- Pilih Brand --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="brand_id_err"></div>
                    </div>
                    <div class="form-group">
                        <label>Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product_name" placeholder="Contoh: Kaos Polos, Kemeja Flanel">
                        <div class="invalid-feedback" id="product_name_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Deskripsi produk (opsional)"></textarea>
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

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-pencil-alt text-warning mr-1"></i> Edit Produk</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" autocomplete="off">
                    @csrf
                    <input type="hidden" id="mprid">
                    <div class="form-group">
                        <label>Brand <span class="text-danger">*</span></label>
                        <select class="form-control" id="new_brand_id">
                            <option value="">-- Pilih Brand --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="new_brand_id_err"></div>
                    </div>
                    <div class="form-group">
                        <label>Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_product_name" placeholder="Nama produk">
                        <div class="invalid-feedback" id="new_product_name_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="new_description" rows="3"></textarea>
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
        #products-table tbody td.dataTables_empty { padding: 0 !important; border: none !important; }
    </style>
@endpush

@push('script')
    <script src="{{ asset('stisla-assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function () {
            $('#addModal').on('hidden.bs.modal', function () {
                $('#brand_id, #product_name, #description').val('').removeClass('is-invalid');
                $('#brand_id_err, #product_name_err').text('');
            });
            $(document).on('draw.dt', '#products-table', function () { $('[data-toggle="tooltip"]').tooltip(); });
        });

        function setLoad(s) { s === 'load' ? Swal.fire({ title: 'Memuat data...', allowOutsideClick: false, didOpen: () => Swal.showLoading() }) : Swal.close(); }
        function swalAlert(s, m) { Swal.fire({ icon: s, title: s === 'success' ? 'Berhasil!' : 'Gagal!', text: m, showConfirmButton: true }); }

        function edit(id) {
            $('#mprid').val(id);
            if (!id) { swalAlert('error', 'Terjadi kesalahan saat mengambil data'); return; }
            setLoad('load');
            $.ajax({
                url: '{{ route('products.edit', ':id') }}'.replace(':id', id),
                method: 'GET', dataType: 'json',
                success: function (r) {
                    setLoad('close');
                    $('#new_brand_id').val(r.data.brand_id).removeClass('is-invalid');
                    $('#new_product_name').val(r.data.product_name).removeClass('is-invalid');
                    $('#new_description').val(r.data.description ?? '');
                    $('#editModal').modal('show');
                },
                error: function () { setLoad('close'); swalAlert('error', 'Terjadi kesalahan saat mengambil data'); }
            });
        }

        function save() {
            const brandId = $('#brand_id').val(), name = $('#product_name').val().trim();
            if (!brandId) { $('#brand_id').addClass('is-invalid'); $('#brand_id_err').text('Brand harus dipilih.'); return; }
            $('#brand_id').removeClass('is-invalid');
            if (!name) { $('#product_name').addClass('is-invalid'); $('#product_name_err').text('Nama produk tidak boleh kosong.'); return; }
            $('#product_name').removeClass('is-invalid');
            setLoad('load');
            $.ajax({
                url: '{{ route('products.store') }}', method: 'POST',
                data: { _token: '{{ csrf_token() }}', brand_id: brandId, product_name: name, description: $('#description').val() },
                success: function (r) {
                    setLoad('close');
                    if (r.status === 'failed') { swalAlert('error', r.message); }
                    else { $('#addModal').modal('hide'); $('#products-table').DataTable().ajax.reload(); swalAlert('success', 'Produk berhasil ditambahkan.'); }
                },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan.'); }
            });
        }

        function update() {
            const brandId = $('#new_brand_id').val(), name = $('#new_product_name').val().trim(), mprid = $('#mprid').val();
            if (!brandId) { $('#new_brand_id').addClass('is-invalid'); $('#new_brand_id_err').text('Brand harus dipilih.'); return; }
            $('#new_brand_id').removeClass('is-invalid');
            if (!name) { $('#new_product_name').addClass('is-invalid'); $('#new_product_name_err').text('Nama produk tidak boleh kosong.'); return; }
            $('#new_product_name').removeClass('is-invalid');
            setLoad('load');
            $.ajax({
                url: '{{ route('products.update', ':id') }}'.replace(':id', mprid), method: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'PUT', brand_id: brandId, product_name: name, description: $('#new_description').val() },
                success: function (r) {
                    setLoad('close');
                    if (r.status === 'failed') { swalAlert('error', r.message); }
                    else { $('#editModal').modal('hide'); $('#products-table').DataTable().ajax.reload(); swalAlert('success', 'Produk berhasil diubah!'); }
                },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan.'); }
            });
        }

        function delete_product(id) {
            $.ajax({
                url: '{{ route('products.destroy', ':id') }}'.replace(':id', id), method: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                success: function () { setLoad('close'); $('#products-table').DataTable().ajax.reload(); swalAlert('success', 'Produk berhasil dihapus.'); },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan.'); }
            });
        }

        function confirmDelete(id) {
            Swal.fire({ icon: 'warning', title: 'Hapus Produk?', text: 'Semua varian produk ini juga akan dihapus!', showCancelButton: true, confirmButtonColor: '#e3342f', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
                .then((r) => { if (r.isConfirmed) delete_product(id); });
        }
    </script>
@endpush
