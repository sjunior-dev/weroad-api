<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(5)->create();

        User::factory()->create([
            'name' => fake()->name(),
            'email' => 'sjunior.dev@gmail.com',
            'roles' => ['admin'],
        ]);

        User::factory()->create([
            'name' => fake()->name(),
            'email' => 'sjunior.dev1@gmail.com',
            'roles' => ['editor'],
        ]);
    }
}
