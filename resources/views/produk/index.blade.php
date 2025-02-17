@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Daftar Produk</h2>

        <!-- Tombol Tambah Produk -->
        <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

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
                        <td>{{ $produk->Harga }}</td>
                        <td>{{ $produk->Stok }}</td>
                        <td>
                            <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-info">Detail</a>
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning">Edit</a>

                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
