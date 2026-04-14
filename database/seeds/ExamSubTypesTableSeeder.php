<?php

use Illuminate\Database\Seeder;

class ExamSubTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('exam_sub_types')->delete();
        
        \DB::table('exam_sub_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'exam_type_id' => 1,
                'title' => 'Class Attendance, performance',
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
                'exam_type_id' => 2,
                'title' => 'Board - I',
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
                'exam_type_id' => 2,
                'title' => 'Board - II',
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
                'exam_type_id' => 3,
                'title' => 'Group A / Part - 1',
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
                'exam_type_id' => 3,
                'title' => 'Group B / Part - 2',
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
                'exam_type_id' => 4,
                'title' => 'Hard Part',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'exam_type_id' => 4,
                'title' => 'Soft Part',
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
                'exam_type_id' => 5,
                'title' => 'OSPE',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'exam_type_id' => 5,
                'title' => 'Surface marking',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'exam_type_id' => 5,
                'title' => 'Viscera',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'exam_type_id' => 5,
                'title' => 'Radiology',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'exam_type_id' => 5,
                'title' => 'Dissection',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'exam_type_id' => 5,
                'title' => 'Notebook',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'exam_type_id' => 5,
                'title' => 'Traditional practical methods & experiments',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'exam_type_id' => 5,
                'title' => 'Report on Survey / Research',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'exam_type_id' => 5,
                'title' => 'Report on Day Visit',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'exam_type_id' => 5,
                'title' => 'Assessment on RFST program',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'exam_type_id' => 5,
                'title' => 'Log Book',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'exam_type_id' => 5,
                'title' => 'Long Case',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}