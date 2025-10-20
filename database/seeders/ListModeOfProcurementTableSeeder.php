<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FAIMS\Libraries\ModeOfProcurement;

class ListModeOfProcurementTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        
        $data = [
            [
                'mode' => 'Competitive Public Bidding',
            ],
            [
                'mode' => 'Limited Source Bidding',
            ],
            [
                'mode' => 'Direct Contracting',
            ],
            [
                'mode' => 'Repeat Order',
            ],
            [
                'mode' => 'Shopping',
            ],
            [
                'mode' => 'NP-53.1 Two Failed Biddings',
            ],
            [
                'mode' => 'NP-53.2 Emergency Cases',
            ],
            [
                'mode' => 'NP-53.3 Take-Over of Contracts',
            ],
            [
                'mode' => 'NP-53.4 Adjacent or Contiguous',
            ],
            [
                'mode' => 'NP-53.5 Agency-to-Agency',
            ],
            [
                'mode' => ' NP-53.6 Scientific, Scholarly or Artistic Work, Exclusive Technology and Media Services',
            ],
            [
                'mode' => 'NP-53.7 Highly Technical Consultants',
            ],
            [
                'mode' => 'NP-53.8 Defense Cooperation Agreement',
            ],
            [
                'mode' => 'NP-53.9 Small Value Procurement',
            ],
            [
                'mode' => 'NP-53.10 Lease of Real Property and Venue',
            ],
            [
                'mode' => 'NP-53.11 NGO Participation',
            ],
            [
                'mode' => 'NP-53.13 UN Agencies, International Organizations or International Financing Institutions',
            ],    
            [
                'mode' => 'NP-53.14 Direct Retail Purchase',
            ],
            [
                'mode' => 'Others - Foreign-funded procurement',
            ],
            [
                'mode' => 'Renewal of Contract per Appendix 21 (WETI)',
            ],

        ];
        ModeOfProcurement::insert($data);  
    }
}