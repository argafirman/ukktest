@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Produk</h1>
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="NamaProduk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="NamaProduk" name="NamaProduk" value="{{ $produk->NamaProduk }}" required>
            </div>
            <div class="mb-3">
                <label for="Harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="Harga" name="Harga" value="{{ $produk->Harga }}" required>
            </div>
            <div class="mb-3">
                <label for="Stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="Stok" name="Stok" value="{{ $produk->Stok }}" required>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Gambar Produk</label>
                <input type="file" class="form-control" id="img" name="img">
                <img src="{{ asset('images/' . $produk->img) }}" width="100" class="mt-2">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
