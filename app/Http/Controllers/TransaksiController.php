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
        $total_harga = $produk->Harga * $request->jumlah;

        Transaksi::create([
            'pelanggan_id' => $request->pelanggan_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total_harga,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaksi $transaksi)
    {
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('transaksi.edit', compact('transaksi', 'pelanggans', 'produks'));
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
        $total_harga = $produk->Harga * $request->jumlah;

        $transaksi->update([
            'pelanggan_id' => $request->pelanggan_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total_harga,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
