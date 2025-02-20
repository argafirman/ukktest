<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class StrukController extends Controller
{
    public function cetak($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'produk'])->findOrFail($id);

        return view('struk.print', compact('transaksi'));
    }
}
