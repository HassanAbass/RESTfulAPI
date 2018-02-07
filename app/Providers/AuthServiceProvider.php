<?php

namespace App\Providers;

use App\Buyer;
use App\Policies\BuyerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SellerPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use App\Product;
use App\Seller;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Mockery\Generator\StringManipulation\Pass\Pass;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class        => BuyerPolicy::class,
        Seller::class       => SellerPolicy::class,
        User::class         => UserPolicy::class,
        Transaction::class  => TransactionPolicy::class,
        Product::class      => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::tokensCan([
            'purchase_product'  => 'Create a new transaction for a specific product',
            'manage_products'   => 'Create, read, update, delete products(CRUD)',
            'manage_accounts'   => 'Read your account data, id, name, email, ifVerified, ifAdmin (cannot read password).
            Modify your account data(email, password) cannot delete your account',
            'read_general'      => 'Read general information like creating categories, purchase/selling products, selling categories your transactions(purchases and sales)',

        ]);
        //
    }
}
