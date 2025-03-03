<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminPelangganController extends Controller
{
    // Menampilkan daftar pelanggan
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        if ($request->has('cari')) {
            $query->where('NamaPelanggan', 'like', '%' . $request->cari . '%')
                ->orWhere('Alamat', 'like', '%' . $request->cari . '%')
                ->orWhere('NomorTelepon', 'like', '%' . $request->cari . '%');
        }

        $pelanggans = $query->get();

        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    // Menyimpan pelanggan baru
    public function store(Request $request)
    {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string',
            'NomorTelepon' => 'required|string|max:15',
        ]);

        Pelanggan::create($request->all());

        return response()->json(['message' => 'Pelanggan berhasil ditambahkan.']);
    }

    // Menampilkan detail pelanggan
    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return response()->json($pelanggan);
    }

    // Memperbarui data pelanggan
    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string',
            'NomorTelepon' => 'required|string|max:15',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NomorTelepon' => $request->NomorTelepon,
        ]);

        return response()->json(['message' => 'Pelanggan berhasil diperbarui.']);
    }

    // Menghapus pelanggan
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return response()->json(['message' => 'Pelanggan berhasil dihapus.']);
    }
}
