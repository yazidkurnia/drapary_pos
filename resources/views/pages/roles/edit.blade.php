@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="section-header">
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item">
            <a href="{{ route('roles.index') }}">Manajemen Role</a>
        </div>
        <div class="breadcrumb-item"><h1>Edit Role: {{ $role->name }}</h1></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Role</h4>
                </div>
                <form action="{{ route('roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Nama Role --}}
                        <div class="form-group">
                            <label>Nama Role <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $role->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Contoh: Supervisor">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Hak Akses --}}
                        <div class="form-group">
                            <label>Hak Akses</label>
                            <p class="text-muted small">Pilih hak akses yang dimiliki oleh role ini.</p>

                            @foreach ($permissions as $group => $groupPermissions)
                                <div class="card border mb-3">
                                    <div class="card-header py-2 bg-light">
                                        <strong class="text-capitalize">{{ $group }}</strong>
                                        <button type="button" class="btn btn-sm btn-link float-right p-0 toggle-group"
                                            data-group="{{ $group }}">Pilih Semua</button>
                                    </div>
                                    <div class="card-body py-2">
                                        <div class="row">
                                            @foreach ($groupPermissions as $permission)
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input perm-{{ $group }}"
                                                            type="checkbox"
                                                            name="permissions[]"
                                                            value="{{ $permission->name }}"
                                                            id="perm_{{ $permission->id }}"
                                                            {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Info user yang memakai role ini --}}
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-1"></i>
                            Role ini digunakan oleh <strong>{{ $role->users()->count() }} user</strong>.
                            Perubahan hak akses akan berlaku langsung.
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary ml-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.querySelectorAll('.toggle-group').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var group = this.dataset.group;
        var checkboxes = document.querySelectorAll('.perm-' + group);
        var allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
        this.textContent = allChecked ? 'Pilih Semua' : 'Hapus Semua';
    });
});
</script>
@endpush
