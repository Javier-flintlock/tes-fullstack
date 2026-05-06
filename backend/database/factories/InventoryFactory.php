<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inventaris_id' => fake()->buildingNumber(),
            'barang' => fake()->company(),
            'type' => fake()->randomElement(['Laptop', 'Ponsel']),
            'serial_number' => fake()->randomNumber(),
            'spesifikasi' => fake()->word(),
            'status' => fake()->randomElement(['Baik', 'Dilelang', 'Rusak', 'Tidak Dipakai']),
            'user_id' => User::factory(),
            'department' => fake()->randomElement(['Technology', 'Marketing', 'Finance']),
        ];
    }
}
