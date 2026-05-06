<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();
        Inventory::factory(30)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@web.id',
            'department' => 'Finance',
            'role' => 'admin',
            'password' => 'admin#007'
        ]);
    }
}
