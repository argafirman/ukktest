@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('admin.transaksi.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" placeholder="Cari pelanggan..." value="{{ request('cari') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
        <h2>Daftar Transaksi</h2>
        <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
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
            <td>Rp{{ number_format($transaksi->uang_diberikan ?? 0, 0, ',', '.') }}</td>
<td>Rp{{ number_format($transaksi->kembalian ?? 0, 0, ',', '.') }}</td>

            <td>{{ $transaksi->tanggal_transaksi }}</td>
                <td>
                    <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <button class="btn btn-danger btn-sm delete-button" data-id="{{ $transaksi->id }}">Hapus</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    // SweetAlert Confirmation for Delete
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const transaksiId = this.dataset.id;

            swalWithBootstrapButtons.fire({
                title: "Apakah Anda yakin?",
                text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Tidak, batalkan!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form programmatically
                    const form = document.createElement('form');
                    form.action = `/transaksi/${transaksiId}`;
                    form.method = 'POST';

                    // Add CSRF and method fields
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
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Dibatalkan",
                        text: "Data tidak dihapus!",
                        icon: "error"
                    });
                }
            });
        });
    });
</script>

       
@endsection
