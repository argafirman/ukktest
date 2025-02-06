@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Pelanggan</h1>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
    <table class="table">
        <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Nomor Telepon</th>
        </tr>
        @foreach($pelanggans as $pelanggan)
        <tr>
            <td>{{ $pelanggan->NamaPelanggan }}</td>
            <td>{{ $pelanggan->Alamat }}</td>
            <td>{{ $pelanggan->NomorTelepon }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
