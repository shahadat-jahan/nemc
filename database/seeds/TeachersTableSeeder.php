<?php

use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('teachers')->delete();
        
        \DB::table('teachers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 2,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Raju',
                'last_name' => 'Chowdhury',
                'dob' => '1987-06-07',
                'gender' => 'male',
                'phone' => '01610506030',
                'share_phone' => 1,
                'email' => 'dr.raju96@gmail.com',
                'share_email' => 1,
                'address' => 'Somed complex- 405, Chondipul, South Surma
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558412964_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 10:29:30',
                'updated_at' => '2019-05-21 10:29:30',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 3,
                'department_id' => 4,
                'designation_id' => 6,
                'course_id' => 1,
                'first_name' => 'Dr. Md. Muzibur',
                'last_name' => 'Rahman',
                'dob' => '1961-02-04',
                'gender' => 'male',
                'phone' => '01756750752',
                'share_phone' => 1,
                'email' => 'nrpur1961@gmail.com',
                'share_email' => 1,
                'address' => '68/ Housing Estate, Amberkhana
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 10:32:15',
                'updated_at' => '2019-05-21 10:32:15',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 4,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. A. S. M. Mashrurul',
                'last_name' => 'Haque',
                'dob' => '1987-12-20',
                'gender' => 'male',
                'phone' => '01675540468',
                'share_phone' => 1,
                'email' => 'haquemashrur@gmail.com',
                'share_email' => 1,
            'address' => 'House No. 178, (Ground Floor) Road No. 05, Block E, Uposhohor
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558413278_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 10:34:43',
                'updated_at' => '2019-05-21 10:34:43',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 5,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Sultana Momtarin',
                'last_name' => 'Papri',
                'dob' => '1990-12-16',
                'gender' => 'female',
                'phone' => '01716320825',
                'share_phone' => 1,
                'email' => 'momtarinpapri@yahoo.com',
                'share_email' => 1,
                'address' => 'Flat #2nd Floor, Tasmia Tower, Subid Bazar
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558413430_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 10:37:15',
                'updated_at' => '2019-05-21 10:37:15',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 6,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Rayhan',
                'last_name' => 'Mahmud',
                'dob' => '1991-02-03',
                'gender' => 'male',
                'phone' => '01722381300',
                'share_phone' => 1,
                'email' => 'rayhan.nemc@hotmail.com',
                'share_email' => 1,
                'address' => 'House #49/5, Mohammad Nagar, Jalalabad
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 10:38:59',
                'updated_at' => '2019-05-21 10:38:59',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 7,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Mirza Kamrul Hasan',
                'last_name' => 'Shakil',
                'dob' => '1988-12-02',
                'gender' => 'male',
                'phone' => '01716900576',
                'share_phone' => 1,
                'email' => 'shakilmirza63@gmail.com',
                'share_email' => 1,
                'address' => '317- North Bagbari
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558413665_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 10:41:43',
                'updated_at' => '2019-05-21 10:41:43',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'user_id' => 8,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Sinan',
                'last_name' => 'Mahmud',
                'dob' => '1993-01-07',
                'gender' => 'male',
                'phone' => '01672197332',
                'share_phone' => 1,
                'email' => 'mahmud_sinan@yahoo.com',
                'share_email' => 1,
                'address' => '120-Paira, Dorgah Moholla
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558413817_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 10:43:41',
                'updated_at' => '2019-05-21 10:43:41',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'user_id' => 9,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Sharmistha',
                'last_name' => 'Das',
                'dob' => '1992-12-18',
                'gender' => 'female',
                'phone' => '01625228630',
                'share_phone' => 1,
                'email' => 'mistus525@gmail.com',
                'share_email' => 1,
                'address' => NULL,
                'photo' => 'nemc_files/teachers/1558414006_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 10:46:49',
                'updated_at' => '2019-05-21 10:46:49',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'user_id' => 10,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Tahaani Al-Hoque',
                'last_name' => 'Chowdhury',
                'dob' => '1993-10-02',
                'gender' => 'female',
                'phone' => '01723166508',
                'share_phone' => 1,
                'email' => 'tahaanichowdhury@gmail.com',
                'share_email' => 1,
                'address' => 'Homewisecenter, Tilagarh
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558414151_image.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 10:49:30',
                'updated_at' => '2019-05-21 10:49:30',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'user_id' => 11,
                'department_id' => 6,
                'designation_id' => 6,
                'course_id' => 1,
                'first_name' => 'Dr. Syeda Umme Fahmida',
                'last_name' => 'Malik',
                'dob' => '1974-02-04',
                'gender' => 'female',
                'phone' => '01712241134',
                'share_phone' => 1,
                'email' => 'fahmidareza@yahoo.com',
                'share_email' => 1,
                'address' => 'House #408, Uttar Baghbari
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558414841_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 11:00:45',
                'updated_at' => '2019-05-21 11:42:15',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'user_id' => 12,
                'department_id' => 6,
                'designation_id' => 6,
                'course_id' => 1,
                'first_name' => 'Dr. Md. Kamrul Husain',
                'last_name' => 'Azad',
                'dob' => '1969-07-05',
                'gender' => 'male',
                'phone' => '01715056229',
                'share_phone' => 1,
                'email' => 'kamrul.azad@yahoo.com',
                'share_email' => 1,
                'address' => '25-Borobazar R/A, Amberkhana
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558415059_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 11:04:25',
                'updated_at' => '2019-05-21 11:42:04',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'user_id' => 13,
                'department_id' => 1,
                'designation_id' => 2,
                'course_id' => NULL,
                'first_name' => 'Prof. Dr. Md. Manajjir',
                'last_name' => 'Ali',
                'dob' => '1958-01-01',
                'gender' => 'male',
                'phone' => '01711301116',
                'share_phone' => 0,
                'email' => 'ali.manajjir@yahoo.com',
                'share_email' => 1,
                'address' => 'Ali Valley, 17 Renesa, Surma R/A, P.O.- Akhalia, Upozilla- Sadar, District – Sylhet, Bangladesh
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558416255_download.png',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-21 11:24:25',
                'updated_at' => '2019-05-21 11:46:46',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'user_id' => 14,
                'department_id' => 6,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Rashad',
                'last_name' => 'Kibria',
                'dob' => '1992-02-22',
                'gender' => 'male',
                'phone' => '01718388698',
                'share_phone' => 1,
                'email' => 'rashadkibria@gmail.com',
                'share_email' => 1,
                'address' => 'House #10, Road #31, Block-D, Uposhohor
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558497012_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 09:50:16',
                'updated_at' => '2019-05-22 09:50:16',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'user_id' => 15,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Sadia Islam',
                'last_name' => 'Nabila',
                'dob' => '1989-08-09',
                'gender' => 'female',
                'phone' => '01922743349',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Uddipon-42 Mirabazar, Sylhet
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558508865_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:07:54',
                'updated_at' => '2019-05-22 13:07:54',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'user_id' => 16,
                'department_id' => 4,
                'designation_id' => 5,
                'course_id' => 1,
                'first_name' => 'Prof. Dr. Hamida',
                'last_name' => 'Khatun',
                'dob' => '1975-01-14',
                'gender' => 'female',
                'phone' => '01747914888',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Tawfiq Villa, Kollanpur- 9, Tillagor
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558509064_Photo.PNG',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:11:13',
                'updated_at' => '2019-05-22 13:11:13',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'user_id' => 17,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Syeda Badrun',
                'last_name' => 'Nessa',
                'dob' => '1984-09-11',
                'gender' => 'female',
                'phone' => '01722482381',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 0,
                'address' => NULL,
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:14:26',
                'updated_at' => '2019-05-22 13:14:26',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'user_id' => 18,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Khandker Ishtiaque',
                'last_name' => 'Arafat',
                'dob' => '1988-10-20',
                'gender' => 'male',
                'phone' => '01675869015',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 0,
                'address' => '2B, Doctor\'s Garden, Kajalshah
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:16:12',
                'updated_at' => '2019-05-22 13:16:12',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'user_id' => 19,
                'department_id' => 4,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Asif Hasan',
                'last_name' => 'Bappy',
                'dob' => '1992-07-21',
                'gender' => 'male',
                'phone' => '01723829064',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 0,
                'address' => 'House-12, Road- 17, Khilkhet,
Country : Bangladesh
State : Dhaka
City : Dhaka
Zip code : 1229',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:24:35',
                'updated_at' => '2019-05-22 13:24:35',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'user_id' => 20,
                'department_id' => 6,
                'designation_id' => 11,
                'course_id' => 1,
                'first_name' => 'Dr. Smita',
                'last_name' => 'Roy',
                'dob' => '1986-09-01',
                'gender' => 'female',
                'phone' => '01717889581',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Shorno Nir, Akota-115, Norshing Tilla, Bagbari
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:30:25',
                'updated_at' => '2019-05-22 13:30:25',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'user_id' => 21,
                'department_id' => 6,
                'designation_id' => 8,
                'course_id' => 1,
                'first_name' => 'Dr. Begum Nazmus Sama',
                'last_name' => 'Shimu',
                'dob' => '1982-09-20',
                'gender' => 'female',
                'phone' => '01715744621',
                'share_phone' => 1,
                'email' => 'nazmussamashimu@gmail.com',
                'share_email' => 1,
                'address' => 'Nurani- 65/4, Kalapara, Subidbazar
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558510408_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 13:33:32',
                'updated_at' => '2019-05-22 14:01:27',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'user_id' => 22,
                'department_id' => 6,
                'designation_id' => 8,
                'course_id' => 1,
                'first_name' => 'Dr. Mushfika Rahman',
                'last_name' => 'Chowdhury',
                'dob' => '1975-12-20',
                'gender' => 'female',
                'phone' => '01711323456',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Holding No. 1008, Word No. 09, Road- Abdul Mujib Road, Botesshor Cantonment
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code',
                'photo' => 'nemc_files/teachers/1558512035_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 14:00:41',
                'updated_at' => '2019-05-22 14:00:41',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'user_id' => 23,
                'department_id' => 6,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Adnan Ibn',
                'last_name' => 'Shahjahan',
                'dob' => '1984-02-21',
                'gender' => 'male',
                'phone' => '01718388698',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Holding Provah #11, V.I.P Road- Taltola
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 14:03:15',
                'updated_at' => '2019-05-22 14:03:15',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'user_id' => 24,
                'department_id' => 5,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Shahanara',
                'last_name' => 'Begum',
                'dob' => '1985-03-25',
                'gender' => 'female',
                'phone' => '01714912269',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 0,
                'address' => 'Al-amin- 04, Charadigirpar, Nayasarak
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558587286_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 10:54:50',
                'updated_at' => '2019-05-23 10:54:50',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'user_id' => 25,
                'department_id' => 5,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Tahmina',
                'last_name' => 'Khaleque',
                'dob' => '1964-07-28',
                'gender' => 'female',
                'phone' => '01715112121',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 0,
            'address' => 'Alma Community Center (1st Floor), Tengra Road, Lalabazar
Country : Bangladesh
State : Sylhet
City : Sylhet',
                'photo' => 'nemc_files/teachers/1558587404_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 10:56:47',
                'updated_at' => '2019-05-23 10:56:47',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'user_id' => 26,
                'department_id' => 5,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Tasnia Binta',
                'last_name' => 'Afzal',
                'dob' => '1987-06-01',
                'gender' => 'female',
                'phone' => '01763878216',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 0,
                'address' => '10/N, Rahim Tower, Subhanighat, Sylhet
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558587518_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 10:58:42',
                'updated_at' => '2019-05-23 10:58:42',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'user_id' => 27,
                'department_id' => 5,
                'designation_id' => 11,
                'course_id' => 1,
                'first_name' => 'Dr. Shahinara Akter',
                'last_name' => 'Saki',
                'dob' => '1988-01-26',
                'gender' => 'female',
                'phone' => '01752159899',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 0,
                'address' => 'Somed Complex- 304, Chondipul, South Surma
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558587618_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 11:00:21',
                'updated_at' => '2019-05-23 11:00:21',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'user_id' => 28,
                'department_id' => 5,
                'designation_id' => 6,
                'course_id' => 1,
                'first_name' => 'Dr. Mahmuda Quamrun',
                'last_name' => 'Nahar',
                'dob' => '1977-01-01',
                'gender' => 'female',
                'phone' => '01768637392',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 0,
                'address' => 'House No- 14, Block D, Pollobi, West Pathantula
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558587725_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 11:02:08',
                'updated_at' => '2019-05-23 11:02:08',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'user_id' => 29,
                'department_id' => 5,
                'designation_id' => 8,
                'course_id' => 1,
                'first_name' => 'Dr. Umme Asma',
                'last_name' => 'Mridha',
                'dob' => '1978-11-28',
                'gender' => 'female',
                'phone' => '01711580393',
                'share_phone' => 1,
                'email' => 'asma01197@gmail.com',
                'share_email' => 1,
                'address' => 'Elias Miah, Banglo Bari- 3/1, Subid Bazar
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558590119_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 11:42:10',
                'updated_at' => '2019-05-23 11:42:10',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'user_id' => 30,
                'department_id' => 5,
                'designation_id' => 8,
                'course_id' => 1,
                'first_name' => 'Dr. Nahida Sultana',
                'last_name' => 'Nipa',
                'dob' => '1986-07-12',
                'gender' => 'female',
                'phone' => '01725713661',
                'share_phone' => 1,
                'email' => 'dr.nahidasultana12@gmail.com',
                'share_email' => 1,
                'address' => '5 Moktobgoli, Kazitula
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558590244_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 11:44:10',
                'updated_at' => '2019-05-23 11:44:10',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'user_id' => 31,
                'department_id' => 5,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Bishwajit',
                'last_name' => 'Chakrabarty',
                'dob' => '1978-01-01',
                'gender' => 'male',
                'phone' => '01752450999',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'House No- 19, Shadipur R/A, Shibganj
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 11:45:57',
                'updated_at' => '2019-05-23 11:46:27',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'user_id' => 32,
                'department_id' => 5,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Md. Samiur Rahman',
                'last_name' => 'Laskar',
                'dob' => '1988-12-12',
                'gender' => 'male',
                'phone' => '01713459223',
                'share_phone' => 1,
                'email' => 'sami.laskar@yahoo.com',
                'share_email' => 1,
                'address' => 'Block- H, House-12, Main Road. Shahjalal Uposhohor
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 11:48:09',
                'updated_at' => '2019-05-23 11:48:09',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'user_id' => 33,
                'department_id' => 5,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Arunima',
                'last_name' => 'Datta',
                'dob' => '1989-10-13',
                'gender' => 'female',
                'phone' => '01620946498',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Somed Complex- 304, Chondipull, South Surma
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558590578_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 11:49:42',
                'updated_at' => '2019-05-23 11:49:42',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'user_id' => 34,
                'department_id' => 7,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Saber Ahmed',
                'last_name' => 'Shimul',
                'dob' => '1992-08-29',
                'gender' => 'male',
                'phone' => '01765119377',
                'share_phone' => 1,
                'email' => 'nogorboul29@gmail.com',
                'share_email' => 1,
                'address' => '59- Sonali R/A, Dhamailpara, Akhalia
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:05:38',
                'updated_at' => '2019-05-23 12:05:38',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'user_id' => 35,
                'department_id' => 7,
                'designation_id' => 11,
                'course_id' => 1,
                'first_name' => 'Dr. Md. Akhtar Uz',
                'last_name' => 'Zaman',
                'dob' => '1988-11-16',
                'gender' => 'male',
                'phone' => '01716247914',
                'share_phone' => 0,
                'email' => 'dr.akhtar12345678@gmail.com',
                'share_email' => 0,
                'address' => '384- Uttar Bagbari
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:08:31',
                'updated_at' => '2019-05-23 12:08:31',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'user_id' => 36,
                'department_id' => 7,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Shamrat Adnan',
                'last_name' => 'Chowdhury',
                'dob' => '1990-06-22',
                'gender' => 'male',
                'phone' => '01718059990',
                'share_phone' => 1,
                'email' => 'shamrat.nemc07@gmail.com',
                'share_email' => 1,
                'address' => 'Daroga Bari, Rajanigandha- 01, Bhangatikar, Sheikhghat
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:10:17',
                'updated_at' => '2019-05-23 12:10:17',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'user_id' => 37,
                'department_id' => 7,
                'designation_id' => 8,
                'course_id' => 1,
                'first_name' => 'Dr. Tanusree',
                'last_name' => 'Sarkar',
                'dob' => '1981-09-06',
                'gender' => 'female',
                'phone' => '01712651341',
                'share_phone' => 0,
                'email' => NULL,
                'share_email' => 0,
                'address' => '67- Kha, Sadipur, Shibganj
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558591971_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:13:00',
                'updated_at' => '2019-05-23 12:13:00',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'user_id' => 38,
                'department_id' => 7,
                'designation_id' => 5,
                'course_id' => 1,
                'first_name' => 'Prof. Dr. Md. Abdul',
                'last_name' => 'Khalique',
                'dob' => '1949-09-10',
                'gender' => 'male',
                'phone' => '01750093350',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => '157- Kajalshah
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:16:38',
                'updated_at' => '2019-05-23 12:16:38',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'user_id' => 39,
                'department_id' => 7,
                'designation_id' => 6,
                'course_id' => 1,
                'first_name' => 'Dr. Satya Ranjan',
                'last_name' => 'Roy',
                'dob' => '1950-10-31',
                'gender' => 'male',
                'phone' => '01711976349',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'NEMC',
                'photo' => 'nemc_files/teachers/1558592322_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:18:46',
                'updated_at' => '2019-05-23 12:18:46',
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'user_id' => 40,
                'department_id' => 8,
                'designation_id' => 11,
                'course_id' => 1,
                'first_name' => 'Dr. Fahmida',
                'last_name' => 'Begum',
                'dob' => '1983-01-01',
                'gender' => 'female',
                'phone' => '01712275236',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Road No. 07, House No. 11, Block- A, Uposhohor
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558592533_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:22:17',
                'updated_at' => '2019-05-23 12:22:17',
                'deleted_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'user_id' => 41,
                'department_id' => 8,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Md. Erfat',
                'last_name' => 'Hussain',
                'dob' => '1990-04-24',
                'gender' => 'male',
                'phone' => '01717266225',
                'share_phone' => 1,
                'email' => 'irfat2161@gmail.com',
                'share_email' => 1,
                'address' => 'Bithika A/2, Vatalia Road Lama Bazar
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:25:19',
                'updated_at' => '2019-05-23 12:25:19',
                'deleted_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'user_id' => 42,
                'department_id' => 8,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. A.T.M. Mahadee',
                'last_name' => 'Hasan',
                'dob' => '1992-02-18',
                'gender' => 'male',
                'phone' => '01750629337',
                'share_phone' => 1,
                'email' => 'haasan.mahedi@gmail.com',
                'share_email' => 1,
                'address' => 'NEMC',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:26:54',
                'updated_at' => '2019-05-23 12:26:54',
                'deleted_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'user_id' => 43,
                'department_id' => 8,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Md. Fahmidur',
                'last_name' => 'Rahman',
                'dob' => '1987-02-05',
                'gender' => 'male',
                'phone' => '01717497395',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Rahman Villa Khujarkola, Technical Road
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code',
                'photo' => 'nemc_files/teachers/1558592912_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:28:36',
                'updated_at' => '2019-05-23 12:28:36',
                'deleted_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'user_id' => 44,
                'department_id' => 8,
                'designation_id' => 6,
                'course_id' => 1,
                'first_name' => 'Dr. Mohammad Shamsul',
                'last_name' => 'Alam',
                'dob' => '1974-01-01',
                'gender' => 'male',
                'phone' => '01911681251',
                'share_phone' => 1,
                'email' => 'shamsul.sylhet@gmail.com',
                'share_email' => 1,
                'address' => '188/1- Miah Fazil Chist, Subid Bazar
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558593044_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:30:47',
                'updated_at' => '2019-05-23 12:30:47',
                'deleted_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'user_id' => 45,
                'department_id' => 8,
                'designation_id' => 5,
                'course_id' => 1,
                'first_name' => 'Prof. Dr. Md. Moazzem Husain',
                'last_name' => 'Khan',
                'dob' => '1952-06-30',
                'gender' => 'male',
                'phone' => '01711399104',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Khan Pharmacy, Shibganj Bazar
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558593468_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 12:37:52',
                'updated_at' => '2019-05-23 12:37:52',
                'deleted_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'user_id' => 46,
                'department_id' => 9,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Sadia Nusrat',
                'last_name' => 'Chowdhury',
                'dob' => '1991-12-11',
                'gender' => 'female',
                'phone' => '01677708621',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => '32- Valley City, Shahi Eidgah, TB Gate
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 13:04:18',
                'updated_at' => '2019-05-23 13:04:18',
                'deleted_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'user_id' => 47,
                'department_id' => 9,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Md. Abul Khaer',
                'last_name' => 'Chowdhury',
                'dob' => '1988-01-05',
                'gender' => 'male',
                'phone' => '01711912171',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'House No- 7, Road No. 8, Block- A, Uposhohor
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558595184_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 13:06:27',
                'updated_at' => '2019-05-23 13:06:27',
                'deleted_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'user_id' => 48,
                'department_id' => 9,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Abdul Aziz',
                'last_name' => 'Abdullah',
                'dob' => '1993-07-01',
                'gender' => 'male',
                'phone' => '01711441198',
                'share_phone' => 1,
                'email' => 'abdullahabdulaziz309@gmail.com',
                'share_email' => 1,
            'address' => 'House No. 6 (3rd Floor), Dargah Gate
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 13:08:10',
                'updated_at' => '2019-05-23 13:08:10',
                'deleted_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'user_id' => 49,
                'department_id' => 9,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Tawshif',
                'last_name' => 'Ahmed',
                'dob' => '1990-03-06',
                'gender' => 'male',
                'phone' => '01738234598',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => '15- Sheikhghat, Khuliatula
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 13:09:40',
                'updated_at' => '2019-05-23 13:09:40',
                'deleted_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'user_id' => 50,
                'department_id' => 9,
                'designation_id' => 6,
                'course_id' => NULL,
                'first_name' => 'Dr. Ashoke Bijoy Das',
                'last_name' => 'Gupta',
                'dob' => '1953-10-10',
                'gender' => 'male',
                'phone' => '01674500000',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'C/O Bimolendu Dey Nantu, Jallarpar
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558595660_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 13:14:24',
                'updated_at' => '2019-05-23 13:14:24',
                'deleted_at' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'user_id' => 51,
                'department_id' => 9,
                'designation_id' => 8,
                'course_id' => 1,
                'first_name' => 'Dr. Nasrin',
                'last_name' => 'Akter',
                'dob' => '1986-10-05',
                'gender' => 'male',
                'phone' => '01718284030',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Royal Plaza, 52/A, Pirozpur, South Surma
Country : Bangladesh
State : Sylhet
City : Sylhet',
                'photo' => 'nemc_files/teachers/1558595794_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 13:16:38',
                'updated_at' => '2019-05-23 13:16:38',
                'deleted_at' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'user_id' => 52,
                'department_id' => 9,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Sharmin',
                'last_name' => 'Bakht',
                'dob' => '1988-10-15',
                'gender' => 'female',
                'phone' => '01674745623',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => '13 Jalali, Rahman Bhaban, Electric Supply Road
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 13:18:59',
                'updated_at' => '2019-05-23 13:18:59',
                'deleted_at' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'user_id' => 53,
                'department_id' => 9,
                'designation_id' => 6,
                'course_id' => 1,
                'first_name' => 'Dr. Md. Mokbul',
                'last_name' => 'Hossain',
                'dob' => '1981-10-12',
                'gender' => 'male',
                'phone' => '01711476917',
                'share_phone' => 1,
                'email' => 'dr.mokbulhossain@yahoo.com',
                'share_email' => 1,
                'address' => 'Diganto 6/3, Rai Hossain House, 2nd Floor, Electric Supply Road
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1558596064_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-23 13:21:08',
                'updated_at' => '2019-05-23 13:21:08',
                'deleted_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'user_id' => 324,
                'department_id' => 10,
                'designation_id' => 6,
                'course_id' => 1,
                'first_name' => 'Dr. Md. Sabbir',
                'last_name' => 'Hossain',
                'dob' => '1979-03-24',
                'gender' => 'male',
                'phone' => '01711012502',
                'share_phone' => 0,
                'email' => 'dr.saber122@gmail.com',
                'share_email' => 0,
                'address' => 'Anowara Kutir , Sylhet Road, Barleka
Country : Bangladesh
State : Sylhet
City : Moulvibazar
Zip code',
                'photo' => 'nemc_files/teachers/1568440719_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 11:58:47',
                'updated_at' => '2019-09-14 11:58:47',
                'deleted_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'user_id' => 325,
                'department_id' => 10,
                'designation_id' => 5,
                'course_id' => 1,
                'first_name' => 'Dr. Mosammat Suchana',
                'last_name' => 'Nazrin',
                'dob' => '1978-07-25',
                'gender' => 'female',
                'phone' => '01711984063',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'C/O Md. Farid, Vill: Gohira, PS: Raowjan,
Country : Bangladesh
State : Chittagong
City : Chittagong
Zip code',
                'photo' => 'nemc_files/teachers/1568441195_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:06:39',
                'updated_at' => '2019-09-14 12:06:39',
                'deleted_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'user_id' => 326,
                'department_id' => 10,
                'designation_id' => 8,
                'course_id' => 1,
                'first_name' => 'Dr. Nur-E-Jannatul',
                'last_name' => 'Ferdous',
                'dob' => '1975-05-04',
                'gender' => 'female',
                'phone' => '01715561365',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Nazirpur, Upozila+PO: Bagmara
Country : Bangladesh
State : Rajshahi
City : Rajshahi
Zip code',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:10:12',
                'updated_at' => '2019-09-14 12:10:12',
                'deleted_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'user_id' => 327,
                'department_id' => 10,
                'designation_id' => 8,
                'course_id' => 1,
                'first_name' => 'Dr. Shariful',
                'last_name' => 'Islam',
                'dob' => '1989-08-12',
                'gender' => 'male',
                'phone' => '01705566464',
                'share_phone' => 1,
                'email' => 'sislam89@yahoo.com',
                'share_email' => 1,
                'address' => 'Vill: Ganpur, PO: Chandridor, PS: Kosba
Country : Bangladesh
State : Chittagong
City : Brahmanbaria
Zip code',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:13:28',
                'updated_at' => '2019-09-14 12:13:28',
                'deleted_at' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'user_id' => 328,
                'department_id' => 10,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Dil Shakira',
                'last_name' => 'Rahman',
                'dob' => '1990-12-23',
                'gender' => 'female',
                'phone' => '01746254565',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Khodeja Villa, Bazrapur Road, PO+ PS: Jamalpur
Country : Bangladesh
State : Mymensingh
City : Jamalpur
Zip code',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:16:17',
                'updated_at' => '2019-09-14 12:16:17',
                'deleted_at' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'user_id' => 329,
                'department_id' => 10,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Rahima',
                'last_name' => 'Begum',
                'dob' => '1986-07-13',
                'gender' => 'female',
                'phone' => '01725959472',
                'share_phone' => 1,
                'email' => 'fayzulislam303@gmail.com',
                'share_email' => 1,
                'address' => 'Vill: Fulbari, PO: Fulbari PS: Golapganj
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:19:41',
                'updated_at' => '2019-09-14 12:19:41',
                'deleted_at' => NULL,
            ),
            58 => 
            array (
                'id' => 59,
                'user_id' => 330,
                'department_id' => 10,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Muhsena',
                'last_name' => 'Tahura',
                'dob' => '1989-06-15',
                'gender' => 'female',
                'phone' => '01753422325',
                'share_phone' => 1,
                'email' => 'nowrimuhsena@gmail.com',
                'share_email' => 1,
                'address' => 'Uttaran- 69, Baruthkhana
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:22:05',
                'updated_at' => '2019-09-14 12:22:05',
                'deleted_at' => NULL,
            ),
            59 => 
            array (
                'id' => 60,
                'user_id' => 331,
                'department_id' => 11,
                'designation_id' => 5,
                'course_id' => 1,
                'first_name' => 'Dr. Avijit',
                'last_name' => 'Das',
                'dob' => '1973-12-25',
                'gender' => 'male',
                'phone' => '01715417947',
                'share_phone' => 1,
                'email' => 'avijit.nemc@yahoo.com',
                'share_email' => 1,
            'address' => 'Rabindra Niketan, Fenchuganj Bazar (East)
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3116',
                'photo' => 'nemc_files/teachers/1568442549_Dr. Avijit Das-10000512.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:29:56',
                'updated_at' => '2019-09-14 12:29:56',
                'deleted_at' => NULL,
            ),
            60 => 
            array (
                'id' => 61,
                'user_id' => 332,
                'department_id' => 11,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Mithun Kanti',
                'last_name' => 'Das',
                'dob' => '1993-06-02',
                'gender' => 'male',
                'phone' => '01710889617',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => 'Meghna C- 5/2, Dariapara
Country : Bangladesh
State : Sylhet
City : Sylhet
Zip code : 3100',
                'photo' => 'nemc_files/teachers/1568442719_Photo.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:32:03',
                'updated_at' => '2019-09-14 12:32:03',
                'deleted_at' => NULL,
            ),
            61 => 
            array (
                'id' => 62,
                'user_id' => 333,
                'department_id' => 11,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Sanjida',
                'last_name' => 'Khan',
                'dob' => '1992-11-02',
                'gender' => 'female',
                'phone' => '01732232988',
                'share_phone' => 1,
                'email' => 'sanjidajesy@gmail.com',
                'share_email' => 1,
                'address' => 'Vill: Parshipara, PO: Rajnagar
Country : Bangladesh
State : Sylhet
City : Moulvibazar
Zip code',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:33:59',
                'updated_at' => '2019-09-14 12:33:59',
                'deleted_at' => NULL,
            ),
            62 => 
            array (
                'id' => 63,
                'user_id' => 334,
                'department_id' => 11,
                'designation_id' => 6,
                'course_id' => 1,
                'first_name' => 'Dr. Yeasmin',
                'last_name' => 'Nahar',
                'dob' => '1980-01-01',
                'gender' => 'female',
                'phone' => '01611743462',
                'share_phone' => 1,
                'email' => 'yeasmin43215@yahoo.com',
                'share_email' => 1,
                'address' => 'Baitul Haque, 2 Dasani
Country : Bangladesh
State : Khulna
City : Bagerhat
Zip code : 9300',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:35:44',
                'updated_at' => '2019-09-14 12:35:44',
                'deleted_at' => NULL,
            ),
            63 => 
            array (
                'id' => 64,
                'user_id' => 335,
                'department_id' => 11,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Mohammod Kamrul',
                'last_name' => 'Islam',
                'dob' => '1992-01-01',
                'gender' => 'male',
                'phone' => '01741142229',
                'share_phone' => 1,
                'email' => 'kamrulislamshipo@gmail.com',
                'share_email' => 1,
                'address' => 'Vill: Gopinagar, PO: Brindabanpur, PS: Kamalgonj,
Country : Bangladesh
State : Sylhet
City : Moulvibazar
Zip code',
                'photo' => NULL,
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-09-14 12:37:14',
                'updated_at' => '2019-09-14 12:37:14',
                'deleted_at' => NULL,
            ),
            64 => 
            array (
                'id' => 65,
                'user_id' => 349,
                'department_id' => 10,
                'designation_id' => 11,
                'course_id' => 1,
                'first_name' => 'Dr. Afiatun',
                'last_name' => 'Zannat',
                'dob' => '1989-08-17',
                'gender' => 'female',
                'phone' => '01726325525',
                'share_phone' => 1,
                'email' => NULL,
                'share_email' => 1,
                'address' => NULL,
                'photo' => 'nemc_files/teachers/1572147590_Afiatun Zannat.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-27 09:39:54',
                'updated_at' => '2019-10-27 09:39:54',
                'deleted_at' => NULL,
            ),
            65 => 
            array (
                'id' => 66,
                'user_id' => 350,
                'department_id' => 9,
                'designation_id' => 7,
                'course_id' => 1,
                'first_name' => 'Dr. Md. Mahmudul',
                'last_name' => 'Amin',
                'dob' => '1992-02-01',
                'gender' => 'male',
                'phone' => '01715299706',
                'share_phone' => 1,
                'email' => 'mahmudul.amin.nemc@gamil.com',
                'share_email' => 1,
                'address' => NULL,
                'photo' => 'nemc_files/teachers/1572147831_Mahmudul Amin.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-27 09:44:01',
                'updated_at' => '2019-10-27 09:44:01',
                'deleted_at' => NULL,
            ),
            66 => 
            array (
                'id' => 67,
                'user_id' => 351,
                'department_id' => 30,
                'designation_id' => 10,
                'course_id' => 1,
                'first_name' => 'Dr. Md',
                'last_name' => 'Mahin',
                'dob' => '1987-07-23',
                'gender' => 'male',
                'phone' => '01717458355',
                'share_phone' => 1,
                'email' => 'md.mahin03@yahoo.com',
                'share_email' => 1,
                'address' => NULL,
                'photo' => 'nemc_files/teachers/1572148167_Md. Mahin.jpg',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-10-27 09:49:32',
                'updated_at' => '2019-10-27 09:49:32',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}