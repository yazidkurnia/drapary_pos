@extends('layouts.app')

@section('title', 'Manage Material')

@section('content')

<div class="section-body">
    <div class="col-12 bg-white">
        <h1>Manage Material</h1>
        <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard </a><span>/ Manage Material</span></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-scroll mr-2" style="color:#6777ef;"></i>Daftar Material</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Material
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
                    <i class="fas fa-plus-circle text-primary mr-1"></i> Tambah Data Material
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="material_name">Nama Material <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="material_name" placeholder="Contoh: Katun, Sutra, Wool, Polyester">
                        <div class="invalid-feedback" id="material_name_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="material_code">Kode Material <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="material_code" placeholder="Contoh: KT, SR, WL, PL">
                        <div class="invalid-feedback" id="material_code_err"></div>
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
                    <i class="fas fa-pencil-alt text-warning mr-1"></i> Edit Data Material
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form" autocomplete="off">
                    @csrf
                    <input type="hidden" id="mmid" value="">
                    <div class="form-group">
                        <label for="new_material_name">Nama Material <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_material_name" placeholder="Nama material">
                        <div class="invalid-feedback" id="new_material_name_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="new_material_code">Kode Material <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_material_code" placeholder="Kode material">
                        <div class="invalid-feedback" id="new_material_code_err"></div>
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
        #materials-table tbody td.dataTables_empty { padding: 0 !important; border: none !important; }
    </style>
@endpush

@push('script')
    <script src="{{ asset('stisla-assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function () {
            $('#addModal').on('hidden.bs.modal', function () {
                $('#material_name, #material_code').val('').removeClass('is-invalid');
                $('#material_name_err, #material_code_err').text('');
            });

            $(document).on('draw.dt', '#materials-table', function () {
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
            $('#mmid').val(id);
            if (!id) { swalAlert('error', 'Terjadi kesalahan saat mengambil data material'); return; }

            setLoad('load');
            const routeUrl = '{{ route('materials.edit', ':id') }}'.replace(':id', id);

            $.ajax({
                url: routeUrl,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    setLoad('close');
                    $('#new_material_name').val(response.data.material_name).removeClass('is-invalid');
                    $('#new_material_code').val(response.data.material_code).removeClass('is-invalid');
                    $('#editModal').modal('show');
                },
                error: function () {
                    setLoad('close');
                    swalAlert('error', 'Terjadi kesalahan saat mengambil data material');
                }
            });
        }

        function save() {
            const materialName = $('#material_name').val().trim();
            const materialCode = $('#material_code').val().trim();

            if (!materialName) {
                $('#material_name').addClass('is-invalid');
                $('#material_name_err').text('Nama material tidak boleh kosong.');
                return;
            }
            $('#material_name').removeClass('is-invalid');

            if (!materialCode) {
                $('#material_code').addClass('is-invalid');
                $('#material_code_err').text('Kode material tidak boleh kosong.');
                return;
            }
            $('#material_code').removeClass('is-invalid');

            setLoad('load');
            $.ajax({
                url: '{{ route('materials.store') }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', material_name: materialName, material_code: materialCode },
                success: function (response) {
                    setLoad('close');
                    if (response.status === 'failed') {
                        swalAlert('error', response.message);
                    } else {
                        $('#addModal').modal('hide');
                        $('#materials-table').DataTable().ajax.reload();
                        swalAlert('success', 'Material berhasil ditambahkan.');
                    }
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function update() {
            const newMaterialName = $('#new_material_name').val().trim();
            const newMaterialCode = $('#new_material_code').val().trim();
            const mmid            = $('#mmid').val();
            const routeUrl        = '{{ route('materials.update', ':mmid') }}'.replace(':mmid', mmid);

            if (!newMaterialName) {
                $('#new_material_name').addClass('is-invalid');
                $('#new_material_name_err').text('Nama material tidak boleh kosong.');
                return;
            }
            $('#new_material_name').removeClass('is-invalid');

            if (!newMaterialCode) {
                $('#new_material_code').addClass('is-invalid');
                $('#new_material_code_err').text('Kode material tidak boleh kosong.');
                return;
            }
            $('#new_material_code').removeClass('is-invalid');

            setLoad('load');
            $.ajax({
                url: routeUrl,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    material_name: newMaterialName,
                    material_code: newMaterialCode,
                },
                success: function (response) {
                    setLoad('close');
                    if (response.status === 'failed') {
                        swalAlert('error', response.message);
                    } else {
                        $('#editModal').modal('hide');
                        $('#materials-table').DataTable().ajax.reload();
                        swalAlert('success', 'Berhasil mengubah data material!');
                    }
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function delete_material(id) {
            $.ajax({
                url: '{{ route('materials.destroy', ':id') }}'.replace(':id', id),
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                success: function () {
                    setLoad('close');
                    $('#materials-table').DataTable().ajax.reload();
                    swalAlert('success', 'Material berhasil dihapus.');
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
                if (result.isConfirmed) delete_material(id);
            });
        }
    </script>
@endpush
