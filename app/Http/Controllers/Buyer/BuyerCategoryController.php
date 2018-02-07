<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerCategoryController extends ApiController
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
        $categories = $buyer->transactions()
            ->with('product.categories')
            ->get()
            ->pluck('product.categories') //Nested eager loading
            ->collapse()
            ->unique('id') //repeated elem will be null
            ->values(); // values will remove the repeating elem
        return $this->showAll($categories);
    }
}
