<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'identifier'        => (int)$seller->id,
            'name'              => (string)$seller->name,
            'email'             => (string)$seller->email,
            'isVerified'        => (int)$seller->verified,
            'creationDate'      => (string)$seller->created_at,
            'lastChange'        => (string)$seller->updated_at,
        ];
    }
    static function originalAttributes($index){
        $map = [
            'identifier'        => 'id',
            'name'              => 'name',
            'email'             => 'email',
            'isVerified'        => 'verified',
            'creationDate'      => 'created_at',
            'lastChange'        => 'updated_at',
        ];
        return isset($map[$index])?$map[$index]:null;
    }
    static function transformAttributes($index)
    {
        $map = [
            'id'            => 'identifier',
            'name'          => 'name',
            'email'         => 'email',
            'verified'      => 'isVerified',
            'created_at'    => 'creationDate',
            'updated_at'    => 'lastChange',
        ];
        return isset($map[$index]) ? $map[$index] : null;
    }
}
