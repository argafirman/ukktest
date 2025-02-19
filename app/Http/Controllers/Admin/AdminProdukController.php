<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminProdukController extends Controller
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
        return view('Admin.produk.index', compact('produks'));
    }

    public function create()
    {
        return view('Admin.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaProduk' => 'required',
            'Harga' => 'required|numeric',
            'Stok' => 'required|integer',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = time() . '.' . $request->img->extension();
        $request->img->move(public_path('images'), $imageName);

        Produk::create([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
            'img' => $imageName,
        ]);

        return redirect()->route('adminproduk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('Admin.produk.edit', compact('produk'));
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

        return redirect()->route('adminproduk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('Admin.produk.show', compact('produk'));
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return redirect()->route('adminproduk.index')->with('error', 'Produk tidak ditemukan.');
        }

        // Hapus gambar produk jika ada
        if ($produk->img && file_exists(public_path('images/' . $produk->img))) {
            unlink(public_path('images/' . $produk->img));
        }

        $produk->delete();
        return redirect()->route('adminproduk.index')->with('success', 'Produk berhasil dihapus!');
    }




}
