<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListDropdownsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_dropdowns')->delete();
        
        \DB::table('list_dropdowns')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'n/a',
                'classification' => 'n/a',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Office of the Regional Director',
                'classification' => 'Unit',
                'type' => 'Main',
                'color' => 'n/a',
                'others' => 'ORD',
                'is_active' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Finance and Administrative Support Services',
                'classification' => 'Unit',
                'type' => 'Main',
                'color' => 'n/a',
                'others' => 'FASS',
                'is_active' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Technical Operations Services',
                'classification' => 'Unit',
                'type' => 'Main',
                'color' => 'n/a',
                'others' => 'TOS',
                'is_active' => 1,
            ),
        ));

        
    }
}