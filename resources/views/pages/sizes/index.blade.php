@extends('layouts.app')

@section('title', 'Manage Ukuran')

@section('content')

<div class="section-body">
    <div class="col-12 bg-white">
        <h1>Manage Ukuran</h1>
        <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard </a><span>/ Manage Ukuran</span></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-expand-alt mr-2" style="color:#6777ef;"></i>Daftar Ukuran</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Ukuran
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
                    <i class="fas fa-plus-circle text-primary mr-1"></i> Tambah Data Ukuran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="size_name">Nama Ukuran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="size_name" placeholder="Contoh: Small, Medium, Large">
                        <div class="invalid-feedback" id="size_name_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="size_code">Kode Ukuran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="size_code" placeholder="Contoh: S, M, L, XL">
                        <div class="invalid-feedback" id="size_code_err"></div>
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
                    <i class="fas fa-pencil-alt text-warning mr-1"></i> Edit Data Ukuran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form" autocomplete="off">
                    @csrf
                    <input type="hidden" id="msid" value="">
                    <div class="form-group">
                        <label for="new_size_name">Nama Ukuran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_size_name" placeholder="Nama ukuran">
                        <div class="invalid-feedback" id="new_size_name_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="new_size_code">Kode Ukuran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_size_code" placeholder="Kode ukuran">
                        <div class="invalid-feedback" id="new_size_code_err"></div>
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
        #sizes-table tbody td.dataTables_empty { padding: 0 !important; border: none !important; }
    </style>
@endpush

@push('script')
    <script src="{{ asset('stisla-assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function () {
            $('#addModal').on('hidden.bs.modal', function () {
                $('#size_name, #size_code').val('').removeClass('is-invalid');
                $('#size_name_err, #size_code_err').text('');
            });

            $(document).on('draw.dt', '#sizes-table', function () {
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
            $('#msid').val(id);
            if (!id) { swalAlert('error', 'Terjadi kesalahan saat mengambil data ukuran'); return; }

            setLoad('load');
            const routeUrl = '{{ route('sizes.edit', ':id') }}'.replace(':id', id);

            $.ajax({
                url: routeUrl,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    setLoad('close');
                    $('#new_size_name').val(response.data.size_name).removeClass('is-invalid');
                    $('#new_size_code').val(response.data.size_code).removeClass('is-invalid');
                    $('#editModal').modal('show');
                },
                error: function () {
                    setLoad('close');
                    swalAlert('error', 'Terjadi kesalahan saat mengambil data ukuran');
                }
            });
        }

        function save() {
            const sizeName = $('#size_name').val().trim();
            const sizeCode = $('#size_code').val().trim();

            if (!sizeName) {
                $('#size_name').addClass('is-invalid');
                $('#size_name_err').text('Nama ukuran tidak boleh kosong.');
                return;
            }
            $('#size_name').removeClass('is-invalid');

            if (!sizeCode) {
                $('#size_code').addClass('is-invalid');
                $('#size_code_err').text('Kode ukuran tidak boleh kosong.');
                return;
            }
            $('#size_code').removeClass('is-invalid');

            setLoad('load');
            $.ajax({
                url: '{{ route('sizes.store') }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', size_name: sizeName, size_code: sizeCode },
                success: function (response) {
                    setLoad('close');
                    if (response.status === 'failed') {
                        swalAlert('error', response.message);
                    } else {
                        $('#addModal').modal('hide');
                        $('#sizes-table').DataTable().ajax.reload();
                        swalAlert('success', 'Ukuran berhasil ditambahkan.');
                    }
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function update() {
            const newSizeName = $('#new_size_name').val().trim();
            const newSizeCode = $('#new_size_code').val().trim();
            const msid        = $('#msid').val();
            const routeUrl    = '{{ route('sizes.update', ':msid') }}'.replace(':msid', msid);

            if (!newSizeName) {
                $('#new_size_name').addClass('is-invalid');
                $('#new_size_name_err').text('Nama ukuran tidak boleh kosong.');
                return;
            }
            $('#new_size_name').removeClass('is-invalid');

            if (!newSizeCode) {
                $('#new_size_code').addClass('is-invalid');
                $('#new_size_code_err').text('Kode ukuran tidak boleh kosong.');
                return;
            }
            $('#new_size_code').removeClass('is-invalid');

            setLoad('load');
            $.ajax({
                url: routeUrl,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    size_name: newSizeName,
                    size_code: newSizeCode,
                },
                success: function (response) {
                    setLoad('close');
                    if (response.status === 'failed') {
                        swalAlert('error', response.message);
                    } else {
                        $('#editModal').modal('hide');
                        $('#sizes-table').DataTable().ajax.reload();
                        swalAlert('success', 'Berhasil mengubah data ukuran!');
                    }
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function delete_size(id) {
            $.ajax({
                url: '{{ route('sizes.destroy', ':id') }}'.replace(':id', id),
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                success: function () {
                    setLoad('close');
                    $('#sizes-table').DataTable().ajax.reload();
                    swalAlert('success', 'Ukuran berhasil dihapus.');
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
                if (result.isConfirmed) delete_size(id);
            });
        }
    </script>
@endpush
