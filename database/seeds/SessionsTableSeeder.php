<?php

use Illuminate\Database\Seeder;

class SessionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sessions')->delete();
        
        \DB::table('sessions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '2018-2019',
                'start_year' => 2019,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2019-05-14 15:53:44',
                'updated_at' => '2019-05-15 10:07:17',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '2019-2020',
                'start_year' => 2020,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-05 10:34:28',
                'updated_at' => '2019-10-05 10:34:28',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}