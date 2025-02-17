@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Transaksi</h2>
    <table class="table">
        <tr>
            <th>ID Transaksi</th>
            <td>{{ $transaksi->id }}</td>
        </tr>
        <tr>
            <th>Pelanggan</th>
            <td>{{ $transaksi->pelanggan->NamaPelanggan }}</td>
        </tr>
        <tr>
            <th>Produk</th>
            <td>{{ $transaksi->produk->NamaProduk }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $transaksi->jumlah }}</td>
        </tr>
        <tr>
            <th>Total Harga</th>
            <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Tanggal Transaksi</th>
            <td>{{ $transaksi->tanggal_transaksi }}</td>
        </tr>
    </table>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
