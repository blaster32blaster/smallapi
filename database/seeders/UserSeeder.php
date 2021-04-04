<?php

namespace Database\Seeders;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 5; $i ++) {
            $this->createUser($faker);
        }
    }

    /**
     * create  a user
     *
     * @param Generator $faker
     * @return void
     */
    private function createUser(Generator $faker) : void
    {
        DB::table('users')->insert([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => 'abc123', // password
            'remember_token' => Str::random(10),
        ]);
    }
}
