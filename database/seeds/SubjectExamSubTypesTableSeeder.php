<?php

use Illuminate\Database\Seeder;

class SubjectExamSubTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subject_exam_sub_types')->delete();
        
        \DB::table('subject_exam_sub_types')->insert(array (
            0 => 
            array (
                'exam_sub_type_id' => 1,
                'subject_id' => 3,
            ),
            1 => 
            array (
                'exam_sub_type_id' => 2,
                'subject_id' => 3,
            ),
            2 => 
            array (
                'exam_sub_type_id' => 3,
                'subject_id' => 3,
            ),
            3 => 
            array (
                'exam_sub_type_id' => 4,
                'subject_id' => 3,
            ),
            4 => 
            array (
                'exam_sub_type_id' => 5,
                'subject_id' => 3,
            ),
            5 => 
            array (
                'exam_sub_type_id' => 8,
                'subject_id' => 3,
            ),
            6 => 
            array (
                'exam_sub_type_id' => 13,
                'subject_id' => 3,
            ),
            7 => 
            array (
                'exam_sub_type_id' => 6,
                'subject_id' => 1,
            ),
            8 => 
            array (
                'exam_sub_type_id' => 7,
                'subject_id' => 1,
            ),
            9 => 
            array (
                'exam_sub_type_id' => 8,
                'subject_id' => 1,
            ),
            10 => 
            array (
                'exam_sub_type_id' => 9,
                'subject_id' => 1,
            ),
            11 => 
            array (
                'exam_sub_type_id' => 11,
                'subject_id' => 1,
            ),
            12 => 
            array (
                'exam_sub_type_id' => 12,
                'subject_id' => 1,
            ),
        ));
        
        
    }
}