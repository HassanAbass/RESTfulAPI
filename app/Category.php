<?php

namespace App;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'description',
    ];
    public $transformer = CategoryTransformer::class;
    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
