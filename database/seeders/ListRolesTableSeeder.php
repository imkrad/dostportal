<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_roles')->delete();
        
        \DB::table('list_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Administrator',
                'type' => 'n/a',
                'definition' => '',
            ),

            1 => 
            array (
                'id' => 2,
                'name' => 'Procurement Staff',
                'type' => 'n/a',
                'definition' => '',
            ),

            2 => 
            array (
                'id' => 3,
                'name' => 'Supply Officer',
                'type' => 'n/a',
                'definition' => '',
            ),

            3 => 
            array (
                'id' => 4,
                'name' => 'Regional Director',
                'type' => 'n/a',
                'definition' => '',
            ),

            
            4 => 
            array (
                'id' => 5,
                'name' => 'User',
                'type' => 'n/a',
                'definition' => '',
            ),


        ));
        
    }
}