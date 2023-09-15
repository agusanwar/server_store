<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'users_id',
        'address',
        'payment',
        'total_price',
        'shipping_price',
        'status',
    ];

    // relasi back to user belangsTo 
    public function user(){
        // one to many
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    // relasi  to details, karna dalam di transaksi bisa banyak item 
     public function details(){
        // back to rellasi
        return $this->hasMany(TransactionDetail::class, 'transactions_id', 'id');
    }
}
