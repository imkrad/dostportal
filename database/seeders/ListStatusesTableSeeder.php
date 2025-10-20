<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListStatusesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_statuses')->delete();
        
        \DB::table('list_statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Created',
                'classification' => 'purchase_request',
            ),

            1 => 
            array (
                'id' => 2,
                'name' => 'Reviewed',
                'classification' => 'purchase_request'
            ),

            2 => 
            array (
                'id' => 3,
                'name' => 'Approved',
                'classification' => 'purchase_request',
            ),

            3 => 
            array (
                'id' => 4,
                'name' => 'Pending',
                'classification' => 'purchase_request',
            ),

            4 => 
            array (
                'id' => 5,
                'name' => 'For Bids',
                'classification' => 'purchase_request'
            ),

            5 => 
            array (
                'id' => 6,
                'name' => 'For Recommendation of Award',
                'classification' => 'purchase_request',
            ),

            6 => 
            array (
                'id' => 7,
                'name' => 'For BAC Resolution',
                'classification' => 'purchase_request',
            ),

            7 => 
            array (
                'id' => 8,
                'name' => 'For NOA',
                'classification' => 'purchase_request',
            ),
         

            8 => 
            array (
                'id' => 9,
                'name' => 'Awarded',
                'classification' => 'purchase_request',
            ),

            // Bids Status
            9 => 
            array (
                'id' => 10,
                'name' => 'Available for Award',
                'classification' => 'bids_details',
            ),


            10 => 
            array (
                'id' => 11,
                'name' => 'Pending for Award',
                'classification' => 'bids_details',
            ),

            
            11 => 
            array (
                'id' => 12,
                'name' => 'Not Available for Award',
                'classification' => 'bids_details',
            ),

            12 => 
            array (
                'id' => 13,
                'name' => 'Awarded',
                'classification' => 'bids_details',
            ),

            13 => 
            array (
                'id' =>14,
                'name' => 'Completed',
                'classification' => 'bids',
            ),

            14 => 
            array (
                'id' => 15,
                'name' => 'Pending',
                'classification' => 'bids',
            ),

            

        ));
        
    }
}