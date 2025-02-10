@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Produk</h1>
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="NamaProduk" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="Harga" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="Stok" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Gambar Produk</label>
            <input type="file" name="img" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
