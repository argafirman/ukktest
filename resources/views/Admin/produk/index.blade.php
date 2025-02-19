@extends('layouts.app')

@section('content')
    <div class="container">
    <form action="{{ route('admin.produk.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" placeholder="Cari pelanggan..."
                    value="{{ request('cari') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
        <h2>Daftar Transaksi</h2>
        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
                @foreach ($produks as $produk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img src="{{ asset('images/' . $produk->img) }}" width="50"></td>
                    <td>{{ $produk->NamaProduk }}</td>
                    <td>Rp {{ number_format($produk->Harga, 0, ',', '.') }}</td>
                    <td>{{ $produk->Stok }}</td>
                    <td>
                        <a href="{{ route('admin.produk.show', $produk->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="hapusProduk({{ $produk->id }})">Hapus</button>
                        <form id="delete-form-{{ $produk->id }}" action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function hapusProduk(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Produk akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
@endsection
