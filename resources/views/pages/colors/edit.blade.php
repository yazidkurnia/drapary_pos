@extends('layouts.app')

@section('title', 'Edit Warna')

@section('content')

<div class="section-header bg-white my-3 px-3 py-3">
    <h4 class="mb-0">Edit Warna</h4>
</div>

<div class="section-body">
    <div class="card" style="max-width:480px;">
        <div class="card-body">
            <form action="{{ route('colors.update', $color->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Warna</label>
                    <input type="text" name="color_name" class="form-control @error('color_name') is-invalid @enderror"
                        value="{{ old('color_name', $color->color_name) }}" required>
                    @error('color_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Kode Hex</label>
                    <div class="input-group">
                        <input type="color" name="hexa_code" id="colorPicker"
                            class="form-control form-control-color p-1"
                            value="{{ old('hexa_code', $color->hexa_code) }}" style="max-width:50px;">
                        <input type="text" id="hexText" class="form-control @error('hexa_code') is-invalid @enderror"
                            value="{{ old('hexa_code', $color->hexa_code) }}" maxlength="7" placeholder="#RRGGBB">
                        @error('hexa_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', $color->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $color->is_active) == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <a href="{{ route('colors.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    const picker = document.getElementById('colorPicker');
    const text   = document.getElementById('hexText');
    picker.addEventListener('input', () => text.value = picker.value);
    text.addEventListener('input', () => { if (/^#[0-9A-Fa-f]{6}$/.test(text.value)) picker.value = text.value; });
    text.closest('form').addEventListener('submit', () => picker.name = '');
</script>
@endpush
