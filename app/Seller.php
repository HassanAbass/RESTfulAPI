<?php

namespace App;

use App\Scopes\SellerScope;
use App\Transformers\SellerTransformer;


class Seller extends User
{
    //using global scopes
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new SellerScope());
    }
    public $transformer = SellerTransformer::class;

    public function products(){
        return $this->hasMany(Product::class);
    }
}
