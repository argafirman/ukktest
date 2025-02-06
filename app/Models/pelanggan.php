<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $guarded = ['id'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }
}
