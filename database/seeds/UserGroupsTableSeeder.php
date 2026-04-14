<?php

use Illuminate\Database\Seeder;

class UserGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_groups')->delete();
        
        \DB::table('user_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'group_name' => 'Super Admin',
                'description' => 'Super Admin can access all menus',
                'status' => 0,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'group_name' => 'Admin',
                'description' => 'Admin can access limited menus',
                'status' => 0,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'group_name' => 'Stuff - Office',
                'description' => 'Stuff - Office can access limited menus',
                'status' => 0,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'group_name' => 'Teacher',
                'description' => 'Teacher can access limited menus',
                'status' => 0,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'group_name' => 'Student',
                'description' => 'Student can access limited menus',
                'status' => 0,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'group_name' => 'Parent',
                'description' => 'Parent can access limited menus',
                'status' => 0,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'group_name' => 'Stuff - Accounts',
                'description' => 'Stuff - Accounts can access limited menus',
                'status' => 0,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}