<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'description',
        'tags',
        'categories_id',
    ];


    // relasi to table product gallery one to many
    public function galleries(){
    // one to many
    return $this->hasMany(ProductGallery::class, 'products_id', 'id');
    }

    // relasi to table product category karena kategoti hanya 1 jadi tanpa s
    public function category(){
        // back to relasi
        return $this->belongsTo(ProductCategory::class, 'categories_id', 'id');
    }

}
