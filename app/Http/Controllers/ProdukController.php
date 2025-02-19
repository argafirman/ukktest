<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $produks = Produk::all();
        $query = Produk::query();

        if ($request->has('cari')) {
            $query->where('NamaProduk', 'like', '%' . $request->cari . '%')
                ->orWhere('Harga', 'like', '%' . $request->cari . '%');

        }

        $produks = $query->get();
        return view('produk.index', compact('produks'));

    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'produk_id' => 'required|exists:produks,id',
        'jumlah' => 'required|integer|min:1',
    ]);

    $produk = Produk::findOrFail($request->produk_id);

    if ($produk->Stok < $request->jumlah) {
        return redirect()->back()->with('error', 'Stok tidak cukup!');
    }

    Transaksi::create([
        'pelanggan_id' => auth()->user()->id,
        'produk_id' => $request->produk_id,
        'jumlah' => $request->jumlah,
        'total_harga' => $produk->Harga * $request->jumlah,
        'status' => 'pending', // Menunggu persetujuan admin
        'tanggal_transaksi' => now(),
    ]);

    return redirect()->route('admin.transaksi.index')->with('success', 'Menunggu persetujuan admin!');
}

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'NamaProduk' => 'required',
            'Harga' => 'required|numeric',
            'Stok' => 'required|integer',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('images'), $imageName);
            $produk->img = $imageName;
        }

        $produk->update([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

     public function destroy($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
        }

        // Hapus gambar produk jika ada
        if ($produk->img && file_exists(public_path('images/' . $produk->img))) {
            unlink(public_path('images/' . $produk->img));
        }

        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }




}
