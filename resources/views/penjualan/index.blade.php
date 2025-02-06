@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Penjualan</h1>
    <a href="{{ route('penjualan.create') }}" class="btn btn-primary">Tambah Penjualan</a>
    <table class="table">
        <tr>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Harga</th>
        </tr>
        @foreach($penjualans as $penjualan)
        <tr>
            <td>{{ $penjualan->TanggalPenjualan }}</td>
            <td>{{ $penjualan->pelanggan->NamaPelanggan }}</td>
            <td>{{ $penjualan->Harga }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
