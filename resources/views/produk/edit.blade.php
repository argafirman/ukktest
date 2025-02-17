@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Produk</h2>

    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" class="form-control" name="NamaProduk" value="{{ $produk->NamaProduk }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" name="Harga" value="{{ $produk->Harga }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" class="form-control" name="Stok" value="{{ $produk->Stok }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar Produk</label>
            <input type="file" class="form-control" name="img">
            <img src="{{ asset('images/'.$produk->img) }}" class="img-fluid mt-2" width="100">
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
