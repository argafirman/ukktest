@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center mb-4">Detail Transaksi</h2>

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
                    <th>Uang Diberikan</th>
                    <td>Rp {{ number_format($transaksi->uang_diberikan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Kembalian</th>
                    <td>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Metode Pengambilan</th>
                    <td>{{ $transaksi->metode_pengambilan }}</td>
                </tr>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <td>{{ date('d-m-Y', strtotime($transaksi->tanggal_transaksi)) }}</td>
                </tr>
            </table>

            <hr>

            <!-- Tombol Aksi -->
            <div class="text-center mt-3">
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
                <!-- <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-warning">Edit</a>
                <button class="btn btn-danger delete-button" data-id="{{ $transaksi->id }}">Hapus</button> -->
                <a href="{{ route('struk.cetak', $transaksi->id) }}" class="btn btn-primary" target="_blank">Cetak Struk</a>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert untuk Konfirmasi Hapus -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelector('.delete-button').addEventListener('click', function () {
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
                const form = document.createElement('form');
                form.action = `/transaksi/${transaksiId}`;
                form.method = 'POST';

                const csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = '_token';
                csrfField.value = '{{ csrf_token() }}';
                form.appendChild(csrfField);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>
@endsection
