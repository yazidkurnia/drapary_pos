@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="section-header">
    <h1>Edit User</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Manajemen User</a></div>
        <div class="breadcrumb-item">Edit User</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit User</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
                                placeholder="Masukkan email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                            <input type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimal 8 karakter">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Ulangi password baru">
                        </div>

                        <div class="form-group">
                            <label>Role <span class="text-danger">*</span></label>
                            @error('roles')
                                <div class="text-danger small mb-1">{{ $message }}</div>
                            @enderror
                            <div class="row">
                                @foreach ($roles as $role)
                                    <div class="col-6 col-md-4">
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox"
                                                class="custom-control-input"
                                                id="role_{{ $role->id }}"
                                                name="roles[]"
                                                value="{{ $role->name }}"
                                                {{ in_array($role->name, old('roles', $userRoles)) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
