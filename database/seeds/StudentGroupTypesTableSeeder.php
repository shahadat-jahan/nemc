<?php

use App\Services\UtilityServices;
use Illuminate\Database\Seeder;

class StudentGroupTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupTypes = UtilityServices::$studentGroupTypes;
        foreach ($groupTypes as $key => $groupType) {
            // Skip if already exists
            if (!DB::table('student_group_types')->where('title', $groupType)->exists()) {
                DB::table('student_group_types')->insert([
                    'title' => $groupType,
                    'description' => '',
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
