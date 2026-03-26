@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('content')
<div class="section-header">
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><h1>Manajemen Role & Hak Akses</h1></div>
    </div>
</div>

<div class="section-body">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Role</h4>
                    <div class="card-header-action">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Tambah Role
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Role</th>
                                    <th>Hak Akses</th>
                                    <th>Jumlah User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $role->name }}</strong></td>
                                        <td>
                                            @forelse ($role->permissions as $permission)
                                                <span class="badge badge-light border mr-1 mb-1">{{ $permission->name }}</span>
                                            @empty
                                                <span class="text-muted">Belum ada hak akses</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $role->users()->count() }} user</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Hapus role {{ $role->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada role.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
