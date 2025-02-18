<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // Menampilkan daftar transaksi
    public function index(Request $request)
    {
        $transaksis = Transaksi::with(['pelanggan', 'produk'])->get();

        $query = Transaksi::query();

    if ($request->has('cari')) {
        $query->where('NamaPelanggan', 'like', '%' . $request->cari . '%')
              ->orWhere('Alamat', 'like', '%' . $request->cari . '%')
              ->orWhere('NomorTelepon', 'like', '%' . $request->cari . '%');
    }

    $transaksis = $query->get();
        return view('transaksi.index', compact('transaksis'));
    }

    // Menampilkan form untuk membuat transaksi baru
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('transaksi.create', compact('pelanggans', 'produks'));
    }

    // Menyimpan data transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        // Cek apakah stok cukup
        if ($produk->Stok < $request->jumlah) {
            return redirect()->route('transaksi.create')->with('error', 'Stok produk tidak mencukupi!');
        }

        // Hitung total harga
        $total_harga = $produk->Harga * $request->jumlah;

        // Kurangi stok produk
        $produk->decrement('Stok', $request->jumlah);

        // Simpan transaksi
        Transaksi::create([
            'pelanggan_id' => $request->pelanggan_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total_harga,
            'tanggal_transaksi' => now(),
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit transaksi
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();

        return view('transaksi.edit', compact('transaksi', 'pelanggans', 'produks'));
    }

    // Memperbarui data transaksi
    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        // Hitung ulang stok jika produk atau jumlah berubah
        if ($transaksi->produk_id != $request->produk_id || $transaksi->jumlah != $request->jumlah) {
            // Kembalikan stok lama
            $oldProduk = Produk::findOrFail($transaksi->produk_id);
            $oldProduk->increment('Stok', $transaksi->jumlah);

            // Perbarui stok produk baru
            $newProduk = Produk::findOrFail($request->produk_id);
            if ($newProduk->Stok < $request->jumlah) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi!');
            }
            $newProduk->decrement('Stok', $request->jumlah);
        }

        // Hitung total harga
        $total_harga = $newProduk->Harga * $request->jumlah;

        // Perbarui data transaksi
        $transaksi->update([
            'pelanggan_id' => $request->pelanggan_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total_harga,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    // Menampilkan detail transaksi
    public function show(Transaksi $transaksi)
    {
        return view('transaksi.show', compact('transaksi'));
    }

    // Menghapus transaksi dan mengembalikan stok produk
    public function destroy(Transaksi $transaksi)
    {
        // Ambil data produk yang terkait dengan transaksi
        $produk = Produk::findOrFail($transaksi->produk_id);

        // Kembalikan stok produk
        $produk->increment('Stok', $transaksi->jumlah);

        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibatalkan dan stok dikembalikan!');
    }
}
