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
                'classification' => 'pr_details',
            ),

            4 => 
            array (
                'id' => 5,
                'name' => 'For Bids',
                'classification' => 'pr_details'
            ),

            5 => 
            array (
                'id' => 6,
                'name' => 'Awarded',
                'classification' => 'pr_details',
            ),

            // Bids Status
            6 => 
            array (
                'id' => 7,
                'name' => 'Available for Award',
                'classification' => 'bids',
            ),

            7 => 
            array (
                'id' => 8,
                'name' => 'Pending for Award',
                'classification' => 'bids',
            ),

            
            8 => 
            array (
                'id' => 9,
                'name' => 'Not Available for Award',
                'classification' => 'bids',
            ),

            9 => 
            array (
                'id' => 10,
                'name' => 'Awarded',
                'classification' => 'bids',
            ),

            10 => 
            array (
                'id' =>11,
                'name' => 'Complete',
                'classification' => 'bids_details',
            ),

            11 => 
            array (
                'id' => 12,
                'name' => 'Incomplete',
                'classification' => 'bids_details',
            ),

            

        ));
        
    }
}