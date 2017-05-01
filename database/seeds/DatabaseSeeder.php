<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\User::class, 1)->create();
      factory(App\Company::class, 1)->create();
  		// factory(App\User::class, 100)->create();
  		// factory(App\Product::class, 100)->create();
		  // factory(App\Order::class, 50)->create();
  		// factory(App\Company::class, 1)->create();
      // factory(App\Cost::class, 12)->create();
      // $this->call(UsersTableSeeder::class);
    }
}
