<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['pelanggan', 'produk'])->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('transaksi.create', compact('pelanggans', 'produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_transaksi' => 'required|date',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        // Cek stok
        if ($produk->Stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak cukup.');
        }

        // Kurangi stok
        $produk->Stok -= $request->jumlah;
        $produk->save();

        // Simpan transaksi
        Transaksi::create([
            'pelanggan_id' => $request->pelanggan_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $produk->Harga * $request->jumlah,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_transaksi' => 'required|date',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        // Kembalikan stok lama
        $produk->Stok += $transaksi->jumlah;

        // Cek stok untuk jumlah baru
        if ($produk->Stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak cukup.');
        }

        // Update stok dengan jumlah baru
        $produk->Stok -= $request->jumlah;
        $produk->save();

        // Update transaksi
        $transaksi->update([
            'pelanggan_id' => $request->pelanggan_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $produk->Harga * $request->jumlah,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $produk = Produk::findOrFail($transaksi->produk_id);

        // Kembalikan stok
        $produk->Stok += $transaksi->jumlah;
        $produk->save();

        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan.');
    }
}
