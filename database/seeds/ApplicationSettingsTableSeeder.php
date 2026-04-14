<?php

use Illuminate\Database\Seeder;

class ApplicationSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('application_settings')->delete();
        
        \DB::table('application_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'North East Medical College and Hospital',
                'phone' => '+880 1786511305',
                'email' => 'info@nemc.edu.bd',
                'address' => 'South Surma, Sylhet-3100, Bangladesh',
                'item_exam_mark' => '10',
                'pass_mark' => '60',
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