@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Form Pencarian -->
    <form action="{{ route('produk.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="cari" class="form-control" placeholder="Cari produk..." value="{{ request('cari') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <h2>Daftar Produk</h2>

    <!-- Tombol Tambah Produk -->
    <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

    <!-- Pesan Sukses -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel Produk -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produks as $produk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($produk->img && file_exists(public_path('images/' . $produk->img)))
                            <img src="{{ asset('images/' . $produk->img) }}" width="50">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" width="50" alt="Default Image">
                        @endif
                    </td>
                    <td>{{ $produk->NamaProduk }}</td>
                    <td>Rp {{ number_format($produk->Harga, 0, ',', '.') }}</td>
                    <td>{{ $produk->Stok }}</td>
                    <td>
                        <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $produk->id }}" data-name="{{ $produk->NamaProduk }}">
                            Hapus
                        </button>

                        <form id="delete-form-{{ $produk->id }}" action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Produk tidak ditemukan.</td>
                </tr>
            @endforelse
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
                    form.action = `/produk/${produksiId}`;
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
