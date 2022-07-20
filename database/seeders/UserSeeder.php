<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        'name' => 'Jessica',
        'lastname' => 'Diaz',
        'email' => 'admin@admin.com',
        'password' => '$2y$10$WOC9crKn8fn4bxc/GYzgEeaYmbmXre1TiMC.qXoZVZLmLwwmvaO.G',
        ])->assignRole('admin');

        User::create([
        'name' => 'Duvan',
        'lastname' => 'Rodriguez',
        'email' => 'vendedor@vendedor.com',
        'password' => '$2y$10$WOC9crKn8fn4bxc/GYzgEeaYmbmXre1TiMC.qXoZVZLmLwwmvaO.G',
        ])->assignRole('vendedor');

        User::create([
        'name' => 'Carmen',
        'lastname' => 'Bedoya',
        'email' => 'cliente@cliente.com',
        'password' => '$2y$10$WOC9crKn8fn4bxc/GYzgEeaYmbmXre1TiMC.qXoZVZLmLwwmvaO.G',
        ])->assignRole('cliente');
    }
}
