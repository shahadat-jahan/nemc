<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('departments')->delete();
        
        \DB::table('departments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Administration',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Admission',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'IT',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Anatomy',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Physiology',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Biochemistry',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Community Medicine',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Forensic Medicine',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Pharmacology & Therapeutics',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Pathology',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Microbiology',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Medicine',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Pediatrics',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Surgery',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Gynaecology',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Dental Materials',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Periodontology & Oral Pathology',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Oral & Maxillofacial Surgery',
                'description' => NULL,
                'department_lead_id' => NULL,
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
                'title' => 'Conservative Dentistry & Endodontics',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'title' => 'Prosthodontics',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'title' => 'Orthodontics & Dentofacial Orthopedics',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'title' => 'Pedodontics & Dental Public Health',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-14 15:46:34',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'title' => 'Anaesthesiology',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 10:03:41',
                'updated_at' => '2019-05-22 10:03:41',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'title' => 'Cardiology',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 10:06:13',
                'updated_at' => '2019-05-22 10:06:42',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'title' => 'Urology',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 10:07:01',
                'updated_at' => '2019-05-22 10:10:57',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'title' => 'Dermatology',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 10:08:27',
                'updated_at' => '2019-05-22 10:08:27',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'title' => 'Forensic Medicine',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 10:08:50',
                'updated_at' => '2019-05-22 10:08:50',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'title' => 'Accounts',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-21 10:03:23',
                'updated_at' => '2019-10-21 10:03:23',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'title' => 'Dental',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-21 10:03:49',
                'updated_at' => '2019-10-21 10:03:49',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'title' => 'Orthopaedics',
                'description' => NULL,
                'department_lead_id' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-27 09:47:45',
                'updated_at' => '2019-10-27 09:47:45',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}