<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        Pelanggan::create([
            'NamaPelanggan' => 'John Doe',
            'Alamat' => 'Jl. Contoh No. 1',
            'NomorTelepon' => '081234567890',
        ]);
    }
}


