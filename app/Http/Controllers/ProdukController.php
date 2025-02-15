<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        return view('produk.index', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga' => 'required|numeric',
            'Stok' => 'required|integer',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('images'), $imageName);
        } else {
            $imageName = 'default.png';
        }

        Produk::create([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
            'img' => $imageName,
        ]);

        return response()->json(['message' => 'Produk berhasil ditambahkan!']);
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga' => 'required|numeric',
            'Stok' => 'required|integer',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $produk = Produk::findOrFail($id);

        if ($request->hasFile('img')) {
            if ($produk->img && file_exists(public_path('images/' . $produk->img))) {
                unlink(public_path('images/' . $produk->img));
            }

            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('images'), $imageName);
        } else {
            $imageName = $produk->img;
        }

        $produk->update([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
            'img' => $imageName,
        ]);

        return response()->json(['message' => 'Produk berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->img && file_exists(public_path('images/' . $produk->img))) {
            unlink(public_path('images/' . $produk->img));
        }

        $produk->delete();

        return response()->json(['message' => 'Produk berhasil dihapus!']);
    }
}
