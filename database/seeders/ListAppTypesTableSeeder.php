<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListAppTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('app_types')->delete();
        
        \DB::table('app_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Annual Procurement Plan',
                'code' => '',
            ),

            1 => 
            array (
                'id' => 2,
                'name' => 'Supplemental Procurement Plan',
                'code' => ''
            ),

        
        ));
        
    }
}