<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 25)->create()->each(function($user){
            $car = factory(App\Car::class)->make();
            $car->user_id = $user->id;
            $car->request = 1;
            $car->mot_time = Carbon::now()->toDateTimeString();
            $car->save();
            
            $faker = Faker::create();
            $imgUrl = $faker->imageUrl(100, 100, null, false);
            $car->addMediaFromUrl($imgUrl)->toMediaCollection('images');

        });
    }
}
