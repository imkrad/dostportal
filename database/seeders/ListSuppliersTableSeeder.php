<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListSuppliersTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('suppliers')->delete();
        
        \DB::table('suppliers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'RC Lim Enterprises',
                'personnel' => 'Ms. Olivia Harper',
                'address' => 'Zamboanga City',
                'code' => 'SUP-10-0001',
            ),

            1 => 
            array (
                'id' => 2,
                'name' => 'Phone Patch',
                'personnel' => 'Mr. Ethan Wells',
                'address' => 'Zamboanga City',
                'code' => 'SUP-10-0002',
            ),

            2 => 
            array (
                'id' => 3,
                 'name' => 'Lenin',
                'personnel' => 'Mr. Liam Foster',
                'address' => 'Zamboanga City',
                'code' => 'SUP-10-0003',
            ),

        
        ));
        
    }
}