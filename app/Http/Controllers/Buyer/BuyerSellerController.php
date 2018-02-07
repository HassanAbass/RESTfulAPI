<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
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
        $sellers = $buyer->transactions()
            ->with('product.seller')
            ->get()
            ->pluck('product.seller') //Nested eager loading
            ->unique('id') //repeated elem will be null
            ->values(); // values will remove the repeating elem
        return $this->showAll($sellers);
    }
}
