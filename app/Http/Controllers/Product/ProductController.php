<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('client.credentials')->only(['index','show']);
    }
    public function index() {
        return $this->showAll(Product::all());
    }
    public function show(Product $product) {
        return $this->showOne($product);
    }
}
