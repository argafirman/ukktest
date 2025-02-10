@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Produk</h1>
        <a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah Produk</a>
        <table class="table">
            <tr>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            @foreach ($produks as $produk)
                <tr>
                    <td><img src="{{ asset('images/' . $produk->img) }}" width="100"></td>
                    <td>{{ $produk->NamaProduk }}</td>
                    <td>{{ $produk->Harga }}</td>
                    <td>{{ $produk->Stok }}</td>
                    <td>
                        <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-info">Lihat</a>
                        <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
