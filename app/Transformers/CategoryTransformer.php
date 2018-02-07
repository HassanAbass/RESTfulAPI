<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier'        => (int)$category->id,
            'title'             => (string)$category->name,
            'details'           => (string)$category->description,
            'creationDate'      => (string)$category->created_at,
            'lastChange'        => (string)$category->updated_at,

            'links'             => [
                [
                    'rel'           => 'self',
                    'href'          => route('categories.show',$category->id),
                ],
                [
                    'rel'           => 'categories.buyers',
                    'href'          => route('categories.buyers.index',$category->id),
                ],
                [
                    'rel'           => 'categories.products',
                    'href'          => route('categories.products.index',$category->id),
                ],
                [
                    'rel'           => 'categories.sellers',
                    'href'          => route('categories.sellers.index',$category->id),
                ],
                [
                    'rel'           => 'categories.transactions',
                    'href'          => route('categories.transactions.index',$category->id),
                ],

            ],
        ];
    }
    static function originalAttributes($index){
        $map = [
            'identifier'        => 'id',
            'title'             => 'name',
            'details'           => 'description',
            'creationDate'      => 'created_at',
            'lastChange'        => 'updated_at',
        ];
        return isset($map[$index])?$map[$index]:null;
    }
    static function transformAttributes($index){
        $map = [
            'id'                => 'identifier',
            'name'              => 'title',
            'description'       => 'details',
            'created_at'        => 'creationDate',
            'updated_at'        => 'lastChange',
        ];
        return isset($map[$index])?$map[$index]:null;
    }
}
