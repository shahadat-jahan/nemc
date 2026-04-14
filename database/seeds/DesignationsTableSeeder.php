<?php

use Illuminate\Database\Seeder;

class DesignationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('designations')->delete();
        
        \DB::table('designations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Chairman',
                'description' => NULL,
                'org_order' => '1',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Principle',
                'description' => NULL,
                'org_order' => '2',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Managing Director',
                'description' => NULL,
                'org_order' => '3',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Head of Department',
                'description' => NULL,
                'org_order' => '4',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Professor',
                'description' => NULL,
                'org_order' => '5',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Associate Professor',
                'description' => NULL,
                'org_order' => '6',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => '2019-05-22 13:19:03',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Lecturer',
                'description' => NULL,
                'org_order' => '7',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'Assistant Professor',
                'description' => NULL,
                'org_order' => '8',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:17:46',
                'updated_at' => '2019-05-22 13:17:46',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Vice Principal',
                'description' => NULL,
                'org_order' => '9',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:18:32',
                'updated_at' => '2019-05-22 13:18:32',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'Registrar',
                'description' => NULL,
                'org_order' => '10',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:19:59',
                'updated_at' => '2019-05-22 13:19:59',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'title' => 'Senior Lecturer',
                'description' => NULL,
                'org_order' => '11',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:20:43',
                'updated_at' => '2019-05-22 13:20:43',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'title' => 'Senior Registrar',
                'description' => NULL,
                'org_order' => '12',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:21:10',
                'updated_at' => '2019-05-22 13:21:10',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'title' => 'RP/RS',
                'description' => NULL,
                'org_order' => '13',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:22:22',
                'updated_at' => '2019-05-22 13:22:22',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'title' => 'Secretary',
                'description' => NULL,
                'org_order' => '14',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-21 09:38:42',
                'updated_at' => '2019-10-21 09:38:42',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'title' => 'Senior Assistant Secretary',
                'description' => NULL,
                'org_order' => '15',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-21 09:39:20',
                'updated_at' => '2019-10-21 09:39:20',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'title' => 'Chief Accountant',
                'description' => NULL,
                'org_order' => '16',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-21 09:40:08',
                'updated_at' => '2019-10-21 09:40:08',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'title' => 'Deputy Manager Admin &Finance',
                'description' => NULL,
                'org_order' => '17',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-21 09:41:06',
                'updated_at' => '2019-10-21 09:41:06',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'title' => 'Assistant Accountant',
                'description' => NULL,
                'org_order' => '18',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-21 09:42:14',
                'updated_at' => '2019-10-21 09:42:14',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'title' => 'Office Assistant',
                'description' => NULL,
                'org_order' => '19',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-21 09:44:16',
                'updated_at' => '2019-10-21 09:44:16',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'title' => 'Assistant Secretary',
                'description' => NULL,
                'org_order' => '20',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-21 09:45:46',
                'updated_at' => '2019-10-21 09:45:46',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'title' => 'Manager- MIS',
                'description' => NULL,
                'org_order' => '21',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-23 11:49:25',
                'updated_at' => '2019-10-23 11:49:25',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'title' => 'Computer Engineer',
                'description' => NULL,
                'org_order' => '22',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-23 11:50:34',
                'updated_at' => '2019-10-23 11:50:34',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'title' => 'Assistant Manager- IT',
                'description' => NULL,
                'org_order' => '23',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-23 12:05:35',
                'updated_at' => '2019-10-23 12:05:35',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'title' => 'Deputy Manager- Accounts',
                'description' => NULL,
                'org_order' => '24',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-23 12:37:10',
                'updated_at' => '2019-10-23 12:37:10',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}