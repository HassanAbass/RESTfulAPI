<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;

class TransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,transaction')->only(['show']);
    }

    public function index() {
        return $this->showAll(Transaction::all());
    }
    public function show(Transaction $transaction) {
        return $this->showOne($transaction);
    }
}
