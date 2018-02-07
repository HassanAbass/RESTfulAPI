<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Product;
use App\Transaction;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{

    public function run()
    {

        //DB::statement('SET FOREIGN_KEY_CHECKS=0');
        /*
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        */
        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        //DB::table('category_product')->truncate();
        $userQty        = 3000;
        $categoriesQty  = 30;
        $productsQty    = 1000;
        $transactionQty = 1000;
        /*
        factory(User::class,$userQty)->create();

        factory(Category::class,$categoriesQty)->create();

        factory(Product::class,$productsQty)->create()->each(function ($products){
            $categories = Category::all()->random(mt_rand(1,5))->pluck('id');
            $products->categories()->attach($categories);
        });*/
        factory(Transaction::class,$transactionQty)->create();

    }
}
