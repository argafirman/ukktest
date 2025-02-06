@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Produk</h1>
    <a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah Produk</a>
    <table class="table">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>
        @foreach($produks as $produk)
        <tr>
            <td>{{ $produk->NamaProduk }}</td>
            <td>{{ $produk->Harga }}</td>
            <td>{{ $produk->Stok }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
