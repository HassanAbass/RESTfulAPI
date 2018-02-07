<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier'        => (int)$user->id,
            'name'              => (string)$user->name,
            'email'             => (string)$user->email,
            'isVerified'        => (int)$user->verified,
            'isAdmin'           => ($user->isAdmin()=='true'),
            'creationDate'      => (string)$user->created_at,
            'lastChange'        => (string)$user->updated_at,
        ];
    }
    static function originalAttributes($index){
        $map = [
            'identifier'        => 'id',
            'name'              => 'name',
            'email'             => 'email',
            'password'          => 'password',
            'password_confirmation'          => 'password_confirmation',
            'isVerified'        => 'verified',
            'isAdmin'           => 'admin',
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
            'password'      => 'password',
            'password_confirmation'      => 'password_confirmation',
            'verified'      => 'isVerified',
            'admin'         => 'isAdmin',
            'created_at'    => 'creationDate',
            'updated_at'    => 'lastChange',
        ];
        return isset($map[$index]) ? $map[$index] : null;
    }
}
