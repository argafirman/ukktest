<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSupplier extends Model
{
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
