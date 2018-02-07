<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Transaction;
use App\Transformers\ProductTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.ProductTransformer::class)->only(['store']);
        $this->middleware('scope:purchase_product')->only(['store']);
        $this->middleware('can:purchase,buyer')->only('store');
    }
    //Create a transaction
    public function store(Request $request, Product $product, User $buyer){
        $rules = [
                'quantity' => 'required|integer|min:1'
            ];
        $this->validate($request,$rules);
        if($buyer->id == $product->seller_id){
            return $this->errorResponse('Buyer cant be the same seller',409);
        }
        if(!$buyer->isVerified()){
            return $this->errorResponse('The buyer must be verified user',409);
        }
        if(!$product->seller->isVerified()){
            return $this->errorResponse('The seller must be verified user',409);
        }
        if(!$product->isAvailable()){
            return $this->errorResponse('The product isnt availabe',409);
        }
        if($product->quantity < $request->quantity){
            return $this->errorResponse('All Products has been consumed',409);
        }
        $transaction = DB::transaction(function () use($request,$product,$buyer) {
            $product->quantity -= $request->quantity;
            $product->save();
            $trans= Transaction::create([
                'quantity'      => $request->quantity,
                'buyer_id'      => $buyer->id,
                'product_id'    => $product->id,
            ]);
            return $trans;
        });
        return $this->showOne($transaction,201);

    }


}
