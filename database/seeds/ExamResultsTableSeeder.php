<?php

use Illuminate\Database\Seeder;

class ExamResultsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('exam_results')->delete();
        
        
        
    }
}