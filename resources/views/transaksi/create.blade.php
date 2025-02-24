@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Transaksi</h2>
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Pelanggan</label>
                <select name="pelanggan_id" class="form-control" required>
                    <option value="">Pilih Pelanggan</option>
                    @foreach ($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->NamaPelanggan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Produk</label>
                <select name="produk_id" class="form-control" id="produk" required>
                    <option value="">Pilih Produk</option>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}" data-harga="{{ $produk->Harga }}">
                            {{ $produk->NamaProduk }} - Stok: {{ $produk->Stok }} - Rp{{ number_format($produk->Harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
            </div>
            <div class="mb-3">
                <label>Ongkos Kirim</label>
                <input type="number" name="ongkir" id="ongkir" class="form-control" min="0" value="0" required>
            </div>
            <div class="mb-3">
                <label>Total Harga</label>
                <input type="text" id="total_harga" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label>Metode Pengambilan</label>
                <select name="metode_pengambilan" class="form-control" required>
                    <option value="Diambil">Diambil</option>
                    <option value="Diantar">Diantar</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Uang Diberikan</label>
                <input type="number" name="uang_diberikan" id="uang_diberikan" class="form-control" min="0" required>
            </div>
            <div class="mb-3">
                <label>Kembalian</label>
                <input type="text" id="kembalian" class="form-control" readonly>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let produkSelect = document.getElementById("produk");
            let jumlahInput = document.getElementById("jumlah");
            let ongkirInput = document.getElementById("ongkir");
            let totalHargaInput = document.getElementById("total_harga");
            let uangDiberikanInput = document.getElementById("uang_diberikan");
            let kembalianInput = document.getElementById("kembalian");

            function hitungTotalHarga() {
                let harga = produkSelect.options[produkSelect.selectedIndex].getAttribute("data-harga") || 0;
                let jumlah = jumlahInput.value || 0;
                let ongkir = parseFloat(ongkirInput.value) || 0;
                let total = (harga * jumlah) + ongkir;
                totalHargaInput.value = "Rp" + total.toLocaleString("id-ID");
                hitungKembalian();
            }

            function hitungKembalian() {
                let totalHarga = parseFloat(totalHargaInput.value.replace("Rp", "").replace(/\./g, "")) || 0;
                let uangDiberikan = parseFloat(uangDiberikanInput.value) || 0;
                let kembalian = uangDiberikan - totalHarga;
                kembalianInput.value = kembalian >= 0 ? "Rp" + kembalian.toLocaleString("id-ID") : "Uang tidak cukup!";
            }

            produkSelect.addEventListener("change", hitungTotalHarga);
            jumlahInput.addEventListener("input", hitungTotalHarga);
            ongkirInput.addEventListener("input", hitungTotalHarga);
            uangDiberikanInput.addEventListener("input", hitungKembalian);
        });
    </script>
@endsection  