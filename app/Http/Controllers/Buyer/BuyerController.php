<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Buyer;


class BuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,buyer')->only(['show']);
    }

    public function index(){
        return $this->showAll(Buyer::all());
    }
    //using implicit model binding
    public function show(Buyer $buyer){
        return $this->showOne($buyer);
    }
}
