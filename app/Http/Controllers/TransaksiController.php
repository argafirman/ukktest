<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Produk;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('pelanggan', 'produk')->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan' => 'required',
            'produk' => 'required',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
        ]);

        $pelanggan = Pelanggan::where('NamaPelanggan', $request->pelanggan)->first();
        $produk = Produk::where('NamaProduk', $request->produk)->first();

        if (!$pelanggan || !$produk) {
            return response()->json(['message' => 'Pelanggan atau Produk tidak ditemukan!'], 400);
        }

        $transaksi = Transaksi::create([
            'id_pelanggan' => $pelanggan->id,
            'id_produk' => $produk->id,
            'jumlah' => $request->jumlah,
            'total_harga' => $request->total_harga,
            'tanggal_transaksi' => $request->tanggal,
        ]);

        return response()->json(['message' => 'Transaksi berhasil ditambahkan!', 'data' => $transaksi], 201);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'produk')->findOrFail($id);
        return response()->json($transaksi);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggan' => 'required',
            'produk' => 'required',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $pelanggan = Pelanggan::where('NamaPelanggan', $request->pelanggan)->first();
        $produk = Produk::where('NamaProduk', $request->produk)->first();

        if (!$pelanggan || !$produk) {
            return response()->json(['message' => 'Pelanggan atau Produk tidak ditemukan!'], 400);
        }

        $transaksi->update([
            'id_pelanggan' => $pelanggan->id,
            'id_produk' => $produk->id,
            'jumlah' => $request->jumlah,
            'total_harga' => $request->total_harga,
            'tanggal_transaksi' => $request->tanggal,
        ]);

        return response()->json(['message' => 'Transaksi berhasil diperbarui!', 'data' => $transaksi]);
    }

    public function cetakStruk($id)
{
    $transaksi = Transaksi::with(['pelanggan', 'produk'])->findOrFail($id);
    return view('struk', compact('transaksi'));
}


    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus!']);
    }
}
