<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AdminTransaksiController extends Controller
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
        return view('admin.transaksi.index', compact('transaksis'));
    }

    // Menampilkan form untuk membuat transaksi baru
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('admin.transaksi.create', compact('pelanggans', 'produks'));
    }

    // Menyimpan data transaksi baru
    public function store(Request $request)
{
    
    $request->validate([
        'produk_id' => 'required|exists:produks,id',
        'pelanggan_id' => 'required|exists:pelanggans,id',
        'jumlah' => 'required|integer|min:1',
        'uang_diberikan' => 'required|numeric|min:0',
        
    ]);

    $produk = Produk::findOrFail($request->produk_id);

    if ($produk->Stok < $request->jumlah) {
        return redirect()->back()->with('error', 'Stok tidak cukup!');
    }

    $total_harga = $produk->Harga * $request->jumlah;
    $uang_diberikan = (float) $request->uang_diberikan; // Konversi ke float
    $kembalian = $uang_diberikan - $total_harga;

    if ($kembalian < 0) {
        return redirect()->back()->with('error', 'Uang yang diberikan tidak cukup!');
    }

    $produk->decrement('Stok', $request->jumlah);

    // Debug sebelum menyimpan
    ([
        'pelanggan_id' => $request->pelanggan_id,
        'produk_id' => $request->produk_id,
        'jumlah' => $request->jumlah,
        'total_harga' => $total_harga,
        'uang_diberikan' => $uang_diberikan,
        'kembalian' => $kembalian,
        'tanggal_transaksi' => now(),
    ]);

    Transaksi::create([
        'pelanggan_id' => $request->pelanggan_id,
        'produk_id' => $request->produk_id,
        'jumlah' => $request->jumlah,
        'total_harga' => $total_harga,
        'uang_diberikan' => $uang_diberikan,
        'kembalian' => $kembalian,
        'tanggal_transaksi' => now(),
    ]);

    return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil!');
}

   
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('admin.transaksi.edit', compact('transaksi', 'pelanggans', 'produks'));
    }

    // Memperbarui data transaksi
    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',  // Validasi pelanggan
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
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
            'pelanggan_id' => $request->pelanggan_id,  // Update pelanggan_id yang dipilih
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total_harga,
        ]);
    
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }
    
    // Menampilkan detail transaksi
    public function show(Transaksi $transaksi)
    {
        return view('admin.transaksi.show', compact('transaksi'));
    }

    // Menghapus transaksi dan mengembalikan stok
    public function destroy(Transaksi $transaksi)
{
    // Ambil produk yang terkait dengan transaksi
    $produk = Produk::findOrFail($transaksi->produk_id);

    // Kembalikan stok produk yang terkait dengan transaksi yang dihapus
    $produk->increment('Stok', $transaksi->jumlah);

    // Hapus transaksi
    $transaksi->delete();

    return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dibatalkan dan stok dikembalikan!');
}

}
