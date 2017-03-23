<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
	static $password;
    return [
        'remember_token' => str_random(10),
		'admin' => $faker->boolean,
		'name' => $faker->name,
		'username' => $faker->unique()->userName,
		'contact_number' => $faker->randomNumber($nbDigits = NULL),
		'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
		'email' => $faker->safeEmail,
		'password' => 'secret',
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'product_name' => str_random(10),
		'quantity' => $faker->randomNumber($nbDigits = NULL),
		'date_bought' => $faker->date($format = 'Y-m-d', $max = 'now'),
		'price_bought' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 10000),
		'selling_price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 10000),
		'date_sold' => $faker->date($format = 'Y-m-d', $max = 'now'),
		'supplier' => $faker->company,
    ];
});
