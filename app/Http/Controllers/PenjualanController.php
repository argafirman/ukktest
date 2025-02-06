<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('pelanggan')->get();
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        return view('penjualan.create', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'TanggalPenjualan' => 'required|date',
            'Harga' => 'required|numeric',
            'PelangganID' => 'required|exists:pelanggans,PelangganID',
        ]);

        Penjualan::create($request->all());
        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan.');
    }
}
