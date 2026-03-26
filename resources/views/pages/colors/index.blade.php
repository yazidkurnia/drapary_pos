@extends('layouts.app')

@section('title', 'Manage Warna')

@section('content')

<div class="section-body">
    <div class="col-12 bg-white">
        <h1>Manage Warna</h1>
        <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard </a><span>/ Manage Warna</span></div>
        {{-- <div class="breadcrumb-item"></div> --}}
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-palette mr-2" style="color:#6777ef;"></i>Daftar Warna</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Warna
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
                    <i class="fas fa-plus-circle text-primary mr-1"></i> Tambah Data Warna
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-form" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="color_name">Nama Warna <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="color_name" placeholder="Contoh: Merah Marun">
                        <div class="invalid-feedback" id="color_name_err"></div>
                    </div>

                    <div class="form-group mb-0">
                        <label>Pilih Warna <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center">
                            <div id="pickr-add"></div>
                            <input type="text" class="form-control ml-2" id="color_hex_code"
                                placeholder="#3490dc" maxlength="7"
                                style="font-family:monospace;max-width:120px;letter-spacing:1px;">
                        </div>

                        {{-- Live preview --}}
                        <div class="color-preview-card mt-3">
                            <div class="color-preview-swatch" id="add-swatch" style="background:#3490dc;"></div>
                            <div class="color-preview-info">
                                <span class="color-preview-name" id="add-prev-name">Nama Warna</span>
                                <span class="color-preview-hex" id="add-prev-hex">#3490DC</span>
                            </div>
                        </div>
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
                    <i class="fas fa-pencil-alt text-warning mr-1"></i> Edit Data Warna
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form" autocomplete="off">
                    @csrf
                    <input type="hidden" id="mcid" value="">

                    <div class="form-group">
                        <label for="new_color_name">Nama Warna <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_color_name" placeholder="Nama warna">
                    </div>

                    <div class="form-group mb-0">
                        <label>Pilih Warna <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center">
                            <div id="pickr-edit"></div>
                            <input type="text" class="form-control ml-2" id="new_hexa_code"
                                placeholder="#3490dc" maxlength="7"
                                style="font-family:monospace;max-width:120px;letter-spacing:1px;">
                        </div>

                        {{-- Live preview --}}
                        <div class="color-preview-card mt-3">
                            <div class="color-preview-swatch" id="edit-swatch" style="background:#3490dc;"></div>
                            <div class="color-preview-info">
                                <span class="color-preview-name" id="edit-prev-name">Nama Warna</span>
                                <span class="color-preview-hex" id="edit-prev-hex">#3490DC</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3 mb-0">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr@1.9.1/dist/themes/nano.min.css">
    <style>
        /* ── Color Preview Card ─────────────────────────────── */
        .color-preview-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .color-preview-swatch {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, .1);
            flex-shrink: 0;
            transition: background-color .15s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .12);
        }
        .color-preview-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .color-preview-name {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }
        .color-preview-hex {
            font-size: 12px;
            font-family: monospace;
            color: #6b7280;
            letter-spacing: .5px;
        }

        /* ── Pickr button overrides ──────────────────────────── */
        .pickr .pcr-button {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .pickr .pcr-button:focus,
        .pickr .pcr-button:hover {
            border-color: #6777ef;
            box-shadow: 0 0 0 .2rem rgba(103, 119, 239, .2);
        }

        /* ── DataTable empty state ───────────────────────────── */
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
        #colors-table tbody td.dataTables_empty {
            padding: 0 !important;
            border: none !important;
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('stisla-assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    {{ $dataTable->scripts() }}
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr@1.9.1/dist/pickr.min.js"></script>
    <script>
        let pickrAdd, pickrEdit;

        $(document).ready(function () {

            /* ── Pickr: Add modal ───────────────────────────────── */
            pickrAdd = Pickr.create({
                el: '#pickr-add',
                theme: 'nano',
                default: '#3490dc',
                components: {
                    preview: true,
                    opacity: false,
                    hue: true,
                    interaction: { hex: true, input: true, save: true }
                }
            });

            pickrAdd
                .on('change', (color) => {
                    const hex = color.toHEXA().toString();
                    $('#color_hex_code').val(hex);
                    syncAddPreview();
                })
                .on('save', () => pickrAdd.hide());

            /* ── Pickr: Edit modal ──────────────────────────────── */
            pickrEdit = Pickr.create({
                el: '#pickr-edit',
                theme: 'nano',
                default: '#3490dc',
                components: {
                    preview: true,
                    opacity: false,
                    hue: true,
                    interaction: { hex: true, input: true, save: true }
                }
            });

            pickrEdit
                .on('change', (color) => {
                    const hex = color.toHEXA().toString();
                    $('#new_hexa_code').val(hex);
                    syncEditPreview();
                })
                .on('save', () => pickrEdit.hide());

            /* ── Sync hex text input → Pickr ────────────────────── */
            $('#color_hex_code').on('input', function () {
                const val = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                    pickrAdd.setColor(val, true);
                    syncAddPreview();
                }
            });

            $('#new_hexa_code').on('input', function () {
                const val = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                    pickrEdit.setColor(val, true);
                    syncEditPreview();
                }
            });

            /* ── Sync name input → preview label ────────────────── */
            $('#color_name').on('input', syncAddPreview);
            $('#new_color_name').on('input', syncEditPreview);

            /* ── Reset add modal on close ───────────────────────── */
            $('#addModal').on('hidden.bs.modal', function () {
                $('#color_name').val('').removeClass('is-invalid');
                $('#color_hex_code').val('#3490dc');
                pickrAdd.setColor('#3490dc', true);
                syncAddPreview();
            });

            /* ── Tooltips on DataTable draw ─────────────────────── */
            $(document).on('draw.dt', '#colors-table', function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        });

        /* ── Preview sync helpers ──────────────────────────────── */
        function syncAddPreview() {
            const hex  = $('#color_hex_code').val() || '#3490dc';
            const name = $('#color_name').val().trim() || 'Nama Warna';
            $('#add-swatch').css('background-color', hex);
            $('#add-prev-hex').text(hex.toUpperCase());
            $('#add-prev-name').text(name);
        }

        function syncEditPreview() {
            const hex  = $('#new_hexa_code').val() || '#3490dc';
            const name = $('#new_color_name').val().trim() || 'Nama Warna';
            $('#edit-swatch').css('background-color', hex);
            $('#edit-prev-hex').text(hex.toUpperCase());
            $('#edit-prev-name').text(name);
        }

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
            $('#mcid').val(id);
            if (!id) { swalAlert('error', 'Terjadi kesalahan saat mengambil data warna'); return; }

            setLoad('load');
            const routeUrl = '{{ route('colors.edit', ':id') }}'.replace(':id', id);

            $.ajax({
                url: routeUrl,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    setLoad('close');
                    const hex  = response.data.hexa_code;
                    const name = response.data.color_name;
                    $('#new_color_name').val(name);
                    $('#new_hexa_code').val(hex);
                    pickrEdit.setColor(hex, true);
                    $('#is_active').prop('checked', !!response.data.is_active);
                    syncEditPreview();
                    $('#editModal').modal('show');
                },
                error: function () {
                    setLoad('close');
                    swalAlert('error', 'Terjadi kesalahan saat mengambil data warna');
                }
            });
        }

        function save() {
            const colorName = $('#color_name').val().trim();
            const colorHexa = $('#color_hex_code').val();

            // Inline validation
            if (!colorName) {
                $('#color_name').addClass('is-invalid');
                $('#color_name_err').text('Nama warna tidak boleh kosong.');
                return;
            }
            $('#color_name').removeClass('is-invalid');

            setLoad('load');
            $.ajax({
                url: '{{ route('colors.store') }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', color_name: colorName, hexa_code: colorHexa },
                success: function (response) {
                    setLoad('close');
                    $('#addModal').modal('hide');
                    $('#colors-table').DataTable().ajax.reload();
                    if (response.status === 'failed') {
                        swalAlert('error', 'Gagal menambahkan data');
                    } else {
                        swalAlert('success', 'Warna berhasil ditambahkan.');
                    }
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function update() {
            const newColorName = $('#new_color_name').val().trim();
            const newHexaCode  = $('#new_hexa_code').val();
            const mcid         = $('#mcid').val();
            const isActive     = $('#is_active').is(':checked') ? 1 : 0;
            const routeUrl     = '{{ route('colors.update', ':mcid') }}'.replace(':mcid', mcid);

            setLoad('load');
            $.ajax({
                url: routeUrl,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    color_name: newColorName,
                    hexa_code: newHexaCode,
                    is_active: isActive
                },
                success: function () {
                    setLoad('close');
                    $('#editModal').modal('hide');
                    $('#colors-table').DataTable().ajax.reload();
                    swalAlert('success', 'Berhasil mengubah data warna!');
                },
                error: function (xhr) {
                    setLoad('close');
                    swalAlert('error', xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.');
                }
            });
        }

        function delete_color(id){
            $.ajax({
                url: '{{ route('colors.destroy', ':id') }}'.replace(':id', id),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    setLoad('close');
                    $('#colors-table').DataTable().ajax.reload();
                    swalAlert('success', 'Warna berhasil dihapus.');
                },
                error: function(xhr) {
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
                    delete_color(id)
                }
            });
        }
    </script>
@endpush
