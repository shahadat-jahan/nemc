<?php

use Illuminate\Database\Seeder;

class StudentGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('student_groups')->delete();
        
        \DB::table('student_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'session_id' => 1,
                'course_id' => 1,
                'group_name' => 'Group - A',
                'type' => 1,
                'roll_start' => 1,
                'roll_end' => 30,
                'old_student' => 0,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-23 10:17:34',
                'updated_at' => '2019-10-23 10:17:34',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'session_id' => 1,
                'course_id' => 1,
                'group_name' => 'Group - B',
                'type' => 1,
                'roll_start' => 31,
                'roll_end' => 60,
                'old_student' => 0,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-23 10:17:59',
                'updated_at' => '2019-10-23 10:17:59',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'session_id' => 1,
                'course_id' => 1,
                'group_name' => 'Group - C',
                'type' => 1,
                'roll_start' => 61,
                'roll_end' => 90,
                'old_student' => 0,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-23 10:18:26',
                'updated_at' => '2019-10-23 10:18:26',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'session_id' => 1,
                'course_id' => 1,
                'group_name' => 'Group - D',
                'type' => 1,
                'roll_start' => 91,
                'roll_end' => 120,
                'old_student' => 0,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-23 10:18:57',
                'updated_at' => '2019-10-23 10:18:57',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}