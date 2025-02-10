@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Produk</h1>
    <img src="{{ asset('images/'.$produk->img) }}" width="200"><br>
    <p><strong>Nama Produk:</strong> {{ $produk->NamaProduk }}</p>
    <p><strong>Harga:</strong> {{ $produk->Harga }}</p>
    <p><strong>Stok:</strong> {{ $produk->Stok }}</p>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
