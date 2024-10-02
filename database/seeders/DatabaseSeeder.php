<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ListDataTableSeeder::class);

        \DB::table('users')->insert([
            'username' => 'administrator',
            'email' => 'dost9ict@gmail.com',
            'password' => bcrypt('123456789'),
            'role' => 'Administrator',
            'is_active' => 1,
            'email_verified_at' => '2024-05-15 08:46:33',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        \DB::table('user_profiles')->insert([
            'firstname' => 'Ra-ouf',
            'lastname' => 'Jumli',
            'middlename' => 'Indanan',
            'avatar' => 'avatar.jpg',
            'sex' => 'Male',
            'birthdate' => '1994-03-11',
            'marital_id' => 1,
            'religion_id' => 1,
            'blood_id' => 1,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
       
        $this->call(LocationRegionsTableSeeder::class);
        $this->call(LocationProvincesTableSeeder::class);
        $this->call(LocationMunicipalitiesTableSeeder::class);
        $this->call(LocationBarangaysTableSeeder::class);
        $this->call(ListMenusTableSeeder::class);
        $this->call(ListSalariesTableSeeder::class);
        $this->call(ListPositionsTableSeeder::class);
        $this->call(ListDropdownsTableSeeder::class);
        $this->call(ListUnitsTableSeeder::class);
        $this->call(ListSystemsTableSeeder::class);
        $this->call(UnitTypesTableSeeder::class);
        $this->call(ListSectionsTableSeeder::class);
        $this->call(FundClustersTableSeeder::class);
        $this->call(PurchaseRequestStatusesTableSeeder::class);
    }
}
