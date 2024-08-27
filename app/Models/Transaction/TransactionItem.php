<?php

namespace App\Models\Transaction;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;
    protected $table = 'transaction_item';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'id_product');
    }

}
