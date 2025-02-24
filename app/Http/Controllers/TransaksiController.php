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

    //Menghapus data
    public function destroy($id)
{
    $transaksi = Transaksi::findOrFail($id);
    $transaksi->delete();

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
}

    // Menghitung ongkos kirim
    public function hitungOngkir(Request $request)
    {
        $request->validate([
            'jarak' => 'required|numeric|min:1',
        ]);

        $tarif_per_km = 5000; // Tarif ongkir per km
        $ongkir = $request->jarak * $tarif_per_km;

        return response()->json(['ongkir' => $ongkir]);
    }

    // Menyimpan transaksi baru dengan metode_pengambilan dan ongkir
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'jumlah' => 'required|integer|min:1',
            'uang_diberikan' => 'required|numeric|min:0',
            'metode_pengambilan' => 'required|in:Diambil,Diantar',
            'ongkir' => 'required|numeric|min:0',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->Stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak cukup!');
        }

        $total_harga = ($produk->Harga * $request->jumlah) + $request->ongkir;
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
            'metode_pengambilan' => $request->metode_pengambilan,
            'ongkir' => $request->ongkir,
            'tanggal_transaksi' => now(),
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil!');
    }

    // Menampilkan detail transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'produk'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }
}
