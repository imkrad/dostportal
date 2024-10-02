<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListSectionsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'division_id' => 1,
                'name' => 'Office of the Regional Director',
                'responsibility_center_code' => '19-001-03-00009-01',
            ),
            1 => 
            array (
                'id' => 2,
                'division_id' => 2,
                'name' => 'Supply Unit',
                'responsibility_center_code' => '19-001-03-00009-02-01',
            ),
            2 => 
            array (
                'id' => 3,
                'division_id' => 2,
                'name' => 'Accounting Unit',
                'responsibility_center_code' => '19-001-03-00009-02-02',
            ),
            3 => 
            array (
                'id' => 4,
                'division_id' => 2,
                'name' => 'Cashiering Unit ',
                'responsibility_center_code' => '19-001-03-00009-02-03',
            ),
            4 => 
            array (
                'id' => 5,
                'division_id' => 3,
                'name' => 'S&T Scholarships Unit',
                'responsibility_center_code' => '19-001-03-00009-03-05',
            ),
            5 => 
            array (
                'id' => 6,
                'division_id' => 3,
                'name' => 'S&T Information Center',
                'responsibility_center_code' => '19-001-03-00009-03-05',
            ),
            6 => 
            array (
                'id' => 7,
                'division_id' => 3,
                'name' => 'Information and Communication Technnology Unit',
                'responsibility_center_code' => '19-001-03-00009-03',
            ),
            7 => 
            array (
                'id' => 8,
                'division_id' => 3,
                'name' => 'RSTL Office',
                'responsibility_center_code' => '',
            ),
            8 => 
            array (
                'id' => 9,
                'division_id' => 3,
                'name' => 'Metrology and Calibration Laboratory',
                'responsibility_center_code' => '19-001-03-00009-03-06',
            ),
            9 => 
            array (
                'id' => 10,
                'division_id' => 3,
                'name' => 'Chemical Testing Laboratory',
                'responsibility_center_code' => '19-001-03-00009-01-01',
            ),
            10 => 
            array (
                'id' => 11,
                'division_id' => 3,
                'name' => 'Microbiological Testing Laboratory',
                'responsibility_center_code' => '19-001-03-00009-03-01',
            ),
            11 => 
            array (
                'id' => 12,
                'division_id' => 4,
                'name' => 'Field Operations Services Office',
                'responsibility_center_code' => '19-001-03-00009-03-04',
            ),
            12 => 
            array (
                'id' => 13,
                'division_id' => 4,
                'name' => 'PSTC-Zamboanga del Sur',
                'responsibility_center_code' => '19-001-03-00009-03-03',
            ),
            13 => 
            array (
                'id' => 14,
                'division_id' => 4,
                'name' => 'PSTC-Zamboanga del Norte',
                'responsibility_center_code' => '19-001-03-00009-03-02',
            ),
            14 => 
            array (
                'id' => 15,
                'division_id' => 4,
                'name' => 'PSTC-Zamboanga Sibugay',
                'responsibility_center_code' => '19-001-03-00009-01-04',
            ),
            15 => 
            array (
                'id' => 16,
                'division_id' => 4,
                'name' => 'PSTC-Isabela Basilan',
                'responsibility_center_code' => '19-001-03-00009-01-05',
            ),
            16 => 
            array (
                'id' => 17,
                'division_id' => 2,
                'name' => 'Human Resource and Development',
                'responsibility_center_code' => '19-001-03-00009-01-06',
            ),


        ));

        
    }
}