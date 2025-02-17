@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Produk</h2>

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="NamaProduk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" name="NamaProduk" required>
            </div>
            <div class="mb-3">
                <label for="Harga" class="form-label">Harga</label>
                <input type="number" class="form-control" name="Harga" required>
            </div>
            <div class="mb-3">
                <label for="Stok" class="form-label">Stok</label>
                <input type="number" class="form-control" name="Stok" required>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Gambar Produk</label>
                <input type="file" class="form-control" name="img" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
