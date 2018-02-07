<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,buyer')->only(['index']);
    }
    public function index(Buyer $buyer){
        $transactions = $buyer->transactions;
        return $this->showAll($transactions);
    }
}
