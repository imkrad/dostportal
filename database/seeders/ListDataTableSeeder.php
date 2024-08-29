<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListDataTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_data')->delete();
        
        \DB::table('list_data')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'n/a',
                'type' => 'n/a',
                'is_active' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Single',
                'type' => 'Marital Status',
                'is_active' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Married',
                'type' => 'Marital Status',
                'is_active' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Widowed',
                'type' => 'Marital Status',
                'is_active' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Divorced',
                'type' => 'Marital Status',
                'is_active' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Separated',
                'type' => 'Marital Status',
                'is_active' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'A+',
                'type' => 'Blood Type',
                'is_active' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'A-',
                'type' => 'Blood Type',
                'is_active' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'B+',
                'type' => 'Blood Type',
                'is_active' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'B-',
                'type' => 'Blood Type',
                'is_active' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'AB+',
                'type' => 'Blood Type',
                'is_active' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'AB-',
                'type' => 'Blood Type',
                'is_active' => 1,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'O+',
                'type' => 'Blood Type',
                'is_active' => 1,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'O-',
                'type' => 'Blood Type',
                'is_active' => 1,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Plantilla',
                'type' => 'Employment Status',
                'is_active' => 1,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Contract of Service',
                'type' => 'Employment Status',
                'is_active' => 1,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Job Order',
                'type' => 'Employment Status',
                'is_active' => 1,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Laborer I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Utility Worker I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Laboratory Aide I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Clerk',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Driver I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Laborer II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Clerk II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Driver II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Laboratory Aide II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Science Aide',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Agricultural Technician I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Clerk III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Labor Foreman',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Laboratory Technician I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Utility Foreman',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Computer Operator I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Agricultural Technician II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Clerk IV',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Labor General Foreman',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Laboratory Inspector I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Laboratory Technician II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Project Development Assistant',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Project Assistant I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Laboratory Technician II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Computer Operator II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Science Research Assistant',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Laboratory Inspector II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Project Assistant II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Computer Maintenance Technologist I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Computer Programmer I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Data Entry Machine Operator III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'Information Officer I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Science Research Analyst',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Project Evaluation Officer I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Project Development Officer I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Computer Operator III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Project Assistant III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'University Research Associate I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Science Research Specialist I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'Computer Operator IV',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Project Assistant IV',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'University Research Associate II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'Computer Maintenance Technologist II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'Computer Programmer II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Information Officer II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Project Evaluation Officer II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Project Development Officer II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Information Systems Analyst II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Science Research Specialist II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'University Researcher I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'Computer Maintenance Technologist III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'Computer Programmer III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'Information Officer III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'Project Development Officer III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'Project Evaluation Officer III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'University Researcher II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'Information Technology Officer I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'Senior Science Research Specialist',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'Project Officer I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'University Researcher III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'Project Administrative Officer V',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'Project Technical Officer V',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'Project Officer II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'Information Officer IV',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'Information Technology Officer II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'Project Officer III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'Project Evaluation Officer IV',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'Project Development Officer IV',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'Supervising Science Research Specialist',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'University Researcher IV',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'Project Officer IV',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'S&T Fellow I',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'Chief Science Research Specialist',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'Project Officer V',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'University Researcher V',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'S&T Fellow II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'S&T Fellow III',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'S&T Fellow IV',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'S&T Fellow V',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
            96 => 
            array (
                'id' => 158,
                'name' => 'Project Laborer I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            97 => 
            array (
                'id' => 159,
                'name' => 'Project Utility Aide I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            98 => 
            array (
                'id' => 160,
                'name' => 'Project Utility Worker I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            99 => 
            array (
                'id' => 161,
                'name' => 'Project Utility Aide II',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            100 => 
            array (
                'id' => 162,
                'name' => 'Project Laborer II',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            101 => 
            array (
                'id' => 163,
                'name' => 'Project Administrative I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            102 => 
            array (
                'id' => 164,
                'name' => 'Project Technical Aide I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            103 => 
            array (
                'id' => 165,
                'name' => 'Project Administrative Aide II',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            104 => 
            array (
                'id' => 166,
                'name' => 'Project Technical Aide II',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            105 => 
            array (
                'id' => 167,
                'name' => 'Project Technical Aide III',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            106 => 
            array (
                'id' => 168,
                'name' => 'Project Administrative Aide III',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            107 => 
            array (
                'id' => 169,
                'name' => 'Project Technical Aide IV',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            108 => 
            array (
                'id' => 170,
                'name' => 'Project Administrative Aide IV',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            109 => 
            array (
                'id' => 171,
                'name' => 'Project Technical Aide V',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            110 => 
            array (
                'id' => 172,
                'name' => 'Project Administrative Aide V',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            111 => 
            array (
                'id' => 173,
                'name' => 'Project Technical Aide VI',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            112 => 
            array (
                'id' => 174,
                'name' => 'Project Administrative Aide VI',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            113 => 
            array (
                'id' => 175,
                'name' => 'Project Technical Assistant I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            114 => 
            array (
                'id' => 176,
                'name' => 'Project Administrative Assistant I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            115 => 
            array (
                'id' => 177,
                'name' => 'Project Technical Assistant II',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            116 => 
            array (
                'id' => 178,
                'name' => 'Project Administrative Assistant II',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            117 => 
            array (
                'id' => 179,
                'name' => 'Project Technical Assistant III',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            118 => 
            array (
                'id' => 180,
                'name' => 'Project Administrative Assistant III',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            119 => 
            array (
                'id' => 181,
                'name' => 'Project Technical Assistant IV',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            120 => 
            array (
                'id' => 182,
                'name' => 'Project Administrative Assistant IV',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            121 => 
            array (
                'id' => 183,
                'name' => 'Project Technical Assistant V',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            122 => 
            array (
                'id' => 184,
                'name' => 'Project Administrative Assistant V',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            123 => 
            array (
                'id' => 185,
                'name' => 'Project Technical Assistant VI',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            124 => 
            array (
                'id' => 186,
                'name' => 'Project Administrative Assistant VI',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            125 => 
            array (
                'id' => 187,
                'name' => 'Project Technical Specialist I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            126 => 
            array (
                'id' => 188,
                'name' => 'Project Administrative Officer I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            127 => 
            array (
                'id' => 189,
                'name' => 'Project Technical Officer I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            128 => 
            array (
                'id' => 190,
                'name' => 'Project Technical Specialist II',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            129 => 
            array (
                'id' => 191,
                'name' => 'Project Administrative Officer II',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            130 => 
            array (
                'id' => 192,
                'name' => 'Project Technical Officer II',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            131 => 
            array (
                'id' => 193,
                'name' => 'Project Technical Specialist III',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            132 => 
            array (
                'id' => 194,
                'name' => 'Project Administrative Officer III',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            133 => 
            array (
                'id' => 195,
                'name' => 'Project Technical Officer III',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            134 => 
            array (
                'id' => 196,
                'name' => 'Project Technical Specialist IV',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            135 => 
            array (
                'id' => 197,
                'name' => 'Project Administrative Officer IV',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            136 => 
            array (
                'id' => 198,
                'name' => 'Project Technical Officer IV',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            137 => 
            array (
                'id' => 199,
                'name' => 'Project Technical Specialist V',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            138 => 
            array (
                'id' => 200,
                'name' => 'Project Administrative Officer V',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            139 => 
            array (
                'id' => 201,
                'name' => 'Project Technical Officer V',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            140 => 
            array (
                'id' => 202,
                'name' => 'Project Technical Specialist VI',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            141 => 
            array (
                'id' => 203,
                'name' => 'Project Administrative Officer VI',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            142 => 
            array (
                'id' => 204,
                'name' => 'Project Technical Officer VI',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            143 => 
            array (
                'id' => 205,
                'name' => 'Project Senior Technical Specialist',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            144 => 
            array (
                'id' => 206,
                'name' => 'Project Senior Administrative Officer I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            145 => 
            array (
                'id' => 207,
                'name' => 'Project Senior Technical Officer I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            146 => 
            array (
                'id' => 208,
                'name' => 'Project Supervising Technical Specialist',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            147 => 
            array (
                'id' => 209,
                'name' => 'Project Supervising Technical Officer',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            148 => 
            array (
                'id' => 210,
                'name' => 'Project Supervising Adminstrative Officer',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            149 => 
            array (
                'id' => 211,
                'name' => 'S&T Fellow I',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            150 => 
            array (
                'id' => 212,
                'name' => 'Project Chief Technical Specialist',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            151 => 
            array (
                'id' => 213,
                'name' => 'Project Chief Technical Officer',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            152 => 
            array (
                'id' => 214,
                'name' => 'Project Chief Administrative Officer',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            153 => 
            array (
                'id' => 215,
                'name' => 'S&T Fellow II',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            154 => 
            array (
                'id' => 216,
                'name' => 'S&T Fellow III',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            155 => 
            array (
                'id' => 217,
                'name' => 'S&T Fellow IV',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            156 => 
            array (
                'id' => 218,
                'name' => 'S&T Fellow V',
                'type' => 'Administrative Order',
                'is_active' => 1,
            ),
            157 => 
            array (
                'id' => 219,
                'name' => 'Information Systems Researcher II',
                'type' => 'Special Order',
                'is_active' => 1,
            ),
        ));

        
    }
}