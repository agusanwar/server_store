<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;

class ProductCategoryController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $show_product = $request->input('show_product');


        // get data by id
        if($id)
        {
            $category = ProductCategory::with(['category'])->find($id);

            if($category)
            {
                return ResponseFormatter::success(
                    $category,
                    'Data  Category berhasil diambil'
                );
            }
            else
            {
                return ResponseFormatter::error(
                    null,
                    'Data Category tidak ada',
                    401
                );
            }
        }
        
        // 
        $category = ProductCategory::query();

        if($name)
        {
            $category->where('name', 'like', '%' . $name . '%');
            // $product->where('name',  $name );
        }
        if($show_product)
        {
            $category->with('products');
        }

         return ResponseFormatter::success(
            $category->paginate($limit),
            'Data list category berhasil diambil');
    }
}
