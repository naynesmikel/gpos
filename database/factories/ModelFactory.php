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
	static $admin, $name, $username, $password;
    return [
        'remember_token' => str_random(10),
				'admin' => 1,
				'name' => 'Administrator',
				'username' => 'admin',
				'contact_number' => $faker->e164PhoneNumber,
				'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
				'email' => $faker->safeEmail,
				'password' => 'gposadmin',
    ];
});

$factory->define(App\Company::class, function (Faker\Generator $faker) {
		static $tax;
    return [
				'company_name' => $faker->company,
				'company_slogan'=> $faker->sentence($nbWords = 12, $variableNbWords = true),
				'location' => $faker->address,
				'company_contact_number' => $faker->phoneNumber,
				'company_email' => $faker->email,
				'tax' => 12,
				'water_bill' => $faker->randomFloat($nbMaxDecimals = 2, $min = 250, $max = 500),
				'electric_bill' => $faker->randomFloat($nbMaxDecimals = 2, $min = 250, $max = 500),
				'rent' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1000, $max = 1500),
				'labor' => $faker->randomFloat($nbMaxDecimals = 2, $min = 250, $max = 500),
    ];
});

/*$factory->define(App\User::class, function (Faker\Generator $faker) {
	static $password;
    return [
        'remember_token' => str_random(10),
				'admin' => $faker->boolean,
				'name' => $faker->name,
				'username' => $faker->unique()->userName,
				'contact_number' => $faker->e164PhoneNumber,
				'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
				'email' => $faker->safeEmail,
				'password' => 'secret',
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
				'barcode' => $faker->randomNumber($nbDigits = 7),
        'product_name' => $faker->safeColorName,
				'quantity' => $faker->numberBetween($min = 10, $max = 250),
				'date_bought' => $faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now', $timezone = date_default_timezone_get()),
				'price_bought' => $faker->randomFloat($nbMaxDecimals = 2, $min = 5, $max = 250),
				'selling_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 500),
				'supplier' => $faker->company,
    ];
});

$factory->define(App\Order::class, function (Faker\Generator $faker) {
		static $discount;
    return [
				'name' => $faker->name,
				'price_bought' => $faker->randomFloat($nbMaxDecimals = 2, $min = 5, $max = 250),
				'product_name' => $faker->safeColorName,
				'quantity' => $faker->numberBetween($min = 10, $max = 250),
				'selling_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 500),
				'subtotal' => $faker->randomFloat($nbMaxDecimals = 2, $min = 250, $max = 1000),
				'discount' => 0,
				'total_amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 300, $max = 1500),
				'date_sold' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now', $timezone = date_default_timezone_get()),
    ];
});


$factory->define(App\Company::class, function (Faker\Generator $faker) {
		static $tax;
    return [
				'company_name' => $faker->company,
				'company_slogan'=> $faker->sentence($nbWords = 12, $variableNbWords = true),
				'location' => $faker->address,
				'company_contact_number' => $faker->phoneNumber,
				'company_email' => $faker->email,
				'tax' => 12,
				'water_bill' => $faker->randomFloat($nbMaxDecimals = 2, $min = 250, $max = 500),
				'electric_bill' => $faker->randomFloat($nbMaxDecimals = 2, $min = 250, $max = 500),
				'rent' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1000, $max = 1500),
				'labor' => $faker->randomFloat($nbMaxDecimals = 2, $min = 250, $max = 500),
    ];
});

$factory->define(App\Cost::class, function (Faker\Generator $faker) {
		static $tax, $rent, $labor;
    return [
				'month' => $faker->month,
				'year'=> $faker->numberBetween($min = 2016, $max = 2017),
				'tax' => 12,
				'water_bill' => $faker->randomFloat($nbMaxDecimals = 2, $min = 250, $max = 500),
				'electric_bill' => $faker->randomFloat($nbMaxDecimals = 2, $min = 250, $max = 500),
				'rent' => 500,
				'labor' => 500,
    ];
});*/
