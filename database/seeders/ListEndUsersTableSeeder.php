<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListEndUsersTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('end_users')->delete();
        
        \DB::table('end_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Regional Office',
                'code' => '',
            ),

            1 => 
            array (
                'id' => 2,
                'name' => 'PSTO',
                'code' => ''
            ),

        
        ));
        
    }
}