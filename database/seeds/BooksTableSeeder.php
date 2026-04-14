<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('books')->delete();
        
        \DB::table('books')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'A Text Book of Medical Physiology',
                'subject_id' => 2,
                'author' => 'Arthar C Guyton MD John E Hall. Ph.D',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-29 09:59:50',
                'updated_at' => '2019-08-29 09:59:50',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Ganong’s Review of Medical Physiology',
                'subject_id' => 2,
                'author' => 'Willam F. Ganong MD',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-29 10:00:33',
                'updated_at' => '2019-08-29 10:00:33',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Samson’s Wright Applied Physiology',
                'subject_id' => 2,
                'author' => 'Cyril A. Keele, Eric Neil, Norman Joels',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-29 10:01:10',
                'updated_at' => '2019-08-29 10:01:10',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'A Text Book of Practical Physiology',
                'subject_id' => 2,
                'author' => 'CL. Ghai',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-29 10:01:45',
                'updated_at' => '2019-08-29 10:01:45',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Hand Book of Practical Physiology',
                'subject_id' => 2,
                'author' => 'Dr. B.K.Agarwala',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-29 10:02:27',
                'updated_at' => '2019-08-29 10:02:27',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
            'title' => 'Human Physiology (CVS, NS)',
                'subject_id' => 2,
                'author' => 'C.C.Chatterjee',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-29 10:03:03',
                'updated_at' => '2019-08-29 10:03:03',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
            'title' => 'MAT (Mordern Assessment Technique of Medical Physiology)',
                'subject_id' => 2,
                'author' => 'Physiology Curriculam Committee',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-29 10:04:01',
                'updated_at' => '2019-08-29 10:04:01',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'Laboratory Manual For Practical Biochemistry & Physiology',
                'subject_id' => 2,
                'author' => 'Prof. Dr. Ruhul Amin Dr. Selim Reza',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-29 10:04:49',
                'updated_at' => '2019-08-29 10:04:49',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Cunninghums manual practical anatomy, Vol: I, II & III',
                'subject_id' => 1,
                'author' => 'Romanes, G.J.',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-29 10:07:36',
                'updated_at' => '2019-08-29 10:07:36',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'Clinical anatomy for medical students',
                'subject_id' => 1,
                'author' => 'Snell, R.S.',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:05:36',
                'updated_at' => '2019-08-31 10:05:36',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'title' => 'Clinical neuroanatomy for medical students',
                'subject_id' => 1,
                'author' => 'Snell, R.S.',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:06:36',
                'updated_at' => '2019-08-31 10:06:36',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'title' => 'Histology: Text & atlas Basic histology',
                'subject_id' => 1,
                'author' => 'Ross, Michael, H. Or Junqueira, L.C.',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:07:41',
                'updated_at' => '2019-08-31 10:07:41',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'title' => 'Langman’s Medical Embryology',
                'subject_id' => 1,
                'author' => 'Sadler, T.W.',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:08:32',
                'updated_at' => '2019-08-31 10:08:32',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'title' => 'Essentials of medical genetics',
                'subject_id' => 1,
                'author' => 'Datta, A.K.',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:09:25',
                'updated_at' => '2019-08-31 10:09:25',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'title' => 'Principles of general anatomy',
                'subject_id' => 1,
                'author' => 'Vishram Singh',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:10:15',
                'updated_at' => '2019-08-31 10:10:15',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'title' => 'Human anatomy, Vol: I, II & III',
                'subject_id' => 1,
                'author' => 'Vishram Singh',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:10:58',
                'updated_at' => '2019-08-31 10:10:58',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'title' => 'DiFiore’s Atlas of histology',
                'subject_id' => 1,
                'author' => 'Eroschenoka. V.P.',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:11:47',
                'updated_at' => '2019-08-31 10:11:47',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'title' => 'Gray’s Anatomy, The anatomical of clinical practical',
                'subject_id' => 1,
                'author' => 'Henry Gray',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:12:26',
                'updated_at' => '2019-08-31 10:12:26',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'title' => 'Tabers cyclopedic medical dictionary',
                'subject_id' => 1,
                'author' => 'Jayper F.A. DAVIS',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:13:12',
                'updated_at' => '2019-08-31 10:13:12',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'title' => 'Atlas',
                'subject_id' => 1,
                'author' => 'Grants',
                'edition' => 'Latest',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-08-31 10:13:59',
                'updated_at' => '2019-08-31 10:13:59',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}