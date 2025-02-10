@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Produk</h1>
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="NamaProduk" class="form-control" value="{{ $produk->NamaProduk }}" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="Harga" class="form-control" value="{{ $produk->Harga }}" required>
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="Stok" class="form-control" value="{{ $produk->Stok }}" required>
        </div>
        <div class="form-group">
            <label>Gambar Produk</label><br>
            <img src="{{ asset('images/'.$produk->img) }}" width="100"><br>
            <input type="file" name="img" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
