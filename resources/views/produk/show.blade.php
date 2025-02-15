@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Produk</h1>
        <div class="card">
            <div class="card-body">
                <img src="{{ asset('images/' . $produk->img) }}" width="200">
                <h3>{{ $produk->NamaProduk }}</h3>
                <p>Harga: Rp {{ number_format($produk->Harga, 2, ',', '.') }}</p>
                <p>Stok: {{ $produk->Stok }}</p>
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
