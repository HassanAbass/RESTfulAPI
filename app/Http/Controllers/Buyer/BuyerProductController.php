<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,buyer')->only(['index']);
    }
    public function index(Buyer $buyer){
        /*
         * transactions() returns collections so we need to use
         * eager loading with() to get product for every transaction
         */
        $products = $buyer->transactions()
            ->with('product')
            ->get()
            ->pluck('product');
        return $this->showAll($products);
    }
}
