<?php

namespace Database\Seeders;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
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
            $this->createTag($faker);
        }
    }

    /**
     * create a tag
     *
     * @param Generator $faker
     * @return void
     */
    private function createTag(Generator $faker) : void
    {
        DB::table('tags')->insert([
            'name' => Str::random(10),
        ]);
    }
}
