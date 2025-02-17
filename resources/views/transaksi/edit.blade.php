@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Transaksi</h2>
    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Pelanggan</label>
            <select name="pelanggan_id" class="form-control" required>
                @foreach ($pelanggans as $pelanggan)
                <option value="{{ $pelanggan->id }}" {{ $transaksi->pelanggan_id == $pelanggan->id ? 'selected' : '' }}>{{ $pelanggan->NamaPelanggan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Produk</label>
            <select name="produk_id" class="form-control" required>
                @foreach ($produks as $produk)
                <option value="{{ $produk->id }}" {{ $transaksi->produk_id == $produk->id ? 'selected' : '' }}>{{ $produk->NamaProduk }} - Stok: {{ $produk->Stok }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $transaksi->jumlah }}" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
