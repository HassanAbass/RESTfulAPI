<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier'        => (int)$transaction->id,
            'quantity'          => (int)$transaction->quantity,
            'buyer'             => (int)$transaction->buyer_id,
            'product'           => (int)$transaction->product_id,
            'creationDate'      => (string)$transaction->created_at,
            'lastChange'        => (string)$transaction->updated_at,
        ];
    }
    static function originalAttributes($index){
        $map = [
            'identifier'        => 'id',
            'quantity'          => 'quantity',
            'buyer'             => 'buyer_id',
            'product'           => 'product_id',
            'creationDate'      => 'created_at',
            'lastChange'        => 'updated_at',
        ];
        return isset($map[$index])?$map[$index]:null;
    }
    static function transformAttributes($index){
        $map = [
            'id'            => 'identifier',
            'quantity'      => 'quantity',
            'buyer_id'      => 'buyer',
            'product_id'    => 'product',
            'created_at'    => 'creationDate',
            'updated_at'    => 'lastChange',
        ];
        return isset($map[$index])?$map[$index]:null;
    }
}
