@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Transaksi</h1>
    <p><strong>Pelanggan:</strong> {{ $transaksi->pelanggan->NamaPelanggan }}</p>
    <p><strong>Produk:</strong> {{ $transaksi->produk->NamaProduk }}</p>
    <p><strong>Jumlah:</strong> {{ $transaksi->jumlah }}</p>
    <p><strong>Total Harga:</strong> Rp {{ number_format($transaksi->total_harga, 2) }}</p>
    <p><strong>Tanggal:</strong> {{ $transaksi->tanggal_transaksi }}</p>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
