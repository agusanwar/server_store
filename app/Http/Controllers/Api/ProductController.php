<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;


class ProductController extends Controller
{
    //Create Data API
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

         // get data by id
         if($id)
         {
            $product = Product::with(['category', 'galleries'])->find($id);
        
            if($product)
            {  
            // jika data ada
                return ResponseFormatter::success(
                    $product->paginate($limit),
                    'Data  product berhasil diambil'
                );
            }
            else
            {  
                // jika data tidak ada
                return ResponseFormatter::error(
                    null,
                    'Data product tidak ada',
                    401
                );
            }
        }

         // get add data
        $product = Product::with(['category', 'galleries']); 

        if($name)
        {
            $product->where('name', 'like', '%' . $name . '%');
            // $product->where('name',  $name );
        }
        if($description)
        {
            $product->where('description', 'like', '%' . $description . '%');
            //  $product->where('description',  $description );
        }
        if($tags) 
        {
            $product->where('tags', 'like', '%' . $tags .'%');
            //  $product->where('tags',  $tags );
        }
        if($price_from) 
        {
            $product->where('price_from', '>=' . $price_from);
            //  $product->where('price_from',  $price_from );
        }
        if($price_to) 
        {
            $product->where('price_to', '<=' . $price_to);
            //  $product->where('price_to',  $price_to );
        }
        if($categories) 
        {
            $product->where('categories', $categories);
            //  $product->where('categories',  $categories );
        }

        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data list product berhasil diambil');
    }
}
