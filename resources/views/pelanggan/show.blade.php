@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Pelanggan</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $pelanggan->NamaPelanggan }}</p>
            <p><strong>Alamat:</strong> {{ $pelanggan->Alamat }}</p>
            <p><strong>Nomor Telepon:</strong> {{ $pelanggan->NomorTelepon }}</p>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
