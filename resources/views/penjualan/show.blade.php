@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Penjualan</h1>
    <table class="table">
        <tr>
            <th>Tanggal:</th>
            <td>{{ $penjualan->TanggalPenjualan }}</td>
        </tr>
        <tr>
            <th>Pelanggan:</th>
            <td>{{ $penjualan->pelanggan->NamaPelanggan }}</td>
        </tr>
        <tr>
            <th>Harga:</th>
            <td>{{ $penjualan->Harga }}</td>
        </tr>
    </table>
    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
