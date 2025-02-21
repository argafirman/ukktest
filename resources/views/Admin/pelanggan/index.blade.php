@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('admin.pelanggan.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" placeholder="Cari pelanggan..."
                    value="{{ request('cari') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
        <h1>Daftar Pelanggan</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            Tambah Pelanggan
        </button>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pelanggans as $pelanggan)
                    <tr>
                        <td>{{ $pelanggan->NamaPelanggan }}</td>
                        <td>{{ $pelanggan->Alamat }}</td>
                        <td>{{ $pelanggan->NomorTelepon }}</td>
                        <td>
                            <button class="btn btn-info" onclick="showDetail({{ $pelanggan->id }})">Lihat</button>
                            <button class="btn btn-warning" onclick="editPelanggan({{ $pelanggan->id }})">Edit</button>
                            <button class="btn btn-danger" onclick="deletePelanggan({{ $pelanggan->id }})">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        @csrf
                        <div class="mb-3">
                            <label for="NamaPelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="Alamat" name="Alamat" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="NomorTelepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="NomorTelepon" name="NomorTelepon" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pelanggan -->
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showModalLabel">Detail Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama:</strong> <span id="detailNama"></span></p>
                    <p><strong>Alamat:</strong> <span id="detailAlamat"></span></p>
                    <p><strong>Nomor Telepon:</strong> <span id="detailNomorTelepon"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pelanggan -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        @csrf
                        @method('PUT')
                        <!-- Input hidden untuk menyimpan ID pelanggan -->
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editNamaPelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="editNamaPelanggan" name="NamaPelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAlamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="editAlamat" name="Alamat" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editNomorTelepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="editNomorTelepon" name="NomorTelepon" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Library Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Tambah pelanggan
        document.getElementById('createForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            fetch("{{ route('pelanggan.store') }}", {
                    method: "POST",
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        title: "Berhasil!",
                        text: data.message,
                        icon: "success",
                        draggable: true
                    }).then(() => location.reload());
                })
                .catch(error => {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan saat menambah pelanggan.",
                        icon: "error",
                        draggable: true
                    });
                });
        });

        // Hapus pelanggan
        function deletePelanggan(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data pelanggan akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/pelanggan/${id}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire({
                                title: "Berhasil!",
                                text: data.message,
                                icon: "success",
                                draggable: true
                            }).then(() => location.reload());
                        })
                        .catch(error => {
                            Swal.fire({
                                title: "Gagal!",
                                text: "Terjadi kesalahan saat menghapus pelanggan.",
                                icon: "error",
                                draggable: true
                            });
                        });
                }
            });
        }

        // Tampilkan detail pelanggan
        function showDetail(id) {
            fetch(`/pelanggan/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailNama').textContent = data.NamaPelanggan;
                    document.getElementById('detailAlamat').textContent = data.Alamat;
                    document.getElementById('detailNomorTelepon').textContent = data.NomorTelepon;
                    new bootstrap.Modal(document.getElementById('showModal')).show();
                });
        }

        // Edit pelanggan
        function editPelanggan(id) {
            fetch(`/pelanggan/${id}`)
                .then(response => response.json())
                .then(data => {
                    // Isi data ke form edit
                    document.getElementById('editId').value = data.id;
                    document.getElementById('editNamaPelanggan').value = data.NamaPelanggan;
                    document.getElementById('editAlamat').value = data.Alamat;
                    document.getElementById('editNomorTelepon').value = data.NomorTelepon;
                    
                    // Ubah atribut action form edit secara dinamis
                    document.getElementById('editForm').setAttribute('action', `/pelanggan/${id}`);
                    
                    // Tampilkan modal edit
                    new bootstrap.Modal(document.getElementById('editModal')).show();
                });
        }

        // Proses submit form edit dengan method PUT
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let id = document.getElementById('editId').value;
            let formData = {
                NamaPelanggan: document.getElementById('editNamaPelanggan').value,
                Alamat: document.getElementById('editAlamat').value,
                NomorTelepon: document.getElementById('editNomorTelepon').value,
            };

            fetch(`/pelanggan/${id}`, {
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: "Berhasil!",
                    text: data.message,
                    icon: "success",
                    draggable: true
                }).then(() => location.reload());
            })
            .catch(error => {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat mengupdate pelanggan.",
                    icon: "error",
                    draggable: true
                });
            });
        });
    </script>
@endsection
