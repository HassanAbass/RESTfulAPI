<?php

namespace App\Policies;

use App\Traits\AdminActions;
use App\User;
use App\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization, AdminActions;
    public function view(User $user, Transaction $transaction)
    {
        return  $user->id === $transaction->buyer->id ||
                $user->id === $transaction->product->seller_id;
    }


}
