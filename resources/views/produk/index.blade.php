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

    <!-- Modal Tambah/Edit Produk -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah/Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="formMethod" name="_method" value="POST">
                        <div class="mb-3">
                            <label for="NamaProduk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="NamaProduk" name="NamaProduk" required>
                        </div>
                        <div class="mb-3">
                            <label for="Harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="Harga" name="Harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="Stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="Stok" name="Stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="img" name="img">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Produk -->
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showModalLabel">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="detailImg" src="" class="img-fluid mb-3" width="200" alt="Gambar Produk">
                    <p><strong>Nama:</strong> <span id="detailNama"></span></p>
                    <p><strong>Harga:</strong> <span id="detailHarga"></span></p>
                    <p><strong>Stok:</strong> <span id="detailStok"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi tambah/edit produk
        document.getElementById('createForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            fetch(this.action, {
                method: document.getElementById('formMethod').value,
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire("Berhasil!", data.message, "success").then(() => location.reload());
            })
            .catch(() => Swal.fire("Gagal!", "Terjadi kesalahan.", "error"));
        });

        // Fungsi hapus produk
        function deleteProduk(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data produk akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/produk/${id}`, {
                        method: "DELETE",
                        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
                    })
                    .then(response => response.json())
                    .then(data => Swal.fire("Berhasil!", data.message, "success").then(() => location.reload()))
                    .catch(() => Swal.fire("Gagal!", "Terjadi kesalahan.", "error"));
                }
            });
        }

        // Fungsi detail produk
        function showDetail(id) {
            fetch(`/produk/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('detailImg').src = `/images/${data.img}`;
                document.getElementById('detailNama').textContent = data.NamaProduk;
                document.getElementById('detailHarga').textContent = `Rp ${data.Harga}`;
                document.getElementById('detailStok').textContent = data.Stok;

                new bootstrap.Modal(document.getElementById('showModal')).show();
            })
            .catch(() => console.error("Error mengambil data produk"));
        }

        // Fungsi edit produk
        function editProduk(id) {
            fetch(`/produk/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('NamaProduk').value = data.NamaProduk;
                document.getElementById('Harga').value = data.Harga;
                document.getElementById('Stok').value = data.Stok;
                document.getElementById('createForm').action = `/produk/${id}`;
                document.getElementById('formMethod').value = 'PUT';
                new bootstrap.Modal(document.getElementById('createModal')).show();
            })
            .catch(() => console.error("Error mengambil data produk"));
        }
    </script>
@endsection
