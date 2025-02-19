@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Produk</h2>

    <div class="card">
        <div class="card-body">
            <img src="{{ asset('images/'.$produk->img) }}" class="img-fluid mb-3" width="200">

            <h4>{{ $produk->NamaProduk }}</h4>
            <p><strong>Harga:</strong> Rp {{ number_format($produk->Harga, 2, ',', '.') }}</p>
            <p><strong>Stok:</strong> {{ $produk->Stok }} pcs</p>

            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
