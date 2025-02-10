@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Penjualan</h1>
    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="TanggalPenjualan" class="form-label">Tanggal Penjualan</label>
            <input type="date" class="form-control" name="TanggalPenjualan" required>
        </div>
        <div class="mb-3">
            <label for="id_pelanggan" class="form-label">Pelanggan</label>
            <select class="form-control" name="id_pelanggan" required>
                @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}">{{ $pelanggan->NamaPelanggan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="Harga" class="form-label">Harga</label>
            <input type="number" class="form-control" name="Harga" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
