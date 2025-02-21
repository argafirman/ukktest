<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransaksiController extends Controller
{
    // Menampilkan daftar transaksi
    public function index(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'produk']);

        if ($request->has('cari')) {
            $query->whereHas('pelanggan', function ($q) use ($request) {
                $q->where('NamaPelanggan', 'like', '%' . $request->cari . '%')
                  ->orWhere('Alamat', 'like', '%' . $request->cari . '%')
                  ->orWhere('NomorTelepon', 'like', '%' . $request->cari . '%');
            });
        }

        $transaksis = $query->get();
        return view('transaksi.index', compact('transaksis'));
    }

    // Menampilkan form transaksi baru
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('transaksi.create', compact('pelanggans', 'produks'));
    }

    // Menyimpan transaksi baru dengan metode_pengambilan
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'jumlah' => 'required|integer|min:1',
            'uang_diberikan' => 'required|numeric|min:0',
            'metode_pengambilan' => 'required|in:Diambil,Diantar', // Validasi tambahan
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->Stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak cukup!');
        }

        $total_harga = $produk->Harga * $request->jumlah;
        $uang_diberikan = (float) $request->uang_diberikan;
        $kembalian = $uang_diberikan - $total_harga;

        if ($kembalian < 0) {
            return redirect()->back()->with('error', 'Uang yang diberikan tidak cukup!');
        }

        $produk->decrement('Stok', $request->jumlah);

        Transaksi::create([
            'pelanggan_id' => $request->pelanggan_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total_harga,
            'uang_diberikan' => $uang_diberikan,
            'kembalian' => $kembalian,
            'metode_pengambilan' => $request->metode_pengambilan, // Simpan metode pengambilan
            'tanggal_transaksi' => now(),
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil!');
    }

    // Menampilkan form edit transaksi
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('transaksi.edit', compact('transaksi', 'pelanggans', 'produks'));
    }

    // Memperbarui transaksi, termasuk metode_pengambilan
    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'metode_pengambilan' => 'required|in:Diambil,Diantar', // Validasi tambahan
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $oldProduk = Produk::findOrFail($transaksi->produk_id);

        // Kembalikan stok produk lama sebelum mengubah transaksi
        $oldProduk->increment('Stok', $transaksi->jumlah);

        $newProduk = Produk::findOrFail($request->produk_id);
        if ($newProduk->Stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        // Kurangi stok produk baru
        $newProduk->decrement('Stok', $request->jumlah);
        $total_harga = $newProduk->Harga * $request->jumlah;

        $transaksi->update([
            'pelanggan_id' => $request->pelanggan_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total_harga,
            'metode_pengambilan' => $request->metode_pengambilan, // Update metode pengambilan
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    // Menampilkan detail transaksi
    public function show(Transaksi $transaksi)
    {
        return view('transaksi.show', compact('transaksi'));
    }

    // Menghapus transaksi dan mengembalikan stok
    public function destroy(Transaksi $transaksi)
    {
        // Kembalikan stok produk sebelum menghapus transaksi
        $produk = Produk::findOrFail($transaksi->produk_id);
        $produk->increment('Stok', $transaksi->jumlah);

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibatalkan dan stok dikembalikan!');
    }
}
