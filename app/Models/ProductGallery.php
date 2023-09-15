<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'products_id',
        'url',
    ];

    // add muttator because data full url
    public function getUrlAttribute($url){
        //convert url to url image (storage)
    return config('app.url') . Storage::url($url);
    }
}
