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
        // // buat folder place jika folder tidak ada
        // if(!in_array('public/places',Storage::directories('public'))){ // storage/app/*
        //     Storage::makeDirectory('public/places');
        //     echo "folder storage/app/places/ berhasil ditambahkan\n";
        // }

        // // kosongkan file gambar (nanti di update ulang gambarnya)
        // Storage::delete(Storage::allFiles('public/places'));
        // echo "places/* successfully deleteds!\n";

        \App\Models\Product::create([
            'id' => '1234567890123',
            'name' => 'New Orleans ml',
            'category' => 'Parfum',
        ]);

        \App\Models\Product::create([
            'id' => '1234567890124',
            'name' => 'Aqua 100ml',
            'category' => 'minuman',
        ]);

        \App\Models\Product::create([
            'id' => '2234567890121',
            'name' => 'Kit kat',
            'category' => 'snack',
        ]);


        \App\Models\Shop::create([
            'id' => 1,
            'name' => 'toko1',
            'address' => 'Jl.Soekarno',
            'lat' => -0.04183445144272559,
            'lng' => 109.32028965224141,
        ]);

        \App\Models\Shop::create([
            'id' => 2,
            'name' => 'toko2',
            'address' => 'Jl.Soetoyo',
            'lat' => -0.04520722723041784,
            'lng' => 109.36358881291396,
        ]);

        \App\Models\Shop::create([
            'id' => 3,
            'name' => 'toko2',
            'address' => 'Jl.Soetoyo',
            'lat' => -0.05623711446160067,
            'lng' => 109.3372446919995,
        ]);

        \App\Models\User::create([
            'id' => 1,
            'name' => 'Budi Ari',
            'email' => 'a@a.a',
            'password' => "123456",
        ]);

        \App\Models\Transaction::create([
            'prod_id' => '1234567890123',
            'shop_id' => 1,
            'price' => 3000,
            'user_id' => 1
        ]);

        \App\Models\Transaction::create([
            'prod_id' => '1234567890123',
            'shop_id' => 2,
            'price' => 2000,
            'user_id' => 1
        ]);

        \App\Models\Transaction::create([
            'prod_id' => '1234567890124',
            'shop_id' => 2,
            'price' => 2000,
            'user_id' => 1
        ]);
    }
}
