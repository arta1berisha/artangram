<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => '12345678',
            'is_private' => '1'
        ]);
    }
    //     \App\Models\Post::factory(10)->create();

    //     \App\Models\Post::factory()->create([
    //         'slug' => 'test-test',
    //         'post_img' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FLaravel&psig=AOvVaw1eD5E_fMz5QNSBEsY5l5lw&ust=1680858919579000&source=images&cd=vfe&ved=0CBAQjRxqFwoTCMCV4Mj1lP4CFQAAAAAdAAAAABAD',
    //         'description' => 'lorem ipsum',
    //     ]);
    // }
}
