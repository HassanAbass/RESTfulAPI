<?php

namespace App\Policies;

use App\Traits\AdminActions;
use App\User;
use App\Buyer;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuyerPolicy
{
    use HandlesAuthorization, AdminActions;


    public function view(User $user, Buyer $buyer)
    {
        return ($user->id == $buyer->id);
    }


    public function purchase(User $user, Buyer $buyer)
    {
        return $user->id === $buyer->id;
    }
}
