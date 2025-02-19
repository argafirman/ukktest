@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pelanggan</h1>
    <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="NamaPelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control @error('NamaPelanggan') is-invalid @enderror"
                   name="NamaPelanggan" value="{{ old('NamaPelanggan', $pelanggan->NamaPelanggan) }}">
            @error('NamaPelanggan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="Alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control @error('Alamat') is-invalid @enderror"
                   name="Alamat" value="{{ old('Alamat', $pelanggan->Alamat) }}">
            @error('Alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="NomorTelepon" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control @error('NomorTelepon') is-invalid @enderror"
                   name="NomorTelepon" value="{{ old('NomorTelepon', $pelanggan->NomorTelepon) }}">
            @error('NomorTelepon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
