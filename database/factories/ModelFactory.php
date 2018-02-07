<?php

use App\User;
use App\Category;
use App\Product;
Use App\Transaction;
Use App\Seller;
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([
            User::VERIFIED_USER,User::UNVERIFIED_USER
        ]),
        'verification_token' => $verified == User::VERIFIED_USER?
            null : User::generateVerificationCode(),
        'admin' => $faker->randomElement([
            User::ADMIN_USER,User::REGULAR_USER
        ]),
    ];
});
$factory->define(Category::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),

    ];
});
$factory->define(Product::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1,10),
        'status' => $faker->randomElement([
            Product::AVAILABALE_PRODUCT,Product::UNAVAILABALE_PRODUCT
        ]),
        'image' => $faker->numberBetween(1,10),
        'seller_id' => User::all()->random()->id,
        //User::inRandomOrder()->first()->id
    ];
});
$factory->define(Transaction::class, function (Faker\Generator $faker) {
    $seller = Seller::has('products')->get()->random();
    $buyer  = User::all()->except($seller->id)->random();
    return [
       'quantity'    => $faker->numberBetween(1,3),
        'buyer_id'   => $buyer->id,
        'product_id' => $seller->products->random()->id,
    ];
});

/*

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://127.0.0.1/users",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
 */