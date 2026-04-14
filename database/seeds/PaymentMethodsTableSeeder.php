<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_methods')->delete();
        
        \DB::table('payment_methods')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Cash on NEMC',
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
                'title' => 'Cash on Bank',
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
                'title' => 'Check',
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