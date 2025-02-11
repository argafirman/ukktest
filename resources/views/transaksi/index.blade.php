@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Transaksi</h1>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
    <table class="table">
        <tr>
            <th>Pelanggan</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
        @foreach($transaksis as $transaksi)
        <tr>
            <td>{{ $transaksi->pelanggan->NamaPelanggan }}</td>
            <td>{{ $transaksi->produk->NamaProduk }}</td>
            <td>{{ $transaksi->jumlah }}</td>
            <td>Rp {{ number_format($transaksi->total_harga, 2) }}</td>
            <td>{{ $transaksi->tanggal_transaksi }}</td>
            <td>
                <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-info">Lihat</a>
                <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
