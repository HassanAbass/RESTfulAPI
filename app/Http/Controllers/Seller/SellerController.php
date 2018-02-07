<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\ApiController;
use App\Seller;


class SellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,seller')->only(['show']);
    }
    public function index(){
        return $this->showAll(Seller::all());
    }

    public function show(Seller $seller){
        return $this->showOne( $seller );
    }
}
