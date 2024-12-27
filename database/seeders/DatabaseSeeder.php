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

        // SEEDER MENU ======================================================================
        \App\Models\Menu::create([
            'image' => 'croissant.jpg',
            'name' => 'Croissant',
            'price' => 15000,
            'description' => 'Croissant asli dari bahan yang diambil dari Franch.',
            'category' => 'Makanan',
            'status' => 'Kosong'
        ]);
        \App\Models\Menu::create([
            'image' => 'chickenWings.jpg',
            'name' => 'Chicken Wingz',
            'price' => 35000,
            'description' => 'Chicken wings dengan bumbu barbeque dari Texas dan Mexico yang pastinya sangat nendang.',
            'category' => 'Makanan',
            'status' => 'Tersedia'
        ]);
        \App\Models\Menu::create([
            'image' => 'french.jpg',
            'name' => 'French Fries',
            'price' => 14000,
            'description' => 'French fries yang dibuat dengan kentang asli yang memiliki rasa gurih asin.',
            'category' => 'Makanan',
            'status' => 'Tersedia'
        ]);

        \App\Models\Menu::create([
            'image' => 'macaron.jpg',
            'name' => 'Macaron',
            'price' => 26000,
            'description' => 'Macaron terbuat dari tepung yang dicampur gula lalu diolah seperti kue, memiliki rasa manis seperti gulali.',
            'category' => 'Camilan',
            'status' => 'Tersedia'
        ]);

        \App\Models\Menu::create([
            'image' => 'pisang.jpeg',
            'name' => 'Pisang Goreng',
            'price' => 17000,
            'description' => 'Memiliki rasa manis dengan tekstur gurih, pisang goreng ini cocok dimakan selagi hangat',
            'category' => 'Camilan',
            'status' => 'Kosong'
        ]);

        \App\Models\Menu::create([
            'image' => 'pie.jpg',
            'name' => 'Pie Buah',
            'price' => 12000,
            'description' => 'Berasal dari buah yang segar dan asli, pie buah ini cocok bagi yang ingin makanan rendah kalori.',
            'category' => 'Dessert',
            'status' => 'Tersedia'
        ]);

        \App\Models\Menu::create([
            'image' => 'latte.jpg',
            'name' => 'Kopi Latte',
            'price' => 20000,
            'description' => 'Kopi latte yang dibuat dengan biji kopi asli dari daerah Brazil.',
            'category' => 'Minuman',
            'status' => 'Tersedia'
        ]);
        \App\Models\Menu::create([
            'image' => 'matcha.jpg',
            'name' => 'Es Matcha',
            'price' => 15000,
            'description' => 'Es matcha dengan bahan berkualitas asli dari Jepang.',
            'category' => 'Minuman',
            'status' => 'Kosong'
        ]);
        \App\Models\Menu::create([
            'image' => 'milk.jpg',
            'name' => 'Susu Segar',
            'price' => 10000,
            'description' => 'Susu segar dari sapi Selandia Baru.',
            'category' => 'Minuman',
            'status' => 'Tersedia'
        ]);
        \App\Models\Menu::create([
            'image' => 'jambu.jpg',
            'name' => 'Jus Jambu',
            'price' => 15000,
            'description' => 'Jus jambu dengan buah asli dan manis.',
            'category' => 'Minuman',
            'status' => 'Tersedia'
        ]);
        \App\Models\Menu::create([
            'image' => 'tea.jpg',
            'name' => 'Es Teh Manis',
            'price' => 5000,
            'description' => 'Teh dengan gula asli dan es.',
            'category' => 'Minuman',
            'status' => 'Kosong'
        ]);
        \App\Models\Menu::create([
            'image' => 'water.jpg',
            'name' => 'Air Putih',
            'price' => 3000,
            'description' => 'Air kemasan putih biasa.',
            'category' => 'Minuman',
            'status' => 'Tersedia'
        ]);
        // \App\Models\Menu::factory()->count(10)->create();

        \App\Models\Transaction::factory()->count(10)->create();
    }
}
