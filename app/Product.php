<?php

namespace App;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    const AVAILABALE_PRODUCT   = 'available';
    const UNAVAILABALE_PRODUCT = 'unavailable';
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];
    public $transformer = ProductTransformer::class;
    public function isAvailable(){
        return $this->status == Product::AVAILABALE_PRODUCT;
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function seller(){
        return $this->belongsTo(Seller::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

}
