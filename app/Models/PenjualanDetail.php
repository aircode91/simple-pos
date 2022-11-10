<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'sale_details';
    protected $guarded = ['create_at', 'update_at'];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id', 'product_id');
    }
}
