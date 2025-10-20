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
                'classification' => 'procurement',
            ),

            1 => 
            array (
                'id' => 2,
                'name' => 'Reviewed',
                'classification' => 'procurement'
            ),

            2 => 
            array (
                'id' => 3,
                'name' => 'Approved',
                'classification' => 'procurement',
            ),

            3 => 
            array (
                'id' => 4,
                'name' => 'For Bids',
                'classification' => 'procurement'
            ),

            4 => 
            array (
                'id' => 5,
                'name' => 'For Recommendation of Award',
                'classification' => 'procurement',
            ),

            5 => 
            array (
                'id' => 6,
                'name' => 'For BAC Resolution',
                'classification' => 'procurement',
            ),

            6 => 
            array (
                'id' => 7,
                'name' => 'For NOA',
                'classification' => 'procurement',
            ),
         

            7 => 
            array (
                'id' => 8,
                'name' => 'Awarded',
                'classification' => 'procurement',
            ),

            // Bids Status
            8 => 
            array (
                'id' => 9,
                'name' => 'Available for Award',
                'classification' => 'procurement',
            ),


            9 => 
            array (
                'id' => 10,
                'name' => 'Available for Re-Award',
                'classification' => 'procurement',
            ),

            
            10 => 
            array (
                'id' => 11,
                'name' => 'Not Available for Award',
                'classification' => 'procurement',
            ),

            11 => 
            array (
                'id' => 12,
                'name' => 'NOA Not Conformed',
                'classification' => 'procurement',
            ),

            12 => 
            array (
                'id' =>13,
                'name' => 'PO Not Conformed',
                'classification' => 'procurement',
            ),

            13 => 
            array (
                'id' =>14,
                'name' => 'Conformed',
                'classification' => 'procurement',
            ),

            14 => 
            array (
                'id' =>15,
                'name' => 'Not Conformed',
                'classification' => 'procurement',
            ),

            15 => 
            array (
                'id' =>16,
                'name' => 'NOA Conformed/ For PO',
                'classification' => 'procurement',
            ),

            16 => 
            array (
                'id' =>17,
                'name' => 'PO Conformed/ Awaiting for Delivery',
                'classification' => 'procurement',
            ),

            17 => 
            array (
                'id' =>18,
                'name' => 'PO Conformed/ For NTP',
                'classification' => 'procurement',
            ),

            18 => 
            array (
                'id' => 19,
                'name' => 'Pending',
                'classification' => 'procurement',
            ),

            19 => 
            array (
                'id' => 20,
                'name' => 'Ongoing',
                'classification' => 'procurement',
            ),

            20 => 
            array (
                'id' => 21,
                'name' => 'Completed',
                'classification' => 'procurement',
            ),

            21 => 
            array (
                'id' => 22,
                'name' => 'For Rebid',
                'classification' => 'procurement',
            ),

            22 => 
            array (
                'id' => 23,
                'name' => 'For Re-award',
                'classification' => 'procurement',
            ),

            

        ));
        
    }
}