<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('scope:manage_products')->except(['index']);
        $this->middleware('can:add-category,product')->only('update');
        $this->middleware('can:delete-category,product')->only('destroy');
    }
    public function index(Product $product){
        $categories = $product->categories;
        return $this->showAll($categories);
    }
    //update the intermediate table category_product
    public function update(Request $request,Product $product,Category $category){
        /*
        * In many to many relationship we use
        * attach, sync, syncWithoutDetaching to insert into intermediate table
        */
        $product->categories()->syncWithoutDetaching([
            $category->id
        ]);
        return $this->showAll($product->categories);
    }

    public function destroy(Product $product,Category $category){
        if(!$product->categories()->find($category->id)){
            return $this->errorResponse('The category isnt related to that product',404);
        }
        $product->categories()->detach($category->id);

        return $this->showAll($product->categories);
    }
}
