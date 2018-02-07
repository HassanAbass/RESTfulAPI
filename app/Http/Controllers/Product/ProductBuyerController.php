<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;

class ProductBuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(Product $product){
        $transactions = $product->transactions()
            ->with('buyer')
            ->get()
            ->pluck('buyer');
        return $this->showAll($transactions);
    }
}
