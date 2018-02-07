<?php

namespace App\Http\Controllers;
use App\Traits\ApiResponser;

class ApiController extends Controller{
    use ApiResponser;
    public function __construct()
    {
        //using api guard to initiate passport driver in config.auth
        $this->middleware('auth:api');
    }
}