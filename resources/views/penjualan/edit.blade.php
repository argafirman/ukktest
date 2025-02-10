@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Penjualan</h1>
    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="TanggalPenjualan" class="form-label">Tanggal Penjualan</label>
            <input type="date" class="form-control" name="TanggalPenjualan" value="{{ $penjualan->TanggalPenjualan }}" required>
        </div>
        <div class="mb-3">
            <label for="id_pelanggan" class="form-label">Pelanggan</label>
            <select class="form-control" name="id_pelanggan" required>
                @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}" {{ $penjualan->id_pelanggan == $pelanggan->id ? 'selected' : '' }}>
                        {{ $pelanggan->NamaPelanggan }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="Harga" class="form-label">Harga</label>
            <input type="number" class="form-control" name="Harga" value="{{ $penjualan->Harga }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
