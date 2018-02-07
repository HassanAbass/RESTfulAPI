<?php

namespace App\Policies;

use App\Traits\AdminActions;
use App\User;
use App\Seller;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
{
    use HandlesAuthorization, AdminActions;
    public function view(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    public function sale(User $user, User $seller)
    {
        return $user->id === $seller->id;
    }
    public function editProduct(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    public function deleteProduct(User $user, User $seller)
    {
        return $user->id === $seller->id;
    }
}
