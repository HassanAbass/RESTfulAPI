<?php

namespace App;


use App\Scopes\BuyerScope;
use App\Transformers\BuyerTransformer;


class Buyer extends User
{
    //using global scopes
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new BuyerScope());
    }
    public $transformer = BuyerTransformer::class;
    //Buyer to Transaction is one to many relationship
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
