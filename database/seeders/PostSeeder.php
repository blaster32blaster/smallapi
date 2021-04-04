<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $files = File::all();
        $users = User::all();
        for ($i = 0; $i < 5; $i ++) {
            $this->createPost(
                $faker,
                $users->values()->get($i),
                $files->values()->get($i),
            );
        }
    }

    /**
     * create a post
     *
     * @param Generator $faker
     * @param User $user
     * @param File $file
     * @return void
     */
    private function createPost(
        Generator $faker,
        User $user,
        File $file
    ) : void {
        DB::table('posts')->insert([
            'id' => $faker->uuid,
            'title' => $faker->name,
            'body' => Str::random(10),
            'main_image' => $file->id,
            'owner' => $user->id
        ]);
    }
}
