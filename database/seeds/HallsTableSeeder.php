<?php

use Illuminate\Database\Seeder;

class HallsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('halls')->delete();
        
        \DB::table('halls')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Fahim Gallery',
                'floor_number' => 2,
                'room_number' => '1',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-26 12:19:40',
                'updated_at' => '2019-05-26 12:20:26',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Gallery - II',
                'floor_number' => 1,
                'room_number' => '2',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-26 12:20:57',
                'updated_at' => '2019-05-26 12:54:46',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Gallery - IV',
                'floor_number' => 3,
                'room_number' => '4',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-26 12:22:06',
                'updated_at' => '2019-05-26 12:54:27',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Gallery - V',
                'floor_number' => 3,
                'room_number' => '5',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-26 12:23:38',
                'updated_at' => '2019-05-26 12:54:14',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Gallery - VI',
                'floor_number' => 4,
                'room_number' => '6',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-26 12:24:16',
                'updated_at' => '2019-05-26 12:53:43',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Dissection',
                'floor_number' => 0,
                'room_number' => '01',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-23 10:49:21',
                'updated_at' => '2019-10-23 10:49:21',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Tutorial Class Room',
                'floor_number' => 0,
                'room_number' => '02',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-23 10:49:50',
                'updated_at' => '2019-10-23 10:49:50',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}