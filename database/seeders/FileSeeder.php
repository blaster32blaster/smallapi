<?php

namespace Database\Seeders;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FileSeeder extends Seeder
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
            $this->createFile($faker);
        }
    }

    /**
     * create a file
     *
     * @param Generator $faker
     * @return void
     */
    private function createFile(Generator $faker) : void
    {
        DB::table('files')->insert([
            'data' => Str::random(10),
        ]);
    }
}
