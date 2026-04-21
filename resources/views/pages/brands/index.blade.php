@extends('layouts.app')

@section('title', 'Manage Brand')

@section('content')

<div class="section-body">
    <div class="col-12 bg-white">
        <h1>Manage Brand</h1>
        <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard </a><span>/ Manage Brand</span></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-tag mr-2" style="color:#6777ef;"></i>Daftar Brand</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Brand
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

{{-- ── Add Modal ─────────────────────────────────────────────────── --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">
                    <i class="fas fa-plus-circle text-primary mr-1"></i> Tambah Data Brand
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="brand_name">Nama Brand <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="brand_name" placeholder="Contoh: Nike, Adidas">
                        <div class="invalid-feedback" id="brand_name_err"></div>
                    </div>
                    <div class="form-group">
                        <label for="brand_code">Kode Brand <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="brand_code" placeholder="Contoh: NKE, ADI">
                        <div class="invalid-feedback" id="brand_code_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Deskripsi singkat brand (opsional)"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" onclick="save()">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Edit Modal ────────────────────────────────────────────────── --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-pencil-alt text-warning mr-1"></i> Edit Data Brand
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form" autocomplete="off">
                    @csrf
                    <input type="hidden" id="mbid" value="">
                    <div class="form-group">
                        <label for="new_brand_name">Nama Brand <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_brand_name" placeholder="Nama brand">
                        <div class="invalid-feedback" id="new_brand_name_err"></div>
                    </div>
                    <div class="form-group">
                        <label for="new_brand_code">Kode Brand <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_brand_code" placeholder="Kode brand">
                        <div class="invalid-feedback" id="new_brand_code_err"></div>
                    </div>
                    <div class="form-group">
                        <label for="new_description">Deskripsi</label>
                        <textarea class="form-control" id="new_description" rows="3" placeholder="Deskripsi singkat brand (opsional)"></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="d-block">Status</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active">
                            <label class="custom-control-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" onclick="update()">
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
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
        .dt-empty-state { padding: 48px 24px; text-align: center; }
        .dt-empty-icon {
            width: 80px; height: 80px; border-radius: 50%;
            background: linear-gradient(135deg, #6777ef22, #6777ef11);
            border: 2px dashed #6777ef55;
            display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
        }
        .dt-empty-icon i { font-size: 32px; color: #6777ef; opacity: .7; }
        .dt-empty-title { font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .dt-empty-desc { font-size: 13px; color: #9ca3af; line-height: 1.6; margin-bottom: 0; }
        #brands-table tbody td.dataTables_empty { padding: 0 !important; border: none !important; }
    </style>
@endpush

@push('script')
    <script src="{{ asset('stisla-assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function () {
            $('#addModal').on('hidden.bs.modal', function () {
                $('#brand_name, #brand_code').val('').removeClass('is-invalid');
                $('#brand_name_err, #brand_code_err').text('');
                $('#description').val('');
            });

            $(document).on('draw.dt', '#brands-table', function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        });

        function setLoad(status) {
            if (status === 'load') {
                Swal.fire({ title: 'Memuat data...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            } else {
                Swal.close();
            }
        }

        function swalAlert(status, message) {
            Swal.fire({
                icon: status,
                title: status === 'success' ? 'Berhasil!' : 'Gagal!',
                text: message,
                showConfirmButton: true
            });
        }

        function edit(id) {
            $('#mbid').val(id);
            if (!id) { swalAlert('error', 'Terjadi kesalahan saat mengambil data brand'); return; }

            setLoad('load');
            const routeUrl = '{{ route('brands.edit', ':id') }}'.replace(':id', id);

            $.ajax({
                url: routeUrl,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    setLoad('close');
                    $('#new_brand_name').val(response.data.brand_name).removeClass('is-invalid');
                    $('#new_brand_code').val(response.data.brand_code).removeClass('is-invalid');
                    $('#new_description').val(response.data.description ?? '');
                    $('#is_active').prop('checked', !!response.data.is_active);
                    $('#editModal').modal('show');
                },
                error: function () {
                    setLoad('close');
                    swalAlert('error', 'Terjadi kesalahan saat mengambil data brand');
                }
            });
        }

        function save() {
            const brandName = $('#brand_name').val().trim();
            const brandCode = $('#brand_code').val().trim();

            if (!brandName) {
                $('#brand_name').addClass('is-invalid');
                $('#brand_name_err').text('Nama brand tidak boleh kosong.');
                return;
            }
            $('#brand_name').removeClass('is-invalid');

            if (!brandCode) {
                $('#brand_code').addClass('is-invalid');
                $('#brand_code_err').text('Kode brand tidak boleh kosong.');
                return;
            }
            $('#brand_code').removeClass('is-invalid');

            setLoad('load');
            $.ajax({
                url: '{{ route('brands.store') }}',
                method: 'POST',
                data: {
                    _token:      '{{ csrf_token() }}',
                    brand_name:  brandName,
                    brand_code:  brandCode,
                    description: $('#description').val().trim(),
                },
                success: function (response) {
                    setLoad('close');
                    if (response.status === 'failed') {
                        swalAlert('error', response.message);
                    } else {
                        $('#addModal').modal('hide');
                        $('#brands-table').DataTable().ajax.reload();
                        swalAlert('success', 'Brand berhasil ditambahkan.');
                    }
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function update() {
            const newBrandName = $('#new_brand_name').val().trim();
            const newBrandCode = $('#new_brand_code').val().trim();
            const mbid         = $('#mbid').val();
            const routeUrl     = '{{ route('brands.update', ':mbid') }}'.replace(':mbid', mbid);

            if (!newBrandName) {
                $('#new_brand_name').addClass('is-invalid');
                $('#new_brand_name_err').text('Nama brand tidak boleh kosong.');
                return;
            }
            $('#new_brand_name').removeClass('is-invalid');

            if (!newBrandCode) {
                $('#new_brand_code').addClass('is-invalid');
                $('#new_brand_code_err').text('Kode brand tidak boleh kosong.');
                return;
            }
            $('#new_brand_code').removeClass('is-invalid');

            setLoad('load');
            $.ajax({
                url: routeUrl,
                method: 'POST',
                data: {
                    _token:      '{{ csrf_token() }}',
                    _method:     'PUT',
                    brand_name:  newBrandName,
                    brand_code:  newBrandCode,
                    description: $('#new_description').val().trim(),
                    is_active:   $('#is_active').is(':checked') ? 1 : 0,
                },
                success: function (response) {
                    setLoad('close');
                    if (response.status === 'failed') {
                        swalAlert('error', response.message);
                    } else {
                        $('#editModal').modal('hide');
                        $('#brands-table').DataTable().ajax.reload();
                        swalAlert('success', 'Berhasil mengubah data brand!');
                    }
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function delete_brand(id) {
            $.ajax({
                url: '{{ route('brands.destroy', ':id') }}'.replace(':id', id),
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                success: function () {
                    setLoad('close');
                    $('#brands-table').DataTable().ajax.reload();
                    swalAlert('success', 'Brand berhasil dihapus.');
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Data?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) delete_brand(id);
            });
        }
    </script>
@endpush
