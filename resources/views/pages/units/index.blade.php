@extends('layouts.app')

@section('title', 'Manage Satuan')

@section('content')

<div class="section-body">
    <div class="col-12 bg-white">
        <h1>Manage Satuan</h1>
        <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard </a><span>/ Manage Satuan</span></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-ruler mr-2" style="color:#6777ef;"></i>Daftar Satuan</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Satuan
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
                    <i class="fas fa-plus-circle text-primary mr-1"></i> Tambah Data Satuan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="unit_name">Nama Satuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="unit_name" placeholder="Contoh: Meter, Kilogram, Pcs">
                        <div class="invalid-feedback" id="unit_name_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="unit_code">Kode Satuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="unit_code" placeholder="Contoh: m, kg, pcs">
                        <div class="invalid-feedback" id="unit_code_err"></div>
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
                    <i class="fas fa-pencil-alt text-warning mr-1"></i> Edit Data Satuan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form" autocomplete="off">
                    @csrf
                    <input type="hidden" id="muid" value="">
                    <div class="form-group">
                        <label for="new_unit_name">Nama Satuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_unit_name" placeholder="Nama satuan">
                        <div class="invalid-feedback" id="new_unit_name_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="new_unit_code">Kode Satuan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_unit_code" placeholder="Kode satuan">
                        <div class="invalid-feedback" id="new_unit_code_err"></div>
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
        .dt-empty-state {
            padding: 48px 24px;
            text-align: center;
        }
        .dt-empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6777ef22, #6777ef11);
            border: 2px dashed #6777ef55;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .dt-empty-icon i {
            font-size: 32px;
            color: #6777ef;
            opacity: .7;
        }
        .dt-empty-title {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .dt-empty-desc {
            font-size: 13px;
            color: #9ca3af;
            line-height: 1.6;
            margin-bottom: 0;
        }
        #units-table tbody td.dataTables_empty {
            padding: 0 !important;
            border: none !important;
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('stisla-assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function () {
            /* ── Reset add modal on close ───────────────────────── */
            $('#addModal').on('hidden.bs.modal', function () {
                $('#unit_name').val('').removeClass('is-invalid');
                $('#unit_name_err').text('');
                $('#unit_code').val('').removeClass('is-invalid');
                $('#unit_code_err').text('');
            });

            /* ── Tooltips on DataTable draw ─────────────────────── */
            $(document).on('draw.dt', '#units-table', function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        });

        /* ── SweetAlert helpers ────────────────────────────────── */
        function setLoad(status) {
            if (status === 'load') {
                Swal.fire({
                    title: 'Memuat data...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
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

        /* ── CRUD ──────────────────────────────────────────────── */
        function edit(id) {
            $('#muid').val(id);
            if (!id) { swalAlert('error', 'Terjadi kesalahan saat mengambil data satuan'); return; }

            setLoad('load');
            const routeUrl = '{{ route('units.edit', ':id') }}'.replace(':id', id);

            $.ajax({
                url: routeUrl,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    setLoad('close');
                    $('#new_unit_name').val(response.data.unit_name).removeClass('is-invalid');
                    $('#new_unit_code').val(response.data.unit_code).removeClass('is-invalid');
                    $('#editModal').modal('show');
                },
                error: function () {
                    setLoad('close');
                    swalAlert('error', 'Terjadi kesalahan saat mengambil data satuan');
                }
            });
        }

        function save() {
            const unitName = $('#unit_name').val().trim();
            const unitCode = $('#unit_code').val().trim();

            if (!unitName) {
                $('#unit_name').addClass('is-invalid');
                $('#unit_name_err').text('Nama satuan tidak boleh kosong.');
                return;
            }
            $('#unit_name').removeClass('is-invalid');

            if (!unitCode) {
                $('#unit_code').addClass('is-invalid');
                $('#unit_code_err').text('Kode satuan tidak boleh kosong.');
                return;
            }
            $('#unit_code').removeClass('is-invalid');

            setLoad('load');
            $.ajax({
                url: '{{ route('units.store') }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', unit_name: unitName, unit_code: unitCode },
                success: function (response) {
                    setLoad('close');
                    if (response.status === 'failed') {
                        swalAlert('error', response.message);
                    } else {
                        $('#addModal').modal('hide');
                        $('#units-table').DataTable().ajax.reload();
                        swalAlert('success', 'Satuan berhasil ditambahkan.');
                    }
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function update() {
            const newUnitName = $('#new_unit_name').val().trim();
            const newUnitCode = $('#new_unit_code').val().trim();
            const muid        = $('#muid').val();
            const routeUrl    = '{{ route('units.update', ':muid') }}'.replace(':muid', muid);

            if (!newUnitName) {
                $('#new_unit_name').addClass('is-invalid');
                $('#new_unit_name_err').text('Nama satuan tidak boleh kosong.');
                return;
            }
            $('#new_unit_name').removeClass('is-invalid');

            if (!newUnitCode) {
                $('#new_unit_code').addClass('is-invalid');
                $('#new_unit_code_err').text('Kode satuan tidak boleh kosong.');
                return;
            }
            $('#new_unit_code').removeClass('is-invalid');

            setLoad('load');
            $.ajax({
                url: routeUrl,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    unit_name: newUnitName,
                    unit_code: newUnitCode,
                },
                success: function (response) {
                    setLoad('close');
                    if (response.status === 'failed') {
                        swalAlert('error', response.message);
                    } else {
                        $('#editModal').modal('hide');
                        $('#units-table').DataTable().ajax.reload();
                        swalAlert('success', 'Berhasil mengubah data satuan!');
                    }
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function delete_unit(id) {
            $.ajax({
                url: '{{ route('units.destroy', ':id') }}'.replace(':id', id),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function () {
                    setLoad('close');
                    $('#units-table').DataTable().ajax.reload();
                    swalAlert('success', 'Satuan berhasil dihapus.');
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
                if (result.isConfirmed) {
                    delete_unit(id);
                }
            });
        }
    </script>
@endpush
