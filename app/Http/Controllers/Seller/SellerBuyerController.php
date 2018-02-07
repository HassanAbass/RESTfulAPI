<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellerBuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(Seller $seller){
        /*
         * transactions() returns collections so we need to use
         * eager loading with() to get product for every transaction
         */
        $buyers = $seller->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id') //repeated elem will be null
            ->values(); // values will remove the repeating elem
        return $this->showAll($buyers);
    }
}
