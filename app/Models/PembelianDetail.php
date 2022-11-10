<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'purchase_details';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Produk::class, 'id', 'product_id');
    }
}
