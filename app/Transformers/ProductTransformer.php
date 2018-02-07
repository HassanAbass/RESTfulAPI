<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier'        => (int)$product->id,
            'title'             => (string)$product->name,
            'details'           => (string)$product->description,
            'stock'             => (int)$product->quantity,
            'situation'         => (string)$product->status,
            'picture'           => url("img/{$product->image}"),
            'seller'            => (int)$product->seller_id,
            'creationDate'      => (string)$product->created_at,
            'lastChange'        => (string)$product->updated_at,
        ];
    }
    static function originalAttributes($index){
        $map = [
            'identifier'        => 'id',
            'title'             => 'name',
            'details'           => 'description',
            'stock'             => 'quantity',
            'situation'         => 'status',
            'picture'           => 'image',
            'seller'            => 'seller_id',
            'creationDate'      => 'created_at',
            'lastChange'        => 'updated_at',
        ];
        return isset($map[$index])?$map[$index]:null;
    }
    static function transformAttributes($index){
        $map = [
            'id'            => 'identifier',
            'name'          => 'title',
            'description'   => 'details',
            'quantity'      => 'stock',
            'status'        => 'situation',
            'image'         => 'picture',
            'seller_id'     => 'seller',
            'created_at'    => 'creationDate',
            'updated_at'    => 'lastChange',
        ];
        return isset($map[$index])?$map[$index]:null;
    }
}
