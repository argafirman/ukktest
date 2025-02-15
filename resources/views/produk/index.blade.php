@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Produk</h1>

        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
            Tambah Produk
        </button>

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
                    <td>Rp {{ number_format($produk->Harga, 2, ',', '.') }}</td>
                    <td>{{ $produk->Stok }}</td>
                    <td>
                        <button class="btn btn-info" onclick="showDetail({{ $produk->id }})">Lihat</button>
                        <button class="btn btn-warning" onclick="editProduk({{ $produk->id }})">Edit</button>
                        <button class="btn btn-danger" onclick="deleteProduk({{ $produk->id }})">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- Modal Tambah Produk -->
    @include('produk.create')

    <script>
        function showDetail(id) {
            window.location.href = `/produk/show/${id}`;
        }

        function editProduk(id) {
            window.location.href = `/produk/edit/${id}`;
        }

        function deleteProduk(id) {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                fetch(`/produk/delete/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                }).then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                }).catch(error => console.error(error));
            }
        }
    </script>
@endsection
