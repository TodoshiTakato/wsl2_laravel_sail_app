<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Category;
use App\Product;

class ProductsController0001 extends Controller
{
    public function Products () {

//        $products = DB::table('Products')->get();
//        $categories = DB::table('Categories')->get();
        $products = Product::all();  // All products
        $categories = Category::all();  // All categories
        $subcategory_counter = 0;  // Counter
        $subcategory_names = [];   // Names of Categories
        $subcategory_ids = [];   // IDs of Sub Categories
        for($i = 0; $i < count($categories); $i++) {      // Loop for Sub Categories
            if ($categories[$i]->parent_id != null) {
                $subcategory_ids[$subcategory_counter] = $categories[$i]->id;
                $subcategory_names[$subcategory_counter] = $categories[$i]->name;
                $subcategory_counter++;
            }
        }

        return view('products.products', [
            'products'=>$products,
            'categories'=>$categories,
            'subcategory_counter'=>$subcategory_counter,
            'subcategory_ids'=>$subcategory_ids,
            'subcategory_names'=>$subcategory_names,
            ]
        );


    }

    public function Product ($id) {
        $product = Product::find($id);
        return view('products.product', compact('product'));
    }

    public function getMinMaxPrice() {
        $minmax_array = Product::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();
//        echo $minmax_array->min_price . ' ' . $minmax_array->max_price;
        return $minmax_array;
    }




}
