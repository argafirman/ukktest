@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Transaksi</h1>
    <button class="btn btn-primary mb-3" onclick="showCreateModal()">Tambah Transaksi</button>

    <table class="table">
        <tr>
            <th>Pelanggan</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
        @foreach($transaksis as $transaksi)
        <tr>
            <td>{{ $transaksi->pelanggan->NamaPelanggan }}</td>
            <td>{{ $transaksi->produk->NamaProduk }}</td>
            <td>{{ $transaksi->jumlah }}</td>
            <td>Rp {{ number_format($transaksi->total_harga, 2) }}</td>
            <td>{{ $transaksi->tanggal_transaksi }}</td>
            <td>
                <button class="btn btn-info" onclick="showDetail({{ $transaksi->id }})">Lihat</button>
                <button class="btn btn-warning" onclick="showEditModal({{ $transaksi->id }})">Edit</button>
                <a href="{{ route('transaksi.struk', $transaksi->id) }}" class="btn btn-secondary">Cetak Struk</a>

                <button class="btn btn-danger" onclick="deleteTransaksi({{ $transaksi->id }})">Hapus</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showCreateModal() {
        Swal.fire({
            title: "Tambah Transaksi",
            html: `
                <input id="pelanggan" class="swal2-input" placeholder="Nama Pelanggan">
                <input id="produk" class="swal2-input" placeholder="Nama Produk">
                <input id="jumlah" type="number" class="swal2-input" placeholder="Jumlah">
                <input id="total_harga" type="number" class="swal2-input" placeholder="Total Harga">
                <input id="tanggal" type="date" class="swal2-input">
            `,
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal",
            preConfirm: () => {
                return {
                    pelanggan: document.getElementById('pelanggan').value,
                    produk: document.getElementById('produk').value,
                    jumlah: document.getElementById('jumlah').value,
                    total_harga: document.getElementById('total_harga').value,
                    tanggal: document.getElementById('tanggal').value
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('transaksi.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(result.value)
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire("Berhasil!", data.message, "success").then(() => location.reload());
                    })
                    .catch(error => {
                        Swal.fire("Gagal!", "Terjadi kesalahan saat menambah transaksi.", "error");
                    });
            }
        });
    }

    function showEditModal(id) {
        fetch(`/transaksi/${id}`)
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: "Edit Transaksi",
                    html: `
                        <input id="pelanggan" class="swal2-input" value="${data.pelanggan.NamaPelanggan}">
                        <input id="produk" class="swal2-input" value="${data.produk.NamaProduk}">
                        <input id="jumlah" type="number" class="swal2-input" value="${data.jumlah}">
                        <input id="total_harga" type="number" class="swal2-input" value="${data.total_harga}">
                        <input id="tanggal" type="date" class="swal2-input" value="${data.tanggal_transaksi}">
                    `,
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal",
                    preConfirm: () => {
                        return {
                            pelanggan: document.getElementById('pelanggan').value,
                            produk: document.getElementById('produk').value,
                            jumlah: document.getElementById('jumlah').value,
                            total_harga: document.getElementById('total_harga').value,
                            tanggal: document.getElementById('tanggal').value
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/transaksi/${id}`, {
                                method: "PUT",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify(result.value)
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire("Berhasil!", data.message, "success").then(() => location.reload());
                            })
                            .catch(error => {
                                Swal.fire("Gagal!", "Terjadi kesalahan saat mengedit transaksi.", "error");
                            });
                    }
                });
            });
    }

    function deleteTransaksi(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data transaksi akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/transaksi/${id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire("Berhasil!", data.message, "success").then(() => location.reload());
                    })
                    .catch(error => {
                        Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus transaksi.", "error");
                    });
            }
        });
    }

    function showDetail(id) {
        fetch(`/transaksi/${id}`)
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: "Detail Transaksi",
                    html: `
                        <p><strong>Pelanggan:</strong> ${data.pelanggan.NamaPelanggan}</p>
                        <p><strong>Produk:</strong> ${data.produk.NamaProduk}</p>
                        <p><strong>Jumlah:</strong> ${data.jumlah}</p>
                        <p><strong>Total Harga:</strong> Rp ${data.total_harga.toLocaleString()}</p>
                        <p><strong>Tanggal:</strong> ${data.tanggal_transaksi}</p>
                    `,
                    confirmButtonText: "Tutup"
                });
            });
    }
</script>
@endsection
