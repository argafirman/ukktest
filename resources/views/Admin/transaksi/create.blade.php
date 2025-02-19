@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Transaksi</h2>
        <form action="{{ route('admin.transaksi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Pelanggan</label>
                <select name="pelanggan_id" class="form-control" required>
                    <option value="">Pilih Pelanggan</option>
                    @foreach ($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->NamaPelanggan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Produk</label>
                <select name="produk_id" class="form-control" required>
                    <option value="">Pilih Produk</option>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}">{{ $produk->NamaProduk }} - Stok: {{ $produk->Stok }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
