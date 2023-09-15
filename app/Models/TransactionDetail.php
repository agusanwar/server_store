<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'products_id',
        'users_id',
        'transactions_id',
        'quantity',
    ];

    // relasi to table product one to one
    public function products(){
        // one to one
        return $this->hasOne(Product::class, 'id', 'products_id');
    }   
}
