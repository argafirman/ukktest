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

    public function show(Transaksi $transaksi)
    {
        return view('transaksi.show', compact('transaksi'));
    }


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
