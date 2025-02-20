@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Transaksi</h2>
    <form id="editTransaksiForm" action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="NamaPelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control @error('NamaPelanggan') is-invalid @enderror"
                   name="NamaPelanggan" value="{{ old('NamaPelanggan', $pelanggan->NamaPelanggan) }}">
            @error('NamaPelanggan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>elect>
        </div>
        <div class="mb-3">
            <label>Produk</label>
            <select name="produk_id" class="form-control" required>
                @foreach ($produks as $produk)
                <option value="{{ $produk->id }}" {{ $transaksi->produk_id == $produk->id ? 'selected' : '' }}>
                    {{ $produk->NamaProduk }} - Stok: {{ $produk->Stok }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $transaksi->jumlah }}" min="1" required>
        </div>
        <button type="button" id="updateButton" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
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

    document.getElementById('updateButton').addEventListener('click', function() {
        swalWithBootstrapButtons.fire({
            title: "Apakah Anda yakin?",
            text: "Anda akan memperbarui data transaksi ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, simpan!",
            cancelButtonText: "Tidak, batalkan!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi, submit form
                document.getElementById('editTransaksiForm').submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Dibatalkan",
                    text: "Data transaksi tidak diubah!",
                    icon: "error"
                });
            }
        });
    });
</script>
@endsection
