@extends('layouts.app')

@section('title', 'Manage Tipe Leher')

@section('content')
<div class="section-body">
    <div class="col-12 bg-white">
        <h1>Manage Tipe Leher</h1>
        <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard </a><span>/ Manage Tipe Leher</span></div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-tshirt mr-2" style="color:#6777ef;"></i>Daftar Tipe Leher</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Tipe Leher
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

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle text-primary mr-1"></i> Tambah Data Tipe Leher</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="add-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="collar_name">Nama Tipe Leher <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="collar_name" placeholder="Contoh: Crew Neck, V-Neck, Turtleneck">
                        <div class="invalid-feedback" id="collar_name_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="collar_code">Kode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="collar_code" placeholder="Contoh: CN, VN, TN">
                        <div class="invalid-feedback" id="collar_code_err"></div>
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

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-pencil-alt text-warning mr-1"></i> Edit Data Tipe Leher</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" autocomplete="off">
                    @csrf
                    <input type="hidden" id="mclid" value="">
                    <div class="form-group">
                        <label for="new_collar_name">Nama Tipe Leher <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_collar_name" placeholder="Nama tipe leher">
                        <div class="invalid-feedback" id="new_collar_name_err"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="new_collar_code">Kode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_collar_code" placeholder="Kode tipe leher">
                        <div class="invalid-feedback" id="new_collar_code_err"></div>
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
        #collars-table tbody td.dataTables_empty { padding: 0 !important; border: none !important; }
    </style>
@endpush

@push('script')
    <script src="{{ asset('stisla-assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function () {
            $('#addModal').on('hidden.bs.modal', function () {
                $('#collar_name, #collar_code').val('').removeClass('is-invalid');
                $('#collar_name_err, #collar_code_err').text('');
            });
            $(document).on('draw.dt', '#collars-table', function () { $('[data-toggle="tooltip"]').tooltip(); });
        });

        function setLoad(s) { s === 'load' ? Swal.fire({ title: 'Memuat data...', allowOutsideClick: false, didOpen: () => Swal.showLoading() }) : Swal.close(); }
        function swalAlert(s, m) { Swal.fire({ icon: s, title: s === 'success' ? 'Berhasil!' : 'Gagal!', text: m, showConfirmButton: true }); }

        function edit(id) {
            $('#mclid').val(id);
            if (!id) { swalAlert('error', 'Terjadi kesalahan saat mengambil data'); return; }
            setLoad('load');
            $.ajax({
                url: '{{ route('collars.edit', ':id') }}'.replace(':id', id),
                method: 'GET', dataType: 'json',
                success: function (r) {
                    setLoad('close');
                    $('#new_collar_name').val(r.data.collar_name).removeClass('is-invalid');
                    $('#new_collar_code').val(r.data.collar_code).removeClass('is-invalid');
                    $('#editModal').modal('show');
                },
                error: function () { setLoad('close'); swalAlert('error', 'Terjadi kesalahan saat mengambil data'); }
            });
        }

        function save() {
            const name = $('#collar_name').val().trim(), code = $('#collar_code').val().trim();
            if (!name) { $('#collar_name').addClass('is-invalid'); $('#collar_name_err').text('Nama tidak boleh kosong.'); return; }
            $('#collar_name').removeClass('is-invalid');
            if (!code) { $('#collar_code').addClass('is-invalid'); $('#collar_code_err').text('Kode tidak boleh kosong.'); return; }
            $('#collar_code').removeClass('is-invalid');
            setLoad('load');
            $.ajax({
                url: '{{ route('collars.store') }}', method: 'POST',
                data: { _token: '{{ csrf_token() }}', collar_name: name, collar_code: code },
                success: function (r) {
                    setLoad('close');
                    if (r.status === 'failed') { swalAlert('error', r.message); }
                    else { $('#addModal').modal('hide'); $('#collars-table').DataTable().ajax.reload(); swalAlert('success', 'Tipe leher berhasil ditambahkan.'); }
                },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.'); }
            });
        }

        function update() {
            const name = $('#new_collar_name').val().trim(), code = $('#new_collar_code').val().trim(), mclid = $('#mclid').val();
            if (!name) { $('#new_collar_name').addClass('is-invalid'); $('#new_collar_name_err').text('Nama tidak boleh kosong.'); return; }
            $('#new_collar_name').removeClass('is-invalid');
            if (!code) { $('#new_collar_code').addClass('is-invalid'); $('#new_collar_code_err').text('Kode tidak boleh kosong.'); return; }
            $('#new_collar_code').removeClass('is-invalid');
            setLoad('load');
            $.ajax({
                url: '{{ route('collars.update', ':id') }}'.replace(':id', mclid), method: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'PUT', collar_name: name, collar_code: code },
                success: function (r) {
                    setLoad('close');
                    if (r.status === 'failed') { swalAlert('error', r.message); }
                    else { $('#editModal').modal('hide'); $('#collars-table').DataTable().ajax.reload(); swalAlert('success', 'Berhasil mengubah data!'); }
                },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.'); }
            });
        }

        function delete_collar(id) {
            $.ajax({
                url: '{{ route('collars.destroy', ':id') }}'.replace(':id', id), method: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                success: function () { setLoad('close'); $('#collars-table').DataTable().ajax.reload(); swalAlert('success', 'Tipe leher berhasil dihapus.'); },
                error: function (xhr) { setLoad('close'); swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.'); }
            });
        }

        function confirmDelete(id) {
            Swal.fire({ icon: 'warning', title: 'Hapus Data?', text: 'Data yang dihapus tidak dapat dikembalikan!', showCancelButton: true, confirmButtonColor: '#e3342f', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' })
                .then((r) => { if (r.isConfirmed) delete_collar(id); });
        }
    </script>
@endpush
