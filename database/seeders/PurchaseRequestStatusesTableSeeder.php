<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseRequestStatusesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_request_statuses')->delete();
        
        \DB::table('purchase_request_statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Created',
                'color' => '#ffae42',
                'code' => '0001',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'reviewed',
                'color' => '#008000',
                'code' => '0002',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Approved',
                'color' => '#0000FF',
                'code' => '0003',
            ),

        ));


      


        
    }
}