@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Transaksi</h1>
    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Pelanggan:</label>
            <select name="pelanggan_id" class="form-control">
                @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}">{{ $pelanggan->NamaPelanggan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Produk:</label>
            <select name="produk_id" class="form-control">
                @foreach($produks as $produk)
                    <option value="{{ $produk->id }}">{{ $produk->NamaProduk }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Jumlah:</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Transaksi:</label>
            <input type="date" name="tanggal_transaksi" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
