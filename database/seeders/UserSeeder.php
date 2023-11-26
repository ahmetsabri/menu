<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainUser = User::factory()->hasRestaurants()->create([
            'name' => 'Ahmet Sabri',
            'email' => 'ahmed@mail.com'
        ]);

        User::factory()->count(10)->hasRestaurants()->create();
    }
}
