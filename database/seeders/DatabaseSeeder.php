<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            StripeSeeder::class,
            PlatformSeeder::class,
            CategorySeeder::class,
            // CustomerSeeder::class,
            // CustomerPlatformSeeder::class,
            // PaymentSeeder::class,
            // CheckbookSeeder::class,
        ]);
    }
}