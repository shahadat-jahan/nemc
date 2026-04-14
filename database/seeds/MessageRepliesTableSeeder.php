<?php

use Illuminate\Database\Seeder;

class MessageRepliesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('message_replies')->delete();
        
        
        
    }
}