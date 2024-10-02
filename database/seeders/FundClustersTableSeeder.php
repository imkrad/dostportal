<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FundClustersTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fund_clusters')->delete();
        
        \DB::table('fund_clusters')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '',
                'name' => 'Regular Fund',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'ST',
                'name' => 'Scholarship Fund',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'TF',
                'name' => 'Trust Fund',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'MDS-TF',
                'name' => 'MDS Trust Fund',
            ),


        ));

        
    }
}