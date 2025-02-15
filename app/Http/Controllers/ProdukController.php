<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $produks = Produk::when($search, function ($query, $search) {
            return $query->where('NamaProduk', 'like', "%$search%");
        })->get();

        return view('produk.index', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaProduk' => 'required',
            'Harga' => 'required|numeric',
            'Stok' => 'required|integer',
            'img' => 'required|image|max:2048'
        ]);

        $fileName = time() . '.' . $request->img->extension();
        $request->img->move(public_path('images'), $fileName);

        Produk::create([
            'NamaProduk' => $request->NamaProduk,
            'Harga' => $request->Harga,
            'Stok' => $request->Stok,
            'img' => $fileName,
        ]);

        return response()->json(['message' => 'Produk berhasil ditambahkan!']);
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaProduk' => 'required',
            'Harga' => 'required|numeric',
            'Stok' => 'required|integer',
            'img' => 'image|max:2048'
        ]);

        $produk = Produk::findOrFail($id);

        if ($request->hasFile('img')) {
            Storage::delete("images/{$produk->img}");
            $fileName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('images'), $fileName);
            $produk->img = $fileName;
        }

        $produk->update($request->except('img'));

        return response()->json(['message' => 'Produk berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        Storage::delete("images/{$produk->img}");
        $produk->delete();

        return response()->json(['message' => 'Produk berhasil dihapus!']);
    }
}
