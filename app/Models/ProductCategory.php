<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        // 'show_product',
    ];

    // relasi product one to many
    public function products(){
        // one to many
        return $this->hasMany(Product::class, 'categories_id', 'id');
    }
}
