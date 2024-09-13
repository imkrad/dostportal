<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListSystemsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_systems')->delete();
        
        \DB::table('list_systems')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Finance and Administrative Information Management System(FAIMS)',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Customer Relation Management System(CRMS)',
            ),

  
        ));

        
    }
}