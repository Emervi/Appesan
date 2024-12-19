<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Admin::create([
            'name' => 'mamat',
            'email' => 'mamat@gmail.com',
            'password' => bcrypt('password'),
            'address' => 'Jl. Merdekah',
        ]);
        \App\Models\Admin::factory()->count(10)->create();


        \App\Models\Chef::create([
            'name' => 'juna',
            'email' => 'juna@gmail.com',
            'password' => bcrypt('password'),
            'address' => 'Jl. Jauh',
        ]);
        \App\Models\Chef::factory()->count(10)->create();


        \App\Models\Cashier::create([
            'name' => 'jon',
            'email' => 'jon@gmail.com',
            'password' => bcrypt('password'),
            'address' => 'Jl. Kuda',
        ]);
        \App\Models\Cashier::factory()->count(10)->create();

        \App\Models\Customer::create([
            'name' => 'Kepin Pelatihan',
            'username' => 'bungs',
            'email' => 'kepin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        \App\Models\Customer::create([
            'name' => 'Levi Athan',
            'username' => 'levis',
            'email' => 'levi@gmail.com',
            'password' => bcrypt('password'),
        ]);
        \App\Models\Customer::factory()->count(10)->create();

        \App\Models\Menu::create([
            'image' => 'latte.jpg',
            'name' => 'Milk Latte',
            'price' => 15000,
            'description' => 'Kopi latte yang dibuat asli dari kopi brazilian funk',
            'category' => 'Minuman',
            'stock' => 15,
        ]);
        \App\Models\Menu::create([
            'image' => 'croissant.jpg',
            'name' => 'Croissant',
            'price' => 45000,
            'description' => 'Croissant asli dari bahan yang diambil dari Franch',
            'category' => 'Makanan',
            'stock' => 10,
        ]);
        \App\Models\Menu::create([
            'image' => 'sendal.jpg',
            'name' => 'Swallow',
            'price' => 125000,
            'description' => 'Sendal masjid',
            'category' => 'Camilan',
            'stock' => 2,
        ]);
        \App\Models\Menu::factory()->count(10)->create();

        \App\Models\Transaction::factory()->count(10)->create();
    }
}
