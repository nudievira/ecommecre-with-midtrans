<?php

namespace App\Models\Transaction;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    use HasFactory;
    protected $table = 'bucket';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'id_product');
    }
}
