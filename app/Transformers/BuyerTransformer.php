<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identifier'        => (int)$buyer->id,
            'name'              => (string)$buyer->name,
            'email'             => (string)$buyer->email,
            'isVerified'        => (int)$buyer->verified,
            'creationDate'      => (string)$buyer->created_at,
            'lastChange'        => (string)$buyer->updated_at,
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
