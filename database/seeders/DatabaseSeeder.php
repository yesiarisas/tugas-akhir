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
        // Memanggil semua seeder secara berurutan
        $this->call([
            AdminTablesSeeder::class,
            AdminMenuPelatihSeeder::class,
        ]);
    }
}