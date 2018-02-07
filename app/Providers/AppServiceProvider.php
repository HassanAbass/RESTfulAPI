<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created(function ($user){
           Mail::to($user)->send(new UserCreated($user));
        });
        Product::updated(function ($product){
           if($product->quantity ==0 && $product->isAvailable()){
               $product->status = $product::UNAVAILABALE_PRODUCT;
               $product->save();
           }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
