<?php

use Illuminate\Database\Seeder;

class ExamCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('exam_categories')->delete();
        
        \DB::table('exam_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Item',
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
                'title' => 'Card',
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
                'title' => 'Term',
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
                'title' => 'Assessment',
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
                'title' => 'Supplementary',
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
                'title' => 'Ward Final',
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
                'title' => 'Professional',
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