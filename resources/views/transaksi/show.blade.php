@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center mb-4">Table Transaksi</h2>

            <!-- Info Toko -->
            {{-- <div class="text-center mb-4">
                <h4>Toko Kami Ambatukam</h4>
                <p>Jalan Raya Roti Jala Maklima Biadap</p>
                <p>Telp: (0123) 456-789</p>
            </div> --}}

            <!-- Informasi Transaksi -->
            <table class="table table-borderless">
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
                    <td>{{ date('d-m-Y', strtotime($transaksi->tanggal_transaksi)) }}</td>
                </tr>
            </table>

            <hr>

            <!-- Pesan Terima Kasih -->
            {{-- <div class="text-center mt-4">
                <h5>Terima Kasih Telah Berbelanja!</h5>
                <p>Silakan datang kembali.</p>
            </div> --}}

            <!-- Tombol Kembali -->
            <div class="text-center mt-3">
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
                <!-- Tombol untuk Cetak Struk -->
                <a href="{{ route('struk.cetak', $transaksi->id) }}" class="btn btn-primary" target="_blank">Cetak Struk</a>
            </div>
        </div>
    </div>
</div>
@endsection
