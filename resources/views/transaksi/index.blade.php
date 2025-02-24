@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('transaksi.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" placeholder="Cari pelanggan..." value="{{ request('cari') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
        <h2>Daftar Transaksi</h2>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Biaya Ongkir</th>
                    <th>Total Bayar</th> <!-- Kolom baru -->
                    <th>Uang Diberikan</th>
                    <th>Kembalian</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->pelanggan->NamaPelanggan }}</td>
                    <td>{{ $transaksi->produk->NamaProduk }}</td>
                    <td>{{ $transaksi->jumlah }}</td>
                    <td>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($transaksi->ongkir ?? 0, 0, ',', '.') }}</td>
                    <td>
                        <strong>Rp{{ number_format(($transaksi->total_harga + ($transaksi->ongkir ?? 0)), 0, ',', '.') }}</strong>
                    </td> <!-- Perhitungan total bayar -->
                    <td>Rp{{ number_format($transaksi->uang_diberikan ?? 0, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($transaksi->kembalian ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->tanggal_transaksi }}</td>
                    <td>
                        <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <button class="btn btn-danger btn-sm delete-button" data-id="{{ $transaksi->id }}">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function () {
                const transaksiId = this.dataset.id;

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Tidak, batalkan!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Buat form hapus secara dinamis
                        const form = document.createElement('form');
                        form.action = `/transaksi/${transaksiId}`;
                        form.method = 'POST';

                        // Tambahkan CSRF token
                        const csrfField = document.createElement('input');
                        csrfField.type = 'hidden';
                        csrfField.name = '_token';
                        csrfField.value = csrfToken;
                        form.appendChild(csrfField);

                        // Tambahkan method DELETE
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        form.appendChild(methodField);

                        document.body.appendChild(form);
                        form.submit();
                    } else {
                        Swal.fire({
                            title: "Dibatalkan",
                            text: "Data tidak dihapus!",
                            icon: "error"
                        });
                    }
                });
            });
        });
    });
</script>

       
@endsection