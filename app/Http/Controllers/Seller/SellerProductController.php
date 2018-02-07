<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\Transformers\ProductTransformer;
use App\Transformers\SellerTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.ProductTransformer::class)->only(['store','update']);
        $this->middleware('scope:manage_products');
        $this->middleware('can:view,seller')->only(['index']);
        $this->middleware('can:sale,seller')->only(['store']);
        $this->middleware('can:edit-product,seller')->only(['update']);
        $this->middleware('can:delete-product,seller')->only(['destroy']);

    }
    public function index(Seller $seller){
        $products = $seller->products;
        return $this->showAll($products);
    }

    public function store(Request $request, User $seller){
        $rules = [
            'name'        => 'required',
            'quantity'    => 'required|integer|min:1',
            'description' => 'required',
            'image'       => 'required|image'
        ];
        $this->validate($request,$rules);
        $data = $request->all();
        $data['status'] = Product::UNAVAILABALE_PRODUCT;
        $data['image']   = $request->image->store('');
        $data['seller_id'] = $seller->id;
        $product = Product::create($data);

        return $this->showOne($product);
    }

    public function update(Request $request,Seller $seller,Product $product){
        $rules = [
            'quantity'    => 'integer|min:1',
            'status'      => 'in:'.Product::AVAILABALE_PRODUCT.','.Product::UNAVAILABALE_PRODUCT,
            'image'       => 'image',
        ];
        $this->validate($request,$rules);
        $this->checkSeller($seller,$product);
        $product->fill($request->intersect(['name','description','quantity']));
        if($request->has('status')){
            $product->status = $request->status;
            if($product->isAvailable() && $product->categories()->count()==0){
                return $this->errorResponse('An active product must have atleast one category',409);
            }
        }
        if($request->hasFile('image')){
            Storage::delete($product->image);
            $product->image = $request->image->store('');
        }
        if($product->isClean()){
            return $this->errorResponse('Specify different value to update',409);
        }
        $product->save();

        return $this->showOne($product);
    }

    public function destroy(Seller $seller,Product $product){
        $this->checkSeller($seller,$product);
        $product->delete();
        Storage::delete($product->image);
        return $this->showOne($product);
    }

    public function checkSeller(Seller $seller,Product $product){
        if($seller->id != $product->seller_id){
            throw new HttpException(422,'Specified seller isnt the actual seller');
        }
    }
}
