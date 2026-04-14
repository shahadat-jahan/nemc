<?php

use Illuminate\Database\Seeder;

class UserGroupPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('user_group_permissions')->delete();

        \DB::table('user_group_permissions')->insert(array (
            0 =>
            array (
                'id' => 754,
                'user_group_id' => 7,
                'action' => 'dashboard',
                'has_permission' => 1,
            ),
            1 =>
            array (
                'id' => 755,
                'user_group_id' => 7,
                'action' => 'dashboard/index',
                'has_permission' => 1,
            ),
            2 =>
            array (
                'id' => 756,
                'user_group_id' => 7,
                'action' => 'students',
                'has_permission' => 1,
            ),
            3 =>
            array (
                'id' => 757,
                'user_group_id' => 7,
                'action' => 'students/index',
                'has_permission' => 1,
            ),
            4 =>
            array (
                'id' => 758,
                'user_group_id' => 7,
                'action' => 'students/edit',
                'has_permission' => 1,
            ),
            5 =>
            array (
                'id' => 759,
                'user_group_id' => 7,
                'action' => 'students/view',
                'has_permission' => 1,
            ),
            6 =>
            array (
                'id' => 760,
                'user_group_id' => 7,
                'action' => 'students/installment',
                'has_permission' => 1,
            ),
            7 =>
            array (
                'id' => 761,
                'user_group_id' => 7,
                'action' => 'payment',
                'has_permission' => 1,
            ),
            8 =>
            array (
                'id' => 762,
                'user_group_id' => 7,
                'action' => 'generate_fee',
                'has_permission' => 1,
            ),
            9 =>
            array (
                'id' => 763,
                'user_group_id' => 7,
                'action' => 'generate_fee/index',
                'has_permission' => 1,
            ),
            10 =>
            array (
                'id' => 764,
                'user_group_id' => 7,
                'action' => 'generate_fee/create',
                'has_permission' => 1,
            ),
            11 =>
            array (
                'id' => 765,
                'user_group_id' => 7,
                'action' => 'generate_fee/edit',
                'has_permission' => 1,
            ),
            12 =>
            array (
                'id' => 766,
                'user_group_id' => 7,
                'action' => 'generate_fee/view',
                'has_permission' => 1,
            ),
            13 =>
            array (
                'id' => 767,
                'user_group_id' => 7,
                'action' => 'collect_fee',
                'has_permission' => 1,
            ),
            14 =>
            array (
                'id' => 768,
                'user_group_id' => 7,
                'action' => 'collect_fee/index',
                'has_permission' => 1,
            ),
            15 =>
            array (
                'id' => 769,
                'user_group_id' => 7,
                'action' => 'collect_fee/create',
                'has_permission' => 1,
            ),
            16 =>
            array (
                'id' => 770,
                'user_group_id' => 7,
                'action' => 'collect_fee/edit',
                'has_permission' => 1,
            ),
            17 =>
            array (
                'id' => 771,
                'user_group_id' => 7,
                'action' => 'collect_fee/view',
                'has_permission' => 1,
            ),
            18 =>
            array (
                'id' => 772,
                'user_group_id' => 7,
                'action' => 'student_payment',
                'has_permission' => 1,
            ),
            19 =>
            array (
                'id' => 773,
                'user_group_id' => 7,
                'action' => 'student_payment/index',
                'has_permission' => 1,
            ),
            20 =>
            array (
                'id' => 774,
                'user_group_id' => 7,
                'action' => 'student_payment/create',
                'has_permission' => 1,
            ),
            21 =>
            array (
                'id' => 775,
                'user_group_id' => 7,
                'action' => 'student_payment/edit',
                'has_permission' => 1,
            ),
            22 =>
            array (
                'id' => 776,
                'user_group_id' => 7,
                'action' => 'student_payment/view',
                'has_permission' => 1,
            ),
            23 =>
            array (
                'id' => 777,
                'user_group_id' => 7,
                'action' => 'guardians',
                'has_permission' => 1,
            ),
            24 =>
            array (
                'id' => 778,
                'user_group_id' => 7,
                'action' => 'guardians/index',
                'has_permission' => 1,
            ),
            25 =>
            array (
                'id' => 779,
                'user_group_id' => 7,
                'action' => 'guardians/view',
                'has_permission' => 1,
            ),
            26 =>
            array (
                'id' => 780,
                'user_group_id' => 7,
                'action' => 'sessions',
                'has_permission' => 1,
            ),
            27 =>
            array (
                'id' => 781,
                'user_group_id' => 7,
                'action' => 'sessions/index',
                'has_permission' => 1,
            ),
            28 =>
            array (
                'id' => 782,
                'user_group_id' => 7,
                'action' => 'sessions/view',
                'has_permission' => 1,
            ),
            29 =>
            array (
                'id' => 783,
                'user_group_id' => 7,
                'action' => 'user_management',
                'has_permission' => 1,
            ),
            30 =>
            array (
                'id' => 784,
                'user_group_id' => 7,
                'action' => 'users/index',
                'has_permission' => 1,
            ),
            31 =>
            array (
                'id' => 785,
                'user_group_id' => 7,
                'action' => 'users/edit',
                'has_permission' => 1,
            ),
            32 =>
            array (
                'id' => 786,
                'user_group_id' => 7,
                'action' => 'users/view',
                'has_permission' => 1,
            ),
            33 =>
            array (
                'id' => 787,
                'user_group_id' => 7,
                'action' => 'notice_board',
                'has_permission' => 1,
            ),
            34 =>
            array (
                'id' => 788,
                'user_group_id' => 7,
                'action' => 'notice_board/index',
                'has_permission' => 1,
            ),
            35 =>
            array (
                'id' => 789,
                'user_group_id' => 7,
                'action' => 'notice_board/view',
                'has_permission' => 1,
            ),
            36 =>
            array (
                'id' => 790,
                'user_group_id' => 7,
                'action' => 'payment_detail',
                'has_permission' => 1,
            ),
            37 =>
            array (
                'id' => 791,
                'user_group_id' => 7,
                'action' => 'payment_detail/index',
                'has_permission' => 1,
            ),
            38 =>
            array (
                'id' => 792,
                'user_group_id' => 7,
                'action' => 'payment_detail/create',
                'has_permission' => 1,
            ),
            39 =>
            array (
                'id' => 793,
                'user_group_id' => 7,
                'action' => 'payment_detail/edit',
                'has_permission' => 1,
            ),
            40 =>
            array (
                'id' => 794,
                'user_group_id' => 7,
                'action' => 'payment_detail/view',
                'has_permission' => 1,
            ),
            41 =>
            array (
                'id' => 795,
                'user_group_id' => 7,
                'action' => 'payment_method',
                'has_permission' => 1,
            ),
            42 =>
            array (
                'id' => 796,
                'user_group_id' => 7,
                'action' => 'payment_method/index',
                'has_permission' => 1,
            ),
            43 =>
            array (
                'id' => 797,
                'user_group_id' => 7,
                'action' => 'payment_method/create',
                'has_permission' => 1,
            ),
            44 =>
            array (
                'id' => 798,
                'user_group_id' => 7,
                'action' => 'payment_method/edit',
                'has_permission' => 1,
            ),
            45 =>
            array (
                'id' => 799,
                'user_group_id' => 7,
                'action' => 'bank',
                'has_permission' => 1,
            ),
            46 =>
            array (
                'id' => 800,
                'user_group_id' => 7,
                'action' => 'bank/index',
                'has_permission' => 1,
            ),
            47 =>
            array (
                'id' => 801,
                'user_group_id' => 7,
                'action' => 'bank/create',
                'has_permission' => 1,
            ),
            48 =>
            array (
                'id' => 802,
                'user_group_id' => 7,
                'action' => 'bank/edit',
                'has_permission' => 1,
            ),
            49 =>
            array (
                'id' => 803,
                'user_group_id' => 7,
                'action' => 'logout',
                'has_permission' => 1,
            ),
            50 =>
            array (
                'id' => 804,
                'user_group_id' => 7,
                'action' => 'logout/index',
                'has_permission' => 1,
            ),
            51 =>
            array (
                'id' => 1006,
                'user_group_id' => 6,
                'action' => 'dashboard',
                'has_permission' => 1,
            ),
            52 =>
            array (
                'id' => 1007,
                'user_group_id' => 6,
                'action' => 'dashboard/index',
                'has_permission' => 1,
            ),
            53 =>
            array (
                'id' => 1008,
                'user_group_id' => 6,
                'action' => 'students',
                'has_permission' => 1,
            ),
            54 =>
            array (
                'id' => 1009,
                'user_group_id' => 6,
                'action' => 'students/index',
                'has_permission' => 1,
            ),
            55 =>
            array (
                'id' => 1010,
                'user_group_id' => 6,
                'action' => 'students/view',
                'has_permission' => 1,
            ),
            56 =>
            array (
                'id' => 1011,
                'user_group_id' => 6,
                'action' => 'payment',
                'has_permission' => 1,
            ),
            57 =>
            array (
                'id' => 1012,
                'user_group_id' => 6,
                'action' => 'generate_fee',
                'has_permission' => 1,
            ),
            58 =>
            array (
                'id' => 1013,
                'user_group_id' => 6,
                'action' => 'generate_fee/index',
                'has_permission' => 1,
            ),
            59 =>
            array (
                'id' => 1014,
                'user_group_id' => 6,
                'action' => 'generate_fee/view',
                'has_permission' => 1,
            ),
            60 =>
            array (
                'id' => 1015,
                'user_group_id' => 6,
                'action' => 'collect_fee',
                'has_permission' => 1,
            ),
            61 =>
            array (
                'id' => 1016,
                'user_group_id' => 6,
                'action' => 'collect_fee/index',
                'has_permission' => 1,
            ),
            62 =>
            array (
                'id' => 1017,
                'user_group_id' => 6,
                'action' => 'collect_fee/view',
                'has_permission' => 1,
            ),
            63 =>
            array (
                'id' => 1018,
                'user_group_id' => 6,
                'action' => 'student_payment',
                'has_permission' => 1,
            ),
            64 =>
            array (
                'id' => 1019,
                'user_group_id' => 6,
                'action' => 'student_payment/index',
                'has_permission' => 1,
            ),
            65 =>
            array (
                'id' => 1020,
                'user_group_id' => 6,
                'action' => 'student_payment/view',
                'has_permission' => 1,
            ),
            66 =>
            array (
                'id' => 1021,
                'user_group_id' => 6,
                'action' => 'attendance',
                'has_permission' => 1,
            ),
            67 =>
            array (
                'id' => 1022,
                'user_group_id' => 6,
                'action' => 'attendance/index',
                'has_permission' => 1,
            ),
            68 =>
            array (
                'id' => 1023,
                'user_group_id' => 6,
                'action' => 'attendance/view',
                'has_permission' => 1,
            ),
            69 =>
            array (
                'id' => 1024,
                'user_group_id' => 6,
                'action' => 'guardians',
                'has_permission' => 1,
            ),
            70 =>
            array (
                'id' => 1025,
                'user_group_id' => 6,
                'action' => 'guardians/index',
                'has_permission' => 1,
            ),
            71 =>
            array (
                'id' => 1026,
                'user_group_id' => 6,
                'action' => 'guardians/edit',
                'has_permission' => 1,
            ),
            72 =>
            array (
                'id' => 1027,
                'user_group_id' => 6,
                'action' => 'guardians/view',
                'has_permission' => 1,
            ),
            73 =>
            array (
                'id' => 1028,
                'user_group_id' => 6,
                'action' => 'guardians/password',
                'has_permission' => 1,
            ),
            74 =>
            array (
                'id' => 1029,
                'user_group_id' => 6,
                'action' => 'teacher',
                'has_permission' => 1,
            ),
            75 =>
            array (
                'id' => 1030,
                'user_group_id' => 6,
                'action' => 'teacher/index',
                'has_permission' => 1,
            ),
            76 =>
            array (
                'id' => 1031,
                'user_group_id' => 6,
                'action' => 'teacher/view',
                'has_permission' => 1,
            ),
            77 =>
            array (
                'id' => 1032,
                'user_group_id' => 6,
                'action' => 'lecture_material',
                'has_permission' => 1,
            ),
            78 =>
            array (
                'id' => 1033,
                'user_group_id' => 6,
                'action' => 'lecture_material/index',
                'has_permission' => 1,
            ),
            79 =>
            array (
                'id' => 1034,
                'user_group_id' => 6,
                'action' => 'lecture_material/view',
                'has_permission' => 1,
            ),
            80 =>
            array (
                'id' => 1035,
                'user_group_id' => 6,
                'action' => 'academic_calendar',
                'has_permission' => 1,
            ),
            81 =>
            array (
                'id' => 1036,
                'user_group_id' => 6,
                'action' => 'academic_calendar/index',
                'has_permission' => 1,
            ),
            82 =>
            array (
                'id' => 1037,
                'user_group_id' => 6,
                'action' => 'class_routine',
                'has_permission' => 1,
            ),
            83 =>
            array (
                'id' => 1038,
                'user_group_id' => 6,
                'action' => 'class_routine/index',
                'has_permission' => 1,
            ),
            84 =>
            array (
                'id' => 1039,
                'user_group_id' => 6,
                'action' => 'class_routine/view',
                'has_permission' => 1,
            ),
            85 =>
            array (
                'id' => 1040,
                'user_group_id' => 6,
                'action' => 'exam',
                'has_permission' => 1,
            ),
            86 =>
            array (
                'id' => 1041,
                'user_group_id' => 6,
                'action' => 'exams',
                'has_permission' => 1,
            ),
            87 =>
            array (
                'id' => 1042,
                'user_group_id' => 6,
                'action' => 'exams/index',
                'has_permission' => 1,
            ),
            88 =>
            array (
                'id' => 1043,
                'user_group_id' => 6,
                'action' => 'exams/view',
                'has_permission' => 1,
            ),
            89 =>
            array (
                'id' => 1044,
                'user_group_id' => 6,
                'action' => 'exam_type',
                'has_permission' => 1,
            ),
            90 =>
            array (
                'id' => 1045,
                'user_group_id' => 6,
                'action' => 'exam_type/index',
                'has_permission' => 1,
            ),
            91 =>
            array (
                'id' => 1046,
                'user_group_id' => 6,
                'action' => 'exam_type/view',
                'has_permission' => 1,
            ),
            92 =>
            array (
                'id' => 1047,
                'user_group_id' => 6,
                'action' => 'result',
                'has_permission' => 1,
            ),
            93 =>
            array (
                'id' => 1048,
                'user_group_id' => 6,
                'action' => 'result/index',
                'has_permission' => 1,
            ),
            94 =>
            array (
                'id' => 1049,
                'user_group_id' => 6,
                'action' => 'result/view',
                'has_permission' => 1,
            ),
            95 =>
            array (
                'id' => 1050,
                'user_group_id' => 6,
                'action' => 'student_progress',
                'has_permission' => 1,
            ),
            96 =>
            array (
                'id' => 1051,
                'user_group_id' => 6,
                'action' => 'student_progress_result',
                'has_permission' => 1,
            ),
            97 =>
            array (
                'id' => 1052,
                'user_group_id' => 6,
                'action' => 'student_progress_result/index',
                'has_permission' => 1,
            ),
            98 =>
            array (
                'id' => 1053,
                'user_group_id' => 6,
                'action' => 'notice_board',
                'has_permission' => 1,
            ),
            99 =>
            array (
                'id' => 1054,
                'user_group_id' => 6,
                'action' => 'notice_board/index',
                'has_permission' => 1,
            ),
            100 =>
            array (
                'id' => 1055,
                'user_group_id' => 6,
                'action' => 'notice_board/view',
                'has_permission' => 1,
            ),
            101 =>
            array (
                'id' => 1056,
                'user_group_id' => 6,
                'action' => 'holiday',
                'has_permission' => 1,
            ),
            102 =>
            array (
                'id' => 1057,
                'user_group_id' => 6,
                'action' => 'holiday/index',
                'has_permission' => 1,
            ),
            103 =>
            array (
                'id' => 1058,
                'user_group_id' => 6,
                'action' => 'holiday/view',
                'has_permission' => 1,
            ),
            104 =>
            array (
                'id' => 1059,
                'user_group_id' => 6,
                'action' => 'message',
                'has_permission' => 1,
            ),
            105 =>
            array (
                'id' => 1060,
                'user_group_id' => 6,
                'action' => 'message/index',
                'has_permission' => 1,
            ),
            106 =>
            array (
                'id' => 1061,
                'user_group_id' => 6,
                'action' => 'message/create',
                'has_permission' => 1,
            ),
            107 =>
            array (
                'id' => 1062,
                'user_group_id' => 6,
                'action' => 'message/edit',
                'has_permission' => 1,
            ),
            108 =>
            array (
                'id' => 1063,
                'user_group_id' => 6,
                'action' => 'message/view',
                'has_permission' => 1,
            ),
            109 =>
            array (
                'id' => 1064,
                'user_group_id' => 6,
                'action' => 'logout',
                'has_permission' => 1,
            ),
            110 =>
            array (
                'id' => 1065,
                'user_group_id' => 6,
                'action' => 'logout/index',
                'has_permission' => 1,
            ),
            111 =>
            array (
                'id' => 2092,
                'user_group_id' => 2,
                'action' => 'dashboard',
                'has_permission' => 1,
            ),
            112 =>
            array (
                'id' => 2093,
                'user_group_id' => 2,
                'action' => 'dashboard/index',
                'has_permission' => 1,
            ),
            113 =>
            array (
                'id' => 2094,
                'user_group_id' => 2,
                'action' => 'admission_management',
                'has_permission' => 1,
            ),
            114 =>
            array (
                'id' => 2095,
                'user_group_id' => 2,
                'action' => 'admission',
                'has_permission' => 1,
            ),
            115 =>
            array (
                'id' => 2096,
                'user_group_id' => 2,
                'action' => 'admission/index',
                'has_permission' => 1,
            ),
            116 =>
            array (
                'id' => 2097,
                'user_group_id' => 2,
                'action' => 'admission/create',
                'has_permission' => 1,
            ),
            117 =>
            array (
                'id' => 2098,
                'user_group_id' => 2,
                'action' => 'admission/edit',
                'has_permission' => 1,
            ),
            118 =>
            array (
                'id' => 2099,
                'user_group_id' => 2,
                'action' => 'admission/view',
                'has_permission' => 1,
            ),
            119 =>
            array (
                'id' => 2100,
                'user_group_id' => 2,
                'action' => 'students',
                'has_permission' => 1,
            ),
            120 =>
            array (
                'id' => 2101,
                'user_group_id' => 2,
                'action' => 'students/index',
                'has_permission' => 1,
            ),
            121 =>
            array (
                'id' => 2102,
                'user_group_id' => 2,
                'action' => 'students/create',
                'has_permission' => 1,
            ),
            122 =>
            array (
                'id' => 2103,
                'user_group_id' => 2,
                'action' => 'students/edit',
                'has_permission' => 1,
            ),
            123 =>
            array (
                'id' => 2104,
                'user_group_id' => 2,
                'action' => 'students/view',
                'has_permission' => 1,
            ),
            124 =>
            array (
                'id' => 2105,
                'user_group_id' => 2,
                'action' => 'students/installment',
                'has_permission' => 1,
            ),
            125 =>
            array (
                'id' => 2106,
                'user_group_id' => 2,
                'action' => 'guardians',
                'has_permission' => 1,
            ),
            126 =>
            array (
                'id' => 2107,
                'user_group_id' => 2,
                'action' => 'guardians/index',
                'has_permission' => 1,
            ),
            127 =>
            array (
                'id' => 2108,
                'user_group_id' => 2,
                'action' => 'guardians/edit',
                'has_permission' => 1,
            ),
            128 =>
            array (
                'id' => 2109,
                'user_group_id' => 2,
                'action' => 'guardians/password',
                'has_permission' => 1,
            ),
            129 =>
            array (
                'id' => 2110,
                'user_group_id' => 2,
                'action' => 'guardians/view',
                'has_permission' => 1,
            ),
            130 =>
            array (
                'id' => 2111,
                'user_group_id' => 2,
                'action' => 'sessions',
                'has_permission' => 1,
            ),
            131 =>
            array (
                'id' => 2112,
                'user_group_id' => 2,
                'action' => 'sessions/index',
                'has_permission' => 1,
            ),
            132 =>
            array (
                'id' => 2113,
                'user_group_id' => 2,
                'action' => 'sessions/create',
                'has_permission' => 1,
            ),
            133 =>
            array (
                'id' => 2114,
                'user_group_id' => 2,
                'action' => 'sessions/edit',
                'has_permission' => 1,
            ),
            134 =>
            array (
                'id' => 2115,
                'user_group_id' => 2,
                'action' => 'sessions/view',
                'has_permission' => 1,
            ),
            135 =>
            array (
                'id' => 2116,
                'user_group_id' => 2,
                'action' => 'user_management',
                'has_permission' => 1,
            ),
            136 =>
            array (
                'id' => 2117,
                'user_group_id' => 2,
                'action' => 'users',
                'has_permission' => 1,
            ),
            137 =>
            array (
                'id' => 2118,
                'user_group_id' => 2,
                'action' => 'users/index',
                'has_permission' => 1,
            ),
            138 =>
            array (
                'id' => 2119,
                'user_group_id' => 2,
                'action' => 'users/create',
                'has_permission' => 1,
            ),
            139 =>
            array (
                'id' => 2120,
                'user_group_id' => 2,
                'action' => 'users/edit',
                'has_permission' => 1,
            ),
            140 =>
            array (
                'id' => 2121,
                'user_group_id' => 2,
                'action' => 'users/view',
                'has_permission' => 1,
            ),
            141 =>
            array (
                'id' => 2122,
                'user_group_id' => 2,
                'action' => 'user_groups',
                'has_permission' => 1,
            ),
            142 =>
            array (
                'id' => 2123,
                'user_group_id' => 2,
                'action' => 'user_groups/index',
                'has_permission' => 1,
            ),
            143 =>
            array (
                'id' => 2124,
                'user_group_id' => 2,
                'action' => 'user_groups/create',
                'has_permission' => 1,
            ),
            144 =>
            array (
                'id' => 2125,
                'user_group_id' => 2,
                'action' => 'user_groups/edit',
                'has_permission' => 1,
            ),
            145 =>
            array (
                'id' => 2126,
                'user_group_id' => 2,
                'action' => 'user_groups/permission',
                'has_permission' => 1,
            ),
            146 =>
            array (
                'id' => 2127,
                'user_group_id' => 2,
                'action' => 'lecture_material',
                'has_permission' => 1,
            ),
            147 =>
            array (
                'id' => 2128,
                'user_group_id' => 2,
                'action' => 'lecture_material/index',
                'has_permission' => 1,
            ),
            148 =>
            array (
                'id' => 2129,
                'user_group_id' => 2,
                'action' => 'lecture_material/create',
                'has_permission' => 1,
            ),
            149 =>
            array (
                'id' => 2130,
                'user_group_id' => 2,
                'action' => 'lecture_material/edit',
                'has_permission' => 1,
            ),
            150 =>
            array (
                'id' => 2131,
                'user_group_id' => 2,
                'action' => 'lecture_material/view',
                'has_permission' => 1,
            ),
            151 =>
            array (
                'id' => 2132,
                'user_group_id' => 2,
                'action' => 'academic_calendar',
                'has_permission' => 1,
            ),
            152 =>
            array (
                'id' => 2133,
                'user_group_id' => 2,
                'action' => 'academic_calendar/index',
                'has_permission' => 1,
            ),
            153 =>
            array (
                'id' => 2134,
                'user_group_id' => 2,
                'action' => 'exam',
                'has_permission' => 1,
            ),
            154 =>
            array (
                'id' => 2135,
                'user_group_id' => 2,
                'action' => 'exams',
                'has_permission' => 1,
            ),
            155 =>
            array (
                'id' => 2136,
                'user_group_id' => 2,
                'action' => 'exams/index',
                'has_permission' => 1,
            ),
            156 =>
            array (
                'id' => 2137,
                'user_group_id' => 2,
                'action' => 'exams/create',
                'has_permission' => 1,
            ),
            157 =>
            array (
                'id' => 2138,
                'user_group_id' => 2,
                'action' => 'exams/edit',
                'has_permission' => 1,
            ),
            158 =>
            array (
                'id' => 2139,
                'user_group_id' => 2,
                'action' => 'exams/view',
                'has_permission' => 1,
            ),
            159 =>
            array (
                'id' => 2140,
                'user_group_id' => 2,
                'action' => 'result',
                'has_permission' => 1,
            ),
            160 =>
            array (
                'id' => 2141,
                'user_group_id' => 2,
                'action' => 'result/index',
                'has_permission' => 1,
            ),
            161 =>
            array (
                'id' => 2142,
                'user_group_id' => 2,
                'action' => 'result/create',
                'has_permission' => 1,
            ),
            162 =>
            array (
                'id' => 2143,
                'user_group_id' => 2,
                'action' => 'result/edit',
                'has_permission' => 1,
            ),
            163 =>
            array (
                'id' => 2144,
                'user_group_id' => 2,
                'action' => 'result/view',
                'has_permission' => 1,
            ),
            164 =>
            array (
                'id' => 2145,
                'user_group_id' => 2,
                'action' => 'exam_category',
                'has_permission' => 1,
            ),
            165 =>
            array (
                'id' => 2146,
                'user_group_id' => 2,
                'action' => 'exam_category/index',
                'has_permission' => 1,
            ),
            166 =>
            array (
                'id' => 2147,
                'user_group_id' => 2,
                'action' => 'exam_category/create',
                'has_permission' => 1,
            ),
            167 =>
            array (
                'id' => 2148,
                'user_group_id' => 2,
                'action' => 'exam_category/edit',
                'has_permission' => 1,
            ),
            168 =>
            array (
                'id' => 2149,
                'user_group_id' => 2,
                'action' => 'exam_category/view',
                'has_permission' => 1,
            ),
            169 =>
            array (
                'id' => 2150,
                'user_group_id' => 2,
                'action' => 'exam_type',
                'has_permission' => 1,
            ),
            170 =>
            array (
                'id' => 2151,
                'user_group_id' => 2,
                'action' => 'exam_type/index',
                'has_permission' => 1,
            ),
            171 =>
            array (
                'id' => 2152,
                'user_group_id' => 2,
                'action' => 'exam_type/create',
                'has_permission' => 1,
            ),
            172 =>
            array (
                'id' => 2153,
                'user_group_id' => 2,
                'action' => 'exam_type/edit',
                'has_permission' => 1,
            ),
            173 =>
            array (
                'id' => 2154,
                'user_group_id' => 2,
                'action' => 'exam_type/view',
                'has_permission' => 1,
            ),
            174 =>
            array (
                'id' => 2155,
                'user_group_id' => 2,
                'action' => 'exam_sub_type',
                'has_permission' => 1,
            ),
            175 =>
            array (
                'id' => 2156,
                'user_group_id' => 2,
                'action' => 'exam_sub_type/index',
                'has_permission' => 1,
            ),
            176 =>
            array (
                'id' => 2157,
                'user_group_id' => 2,
                'action' => 'exam_sub_type/create',
                'has_permission' => 1,
            ),
            177 =>
            array (
                'id' => 2158,
                'user_group_id' => 2,
                'action' => 'exam_sub_type/edit',
                'has_permission' => 1,
            ),
            178 =>
            array (
                'id' => 2159,
                'user_group_id' => 2,
                'action' => 'exam_sub_type/view',
                'has_permission' => 1,
            ),
            179 =>
            array (
                'id' => 2160,
                'user_group_id' => 2,
                'action' => 'student_progress',
                'has_permission' => 1,
            ),
            180 =>
            array (
                'id' => 2161,
                'user_group_id' => 2,
                'action' => 'student_progress_result',
                'has_permission' => 1,
            ),
            181 =>
            array (
                'id' => 2162,
                'user_group_id' => 2,
                'action' => 'student_progress_result/index',
                'has_permission' => 1,
            ),
            182 =>
            array (
                'id' => 2163,
                'user_group_id' => 2,
                'action' => 'student_progress_result/create',
                'has_permission' => 1,
            ),
            183 =>
            array (
                'id' => 2164,
                'user_group_id' => 2,
                'action' => 'subject',
                'has_permission' => 1,
            ),
            184 =>
            array (
                'id' => 2165,
                'user_group_id' => 2,
                'action' => 'subject',
                'has_permission' => 1,
            ),
            185 =>
            array (
                'id' => 2166,
                'user_group_id' => 2,
                'action' => 'subject/index',
                'has_permission' => 1,
            ),
            186 =>
            array (
                'id' => 2167,
                'user_group_id' => 2,
                'action' => 'subject/create',
                'has_permission' => 1,
            ),
            187 =>
            array (
                'id' => 2168,
                'user_group_id' => 2,
                'action' => 'subject/edit',
                'has_permission' => 1,
            ),
            188 =>
            array (
                'id' => 2169,
                'user_group_id' => 2,
                'action' => 'subject/view',
                'has_permission' => 1,
            ),
            189 =>
            array (
                'id' => 2170,
                'user_group_id' => 2,
                'action' => 'subject_group',
                'has_permission' => 1,
            ),
            190 =>
            array (
                'id' => 2171,
                'user_group_id' => 2,
                'action' => 'subject_group/index',
                'has_permission' => 1,
            ),
            191 =>
            array (
                'id' => 2172,
                'user_group_id' => 2,
                'action' => 'subject_group/create',
                'has_permission' => 1,
            ),
            192 =>
            array (
                'id' => 2173,
                'user_group_id' => 2,
                'action' => 'subject_group/edit',
                'has_permission' => 1,
            ),
            193 =>
            array (
                'id' => 2174,
                'user_group_id' => 2,
                'action' => 'subject_group/view',
                'has_permission' => 1,
            ),
            194 =>
            array (
                'id' => 2175,
                'user_group_id' => 2,
                'action' => 'topic_head',
                'has_permission' => 1,
            ),
            195 =>
            array (
                'id' => 2176,
                'user_group_id' => 2,
                'action' => 'topic_head/index',
                'has_permission' => 1,
            ),
            196 =>
            array (
                'id' => 2177,
                'user_group_id' => 2,
                'action' => 'topic_head/create',
                'has_permission' => 1,
            ),
            197 =>
            array (
                'id' => 2178,
                'user_group_id' => 2,
                'action' => 'topic_head/edit',
                'has_permission' => 1,
            ),
            198 =>
            array (
                'id' => 2179,
                'user_group_id' => 2,
                'action' => 'topic_head/view',
                'has_permission' => 1,
            ),
            199 =>
            array (
                'id' => 2180,
                'user_group_id' => 2,
                'action' => 'topic',
                'has_permission' => 1,
            ),
            200 =>
            array (
                'id' => 2181,
                'user_group_id' => 2,
                'action' => 'topic/index',
                'has_permission' => 1,
            ),
            201 =>
            array (
                'id' => 2182,
                'user_group_id' => 2,
                'action' => 'topic/create',
                'has_permission' => 1,
            ),
            202 =>
            array (
                'id' => 2183,
                'user_group_id' => 2,
                'action' => 'topic/edit',
                'has_permission' => 1,
            ),
            203 =>
            array (
                'id' => 2184,
                'user_group_id' => 2,
                'action' => 'topic/view',
                'has_permission' => 1,
            ),
            204 =>
            array (
                'id' => 2185,
                'user_group_id' => 2,
                'action' => 'cards',
                'has_permission' => 1,
            ),
            205 =>
            array (
                'id' => 2186,
                'user_group_id' => 2,
                'action' => 'cards/index',
                'has_permission' => 1,
            ),
            206 =>
            array (
                'id' => 2187,
                'user_group_id' => 2,
                'action' => 'cards/create',
                'has_permission' => 1,
            ),
            207 =>
            array (
                'id' => 2188,
                'user_group_id' => 2,
                'action' => 'cards/edit',
                'has_permission' => 1,
            ),
            208 =>
            array (
                'id' => 2189,
                'user_group_id' => 2,
                'action' => 'cards/view',
                'has_permission' => 1,
            ),
            209 =>
            array (
                'id' => 2190,
                'user_group_id' => 2,
                'action' => 'card_items',
                'has_permission' => 1,
            ),
            210 =>
            array (
                'id' => 2191,
                'user_group_id' => 2,
                'action' => 'card_items/index',
                'has_permission' => 1,
            ),
            211 =>
            array (
                'id' => 2192,
                'user_group_id' => 2,
                'action' => 'card_items/create',
                'has_permission' => 1,
            ),
            212 =>
            array (
                'id' => 2193,
                'user_group_id' => 2,
                'action' => 'card_items/edit',
                'has_permission' => 1,
            ),
            213 =>
            array (
                'id' => 2194,
                'user_group_id' => 2,
                'action' => 'card_items/view',
                'has_permission' => 1,
            ),
            214 =>
            array (
                'id' => 2195,
                'user_group_id' => 2,
                'action' => 'book',
                'has_permission' => 1,
            ),
            215 =>
            array (
                'id' => 2196,
                'user_group_id' => 2,
                'action' => 'book/index',
                'has_permission' => 1,
            ),
            216 =>
            array (
                'id' => 2197,
                'user_group_id' => 2,
                'action' => 'book/create',
                'has_permission' => 1,
            ),
            217 =>
            array (
                'id' => 2198,
                'user_group_id' => 2,
                'action' => 'book/edit',
                'has_permission' => 1,
            ),
            218 =>
            array (
                'id' => 2199,
                'user_group_id' => 2,
                'action' => 'book/view',
                'has_permission' => 1,
            ),
            219 =>
            array (
                'id' => 2200,
                'user_group_id' => 2,
                'action' => 'teacher',
                'has_permission' => 1,
            ),
            220 =>
            array (
                'id' => 2201,
                'user_group_id' => 2,
                'action' => 'teacher/index',
                'has_permission' => 1,
            ),
            221 =>
            array (
                'id' => 2202,
                'user_group_id' => 2,
                'action' => 'teacher/create',
                'has_permission' => 1,
            ),
            222 =>
            array (
                'id' => 2203,
                'user_group_id' => 2,
                'action' => 'teacher/edit',
                'has_permission' => 1,
            ),
            223 =>
            array (
                'id' => 2204,
                'user_group_id' => 2,
                'action' => 'teacher/view',
                'has_permission' => 1,
            ),
            224 =>
            array (
                'id' => 2205,
                'user_group_id' => 2,
                'action' => 'teacher/password',
                'has_permission' => 1,
            ),
            225 =>
            array (
                'id' => 2206,
                'user_group_id' => 2,
                'action' => 'class_routine',
                'has_permission' => 1,
            ),
            226 =>
            array (
                'id' => 2207,
                'user_group_id' => 2,
                'action' => 'class_routine/index',
                'has_permission' => 1,
            ),
            227 =>
            array (
                'id' => 2208,
                'user_group_id' => 2,
                'action' => 'class_routine/create',
                'has_permission' => 1,
            ),
            228 =>
            array (
                'id' => 2209,
                'user_group_id' => 2,
                'action' => 'class_routine/edit',
                'has_permission' => 1,
            ),
            229 =>
            array (
                'id' => 2210,
                'user_group_id' => 2,
                'action' => 'class_routine/view',
                'has_permission' => 1,
            ),
            230 =>
            array (
                'id' => 2211,
                'user_group_id' => 2,
                'action' => 'attendance',
                'has_permission' => 1,
            ),
            231 =>
            array (
                'id' => 2212,
                'user_group_id' => 2,
                'action' => 'attendance/index',
                'has_permission' => 1,
            ),
            232 =>
            array (
                'id' => 2213,
                'user_group_id' => 2,
                'action' => 'attendance/create',
                'has_permission' => 1,
            ),
            233 =>
            array (
                'id' => 2214,
                'user_group_id' => 2,
                'action' => 'attendance/edit',
                'has_permission' => 1,
            ),
            234 =>
            array (
                'id' => 2215,
                'user_group_id' => 2,
                'action' => 'attendance/view',
                'has_permission' => 1,
            ),
            235 =>
            array (
                'id' => 2216,
                'user_group_id' => 2,
                'action' => 'payment',
                'has_permission' => 1,
            ),
            236 =>
            array (
                'id' => 2217,
                'user_group_id' => 2,
                'action' => 'generate_fee',
                'has_permission' => 1,
            ),
            237 =>
            array (
                'id' => 2218,
                'user_group_id' => 2,
                'action' => 'generate_fee/index',
                'has_permission' => 1,
            ),
            238 =>
            array (
                'id' => 2219,
                'user_group_id' => 2,
                'action' => 'generate_fee/create',
                'has_permission' => 1,
            ),
            239 =>
            array (
                'id' => 2220,
                'user_group_id' => 2,
                'action' => 'generate_fee/edit',
                'has_permission' => 1,
            ),
            240 =>
            array (
                'id' => 2221,
                'user_group_id' => 2,
                'action' => 'generate_fee/view',
                'has_permission' => 1,
            ),
            241 =>
            array (
                'id' => 2222,
                'user_group_id' => 2,
                'action' => 'collect_fee',
                'has_permission' => 1,
            ),
            242 =>
            array (
                'id' => 2223,
                'user_group_id' => 2,
                'action' => 'collect_fee/index',
                'has_permission' => 1,
            ),
            243 =>
            array (
                'id' => 2224,
                'user_group_id' => 2,
                'action' => 'collect_fee/create',
                'has_permission' => 1,
            ),
            244 =>
            array (
                'id' => 2225,
                'user_group_id' => 2,
                'action' => 'collect_fee/edit',
                'has_permission' => 1,
            ),
            245 =>
            array (
                'id' => 2226,
                'user_group_id' => 2,
                'action' => 'collect_fee/view',
                'has_permission' => 1,
            ),
            246 =>
            array (
                'id' => 2227,
                'user_group_id' => 2,
                'action' => 'student_payment',
                'has_permission' => 1,
            ),
            247 =>
            array (
                'id' => 2228,
                'user_group_id' => 2,
                'action' => 'student_payment/index',
                'has_permission' => 1,
            ),
            248 =>
            array (
                'id' => 2229,
                'user_group_id' => 2,
                'action' => 'student_payment/edit',
                'has_permission' => 1,
            ),
            249 =>
            array (
                'id' => 2230,
                'user_group_id' => 2,
                'action' => 'student_payment/view',
                'has_permission' => 1,
            ),
            250 =>
            array (
                'id' => 2231,
                'user_group_id' => 2,
                'action' => 'reports',
                'has_permission' => 1,
            ),
            251 =>
            array (
                'id' => 2232,
                'user_group_id' => 2,
                'action' => 'report_admission',
                'has_permission' => 1,
            ),
            252 =>
            array (
                'id' => 2233,
                'user_group_id' => 2,
                'action' => 'report_admission/all',
                'has_permission' => 1,
            ),
            253 =>
            array (
                'id' => 2234,
                'user_group_id' => 2,
                'action' => 'report_attendance',
                'has_permission' => 0,
            ),
            254 =>
            array (
                'id' => 2235,
                'user_group_id' => 2,
                'action' => 'report_attendance/all',
                'has_permission' => 0,
            ),
            255 =>
            array (
                'id' => 2236,
                'user_group_id' => 2,
                'action' => 'report_attendance_by_term',
                'has_permission' => 1,
            ),
            256 =>
            array (
                'id' => 2237,
                'user_group_id' => 2,
                'action' => 'report_attendance_by_term/all',
                'has_permission' => 1,
            ),
            257 =>
            array (
                'id' => 2238,
                'user_group_id' => 2,
                'action' => 'report_attendance_by_phase',
                'has_permission' => 1,
            ),
            258 =>
            array (
                'id' => 2239,
                'user_group_id' => 2,
                'action' => 'report_attendance_by_phase/all',
                'has_permission' => 1,
            ),
            259 =>
            array (
                'id' => 2240,
                'user_group_id' => 2,
                'action' => 'report_attendance_by_student',
                'has_permission' => 1,
            ),
            260 =>
            array (
                'id' => 2241,
                'user_group_id' => 2,
                'action' => 'report_attendance_by_student/all',
                'has_permission' => 1,
            ),
            261 =>
            array (
                'id' => 2242,
                'user_group_id' => 2,
                'action' => 'report_exam_result',
                'has_permission' => 1,
            ),
            262 =>
            array (
                'id' => 2243,
                'user_group_id' => 2,
                'action' => 'report_exam_result/all',
                'has_permission' => 1,
            ),
            263 =>
            array (
                'id' => 2244,
                'user_group_id' => 2,
                'action' => 'report_exam_result_phase',
                'has_permission' => 1,
            ),
            264 =>
            array (
                'id' => 2245,
                'user_group_id' => 2,
                'action' => 'report_exam_result_phase/all',
                'has_permission' => 1,
            ),
            265 =>
            array (
                'id' => 2246,
                'user_group_id' => 2,
                'action' => 'report_exam_result_student',
                'has_permission' => 1,
            ),
            266 =>
            array (
                'id' => 2247,
                'user_group_id' => 2,
                'action' => 'report_exam_result_student/all',
                'has_permission' => 1,
            ),
            267 =>
            array (
                'id' => 2248,
                'user_group_id' => 2,
                'action' => 'report_student_payment',
                'has_permission' => 1,
            ),
            268 =>
            array (
                'id' => 2249,
                'user_group_id' => 2,
                'action' => 'report_student_payment/all',
                'has_permission' => 1,
            ),
            269 =>
            array (
                'id' => 2250,
                'user_group_id' => 2,
                'action' => 'report_student_list',
                'has_permission' => 0,
            ),
            270 =>
            array (
                'id' => 2251,
                'user_group_id' => 2,
                'action' => 'report_student_list/all',
                'has_permission' => 0,
            ),
            271 =>
            array (
                'id' => 2252,
                'user_group_id' => 2,
                'action' => 'report_teacher_list',
                'has_permission' => 0,
            ),
            272 =>
            array (
                'id' => 2253,
                'user_group_id' => 2,
                'action' => 'report_teacher_list/all',
                'has_permission' => 0,
            ),
            273 =>
            array (
                'id' => 2254,
                'user_group_id' => 2,
                'action' => 'notice_board',
                'has_permission' => 1,
            ),
            274 =>
            array (
                'id' => 2255,
                'user_group_id' => 2,
                'action' => 'notice_board/index',
                'has_permission' => 1,
            ),
            275 =>
            array (
                'id' => 2256,
                'user_group_id' => 2,
                'action' => 'notice_board/create',
                'has_permission' => 1,
            ),
            276 =>
            array (
                'id' => 2257,
                'user_group_id' => 2,
                'action' => 'notice_board/edit',
                'has_permission' => 1,
            ),
            277 =>
            array (
                'id' => 2258,
                'user_group_id' => 2,
                'action' => 'notice_board/view',
                'has_permission' => 1,
            ),
            278 =>
            array (
                'id' => 2259,
                'user_group_id' => 2,
                'action' => 'holiday',
                'has_permission' => 1,
            ),
            279 =>
            array (
                'id' => 2260,
                'user_group_id' => 2,
                'action' => 'holiday/index',
                'has_permission' => 1,
            ),
            280 =>
            array (
                'id' => 2261,
                'user_group_id' => 2,
                'action' => 'holiday/create',
                'has_permission' => 1,
            ),
            281 =>
            array (
                'id' => 2262,
                'user_group_id' => 2,
                'action' => 'holiday/edit',
                'has_permission' => 1,
            ),
            282 =>
            array (
                'id' => 2263,
                'user_group_id' => 2,
                'action' => 'holiday/view',
                'has_permission' => 1,
            ),
            283 =>
            array (
                'id' => 2264,
                'user_group_id' => 2,
                'action' => 'message',
                'has_permission' => 1,
            ),
            284 =>
            array (
                'id' => 2265,
                'user_group_id' => 2,
                'action' => 'message/index',
                'has_permission' => 1,
            ),
            285 =>
            array (
                'id' => 2266,
                'user_group_id' => 2,
                'action' => 'message/create',
                'has_permission' => 1,
            ),
            286 =>
            array (
                'id' => 2267,
                'user_group_id' => 2,
                'action' => 'message/edit',
                'has_permission' => 1,
            ),
            287 =>
            array (
                'id' => 2268,
                'user_group_id' => 2,
                'action' => 'message/view',
                'has_permission' => 1,
            ),
            288 =>
            array (
                'id' => 2269,
                'user_group_id' => 2,
                'action' => 'setting',
                'has_permission' => 1,
            ),
            289 =>
            array (
                'id' => 2270,
                'user_group_id' => 2,
                'action' => 'attachment_type',
                'has_permission' => 1,
            ),
            290 =>
            array (
                'id' => 2271,
                'user_group_id' => 2,
                'action' => 'attachment_type/index',
                'has_permission' => 1,
            ),
            291 =>
            array (
                'id' => 2272,
                'user_group_id' => 2,
                'action' => 'attachment_type/create',
                'has_permission' => 1,
            ),
            292 =>
            array (
                'id' => 2273,
                'user_group_id' => 2,
                'action' => 'attachment_type/edit',
                'has_permission' => 1,
            ),
            293 =>
            array (
                'id' => 2274,
                'user_group_id' => 2,
                'action' => 'attachment_type/view',
                'has_permission' => 1,
            ),
            294 =>
            array (
                'id' => 2275,
                'user_group_id' => 2,
                'action' => 'student_category',
                'has_permission' => 1,
            ),
            295 =>
            array (
                'id' => 2276,
                'user_group_id' => 2,
                'action' => 'student_category/index',
                'has_permission' => 1,
            ),
            296 =>
            array (
                'id' => 2277,
                'user_group_id' => 2,
                'action' => 'student_category/create',
                'has_permission' => 1,
            ),
            297 =>
            array (
                'id' => 2278,
                'user_group_id' => 2,
                'action' => 'student_category/edit',
                'has_permission' => 1,
            ),
            298 =>
            array (
                'id' => 2279,
                'user_group_id' => 2,
                'action' => 'student_category/view',
                'has_permission' => 1,
            ),
            299 =>
            array (
                'id' => 2280,
                'user_group_id' => 2,
                'action' => 'student_group',
                'has_permission' => 1,
            ),
            300 =>
            array (
                'id' => 2281,
                'user_group_id' => 2,
                'action' => 'student_group/index',
                'has_permission' => 1,
            ),
            301 =>
            array (
                'id' => 2282,
                'user_group_id' => 2,
                'action' => 'student_group/create',
                'has_permission' => 1,
            ),
            302 =>
            array (
                'id' => 2283,
                'user_group_id' => 2,
                'action' => 'student_group/edit',
                'has_permission' => 1,
            ),
            303 =>
            array (
                'id' => 2284,
                'user_group_id' => 2,
                'action' => 'student_group/view',
                'has_permission' => 1,
            ),
            304 =>
            array (
                'id' => 2285,
                'user_group_id' => 2,
                'action' => 'term',
                'has_permission' => 1,
            ),
            305 =>
            array (
                'id' => 2286,
                'user_group_id' => 2,
                'action' => 'term/index',
                'has_permission' => 1,
            ),
            306 =>
            array (
                'id' => 2287,
                'user_group_id' => 2,
                'action' => 'term/create',
                'has_permission' => 1,
            ),
            307 =>
            array (
                'id' => 2288,
                'user_group_id' => 2,
                'action' => 'term/edit',
                'has_permission' => 1,
            ),
            308 =>
            array (
                'id' => 2289,
                'user_group_id' => 2,
                'action' => 'term/view',
                'has_permission' => 1,
            ),
            309 =>
            array (
                'id' => 2290,
                'user_group_id' => 2,
                'action' => 'phase',
                'has_permission' => 1,
            ),
            310 =>
            array (
                'id' => 2291,
                'user_group_id' => 2,
                'action' => 'phase/index',
                'has_permission' => 1,
            ),
            311 =>
            array (
                'id' => 2292,
                'user_group_id' => 2,
                'action' => 'phase/create',
                'has_permission' => 1,
            ),
            312 =>
            array (
                'id' => 2293,
                'user_group_id' => 2,
                'action' => 'phase/edit',
                'has_permission' => 1,
            ),
            313 =>
            array (
                'id' => 2294,
                'user_group_id' => 2,
                'action' => 'phase/view',
                'has_permission' => 1,
            ),
            314 =>
            array (
                'id' => 2295,
                'user_group_id' => 2,
                'action' => 'designation',
                'has_permission' => 1,
            ),
            315 =>
            array (
                'id' => 2296,
                'user_group_id' => 2,
                'action' => 'designation/index',
                'has_permission' => 1,
            ),
            316 =>
            array (
                'id' => 2297,
                'user_group_id' => 2,
                'action' => 'designation/create',
                'has_permission' => 1,
            ),
            317 =>
            array (
                'id' => 2298,
                'user_group_id' => 2,
                'action' => 'designation/edit',
                'has_permission' => 1,
            ),
            318 =>
            array (
                'id' => 2299,
                'user_group_id' => 2,
                'action' => 'designation/view',
                'has_permission' => 1,
            ),
            319 =>
            array (
                'id' => 2300,
                'user_group_id' => 2,
                'action' => 'department',
                'has_permission' => 1,
            ),
            320 =>
            array (
                'id' => 2301,
                'user_group_id' => 2,
                'action' => 'department/index',
                'has_permission' => 1,
            ),
            321 =>
            array (
                'id' => 2302,
                'user_group_id' => 2,
                'action' => 'department/create',
                'has_permission' => 1,
            ),
            322 =>
            array (
                'id' => 2303,
                'user_group_id' => 2,
                'action' => 'department/edit',
                'has_permission' => 1,
            ),
            323 =>
            array (
                'id' => 2304,
                'user_group_id' => 2,
                'action' => 'department/view',
                'has_permission' => 1,
            ),
            324 =>
            array (
                'id' => 2305,
                'user_group_id' => 2,
                'action' => 'course',
                'has_permission' => 1,
            ),
            325 =>
            array (
                'id' => 2306,
                'user_group_id' => 2,
                'action' => 'course/index',
                'has_permission' => 1,
            ),
            326 =>
            array (
                'id' => 2307,
                'user_group_id' => 2,
                'action' => 'course/create',
                'has_permission' => 1,
            ),
            327 =>
            array (
                'id' => 2308,
                'user_group_id' => 2,
                'action' => 'course/edit',
                'has_permission' => 1,
            ),
            328 =>
            array (
                'id' => 2309,
                'user_group_id' => 2,
                'action' => 'course/view',
                'has_permission' => 1,
            ),
            329 =>
            array (
                'id' => 2310,
                'user_group_id' => 2,
                'action' => 'class_type',
                'has_permission' => 1,
            ),
            330 =>
            array (
                'id' => 2311,
                'user_group_id' => 2,
                'action' => 'class_type/index',
                'has_permission' => 1,
            ),
            331 =>
            array (
                'id' => 2312,
                'user_group_id' => 2,
                'action' => 'class_type/create',
                'has_permission' => 1,
            ),
            332 =>
            array (
                'id' => 2313,
                'user_group_id' => 2,
                'action' => 'class_type/edit',
                'has_permission' => 1,
            ),
            333 =>
            array (
                'id' => 2314,
                'user_group_id' => 2,
                'action' => 'class_type/view',
                'has_permission' => 1,
            ),
            334 =>
            array (
                'id' => 2315,
                'user_group_id' => 2,
                'action' => 'education_board',
                'has_permission' => 1,
            ),
            335 =>
            array (
                'id' => 2316,
                'user_group_id' => 2,
                'action' => 'education_board/index',
                'has_permission' => 1,
            ),
            336 =>
            array (
                'id' => 2317,
                'user_group_id' => 2,
                'action' => 'education_board/create',
                'has_permission' => 1,
            ),
            337 =>
            array (
                'id' => 2318,
                'user_group_id' => 2,
                'action' => 'education_board/edit',
                'has_permission' => 1,
            ),
            338 =>
            array (
                'id' => 2319,
                'user_group_id' => 2,
                'action' => 'education_board/view',
                'has_permission' => 1,
            ),
            339 =>
            array (
                'id' => 2320,
                'user_group_id' => 2,
                'action' => 'bank',
                'has_permission' => 1,
            ),
            340 =>
            array (
                'id' => 2321,
                'user_group_id' => 2,
                'action' => 'bank/index',
                'has_permission' => 1,
            ),
            341 =>
            array (
                'id' => 2322,
                'user_group_id' => 2,
                'action' => 'bank/create',
                'has_permission' => 1,
            ),
            342 =>
            array (
                'id' => 2323,
                'user_group_id' => 2,
                'action' => 'bank/edit',
                'has_permission' => 1,
            ),
            343 =>
            array (
                'id' => 2324,
                'user_group_id' => 2,
                'action' => 'payment_type',
                'has_permission' => 1,
            ),
            344 =>
            array (
                'id' => 2325,
                'user_group_id' => 2,
                'action' => 'payment_type/index',
                'has_permission' => 1,
            ),
            345 =>
            array (
                'id' => 2326,
                'user_group_id' => 2,
                'action' => 'payment_type/create',
                'has_permission' => 1,
            ),
            346 =>
            array (
                'id' => 2327,
                'user_group_id' => 2,
                'action' => 'payment_type/edit',
                'has_permission' => 1,
            ),
            347 =>
            array (
                'id' => 2328,
                'user_group_id' => 2,
                'action' => 'payment_type/view',
                'has_permission' => 1,
            ),
            348 =>
            array (
                'id' => 2329,
                'user_group_id' => 2,
                'action' => 'payment_method',
                'has_permission' => 1,
            ),
            349 =>
            array (
                'id' => 2330,
                'user_group_id' => 2,
                'action' => 'payment_method/index',
                'has_permission' => 1,
            ),
            350 =>
            array (
                'id' => 2331,
                'user_group_id' => 2,
                'action' => 'payment_method/create',
                'has_permission' => 1,
            ),
            351 =>
            array (
                'id' => 2332,
                'user_group_id' => 2,
                'action' => 'payment_method/edit',
                'has_permission' => 1,
            ),
            352 =>
            array (
                'id' => 2333,
                'user_group_id' => 2,
                'action' => 'payment_detail',
                'has_permission' => 1,
            ),
            353 =>
            array (
                'id' => 2334,
                'user_group_id' => 2,
                'action' => 'payment_detail/index',
                'has_permission' => 1,
            ),
            354 =>
            array (
                'id' => 2335,
                'user_group_id' => 2,
                'action' => 'payment_detail/create',
                'has_permission' => 1,
            ),
            355 =>
            array (
                'id' => 2336,
                'user_group_id' => 2,
                'action' => 'payment_detail/edit',
                'has_permission' => 1,
            ),
            356 =>
            array (
                'id' => 2337,
                'user_group_id' => 2,
                'action' => 'payment_detail/view',
                'has_permission' => 1,
            ),
            357 =>
            array (
                'id' => 2338,
                'user_group_id' => 2,
                'action' => 'hall',
                'has_permission' => 1,
            ),
            358 =>
            array (
                'id' => 2339,
                'user_group_id' => 2,
                'action' => 'hall/index',
                'has_permission' => 1,
            ),
            359 =>
            array (
                'id' => 2340,
                'user_group_id' => 2,
                'action' => 'hall/create',
                'has_permission' => 1,
            ),
            360 =>
            array (
                'id' => 2341,
                'user_group_id' => 2,
                'action' => 'hall/edit',
                'has_permission' => 1,
            ),
            361 =>
            array (
                'id' => 2342,
                'user_group_id' => 2,
                'action' => 'hall/view',
                'has_permission' => 1,
            ),
            362 =>
            array (
                'id' => 2343,
                'user_group_id' => 2,
                'action' => 'application_setting',
                'has_permission' => 1,
            ),
            363 =>
            array (
                'id' => 2344,
                'user_group_id' => 2,
                'action' => 'application_setting/index',
                'has_permission' => 1,
            ),
            364 =>
            array (
                'id' => 2345,
                'user_group_id' => 2,
                'action' => 'application_setting/create',
                'has_permission' => 1,
            ),
            365 =>
            array (
                'id' => 2346,
                'user_group_id' => 2,
                'action' => 'application_setting/edit',
                'has_permission' => 1,
            ),
            366 =>
            array (
                'id' => 2347,
                'user_group_id' => 2,
                'action' => 'application_setting/view',
                'has_permission' => 0,
            ),
            367 =>
            array (
                'id' => 2348,
                'user_group_id' => 2,
                'action' => 'logout',
                'has_permission' => 1,
            ),
            368 =>
            array (
                'id' => 2349,
                'user_group_id' => 2,
                'action' => 'logout/index',
                'has_permission' => 1,
            ),
            369 =>
            array (
                'id' => 2350,
                'user_group_id' => 3,
                'action' => 'dashboard',
                'has_permission' => 1,
            ),
            370 =>
            array (
                'id' => 2351,
                'user_group_id' => 3,
                'action' => 'dashboard/index',
                'has_permission' => 1,
            ),
            371 =>
            array (
                'id' => 2352,
                'user_group_id' => 3,
                'action' => 'admission_management',
                'has_permission' => 1,
            ),
            372 =>
            array (
                'id' => 2353,
                'user_group_id' => 3,
                'action' => 'admission',
                'has_permission' => 1,
            ),
            373 =>
            array (
                'id' => 2354,
                'user_group_id' => 3,
                'action' => 'admission/index',
                'has_permission' => 1,
            ),
            374 =>
            array (
                'id' => 2355,
                'user_group_id' => 3,
                'action' => 'admission/create',
                'has_permission' => 1,
            ),
            375 =>
            array (
                'id' => 2356,
                'user_group_id' => 3,
                'action' => 'admission/edit',
                'has_permission' => 1,
            ),
            376 =>
            array (
                'id' => 2357,
                'user_group_id' => 3,
                'action' => 'admission/view',
                'has_permission' => 1,
            ),
            377 =>
            array (
                'id' => 2358,
                'user_group_id' => 3,
                'action' => 'students',
                'has_permission' => 1,
            ),
            378 =>
            array (
                'id' => 2359,
                'user_group_id' => 3,
                'action' => 'students/index',
                'has_permission' => 1,
            ),
            379 =>
            array (
                'id' => 2360,
                'user_group_id' => 3,
                'action' => 'students/create',
                'has_permission' => 1,
            ),
            380 =>
            array (
                'id' => 2361,
                'user_group_id' => 3,
                'action' => 'students/edit',
                'has_permission' => 1,
            ),
            381 =>
            array (
                'id' => 2362,
                'user_group_id' => 3,
                'action' => 'students/view',
                'has_permission' => 1,
            ),
            382 =>
            array (
                'id' => 2363,
                'user_group_id' => 3,
                'action' => 'students/installment',
                'has_permission' => 0,
            ),
            383 =>
            array (
                'id' => 2364,
                'user_group_id' => 3,
                'action' => 'guardians',
                'has_permission' => 1,
            ),
            384 =>
            array (
                'id' => 2365,
                'user_group_id' => 3,
                'action' => 'guardians/index',
                'has_permission' => 1,
            ),
            385 =>
            array (
                'id' => 2366,
                'user_group_id' => 3,
                'action' => 'guardians/edit',
                'has_permission' => 1,
            ),
            386 =>
            array (
                'id' => 2367,
                'user_group_id' => 3,
                'action' => 'guardians/password',
                'has_permission' => 0,
            ),
            387 =>
            array (
                'id' => 2368,
                'user_group_id' => 3,
                'action' => 'guardians/view',
                'has_permission' => 1,
            ),
            388 =>
            array (
                'id' => 2369,
                'user_group_id' => 3,
                'action' => 'sessions',
                'has_permission' => 1,
            ),
            389 =>
            array (
                'id' => 2370,
                'user_group_id' => 3,
                'action' => 'sessions/index',
                'has_permission' => 1,
            ),
            390 =>
            array (
                'id' => 2371,
                'user_group_id' => 3,
                'action' => 'sessions/create',
                'has_permission' => 1,
            ),
            391 =>
            array (
                'id' => 2372,
                'user_group_id' => 3,
                'action' => 'sessions/edit',
                'has_permission' => 1,
            ),
            392 =>
            array (
                'id' => 2373,
                'user_group_id' => 3,
                'action' => 'sessions/view',
                'has_permission' => 1,
            ),
            393 =>
            array (
                'id' => 2374,
                'user_group_id' => 3,
                'action' => 'user_management',
                'has_permission' => 1,
            ),
            394 =>
            array (
                'id' => 2375,
                'user_group_id' => 3,
                'action' => 'users',
                'has_permission' => 0,
            ),
            395 =>
            array (
                'id' => 2376,
                'user_group_id' => 3,
                'action' => 'users/index',
                'has_permission' => 1,
            ),
            396 =>
            array (
                'id' => 2377,
                'user_group_id' => 3,
                'action' => 'users/create',
                'has_permission' => 0,
            ),
            397 =>
            array (
                'id' => 2378,
                'user_group_id' => 3,
                'action' => 'users/edit',
                'has_permission' => 1,
            ),
            398 =>
            array (
                'id' => 2379,
                'user_group_id' => 3,
                'action' => 'users/view',
                'has_permission' => 1,
            ),
            399 =>
            array (
                'id' => 2380,
                'user_group_id' => 3,
                'action' => 'user_groups',
                'has_permission' => 0,
            ),
            400 =>
            array (
                'id' => 2381,
                'user_group_id' => 3,
                'action' => 'user_groups/index',
                'has_permission' => 0,
            ),
            401 =>
            array (
                'id' => 2382,
                'user_group_id' => 3,
                'action' => 'user_groups/create',
                'has_permission' => 0,
            ),
            402 =>
            array (
                'id' => 2383,
                'user_group_id' => 3,
                'action' => 'user_groups/edit',
                'has_permission' => 0,
            ),
            403 =>
            array (
                'id' => 2384,
                'user_group_id' => 3,
                'action' => 'user_groups/permission',
                'has_permission' => 0,
            ),
            404 =>
            array (
                'id' => 2385,
                'user_group_id' => 3,
                'action' => 'lecture_material',
                'has_permission' => 1,
            ),
            405 =>
            array (
                'id' => 2386,
                'user_group_id' => 3,
                'action' => 'lecture_material/index',
                'has_permission' => 1,
            ),
            406 =>
            array (
                'id' => 2387,
                'user_group_id' => 3,
                'action' => 'lecture_material/create',
                'has_permission' => 1,
            ),
            407 =>
            array (
                'id' => 2388,
                'user_group_id' => 3,
                'action' => 'lecture_material/edit',
                'has_permission' => 1,
            ),
            408 =>
            array (
                'id' => 2389,
                'user_group_id' => 3,
                'action' => 'lecture_material/view',
                'has_permission' => 1,
            ),
            409 =>
            array (
                'id' => 2390,
                'user_group_id' => 3,
                'action' => 'academic_calendar',
                'has_permission' => 1,
            ),
            410 =>
            array (
                'id' => 2391,
                'user_group_id' => 3,
                'action' => 'academic_calendar/index',
                'has_permission' => 1,
            ),
            411 =>
            array (
                'id' => 2392,
                'user_group_id' => 3,
                'action' => 'exam',
                'has_permission' => 1,
            ),
            412 =>
            array (
                'id' => 2393,
                'user_group_id' => 3,
                'action' => 'exams',
                'has_permission' => 1,
            ),
            413 =>
            array (
                'id' => 2394,
                'user_group_id' => 3,
                'action' => 'exams/index',
                'has_permission' => 1,
            ),
            414 =>
            array (
                'id' => 2395,
                'user_group_id' => 3,
                'action' => 'exams/create',
                'has_permission' => 1,
            ),
            415 =>
            array (
                'id' => 2396,
                'user_group_id' => 3,
                'action' => 'exams/edit',
                'has_permission' => 1,
            ),
            416 =>
            array (
                'id' => 2397,
                'user_group_id' => 3,
                'action' => 'exams/view',
                'has_permission' => 1,
            ),
            417 =>
            array (
                'id' => 2398,
                'user_group_id' => 3,
                'action' => 'result',
                'has_permission' => 1,
            ),
            418 =>
            array (
                'id' => 2399,
                'user_group_id' => 3,
                'action' => 'result/index',
                'has_permission' => 1,
            ),
            419 =>
            array (
                'id' => 2400,
                'user_group_id' => 3,
                'action' => 'result/create',
                'has_permission' => 1,
            ),
            420 =>
            array (
                'id' => 2401,
                'user_group_id' => 3,
                'action' => 'result/edit',
                'has_permission' => 1,
            ),
            421 =>
            array (
                'id' => 2402,
                'user_group_id' => 3,
                'action' => 'result/view',
                'has_permission' => 1,
            ),
            422 =>
            array (
                'id' => 2403,
                'user_group_id' => 3,
                'action' => 'exam_category',
                'has_permission' => 1,
            ),
            423 =>
            array (
                'id' => 2404,
                'user_group_id' => 3,
                'action' => 'exam_category/index',
                'has_permission' => 1,
            ),
            424 =>
            array (
                'id' => 2405,
                'user_group_id' => 3,
                'action' => 'exam_category/create',
                'has_permission' => 1,
            ),
            425 =>
            array (
                'id' => 2406,
                'user_group_id' => 3,
                'action' => 'exam_category/edit',
                'has_permission' => 1,
            ),
            426 =>
            array (
                'id' => 2407,
                'user_group_id' => 3,
                'action' => 'exam_category/view',
                'has_permission' => 1,
            ),
            427 =>
            array (
                'id' => 2408,
                'user_group_id' => 3,
                'action' => 'exam_type',
                'has_permission' => 1,
            ),
            428 =>
            array (
                'id' => 2409,
                'user_group_id' => 3,
                'action' => 'exam_type/index',
                'has_permission' => 1,
            ),
            429 =>
            array (
                'id' => 2410,
                'user_group_id' => 3,
                'action' => 'exam_type/create',
                'has_permission' => 1,
            ),
            430 =>
            array (
                'id' => 2411,
                'user_group_id' => 3,
                'action' => 'exam_type/edit',
                'has_permission' => 1,
            ),
            431 =>
            array (
                'id' => 2412,
                'user_group_id' => 3,
                'action' => 'exam_type/view',
                'has_permission' => 1,
            ),
            432 =>
            array (
                'id' => 2413,
                'user_group_id' => 3,
                'action' => 'exam_sub_type',
                'has_permission' => 1,
            ),
            433 =>
            array (
                'id' => 2414,
                'user_group_id' => 3,
                'action' => 'exam_sub_type/index',
                'has_permission' => 1,
            ),
            434 =>
            array (
                'id' => 2415,
                'user_group_id' => 3,
                'action' => 'exam_sub_type/create',
                'has_permission' => 1,
            ),
            435 =>
            array (
                'id' => 2416,
                'user_group_id' => 3,
                'action' => 'exam_sub_type/edit',
                'has_permission' => 1,
            ),
            436 =>
            array (
                'id' => 2417,
                'user_group_id' => 3,
                'action' => 'exam_sub_type/view',
                'has_permission' => 1,
            ),
            437 =>
            array (
                'id' => 2418,
                'user_group_id' => 3,
                'action' => 'student_progress',
                'has_permission' => 1,
            ),
            438 =>
            array (
                'id' => 2419,
                'user_group_id' => 3,
                'action' => 'student_progress_result',
                'has_permission' => 1,
            ),
            439 =>
            array (
                'id' => 2420,
                'user_group_id' => 3,
                'action' => 'student_progress_result/index',
                'has_permission' => 1,
            ),
            440 =>
            array (
                'id' => 2421,
                'user_group_id' => 3,
                'action' => 'student_progress_result/create',
                'has_permission' => 1,
            ),
            441 =>
            array (
                'id' => 2422,
                'user_group_id' => 3,
                'action' => 'subject',
                'has_permission' => 1,
            ),
            442 =>
            array (
                'id' => 2423,
                'user_group_id' => 3,
                'action' => 'subject',
                'has_permission' => 1,
            ),
            443 =>
            array (
                'id' => 2424,
                'user_group_id' => 3,
                'action' => 'subject/index',
                'has_permission' => 1,
            ),
            444 =>
            array (
                'id' => 2425,
                'user_group_id' => 3,
                'action' => 'subject/create',
                'has_permission' => 1,
            ),
            445 =>
            array (
                'id' => 2426,
                'user_group_id' => 3,
                'action' => 'subject/edit',
                'has_permission' => 1,
            ),
            446 =>
            array (
                'id' => 2427,
                'user_group_id' => 3,
                'action' => 'subject/view',
                'has_permission' => 1,
            ),
            447 =>
            array (
                'id' => 2428,
                'user_group_id' => 3,
                'action' => 'subject_group',
                'has_permission' => 1,
            ),
            448 =>
            array (
                'id' => 2429,
                'user_group_id' => 3,
                'action' => 'subject_group/index',
                'has_permission' => 1,
            ),
            449 =>
            array (
                'id' => 2430,
                'user_group_id' => 3,
                'action' => 'subject_group/create',
                'has_permission' => 1,
            ),
            450 =>
            array (
                'id' => 2431,
                'user_group_id' => 3,
                'action' => 'subject_group/edit',
                'has_permission' => 1,
            ),
            451 =>
            array (
                'id' => 2432,
                'user_group_id' => 3,
                'action' => 'subject_group/view',
                'has_permission' => 1,
            ),
            452 =>
            array (
                'id' => 2433,
                'user_group_id' => 3,
                'action' => 'topic_head',
                'has_permission' => 1,
            ),
            453 =>
            array (
                'id' => 2434,
                'user_group_id' => 3,
                'action' => 'topic_head/index',
                'has_permission' => 1,
            ),
            454 =>
            array (
                'id' => 2435,
                'user_group_id' => 3,
                'action' => 'topic_head/create',
                'has_permission' => 1,
            ),
            455 =>
            array (
                'id' => 2436,
                'user_group_id' => 3,
                'action' => 'topic_head/edit',
                'has_permission' => 1,
            ),
            456 =>
            array (
                'id' => 2437,
                'user_group_id' => 3,
                'action' => 'topic_head/view',
                'has_permission' => 1,
            ),
            457 =>
            array (
                'id' => 2438,
                'user_group_id' => 3,
                'action' => 'topic',
                'has_permission' => 1,
            ),
            458 =>
            array (
                'id' => 2439,
                'user_group_id' => 3,
                'action' => 'topic/index',
                'has_permission' => 1,
            ),
            459 =>
            array (
                'id' => 2440,
                'user_group_id' => 3,
                'action' => 'topic/create',
                'has_permission' => 1,
            ),
            460 =>
            array (
                'id' => 2441,
                'user_group_id' => 3,
                'action' => 'topic/edit',
                'has_permission' => 1,
            ),
            461 =>
            array (
                'id' => 2442,
                'user_group_id' => 3,
                'action' => 'topic/view',
                'has_permission' => 1,
            ),
            462 =>
            array (
                'id' => 2443,
                'user_group_id' => 3,
                'action' => 'cards',
                'has_permission' => 1,
            ),
            463 =>
            array (
                'id' => 2444,
                'user_group_id' => 3,
                'action' => 'cards/index',
                'has_permission' => 1,
            ),
            464 =>
            array (
                'id' => 2445,
                'user_group_id' => 3,
                'action' => 'cards/create',
                'has_permission' => 1,
            ),
            465 =>
            array (
                'id' => 2446,
                'user_group_id' => 3,
                'action' => 'cards/edit',
                'has_permission' => 1,
            ),
            466 =>
            array (
                'id' => 2447,
                'user_group_id' => 3,
                'action' => 'cards/view',
                'has_permission' => 1,
            ),
            467 =>
            array (
                'id' => 2448,
                'user_group_id' => 3,
                'action' => 'card_items',
                'has_permission' => 1,
            ),
            468 =>
            array (
                'id' => 2449,
                'user_group_id' => 3,
                'action' => 'card_items/index',
                'has_permission' => 1,
            ),
            469 =>
            array (
                'id' => 2450,
                'user_group_id' => 3,
                'action' => 'card_items/create',
                'has_permission' => 1,
            ),
            470 =>
            array (
                'id' => 2451,
                'user_group_id' => 3,
                'action' => 'card_items/edit',
                'has_permission' => 1,
            ),
            471 =>
            array (
                'id' => 2452,
                'user_group_id' => 3,
                'action' => 'card_items/view',
                'has_permission' => 1,
            ),
            472 =>
            array (
                'id' => 2453,
                'user_group_id' => 3,
                'action' => 'book',
                'has_permission' => 1,
            ),
            473 =>
            array (
                'id' => 2454,
                'user_group_id' => 3,
                'action' => 'book/index',
                'has_permission' => 1,
            ),
            474 =>
            array (
                'id' => 2455,
                'user_group_id' => 3,
                'action' => 'book/create',
                'has_permission' => 1,
            ),
            475 =>
            array (
                'id' => 2456,
                'user_group_id' => 3,
                'action' => 'book/edit',
                'has_permission' => 1,
            ),
            476 =>
            array (
                'id' => 2457,
                'user_group_id' => 3,
                'action' => 'book/view',
                'has_permission' => 1,
            ),
            477 =>
            array (
                'id' => 2458,
                'user_group_id' => 3,
                'action' => 'teacher',
                'has_permission' => 1,
            ),
            478 =>
            array (
                'id' => 2459,
                'user_group_id' => 3,
                'action' => 'teacher/index',
                'has_permission' => 1,
            ),
            479 =>
            array (
                'id' => 2460,
                'user_group_id' => 3,
                'action' => 'teacher/create',
                'has_permission' => 1,
            ),
            480 =>
            array (
                'id' => 2461,
                'user_group_id' => 3,
                'action' => 'teacher/edit',
                'has_permission' => 1,
            ),
            481 =>
            array (
                'id' => 2462,
                'user_group_id' => 3,
                'action' => 'teacher/view',
                'has_permission' => 1,
            ),
            482 =>
            array (
                'id' => 2463,
                'user_group_id' => 3,
                'action' => 'teacher/password',
                'has_permission' => 0,
            ),
            483 =>
            array (
                'id' => 2464,
                'user_group_id' => 3,
                'action' => 'class_routine',
                'has_permission' => 1,
            ),
            484 =>
            array (
                'id' => 2465,
                'user_group_id' => 3,
                'action' => 'class_routine/index',
                'has_permission' => 1,
            ),
            485 =>
            array (
                'id' => 2466,
                'user_group_id' => 3,
                'action' => 'class_routine/create',
                'has_permission' => 1,
            ),
            486 =>
            array (
                'id' => 2467,
                'user_group_id' => 3,
                'action' => 'class_routine/edit',
                'has_permission' => 1,
            ),
            487 =>
            array (
                'id' => 2468,
                'user_group_id' => 3,
                'action' => 'class_routine/view',
                'has_permission' => 1,
            ),
            488 =>
            array (
                'id' => 2469,
                'user_group_id' => 3,
                'action' => 'attendance',
                'has_permission' => 1,
            ),
            489 =>
            array (
                'id' => 2470,
                'user_group_id' => 3,
                'action' => 'attendance/index',
                'has_permission' => 1,
            ),
            490 =>
            array (
                'id' => 2471,
                'user_group_id' => 3,
                'action' => 'attendance/create',
                'has_permission' => 1,
            ),
            491 =>
            array (
                'id' => 2472,
                'user_group_id' => 3,
                'action' => 'attendance/edit',
                'has_permission' => 1,
            ),
            492 =>
            array (
                'id' => 2473,
                'user_group_id' => 3,
                'action' => 'attendance/view',
                'has_permission' => 1,
            ),
            493 =>
            array (
                'id' => 2474,
                'user_group_id' => 3,
                'action' => 'payment',
                'has_permission' => 1,
            ),
            494 =>
            array (
                'id' => 2475,
                'user_group_id' => 3,
                'action' => 'generate_fee',
                'has_permission' => 1,
            ),
            495 =>
            array (
                'id' => 2476,
                'user_group_id' => 3,
                'action' => 'generate_fee/index',
                'has_permission' => 1,
            ),
            496 =>
            array (
                'id' => 2477,
                'user_group_id' => 3,
                'action' => 'generate_fee/create',
                'has_permission' => 1,
            ),
            497 =>
            array (
                'id' => 2478,
                'user_group_id' => 3,
                'action' => 'generate_fee/edit',
                'has_permission' => 1,
            ),
            498 =>
            array (
                'id' => 2479,
                'user_group_id' => 3,
                'action' => 'generate_fee/view',
                'has_permission' => 1,
            ),
            499 =>
            array (
                'id' => 2480,
                'user_group_id' => 3,
                'action' => 'collect_fee',
                'has_permission' => 1,
            ),
        ));
        \DB::table('user_group_permissions')->insert(array (
            0 =>
            array (
                'id' => 2481,
                'user_group_id' => 3,
                'action' => 'collect_fee/index',
                'has_permission' => 1,
            ),
            1 =>
            array (
                'id' => 2482,
                'user_group_id' => 3,
                'action' => 'collect_fee/create',
                'has_permission' => 1,
            ),
            2 =>
            array (
                'id' => 2483,
                'user_group_id' => 3,
                'action' => 'collect_fee/edit',
                'has_permission' => 1,
            ),
            3 =>
            array (
                'id' => 2484,
                'user_group_id' => 3,
                'action' => 'collect_fee/view',
                'has_permission' => 1,
            ),
            4 =>
            array (
                'id' => 2485,
                'user_group_id' => 3,
                'action' => 'student_payment',
                'has_permission' => 1,
            ),
            5 =>
            array (
                'id' => 2486,
                'user_group_id' => 3,
                'action' => 'student_payment/index',
                'has_permission' => 1,
            ),
            6 =>
            array (
                'id' => 2487,
                'user_group_id' => 3,
                'action' => 'student_payment/edit',
                'has_permission' => 1,
            ),
            7 =>
            array (
                'id' => 2488,
                'user_group_id' => 3,
                'action' => 'student_payment/view',
                'has_permission' => 1,
            ),
            8 =>
            array (
                'id' => 2489,
                'user_group_id' => 3,
                'action' => 'reports',
                'has_permission' => 1,
            ),
            9 =>
            array (
                'id' => 2490,
                'user_group_id' => 3,
                'action' => 'report_admission',
                'has_permission' => 1,
            ),
            10 =>
            array (
                'id' => 2491,
                'user_group_id' => 3,
                'action' => 'report_admission/all',
                'has_permission' => 1,
            ),
            11 =>
            array (
                'id' => 2492,
                'user_group_id' => 3,
                'action' => 'report_attendance',
                'has_permission' => 0,
            ),
            12 =>
            array (
                'id' => 2493,
                'user_group_id' => 3,
                'action' => 'report_attendance/all',
                'has_permission' => 0,
            ),
            13 =>
            array (
                'id' => 2494,
                'user_group_id' => 3,
                'action' => 'report_attendance_by_term',
                'has_permission' => 1,
            ),
            14 =>
            array (
                'id' => 2495,
                'user_group_id' => 3,
                'action' => 'report_attendance_by_term/all',
                'has_permission' => 1,
            ),
            15 =>
            array (
                'id' => 2496,
                'user_group_id' => 3,
                'action' => 'report_attendance_by_phase',
                'has_permission' => 1,
            ),
            16 =>
            array (
                'id' => 2497,
                'user_group_id' => 3,
                'action' => 'report_attendance_by_phase/all',
                'has_permission' => 1,
            ),
            17 =>
            array (
                'id' => 2498,
                'user_group_id' => 3,
                'action' => 'report_attendance_by_student',
                'has_permission' => 1,
            ),
            18 =>
            array (
                'id' => 2499,
                'user_group_id' => 3,
                'action' => 'report_attendance_by_student/all',
                'has_permission' => 1,
            ),
            19 =>
            array (
                'id' => 2500,
                'user_group_id' => 3,
                'action' => 'report_exam_result',
                'has_permission' => 1,
            ),
            20 =>
            array (
                'id' => 2501,
                'user_group_id' => 3,
                'action' => 'report_exam_result/all',
                'has_permission' => 1,
            ),
            21 =>
            array (
                'id' => 2502,
                'user_group_id' => 3,
                'action' => 'report_exam_result_phase',
                'has_permission' => 1,
            ),
            22 =>
            array (
                'id' => 2503,
                'user_group_id' => 3,
                'action' => 'report_exam_result_phase/all',
                'has_permission' => 1,
            ),
            23 =>
            array (
                'id' => 2504,
                'user_group_id' => 3,
                'action' => 'report_exam_result_student',
                'has_permission' => 1,
            ),
            24 =>
            array (
                'id' => 2505,
                'user_group_id' => 3,
                'action' => 'report_exam_result_student/all',
                'has_permission' => 1,
            ),
            25 =>
            array (
                'id' => 2506,
                'user_group_id' => 3,
                'action' => 'report_student_payment',
                'has_permission' => 1,
            ),
            26 =>
            array (
                'id' => 2507,
                'user_group_id' => 3,
                'action' => 'report_student_payment/all',
                'has_permission' => 1,
            ),
            27 =>
            array (
                'id' => 2508,
                'user_group_id' => 3,
                'action' => 'report_student_list',
                'has_permission' => 0,
            ),
            28 =>
            array (
                'id' => 2509,
                'user_group_id' => 3,
                'action' => 'report_student_list/all',
                'has_permission' => 0,
            ),
            29 =>
            array (
                'id' => 2510,
                'user_group_id' => 3,
                'action' => 'report_teacher_list',
                'has_permission' => 0,
            ),
            30 =>
            array (
                'id' => 2511,
                'user_group_id' => 3,
                'action' => 'report_teacher_list/all',
                'has_permission' => 0,
            ),
            31 =>
            array (
                'id' => 2512,
                'user_group_id' => 3,
                'action' => 'notice_board',
                'has_permission' => 1,
            ),
            32 =>
            array (
                'id' => 2513,
                'user_group_id' => 3,
                'action' => 'notice_board/index',
                'has_permission' => 1,
            ),
            33 =>
            array (
                'id' => 2514,
                'user_group_id' => 3,
                'action' => 'notice_board/create',
                'has_permission' => 1,
            ),
            34 =>
            array (
                'id' => 2515,
                'user_group_id' => 3,
                'action' => 'notice_board/edit',
                'has_permission' => 1,
            ),
            35 =>
            array (
                'id' => 2516,
                'user_group_id' => 3,
                'action' => 'notice_board/view',
                'has_permission' => 1,
            ),
            36 =>
            array (
                'id' => 2517,
                'user_group_id' => 3,
                'action' => 'holiday',
                'has_permission' => 1,
            ),
            37 =>
            array (
                'id' => 2518,
                'user_group_id' => 3,
                'action' => 'holiday/index',
                'has_permission' => 1,
            ),
            38 =>
            array (
                'id' => 2519,
                'user_group_id' => 3,
                'action' => 'holiday/create',
                'has_permission' => 1,
            ),
            39 =>
            array (
                'id' => 2520,
                'user_group_id' => 3,
                'action' => 'holiday/edit',
                'has_permission' => 1,
            ),
            40 =>
            array (
                'id' => 2521,
                'user_group_id' => 3,
                'action' => 'holiday/view',
                'has_permission' => 1,
            ),
            41 =>
            array (
                'id' => 2522,
                'user_group_id' => 3,
                'action' => 'message',
                'has_permission' => 1,
            ),
            42 =>
            array (
                'id' => 2523,
                'user_group_id' => 3,
                'action' => 'message/index',
                'has_permission' => 1,
            ),
            43 =>
            array (
                'id' => 2524,
                'user_group_id' => 3,
                'action' => 'message/create',
                'has_permission' => 1,
            ),
            44 =>
            array (
                'id' => 2525,
                'user_group_id' => 3,
                'action' => 'message/edit',
                'has_permission' => 1,
            ),
            45 =>
            array (
                'id' => 2526,
                'user_group_id' => 3,
                'action' => 'message/view',
                'has_permission' => 1,
            ),
            46 =>
            array (
                'id' => 2527,
                'user_group_id' => 3,
                'action' => 'setting',
                'has_permission' => 1,
            ),
            47 =>
            array (
                'id' => 2528,
                'user_group_id' => 3,
                'action' => 'attachment_type',
                'has_permission' => 1,
            ),
            48 =>
            array (
                'id' => 2529,
                'user_group_id' => 3,
                'action' => 'attachment_type/index',
                'has_permission' => 1,
            ),
            49 =>
            array (
                'id' => 2530,
                'user_group_id' => 3,
                'action' => 'attachment_type/create',
                'has_permission' => 1,
            ),
            50 =>
            array (
                'id' => 2531,
                'user_group_id' => 3,
                'action' => 'attachment_type/edit',
                'has_permission' => 1,
            ),
            51 =>
            array (
                'id' => 2532,
                'user_group_id' => 3,
                'action' => 'attachment_type/view',
                'has_permission' => 1,
            ),
            52 =>
            array (
                'id' => 2533,
                'user_group_id' => 3,
                'action' => 'student_category',
                'has_permission' => 1,
            ),
            53 =>
            array (
                'id' => 2534,
                'user_group_id' => 3,
                'action' => 'student_category/index',
                'has_permission' => 1,
            ),
            54 =>
            array (
                'id' => 2535,
                'user_group_id' => 3,
                'action' => 'student_category/create',
                'has_permission' => 1,
            ),
            55 =>
            array (
                'id' => 2536,
                'user_group_id' => 3,
                'action' => 'student_category/edit',
                'has_permission' => 1,
            ),
            56 =>
            array (
                'id' => 2537,
                'user_group_id' => 3,
                'action' => 'student_category/view',
                'has_permission' => 1,
            ),
            57 =>
            array (
                'id' => 2538,
                'user_group_id' => 3,
                'action' => 'student_group',
                'has_permission' => 1,
            ),
            58 =>
            array (
                'id' => 2539,
                'user_group_id' => 3,
                'action' => 'student_group/index',
                'has_permission' => 1,
            ),
            59 =>
            array (
                'id' => 2540,
                'user_group_id' => 3,
                'action' => 'student_group/create',
                'has_permission' => 1,
            ),
            60 =>
            array (
                'id' => 2541,
                'user_group_id' => 3,
                'action' => 'student_group/edit',
                'has_permission' => 1,
            ),
            61 =>
            array (
                'id' => 2542,
                'user_group_id' => 3,
                'action' => 'student_group/view',
                'has_permission' => 1,
            ),
            62 =>
            array (
                'id' => 2543,
                'user_group_id' => 3,
                'action' => 'term',
                'has_permission' => 1,
            ),
            63 =>
            array (
                'id' => 2544,
                'user_group_id' => 3,
                'action' => 'term/index',
                'has_permission' => 1,
            ),
            64 =>
            array (
                'id' => 2545,
                'user_group_id' => 3,
                'action' => 'term/create',
                'has_permission' => 1,
            ),
            65 =>
            array (
                'id' => 2546,
                'user_group_id' => 3,
                'action' => 'term/edit',
                'has_permission' => 1,
            ),
            66 =>
            array (
                'id' => 2547,
                'user_group_id' => 3,
                'action' => 'term/view',
                'has_permission' => 1,
            ),
            67 =>
            array (
                'id' => 2548,
                'user_group_id' => 3,
                'action' => 'phase',
                'has_permission' => 1,
            ),
            68 =>
            array (
                'id' => 2549,
                'user_group_id' => 3,
                'action' => 'phase/index',
                'has_permission' => 1,
            ),
            69 =>
            array (
                'id' => 2550,
                'user_group_id' => 3,
                'action' => 'phase/create',
                'has_permission' => 1,
            ),
            70 =>
            array (
                'id' => 2551,
                'user_group_id' => 3,
                'action' => 'phase/edit',
                'has_permission' => 1,
            ),
            71 =>
            array (
                'id' => 2552,
                'user_group_id' => 3,
                'action' => 'phase/view',
                'has_permission' => 1,
            ),
            72 =>
            array (
                'id' => 2553,
                'user_group_id' => 3,
                'action' => 'designation',
                'has_permission' => 1,
            ),
            73 =>
            array (
                'id' => 2554,
                'user_group_id' => 3,
                'action' => 'designation/index',
                'has_permission' => 1,
            ),
            74 =>
            array (
                'id' => 2555,
                'user_group_id' => 3,
                'action' => 'designation/create',
                'has_permission' => 1,
            ),
            75 =>
            array (
                'id' => 2556,
                'user_group_id' => 3,
                'action' => 'designation/edit',
                'has_permission' => 1,
            ),
            76 =>
            array (
                'id' => 2557,
                'user_group_id' => 3,
                'action' => 'designation/view',
                'has_permission' => 1,
            ),
            77 =>
            array (
                'id' => 2558,
                'user_group_id' => 3,
                'action' => 'department',
                'has_permission' => 1,
            ),
            78 =>
            array (
                'id' => 2559,
                'user_group_id' => 3,
                'action' => 'department/index',
                'has_permission' => 1,
            ),
            79 =>
            array (
                'id' => 2560,
                'user_group_id' => 3,
                'action' => 'department/create',
                'has_permission' => 1,
            ),
            80 =>
            array (
                'id' => 2561,
                'user_group_id' => 3,
                'action' => 'department/edit',
                'has_permission' => 1,
            ),
            81 =>
            array (
                'id' => 2562,
                'user_group_id' => 3,
                'action' => 'department/view',
                'has_permission' => 1,
            ),
            82 =>
            array (
                'id' => 2563,
                'user_group_id' => 3,
                'action' => 'course',
                'has_permission' => 1,
            ),
            83 =>
            array (
                'id' => 2564,
                'user_group_id' => 3,
                'action' => 'course/index',
                'has_permission' => 1,
            ),
            84 =>
            array (
                'id' => 2565,
                'user_group_id' => 3,
                'action' => 'course/create',
                'has_permission' => 1,
            ),
            85 =>
            array (
                'id' => 2566,
                'user_group_id' => 3,
                'action' => 'course/edit',
                'has_permission' => 1,
            ),
            86 =>
            array (
                'id' => 2567,
                'user_group_id' => 3,
                'action' => 'course/view',
                'has_permission' => 1,
            ),
            87 =>
            array (
                'id' => 2568,
                'user_group_id' => 3,
                'action' => 'class_type',
                'has_permission' => 1,
            ),
            88 =>
            array (
                'id' => 2569,
                'user_group_id' => 3,
                'action' => 'class_type/index',
                'has_permission' => 1,
            ),
            89 =>
            array (
                'id' => 2570,
                'user_group_id' => 3,
                'action' => 'class_type/create',
                'has_permission' => 1,
            ),
            90 =>
            array (
                'id' => 2571,
                'user_group_id' => 3,
                'action' => 'class_type/edit',
                'has_permission' => 1,
            ),
            91 =>
            array (
                'id' => 2572,
                'user_group_id' => 3,
                'action' => 'class_type/view',
                'has_permission' => 1,
            ),
            92 =>
            array (
                'id' => 2573,
                'user_group_id' => 3,
                'action' => 'education_board',
                'has_permission' => 1,
            ),
            93 =>
            array (
                'id' => 2574,
                'user_group_id' => 3,
                'action' => 'education_board/index',
                'has_permission' => 1,
            ),
            94 =>
            array (
                'id' => 2575,
                'user_group_id' => 3,
                'action' => 'education_board/create',
                'has_permission' => 1,
            ),
            95 =>
            array (
                'id' => 2576,
                'user_group_id' => 3,
                'action' => 'education_board/edit',
                'has_permission' => 1,
            ),
            96 =>
            array (
                'id' => 2577,
                'user_group_id' => 3,
                'action' => 'education_board/view',
                'has_permission' => 1,
            ),
            97 =>
            array (
                'id' => 2578,
                'user_group_id' => 3,
                'action' => 'bank',
                'has_permission' => 1,
            ),
            98 =>
            array (
                'id' => 2579,
                'user_group_id' => 3,
                'action' => 'bank/index',
                'has_permission' => 1,
            ),
            99 =>
            array (
                'id' => 2580,
                'user_group_id' => 3,
                'action' => 'bank/create',
                'has_permission' => 1,
            ),
            100 =>
            array (
                'id' => 2581,
                'user_group_id' => 3,
                'action' => 'bank/edit',
                'has_permission' => 1,
            ),
            101 =>
            array (
                'id' => 2582,
                'user_group_id' => 3,
                'action' => 'payment_type',
                'has_permission' => 1,
            ),
            102 =>
            array (
                'id' => 2583,
                'user_group_id' => 3,
                'action' => 'payment_type/index',
                'has_permission' => 1,
            ),
            103 =>
            array (
                'id' => 2584,
                'user_group_id' => 3,
                'action' => 'payment_type/create',
                'has_permission' => 1,
            ),
            104 =>
            array (
                'id' => 2585,
                'user_group_id' => 3,
                'action' => 'payment_type/edit',
                'has_permission' => 1,
            ),
            105 =>
            array (
                'id' => 2586,
                'user_group_id' => 3,
                'action' => 'payment_type/view',
                'has_permission' => 1,
            ),
            106 =>
            array (
                'id' => 2587,
                'user_group_id' => 3,
                'action' => 'payment_method',
                'has_permission' => 1,
            ),
            107 =>
            array (
                'id' => 2588,
                'user_group_id' => 3,
                'action' => 'payment_method/index',
                'has_permission' => 1,
            ),
            108 =>
            array (
                'id' => 2589,
                'user_group_id' => 3,
                'action' => 'payment_method/create',
                'has_permission' => 1,
            ),
            109 =>
            array (
                'id' => 2590,
                'user_group_id' => 3,
                'action' => 'payment_method/edit',
                'has_permission' => 1,
            ),
            110 =>
            array (
                'id' => 2591,
                'user_group_id' => 3,
                'action' => 'payment_detail',
                'has_permission' => 1,
            ),
            111 =>
            array (
                'id' => 2592,
                'user_group_id' => 3,
                'action' => 'payment_detail/index',
                'has_permission' => 1,
            ),
            112 =>
            array (
                'id' => 2593,
                'user_group_id' => 3,
                'action' => 'payment_detail/create',
                'has_permission' => 1,
            ),
            113 =>
            array (
                'id' => 2594,
                'user_group_id' => 3,
                'action' => 'payment_detail/edit',
                'has_permission' => 1,
            ),
            114 =>
            array (
                'id' => 2595,
                'user_group_id' => 3,
                'action' => 'payment_detail/view',
                'has_permission' => 1,
            ),
            115 =>
            array (
                'id' => 2596,
                'user_group_id' => 3,
                'action' => 'hall',
                'has_permission' => 1,
            ),
            116 =>
            array (
                'id' => 2597,
                'user_group_id' => 3,
                'action' => 'hall/index',
                'has_permission' => 1,
            ),
            117 =>
            array (
                'id' => 2598,
                'user_group_id' => 3,
                'action' => 'hall/create',
                'has_permission' => 1,
            ),
            118 =>
            array (
                'id' => 2599,
                'user_group_id' => 3,
                'action' => 'hall/edit',
                'has_permission' => 1,
            ),
            119 =>
            array (
                'id' => 2600,
                'user_group_id' => 3,
                'action' => 'hall/view',
                'has_permission' => 1,
            ),
            120 =>
            array (
                'id' => 2601,
                'user_group_id' => 3,
                'action' => 'application_setting',
                'has_permission' => 1,
            ),
            121 =>
            array (
                'id' => 2602,
                'user_group_id' => 3,
                'action' => 'application_setting/index',
                'has_permission' => 1,
            ),
            122 =>
            array (
                'id' => 2603,
                'user_group_id' => 3,
                'action' => 'application_setting/create',
                'has_permission' => 1,
            ),
            123 =>
            array (
                'id' => 2604,
                'user_group_id' => 3,
                'action' => 'application_setting/edit',
                'has_permission' => 1,
            ),
            124 =>
            array (
                'id' => 2605,
                'user_group_id' => 3,
                'action' => 'application_setting/view',
                'has_permission' => 0,
            ),
            125 =>
            array (
                'id' => 2606,
                'user_group_id' => 3,
                'action' => 'logout',
                'has_permission' => 1,
            ),
            126 =>
            array (
                'id' => 2607,
                'user_group_id' => 3,
                'action' => 'logout/index',
                'has_permission' => 1,
            ),
            127 =>
            array (
                'id' => 2608,
                'user_group_id' => 4,
                'action' => 'dashboard',
                'has_permission' => 1,
            ),
            128 =>
            array (
                'id' => 2609,
                'user_group_id' => 4,
                'action' => 'dashboard/index',
                'has_permission' => 1,
            ),
            129 =>
            array (
                'id' => 2610,
                'user_group_id' => 4,
                'action' => 'admission_management',
                'has_permission' => 0,
            ),
            130 =>
            array (
                'id' => 2611,
                'user_group_id' => 4,
                'action' => 'admission',
                'has_permission' => 0,
            ),
            131 =>
            array (
                'id' => 2612,
                'user_group_id' => 4,
                'action' => 'admission/index',
                'has_permission' => 0,
            ),
            132 =>
            array (
                'id' => 2613,
                'user_group_id' => 4,
                'action' => 'admission/create',
                'has_permission' => 0,
            ),
            133 =>
            array (
                'id' => 2614,
                'user_group_id' => 4,
                'action' => 'admission/edit',
                'has_permission' => 0,
            ),
            134 =>
            array (
                'id' => 2615,
                'user_group_id' => 4,
                'action' => 'admission/view',
                'has_permission' => 0,
            ),
            135 =>
            array (
                'id' => 2616,
                'user_group_id' => 4,
                'action' => 'students',
                'has_permission' => 1,
            ),
            136 =>
            array (
                'id' => 2617,
                'user_group_id' => 4,
                'action' => 'students/index',
                'has_permission' => 1,
            ),
            137 =>
            array (
                'id' => 2618,
                'user_group_id' => 4,
                'action' => 'students/create',
                'has_permission' => 0,
            ),
            138 =>
            array (
                'id' => 2619,
                'user_group_id' => 4,
                'action' => 'students/edit',
                'has_permission' => 0,
            ),
            139 =>
            array (
                'id' => 2620,
                'user_group_id' => 4,
                'action' => 'students/view',
                'has_permission' => 1,
            ),
            140 =>
            array (
                'id' => 2621,
                'user_group_id' => 4,
                'action' => 'students/installment',
                'has_permission' => 0,
            ),
            141 =>
            array (
                'id' => 2622,
                'user_group_id' => 4,
                'action' => 'guardians',
                'has_permission' => 1,
            ),
            142 =>
            array (
                'id' => 2623,
                'user_group_id' => 4,
                'action' => 'guardians/index',
                'has_permission' => 1,
            ),
            143 =>
            array (
                'id' => 2624,
                'user_group_id' => 4,
                'action' => 'guardians/edit',
                'has_permission' => 0,
            ),
            144 =>
            array (
                'id' => 2625,
                'user_group_id' => 4,
                'action' => 'guardians/password',
                'has_permission' => 0,
            ),
            145 =>
            array (
                'id' => 2626,
                'user_group_id' => 4,
                'action' => 'guardians/view',
                'has_permission' => 1,
            ),
            146 =>
            array (
                'id' => 2627,
                'user_group_id' => 4,
                'action' => 'sessions',
                'has_permission' => 0,
            ),
            147 =>
            array (
                'id' => 2628,
                'user_group_id' => 4,
                'action' => 'sessions/index',
                'has_permission' => 0,
            ),
            148 =>
            array (
                'id' => 2629,
                'user_group_id' => 4,
                'action' => 'sessions/create',
                'has_permission' => 0,
            ),
            149 =>
            array (
                'id' => 2630,
                'user_group_id' => 4,
                'action' => 'sessions/edit',
                'has_permission' => 0,
            ),
            150 =>
            array (
                'id' => 2631,
                'user_group_id' => 4,
                'action' => 'sessions/view',
                'has_permission' => 0,
            ),
            151 =>
            array (
                'id' => 2632,
                'user_group_id' => 4,
                'action' => 'user_management',
                'has_permission' => 0,
            ),
            152 =>
            array (
                'id' => 2633,
                'user_group_id' => 4,
                'action' => 'users',
                'has_permission' => 0,
            ),
            153 =>
            array (
                'id' => 2634,
                'user_group_id' => 4,
                'action' => 'users/index',
                'has_permission' => 0,
            ),
            154 =>
            array (
                'id' => 2635,
                'user_group_id' => 4,
                'action' => 'users/create',
                'has_permission' => 0,
            ),
            155 =>
            array (
                'id' => 2636,
                'user_group_id' => 4,
                'action' => 'users/edit',
                'has_permission' => 0,
            ),
            156 =>
            array (
                'id' => 2637,
                'user_group_id' => 4,
                'action' => 'users/view',
                'has_permission' => 0,
            ),
            157 =>
            array (
                'id' => 2638,
                'user_group_id' => 4,
                'action' => 'user_groups',
                'has_permission' => 0,
            ),
            158 =>
            array (
                'id' => 2639,
                'user_group_id' => 4,
                'action' => 'user_groups/index',
                'has_permission' => 0,
            ),
            159 =>
            array (
                'id' => 2640,
                'user_group_id' => 4,
                'action' => 'user_groups/create',
                'has_permission' => 0,
            ),
            160 =>
            array (
                'id' => 2641,
                'user_group_id' => 4,
                'action' => 'user_groups/edit',
                'has_permission' => 0,
            ),
            161 =>
            array (
                'id' => 2642,
                'user_group_id' => 4,
                'action' => 'user_groups/permission',
                'has_permission' => 0,
            ),
            162 =>
            array (
                'id' => 2643,
                'user_group_id' => 4,
                'action' => 'lecture_material',
                'has_permission' => 1,
            ),
            163 =>
            array (
                'id' => 2644,
                'user_group_id' => 4,
                'action' => 'lecture_material/index',
                'has_permission' => 1,
            ),
            164 =>
            array (
                'id' => 2645,
                'user_group_id' => 4,
                'action' => 'lecture_material/create',
                'has_permission' => 1,
            ),
            165 =>
            array (
                'id' => 2646,
                'user_group_id' => 4,
                'action' => 'lecture_material/edit',
                'has_permission' => 1,
            ),
            166 =>
            array (
                'id' => 2647,
                'user_group_id' => 4,
                'action' => 'lecture_material/view',
                'has_permission' => 1,
            ),
            167 =>
            array (
                'id' => 2648,
                'user_group_id' => 4,
                'action' => 'academic_calendar',
                'has_permission' => 1,
            ),
            168 =>
            array (
                'id' => 2649,
                'user_group_id' => 4,
                'action' => 'academic_calendar/index',
                'has_permission' => 1,
            ),
            169 =>
            array (
                'id' => 2650,
                'user_group_id' => 4,
                'action' => 'exam',
                'has_permission' => 1,
            ),
            170 =>
            array (
                'id' => 2651,
                'user_group_id' => 4,
                'action' => 'exams',
                'has_permission' => 1,
            ),
            171 =>
            array (
                'id' => 2652,
                'user_group_id' => 4,
                'action' => 'exams/index',
                'has_permission' => 1,
            ),
            172 =>
            array (
                'id' => 2653,
                'user_group_id' => 4,
                'action' => 'exams/create',
                'has_permission' => 1,
            ),
            173 =>
            array (
                'id' => 2654,
                'user_group_id' => 4,
                'action' => 'exams/edit',
                'has_permission' => 1,
            ),
            174 =>
            array (
                'id' => 2655,
                'user_group_id' => 4,
                'action' => 'exams/view',
                'has_permission' => 1,
            ),
            175 =>
            array (
                'id' => 2656,
                'user_group_id' => 4,
                'action' => 'result',
                'has_permission' => 1,
            ),
            176 =>
            array (
                'id' => 2657,
                'user_group_id' => 4,
                'action' => 'result/index',
                'has_permission' => 1,
            ),
            177 =>
            array (
                'id' => 2658,
                'user_group_id' => 4,
                'action' => 'result/create',
                'has_permission' => 1,
            ),
            178 =>
            array (
                'id' => 2659,
                'user_group_id' => 4,
                'action' => 'result/edit',
                'has_permission' => 1,
            ),
            179 =>
            array (
                'id' => 2660,
                'user_group_id' => 4,
                'action' => 'result/view',
                'has_permission' => 1,
            ),
            180 =>
            array (
                'id' => 2661,
                'user_group_id' => 4,
                'action' => 'exam_category',
                'has_permission' => 1,
            ),
            181 =>
            array (
                'id' => 2662,
                'user_group_id' => 4,
                'action' => 'exam_category/index',
                'has_permission' => 1,
            ),
            182 =>
            array (
                'id' => 2663,
                'user_group_id' => 4,
                'action' => 'exam_category/create',
                'has_permission' => 1,
            ),
            183 =>
            array (
                'id' => 2664,
                'user_group_id' => 4,
                'action' => 'exam_category/edit',
                'has_permission' => 1,
            ),
            184 =>
            array (
                'id' => 2665,
                'user_group_id' => 4,
                'action' => 'exam_category/view',
                'has_permission' => 1,
            ),
            185 =>
            array (
                'id' => 2666,
                'user_group_id' => 4,
                'action' => 'exam_type',
                'has_permission' => 1,
            ),
            186 =>
            array (
                'id' => 2667,
                'user_group_id' => 4,
                'action' => 'exam_type/index',
                'has_permission' => 1,
            ),
            187 =>
            array (
                'id' => 2668,
                'user_group_id' => 4,
                'action' => 'exam_type/create',
                'has_permission' => 1,
            ),
            188 =>
            array (
                'id' => 2669,
                'user_group_id' => 4,
                'action' => 'exam_type/edit',
                'has_permission' => 1,
            ),
            189 =>
            array (
                'id' => 2670,
                'user_group_id' => 4,
                'action' => 'exam_type/view',
                'has_permission' => 1,
            ),
            190 =>
            array (
                'id' => 2671,
                'user_group_id' => 4,
                'action' => 'exam_sub_type',
                'has_permission' => 1,
            ),
            191 =>
            array (
                'id' => 2672,
                'user_group_id' => 4,
                'action' => 'exam_sub_type/index',
                'has_permission' => 1,
            ),
            192 =>
            array (
                'id' => 2673,
                'user_group_id' => 4,
                'action' => 'exam_sub_type/create',
                'has_permission' => 1,
            ),
            193 =>
            array (
                'id' => 2674,
                'user_group_id' => 4,
                'action' => 'exam_sub_type/edit',
                'has_permission' => 1,
            ),
            194 =>
            array (
                'id' => 2675,
                'user_group_id' => 4,
                'action' => 'exam_sub_type/view',
                'has_permission' => 1,
            ),
            195 =>
            array (
                'id' => 2676,
                'user_group_id' => 4,
                'action' => 'student_progress',
                'has_permission' => 1,
            ),
            196 =>
            array (
                'id' => 2677,
                'user_group_id' => 4,
                'action' => 'student_progress_result',
                'has_permission' => 1,
            ),
            197 =>
            array (
                'id' => 2678,
                'user_group_id' => 4,
                'action' => 'student_progress_result/index',
                'has_permission' => 1,
            ),
            198 =>
            array (
                'id' => 2679,
                'user_group_id' => 4,
                'action' => 'student_progress_result/create',
                'has_permission' => 1,
            ),
            199 =>
            array (
                'id' => 2680,
                'user_group_id' => 4,
                'action' => 'subject',
                'has_permission' => 1,
            ),
            200 =>
            array (
                'id' => 2681,
                'user_group_id' => 4,
                'action' => 'subject',
                'has_permission' => 1,
            ),
            201 =>
            array (
                'id' => 2682,
                'user_group_id' => 4,
                'action' => 'subject/index',
                'has_permission' => 1,
            ),
            202 =>
            array (
                'id' => 2683,
                'user_group_id' => 4,
                'action' => 'subject/create',
                'has_permission' => 1,
            ),
            203 =>
            array (
                'id' => 2684,
                'user_group_id' => 4,
                'action' => 'subject/edit',
                'has_permission' => 1,
            ),
            204 =>
            array (
                'id' => 2685,
                'user_group_id' => 4,
                'action' => 'subject/view',
                'has_permission' => 1,
            ),
            205 =>
            array (
                'id' => 2686,
                'user_group_id' => 4,
                'action' => 'subject_group',
                'has_permission' => 0,
            ),
            206 =>
            array (
                'id' => 2687,
                'user_group_id' => 4,
                'action' => 'subject_group/index',
                'has_permission' => 0,
            ),
            207 =>
            array (
                'id' => 2688,
                'user_group_id' => 4,
                'action' => 'subject_group/create',
                'has_permission' => 0,
            ),
            208 =>
            array (
                'id' => 2689,
                'user_group_id' => 4,
                'action' => 'subject_group/edit',
                'has_permission' => 0,
            ),
            209 =>
            array (
                'id' => 2690,
                'user_group_id' => 4,
                'action' => 'subject_group/view',
                'has_permission' => 0,
            ),
            210 =>
            array (
                'id' => 2691,
                'user_group_id' => 4,
                'action' => 'topic_head',
                'has_permission' => 1,
            ),
            211 =>
            array (
                'id' => 2692,
                'user_group_id' => 4,
                'action' => 'topic_head/index',
                'has_permission' => 1,
            ),
            212 =>
            array (
                'id' => 2693,
                'user_group_id' => 4,
                'action' => 'topic_head/create',
                'has_permission' => 1,
            ),
            213 =>
            array (
                'id' => 2694,
                'user_group_id' => 4,
                'action' => 'topic_head/edit',
                'has_permission' => 1,
            ),
            214 =>
            array (
                'id' => 2695,
                'user_group_id' => 4,
                'action' => 'topic_head/view',
                'has_permission' => 1,
            ),
            215 =>
            array (
                'id' => 2696,
                'user_group_id' => 4,
                'action' => 'topic',
                'has_permission' => 1,
            ),
            216 =>
            array (
                'id' => 2697,
                'user_group_id' => 4,
                'action' => 'topic/index',
                'has_permission' => 1,
            ),
            217 =>
            array (
                'id' => 2698,
                'user_group_id' => 4,
                'action' => 'topic/create',
                'has_permission' => 1,
            ),
            218 =>
            array (
                'id' => 2699,
                'user_group_id' => 4,
                'action' => 'topic/edit',
                'has_permission' => 1,
            ),
            219 =>
            array (
                'id' => 2700,
                'user_group_id' => 4,
                'action' => 'topic/view',
                'has_permission' => 1,
            ),
            220 =>
            array (
                'id' => 2701,
                'user_group_id' => 4,
                'action' => 'cards',
                'has_permission' => 1,
            ),
            221 =>
            array (
                'id' => 2702,
                'user_group_id' => 4,
                'action' => 'cards/index',
                'has_permission' => 1,
            ),
            222 =>
            array (
                'id' => 2703,
                'user_group_id' => 4,
                'action' => 'cards/create',
                'has_permission' => 1,
            ),
            223 =>
            array (
                'id' => 2704,
                'user_group_id' => 4,
                'action' => 'cards/edit',
                'has_permission' => 1,
            ),
            224 =>
            array (
                'id' => 2705,
                'user_group_id' => 4,
                'action' => 'cards/view',
                'has_permission' => 1,
            ),
            225 =>
            array (
                'id' => 2706,
                'user_group_id' => 4,
                'action' => 'card_items',
                'has_permission' => 1,
            ),
            226 =>
            array (
                'id' => 2707,
                'user_group_id' => 4,
                'action' => 'card_items/index',
                'has_permission' => 1,
            ),
            227 =>
            array (
                'id' => 2708,
                'user_group_id' => 4,
                'action' => 'card_items/create',
                'has_permission' => 1,
            ),
            228 =>
            array (
                'id' => 2709,
                'user_group_id' => 4,
                'action' => 'card_items/edit',
                'has_permission' => 1,
            ),
            229 =>
            array (
                'id' => 2710,
                'user_group_id' => 4,
                'action' => 'card_items/view',
                'has_permission' => 1,
            ),
            230 =>
            array (
                'id' => 2711,
                'user_group_id' => 4,
                'action' => 'book',
                'has_permission' => 1,
            ),
            231 =>
            array (
                'id' => 2712,
                'user_group_id' => 4,
                'action' => 'book/index',
                'has_permission' => 1,
            ),
            232 =>
            array (
                'id' => 2713,
                'user_group_id' => 4,
                'action' => 'book/create',
                'has_permission' => 1,
            ),
            233 =>
            array (
                'id' => 2714,
                'user_group_id' => 4,
                'action' => 'book/edit',
                'has_permission' => 1,
            ),
            234 =>
            array (
                'id' => 2715,
                'user_group_id' => 4,
                'action' => 'book/view',
                'has_permission' => 1,
            ),
            235 =>
            array (
                'id' => 2716,
                'user_group_id' => 4,
                'action' => 'teacher',
                'has_permission' => 1,
            ),
            236 =>
            array (
                'id' => 2717,
                'user_group_id' => 4,
                'action' => 'teacher/index',
                'has_permission' => 1,
            ),
            237 =>
            array (
                'id' => 2718,
                'user_group_id' => 4,
                'action' => 'teacher/create',
                'has_permission' => 1,
            ),
            238 =>
            array (
                'id' => 2719,
                'user_group_id' => 4,
                'action' => 'teacher/edit',
                'has_permission' => 1,
            ),
            239 =>
            array (
                'id' => 2720,
                'user_group_id' => 4,
                'action' => 'teacher/view',
                'has_permission' => 1,
            ),
            240 =>
            array (
                'id' => 2721,
                'user_group_id' => 4,
                'action' => 'teacher/password',
                'has_permission' => 1,
            ),
            241 =>
            array (
                'id' => 2722,
                'user_group_id' => 4,
                'action' => 'class_routine',
                'has_permission' => 1,
            ),
            242 =>
            array (
                'id' => 2723,
                'user_group_id' => 4,
                'action' => 'class_routine/index',
                'has_permission' => 1,
            ),
            243 =>
            array (
                'id' => 2724,
                'user_group_id' => 4,
                'action' => 'class_routine/create',
                'has_permission' => 0,
            ),
            244 =>
            array (
                'id' => 2725,
                'user_group_id' => 4,
                'action' => 'class_routine/edit',
                'has_permission' => 0,
            ),
            245 =>
            array (
                'id' => 2726,
                'user_group_id' => 4,
                'action' => 'class_routine/view',
                'has_permission' => 1,
            ),
            246 =>
            array (
                'id' => 2727,
                'user_group_id' => 4,
                'action' => 'attendance',
                'has_permission' => 1,
            ),
            247 =>
            array (
                'id' => 2728,
                'user_group_id' => 4,
                'action' => 'attendance/index',
                'has_permission' => 1,
            ),
            248 =>
            array (
                'id' => 2729,
                'user_group_id' => 4,
                'action' => 'attendance/create',
                'has_permission' => 1,
            ),
            249 =>
            array (
                'id' => 2730,
                'user_group_id' => 4,
                'action' => 'attendance/edit',
                'has_permission' => 1,
            ),
            250 =>
            array (
                'id' => 2731,
                'user_group_id' => 4,
                'action' => 'attendance/view',
                'has_permission' => 1,
            ),
            251 =>
            array (
                'id' => 2732,
                'user_group_id' => 4,
                'action' => 'payment',
                'has_permission' => 0,
            ),
            252 =>
            array (
                'id' => 2733,
                'user_group_id' => 4,
                'action' => 'generate_fee',
                'has_permission' => 0,
            ),
            253 =>
            array (
                'id' => 2734,
                'user_group_id' => 4,
                'action' => 'generate_fee/index',
                'has_permission' => 0,
            ),
            254 =>
            array (
                'id' => 2735,
                'user_group_id' => 4,
                'action' => 'generate_fee/create',
                'has_permission' => 0,
            ),
            255 =>
            array (
                'id' => 2736,
                'user_group_id' => 4,
                'action' => 'generate_fee/edit',
                'has_permission' => 0,
            ),
            256 =>
            array (
                'id' => 2737,
                'user_group_id' => 4,
                'action' => 'generate_fee/view',
                'has_permission' => 0,
            ),
            257 =>
            array (
                'id' => 2738,
                'user_group_id' => 4,
                'action' => 'collect_fee',
                'has_permission' => 0,
            ),
            258 =>
            array (
                'id' => 2739,
                'user_group_id' => 4,
                'action' => 'collect_fee/index',
                'has_permission' => 0,
            ),
            259 =>
            array (
                'id' => 2740,
                'user_group_id' => 4,
                'action' => 'collect_fee/create',
                'has_permission' => 0,
            ),
            260 =>
            array (
                'id' => 2741,
                'user_group_id' => 4,
                'action' => 'collect_fee/edit',
                'has_permission' => 0,
            ),
            261 =>
            array (
                'id' => 2742,
                'user_group_id' => 4,
                'action' => 'collect_fee/view',
                'has_permission' => 0,
            ),
            262 =>
            array (
                'id' => 2743,
                'user_group_id' => 4,
                'action' => 'student_payment',
                'has_permission' => 0,
            ),
            263 =>
            array (
                'id' => 2744,
                'user_group_id' => 4,
                'action' => 'student_payment/index',
                'has_permission' => 0,
            ),
            264 =>
            array (
                'id' => 2745,
                'user_group_id' => 4,
                'action' => 'student_payment/edit',
                'has_permission' => 0,
            ),
            265 =>
            array (
                'id' => 2746,
                'user_group_id' => 4,
                'action' => 'student_payment/view',
                'has_permission' => 0,
            ),
            266 =>
            array (
                'id' => 2747,
                'user_group_id' => 4,
                'action' => 'reports',
                'has_permission' => 0,
            ),
            267 =>
            array (
                'id' => 2748,
                'user_group_id' => 4,
                'action' => 'report_admission',
                'has_permission' => 0,
            ),
            268 =>
            array (
                'id' => 2749,
                'user_group_id' => 4,
                'action' => 'report_admission/all',
                'has_permission' => 0,
            ),
            269 =>
            array (
                'id' => 2750,
                'user_group_id' => 4,
                'action' => 'report_attendance',
                'has_permission' => 0,
            ),
            270 =>
            array (
                'id' => 2751,
                'user_group_id' => 4,
                'action' => 'report_attendance/all',
                'has_permission' => 0,
            ),
            271 =>
            array (
                'id' => 2752,
                'user_group_id' => 4,
                'action' => 'report_attendance_by_term',
                'has_permission' => 1,
            ),
            272 =>
            array (
                'id' => 2753,
                'user_group_id' => 4,
                'action' => 'report_attendance_by_term/all',
                'has_permission' => 1,
            ),
            273 =>
            array (
                'id' => 2754,
                'user_group_id' => 4,
                'action' => 'report_attendance_by_phase',
                'has_permission' => 1,
            ),
            274 =>
            array (
                'id' => 2755,
                'user_group_id' => 4,
                'action' => 'report_attendance_by_phase/all',
                'has_permission' => 1,
            ),
            275 =>
            array (
                'id' => 2756,
                'user_group_id' => 4,
                'action' => 'report_attendance_by_student',
                'has_permission' => 1,
            ),
            276 =>
            array (
                'id' => 2757,
                'user_group_id' => 4,
                'action' => 'report_attendance_by_student/all',
                'has_permission' => 1,
            ),
            277 =>
            array (
                'id' => 2758,
                'user_group_id' => 4,
                'action' => 'report_exam_result',
                'has_permission' => 1,
            ),
            278 =>
            array (
                'id' => 2759,
                'user_group_id' => 4,
                'action' => 'report_exam_result/all',
                'has_permission' => 1,
            ),
            279 =>
            array (
                'id' => 2760,
                'user_group_id' => 4,
                'action' => 'report_exam_result_phase',
                'has_permission' => 1,
            ),
            280 =>
            array (
                'id' => 2761,
                'user_group_id' => 4,
                'action' => 'report_exam_result_phase/all',
                'has_permission' => 1,
            ),
            281 =>
            array (
                'id' => 2762,
                'user_group_id' => 4,
                'action' => 'report_exam_result_student',
                'has_permission' => 1,
            ),
            282 =>
            array (
                'id' => 2763,
                'user_group_id' => 4,
                'action' => 'report_exam_result_student/all',
                'has_permission' => 1,
            ),
            283 =>
            array (
                'id' => 2764,
                'user_group_id' => 4,
                'action' => 'report_student_payment',
                'has_permission' => 0,
            ),
            284 =>
            array (
                'id' => 2765,
                'user_group_id' => 4,
                'action' => 'report_student_payment/all',
                'has_permission' => 0,
            ),
            285 =>
            array (
                'id' => 2766,
                'user_group_id' => 4,
                'action' => 'report_student_list',
                'has_permission' => 0,
            ),
            286 =>
            array (
                'id' => 2767,
                'user_group_id' => 4,
                'action' => 'report_student_list/all',
                'has_permission' => 0,
            ),
            287 =>
            array (
                'id' => 2768,
                'user_group_id' => 4,
                'action' => 'report_teacher_list',
                'has_permission' => 0,
            ),
            288 =>
            array (
                'id' => 2769,
                'user_group_id' => 4,
                'action' => 'report_teacher_list/all',
                'has_permission' => 0,
            ),
            289 =>
            array (
                'id' => 2770,
                'user_group_id' => 4,
                'action' => 'notice_board',
                'has_permission' => 1,
            ),
            290 =>
            array (
                'id' => 2771,
                'user_group_id' => 4,
                'action' => 'notice_board/index',
                'has_permission' => 1,
            ),
            291 =>
            array (
                'id' => 2772,
                'user_group_id' => 4,
                'action' => 'notice_board/create',
                'has_permission' => 1,
            ),
            292 =>
            array (
                'id' => 2773,
                'user_group_id' => 4,
                'action' => 'notice_board/edit',
                'has_permission' => 1,
            ),
            293 =>
            array (
                'id' => 2774,
                'user_group_id' => 4,
                'action' => 'notice_board/view',
                'has_permission' => 1,
            ),
            294 =>
            array (
                'id' => 2775,
                'user_group_id' => 4,
                'action' => 'holiday',
                'has_permission' => 1,
            ),
            295 =>
            array (
                'id' => 2776,
                'user_group_id' => 4,
                'action' => 'holiday/index',
                'has_permission' => 1,
            ),
            296 =>
            array (
                'id' => 2777,
                'user_group_id' => 4,
                'action' => 'holiday/create',
                'has_permission' => 1,
            ),
            297 =>
            array (
                'id' => 2778,
                'user_group_id' => 4,
                'action' => 'holiday/edit',
                'has_permission' => 1,
            ),
            298 =>
            array (
                'id' => 2779,
                'user_group_id' => 4,
                'action' => 'holiday/view',
                'has_permission' => 1,
            ),
            299 =>
            array (
                'id' => 2780,
                'user_group_id' => 4,
                'action' => 'message',
                'has_permission' => 1,
            ),
            300 =>
            array (
                'id' => 2781,
                'user_group_id' => 4,
                'action' => 'message/index',
                'has_permission' => 1,
            ),
            301 =>
            array (
                'id' => 2782,
                'user_group_id' => 4,
                'action' => 'message/create',
                'has_permission' => 1,
            ),
            302 =>
            array (
                'id' => 2783,
                'user_group_id' => 4,
                'action' => 'message/edit',
                'has_permission' => 1,
            ),
            303 =>
            array (
                'id' => 2784,
                'user_group_id' => 4,
                'action' => 'message/view',
                'has_permission' => 1,
            ),
            304 =>
            array (
                'id' => 2785,
                'user_group_id' => 4,
                'action' => 'setting',
                'has_permission' => 0,
            ),
            305 =>
            array (
                'id' => 2786,
                'user_group_id' => 4,
                'action' => 'attachment_type',
                'has_permission' => 1,
            ),
            306 =>
            array (
                'id' => 2787,
                'user_group_id' => 4,
                'action' => 'attachment_type/index',
                'has_permission' => 1,
            ),
            307 =>
            array (
                'id' => 2788,
                'user_group_id' => 4,
                'action' => 'attachment_type/create',
                'has_permission' => 1,
            ),
            308 =>
            array (
                'id' => 2789,
                'user_group_id' => 4,
                'action' => 'attachment_type/edit',
                'has_permission' => 1,
            ),
            309 =>
            array (
                'id' => 2790,
                'user_group_id' => 4,
                'action' => 'attachment_type/view',
                'has_permission' => 1,
            ),
            310 =>
            array (
                'id' => 2791,
                'user_group_id' => 4,
                'action' => 'student_category',
                'has_permission' => 0,
            ),
            311 =>
            array (
                'id' => 2792,
                'user_group_id' => 4,
                'action' => 'student_category/index',
                'has_permission' => 0,
            ),
            312 =>
            array (
                'id' => 2793,
                'user_group_id' => 4,
                'action' => 'student_category/create',
                'has_permission' => 0,
            ),
            313 =>
            array (
                'id' => 2794,
                'user_group_id' => 4,
                'action' => 'student_category/edit',
                'has_permission' => 0,
            ),
            314 =>
            array (
                'id' => 2795,
                'user_group_id' => 4,
                'action' => 'student_category/view',
                'has_permission' => 0,
            ),
            315 =>
            array (
                'id' => 2796,
                'user_group_id' => 4,
                'action' => 'student_group',
                'has_permission' => 0,
            ),
            316 =>
            array (
                'id' => 2797,
                'user_group_id' => 4,
                'action' => 'student_group/index',
                'has_permission' => 0,
            ),
            317 =>
            array (
                'id' => 2798,
                'user_group_id' => 4,
                'action' => 'student_group/create',
                'has_permission' => 0,
            ),
            318 =>
            array (
                'id' => 2799,
                'user_group_id' => 4,
                'action' => 'student_group/edit',
                'has_permission' => 0,
            ),
            319 =>
            array (
                'id' => 2800,
                'user_group_id' => 4,
                'action' => 'student_group/view',
                'has_permission' => 0,
            ),
            320 =>
            array (
                'id' => 2801,
                'user_group_id' => 4,
                'action' => 'term',
                'has_permission' => 0,
            ),
            321 =>
            array (
                'id' => 2802,
                'user_group_id' => 4,
                'action' => 'term/index',
                'has_permission' => 0,
            ),
            322 =>
            array (
                'id' => 2803,
                'user_group_id' => 4,
                'action' => 'term/create',
                'has_permission' => 0,
            ),
            323 =>
            array (
                'id' => 2804,
                'user_group_id' => 4,
                'action' => 'term/edit',
                'has_permission' => 0,
            ),
            324 =>
            array (
                'id' => 2805,
                'user_group_id' => 4,
                'action' => 'term/view',
                'has_permission' => 0,
            ),
            325 =>
            array (
                'id' => 2806,
                'user_group_id' => 4,
                'action' => 'phase',
                'has_permission' => 0,
            ),
            326 =>
            array (
                'id' => 2807,
                'user_group_id' => 4,
                'action' => 'phase/index',
                'has_permission' => 0,
            ),
            327 =>
            array (
                'id' => 2808,
                'user_group_id' => 4,
                'action' => 'phase/create',
                'has_permission' => 0,
            ),
            328 =>
            array (
                'id' => 2809,
                'user_group_id' => 4,
                'action' => 'phase/edit',
                'has_permission' => 0,
            ),
            329 =>
            array (
                'id' => 2810,
                'user_group_id' => 4,
                'action' => 'phase/view',
                'has_permission' => 0,
            ),
            330 =>
            array (
                'id' => 2811,
                'user_group_id' => 4,
                'action' => 'designation',
                'has_permission' => 0,
            ),
            331 =>
            array (
                'id' => 2812,
                'user_group_id' => 4,
                'action' => 'designation/index',
                'has_permission' => 0,
            ),
            332 =>
            array (
                'id' => 2813,
                'user_group_id' => 4,
                'action' => 'designation/create',
                'has_permission' => 0,
            ),
            333 =>
            array (
                'id' => 2814,
                'user_group_id' => 4,
                'action' => 'designation/edit',
                'has_permission' => 0,
            ),
            334 =>
            array (
                'id' => 2815,
                'user_group_id' => 4,
                'action' => 'designation/view',
                'has_permission' => 0,
            ),
            335 =>
            array (
                'id' => 2816,
                'user_group_id' => 4,
                'action' => 'department',
                'has_permission' => 0,
            ),
            336 =>
            array (
                'id' => 2817,
                'user_group_id' => 4,
                'action' => 'department/index',
                'has_permission' => 0,
            ),
            337 =>
            array (
                'id' => 2818,
                'user_group_id' => 4,
                'action' => 'department/create',
                'has_permission' => 0,
            ),
            338 =>
            array (
                'id' => 2819,
                'user_group_id' => 4,
                'action' => 'department/edit',
                'has_permission' => 0,
            ),
            339 =>
            array (
                'id' => 2820,
                'user_group_id' => 4,
                'action' => 'department/view',
                'has_permission' => 0,
            ),
            340 =>
            array (
                'id' => 2821,
                'user_group_id' => 4,
                'action' => 'course',
                'has_permission' => 0,
            ),
            341 =>
            array (
                'id' => 2822,
                'user_group_id' => 4,
                'action' => 'course/index',
                'has_permission' => 0,
            ),
            342 =>
            array (
                'id' => 2823,
                'user_group_id' => 4,
                'action' => 'course/create',
                'has_permission' => 0,
            ),
            343 =>
            array (
                'id' => 2824,
                'user_group_id' => 4,
                'action' => 'course/edit',
                'has_permission' => 0,
            ),
            344 =>
            array (
                'id' => 2825,
                'user_group_id' => 4,
                'action' => 'course/view',
                'has_permission' => 0,
            ),
            345 =>
            array (
                'id' => 2826,
                'user_group_id' => 4,
                'action' => 'class_type',
                'has_permission' => 1,
            ),
            346 =>
            array (
                'id' => 2827,
                'user_group_id' => 4,
                'action' => 'class_type/index',
                'has_permission' => 1,
            ),
            347 =>
            array (
                'id' => 2828,
                'user_group_id' => 4,
                'action' => 'class_type/create',
                'has_permission' => 1,
            ),
            348 =>
            array (
                'id' => 2829,
                'user_group_id' => 4,
                'action' => 'class_type/edit',
                'has_permission' => 1,
            ),
            349 =>
            array (
                'id' => 2830,
                'user_group_id' => 4,
                'action' => 'class_type/view',
                'has_permission' => 1,
            ),
            350 =>
            array (
                'id' => 2831,
                'user_group_id' => 4,
                'action' => 'education_board',
                'has_permission' => 0,
            ),
            351 =>
            array (
                'id' => 2832,
                'user_group_id' => 4,
                'action' => 'education_board/index',
                'has_permission' => 0,
            ),
            352 =>
            array (
                'id' => 2833,
                'user_group_id' => 4,
                'action' => 'education_board/create',
                'has_permission' => 0,
            ),
            353 =>
            array (
                'id' => 2834,
                'user_group_id' => 4,
                'action' => 'education_board/edit',
                'has_permission' => 0,
            ),
            354 =>
            array (
                'id' => 2835,
                'user_group_id' => 4,
                'action' => 'education_board/view',
                'has_permission' => 1,
            ),
            355 =>
            array (
                'id' => 2836,
                'user_group_id' => 4,
                'action' => 'bank',
                'has_permission' => 0,
            ),
            356 =>
            array (
                'id' => 2837,
                'user_group_id' => 4,
                'action' => 'bank/index',
                'has_permission' => 0,
            ),
            357 =>
            array (
                'id' => 2838,
                'user_group_id' => 4,
                'action' => 'bank/create',
                'has_permission' => 0,
            ),
            358 =>
            array (
                'id' => 2839,
                'user_group_id' => 4,
                'action' => 'bank/edit',
                'has_permission' => 0,
            ),
            359 =>
            array (
                'id' => 2840,
                'user_group_id' => 4,
                'action' => 'payment_type',
                'has_permission' => 0,
            ),
            360 =>
            array (
                'id' => 2841,
                'user_group_id' => 4,
                'action' => 'payment_type/index',
                'has_permission' => 0,
            ),
            361 =>
            array (
                'id' => 2842,
                'user_group_id' => 4,
                'action' => 'payment_type/create',
                'has_permission' => 0,
            ),
            362 =>
            array (
                'id' => 2843,
                'user_group_id' => 4,
                'action' => 'payment_type/edit',
                'has_permission' => 0,
            ),
            363 =>
            array (
                'id' => 2844,
                'user_group_id' => 4,
                'action' => 'payment_type/view',
                'has_permission' => 0,
            ),
            364 =>
            array (
                'id' => 2845,
                'user_group_id' => 4,
                'action' => 'payment_method',
                'has_permission' => 0,
            ),
            365 =>
            array (
                'id' => 2846,
                'user_group_id' => 4,
                'action' => 'payment_method/index',
                'has_permission' => 0,
            ),
            366 =>
            array (
                'id' => 2847,
                'user_group_id' => 4,
                'action' => 'payment_method/create',
                'has_permission' => 0,
            ),
            367 =>
            array (
                'id' => 2848,
                'user_group_id' => 4,
                'action' => 'payment_method/edit',
                'has_permission' => 0,
            ),
            368 =>
            array (
                'id' => 2849,
                'user_group_id' => 4,
                'action' => 'payment_detail',
                'has_permission' => 0,
            ),
            369 =>
            array (
                'id' => 2850,
                'user_group_id' => 4,
                'action' => 'payment_detail/index',
                'has_permission' => 0,
            ),
            370 =>
            array (
                'id' => 2851,
                'user_group_id' => 4,
                'action' => 'payment_detail/create',
                'has_permission' => 0,
            ),
            371 =>
            array (
                'id' => 2852,
                'user_group_id' => 4,
                'action' => 'payment_detail/edit',
                'has_permission' => 0,
            ),
            372 =>
            array (
                'id' => 2853,
                'user_group_id' => 4,
                'action' => 'payment_detail/view',
                'has_permission' => 0,
            ),
            373 =>
            array (
                'id' => 2854,
                'user_group_id' => 4,
                'action' => 'hall',
                'has_permission' => 1,
            ),
            374 =>
            array (
                'id' => 2855,
                'user_group_id' => 4,
                'action' => 'hall/index',
                'has_permission' => 1,
            ),
            375 =>
            array (
                'id' => 2856,
                'user_group_id' => 4,
                'action' => 'hall/create',
                'has_permission' => 0,
            ),
            376 =>
            array (
                'id' => 2857,
                'user_group_id' => 4,
                'action' => 'hall/edit',
                'has_permission' => 0,
            ),
            377 =>
            array (
                'id' => 2858,
                'user_group_id' => 4,
                'action' => 'hall/view',
                'has_permission' => 1,
            ),
            378 =>
            array (
                'id' => 2859,
                'user_group_id' => 4,
                'action' => 'application_setting',
                'has_permission' => 0,
            ),
            379 =>
            array (
                'id' => 2860,
                'user_group_id' => 4,
                'action' => 'application_setting/index',
                'has_permission' => 0,
            ),
            380 =>
            array (
                'id' => 2861,
                'user_group_id' => 4,
                'action' => 'application_setting/create',
                'has_permission' => 0,
            ),
            381 =>
            array (
                'id' => 2862,
                'user_group_id' => 4,
                'action' => 'application_setting/edit',
                'has_permission' => 0,
            ),
            382 =>
            array (
                'id' => 2863,
                'user_group_id' => 4,
                'action' => 'application_setting/view',
                'has_permission' => 0,
            ),
            383 =>
            array (
                'id' => 2864,
                'user_group_id' => 4,
                'action' => 'logout',
                'has_permission' => 1,
            ),
            384 =>
            array (
                'id' => 2865,
                'user_group_id' => 4,
                'action' => 'logout/index',
                'has_permission' => 1,
            ),
            385 =>
            array (
                'id' => 2866,
                'user_group_id' => 5,
                'action' => 'dashboard',
                'has_permission' => 1,
            ),
            386 =>
            array (
                'id' => 2867,
                'user_group_id' => 5,
                'action' => 'dashboard/index',
                'has_permission' => 1,
            ),
            387 =>
            array (
                'id' => 2868,
                'user_group_id' => 5,
                'action' => 'admission_management',
                'has_permission' => 0,
            ),
            388 =>
            array (
                'id' => 2869,
                'user_group_id' => 5,
                'action' => 'admission',
                'has_permission' => 0,
            ),
            389 =>
            array (
                'id' => 2870,
                'user_group_id' => 5,
                'action' => 'admission/index',
                'has_permission' => 0,
            ),
            390 =>
            array (
                'id' => 2871,
                'user_group_id' => 5,
                'action' => 'admission/create',
                'has_permission' => 0,
            ),
            391 =>
            array (
                'id' => 2872,
                'user_group_id' => 5,
                'action' => 'admission/edit',
                'has_permission' => 0,
            ),
            392 =>
            array (
                'id' => 2873,
                'user_group_id' => 5,
                'action' => 'admission/view',
                'has_permission' => 0,
            ),
            393 =>
            array (
                'id' => 2874,
                'user_group_id' => 5,
                'action' => 'students',
                'has_permission' => 1,
            ),
            394 =>
            array (
                'id' => 2875,
                'user_group_id' => 5,
                'action' => 'students/index',
                'has_permission' => 1,
            ),
            395 =>
            array (
                'id' => 2876,
                'user_group_id' => 5,
                'action' => 'students/create',
                'has_permission' => 0,
            ),
            396 =>
            array (
                'id' => 2877,
                'user_group_id' => 5,
                'action' => 'students/edit',
                'has_permission' => 0,
            ),
            397 =>
            array (
                'id' => 2878,
                'user_group_id' => 5,
                'action' => 'students/view',
                'has_permission' => 1,
            ),
            398 =>
            array (
                'id' => 2879,
                'user_group_id' => 5,
                'action' => 'students/installment',
                'has_permission' => 0,
            ),
            399 =>
            array (
                'id' => 2880,
                'user_group_id' => 5,
                'action' => 'guardians',
                'has_permission' => 0,
            ),
            400 =>
            array (
                'id' => 2881,
                'user_group_id' => 5,
                'action' => 'guardians/index',
                'has_permission' => 0,
            ),
            401 =>
            array (
                'id' => 2882,
                'user_group_id' => 5,
                'action' => 'guardians/edit',
                'has_permission' => 0,
            ),
            402 =>
            array (
                'id' => 2883,
                'user_group_id' => 5,
                'action' => 'guardians/password',
                'has_permission' => 0,
            ),
            403 =>
            array (
                'id' => 2884,
                'user_group_id' => 5,
                'action' => 'guardians/view',
                'has_permission' => 0,
            ),
            404 =>
            array (
                'id' => 2885,
                'user_group_id' => 5,
                'action' => 'sessions',
                'has_permission' => 0,
            ),
            405 =>
            array (
                'id' => 2886,
                'user_group_id' => 5,
                'action' => 'sessions/index',
                'has_permission' => 0,
            ),
            406 =>
            array (
                'id' => 2887,
                'user_group_id' => 5,
                'action' => 'sessions/create',
                'has_permission' => 0,
            ),
            407 =>
            array (
                'id' => 2888,
                'user_group_id' => 5,
                'action' => 'sessions/edit',
                'has_permission' => 0,
            ),
            408 =>
            array (
                'id' => 2889,
                'user_group_id' => 5,
                'action' => 'sessions/view',
                'has_permission' => 0,
            ),
            409 =>
            array (
                'id' => 2890,
                'user_group_id' => 5,
                'action' => 'user_management',
                'has_permission' => 0,
            ),
            410 =>
            array (
                'id' => 2891,
                'user_group_id' => 5,
                'action' => 'users',
                'has_permission' => 0,
            ),
            411 =>
            array (
                'id' => 2892,
                'user_group_id' => 5,
                'action' => 'users/index',
                'has_permission' => 0,
            ),
            412 =>
            array (
                'id' => 2893,
                'user_group_id' => 5,
                'action' => 'users/create',
                'has_permission' => 0,
            ),
            413 =>
            array (
                'id' => 2894,
                'user_group_id' => 5,
                'action' => 'users/edit',
                'has_permission' => 0,
            ),
            414 =>
            array (
                'id' => 2895,
                'user_group_id' => 5,
                'action' => 'users/view',
                'has_permission' => 0,
            ),
            415 =>
            array (
                'id' => 2896,
                'user_group_id' => 5,
                'action' => 'user_groups',
                'has_permission' => 0,
            ),
            416 =>
            array (
                'id' => 2897,
                'user_group_id' => 5,
                'action' => 'user_groups/index',
                'has_permission' => 0,
            ),
            417 =>
            array (
                'id' => 2898,
                'user_group_id' => 5,
                'action' => 'user_groups/create',
                'has_permission' => 0,
            ),
            418 =>
            array (
                'id' => 2899,
                'user_group_id' => 5,
                'action' => 'user_groups/edit',
                'has_permission' => 0,
            ),
            419 =>
            array (
                'id' => 2900,
                'user_group_id' => 5,
                'action' => 'user_groups/permission',
                'has_permission' => 0,
            ),
            420 =>
            array (
                'id' => 2901,
                'user_group_id' => 5,
                'action' => 'lecture_material',
                'has_permission' => 1,
            ),
            421 =>
            array (
                'id' => 2902,
                'user_group_id' => 5,
                'action' => 'lecture_material/index',
                'has_permission' => 1,
            ),
            422 =>
            array (
                'id' => 2903,
                'user_group_id' => 5,
                'action' => 'lecture_material/create',
                'has_permission' => 0,
            ),
            423 =>
            array (
                'id' => 2904,
                'user_group_id' => 5,
                'action' => 'lecture_material/edit',
                'has_permission' => 0,
            ),
            424 =>
            array (
                'id' => 2905,
                'user_group_id' => 5,
                'action' => 'lecture_material/view',
                'has_permission' => 1,
            ),
            425 =>
            array (
                'id' => 2906,
                'user_group_id' => 5,
                'action' => 'academic_calendar',
                'has_permission' => 1,
            ),
            426 =>
            array (
                'id' => 2907,
                'user_group_id' => 5,
                'action' => 'academic_calendar/index',
                'has_permission' => 1,
            ),
            427 =>
            array (
                'id' => 2908,
                'user_group_id' => 5,
                'action' => 'exam',
                'has_permission' => 1,
            ),
            428 =>
            array (
                'id' => 2909,
                'user_group_id' => 5,
                'action' => 'exams',
                'has_permission' => 1,
            ),
            429 =>
            array (
                'id' => 2910,
                'user_group_id' => 5,
                'action' => 'exams/index',
                'has_permission' => 1,
            ),
            430 =>
            array (
                'id' => 2911,
                'user_group_id' => 5,
                'action' => 'exams/create',
                'has_permission' => 0,
            ),
            431 =>
            array (
                'id' => 2912,
                'user_group_id' => 5,
                'action' => 'exams/edit',
                'has_permission' => 0,
            ),
            432 =>
            array (
                'id' => 2913,
                'user_group_id' => 5,
                'action' => 'exams/view',
                'has_permission' => 1,
            ),
            433 =>
            array (
                'id' => 2914,
                'user_group_id' => 5,
                'action' => 'result',
                'has_permission' => 1,
            ),
            434 =>
            array (
                'id' => 2915,
                'user_group_id' => 5,
                'action' => 'result/index',
                'has_permission' => 1,
            ),
            435 =>
            array (
                'id' => 2916,
                'user_group_id' => 5,
                'action' => 'result/create',
                'has_permission' => 0,
            ),
            436 =>
            array (
                'id' => 2917,
                'user_group_id' => 5,
                'action' => 'result/edit',
                'has_permission' => 0,
            ),
            437 =>
            array (
                'id' => 2918,
                'user_group_id' => 5,
                'action' => 'result/view',
                'has_permission' => 1,
            ),
            438 =>
            array (
                'id' => 2919,
                'user_group_id' => 5,
                'action' => 'exam_category',
                'has_permission' => 0,
            ),
            439 =>
            array (
                'id' => 2920,
                'user_group_id' => 5,
                'action' => 'exam_category/index',
                'has_permission' => 0,
            ),
            440 =>
            array (
                'id' => 2921,
                'user_group_id' => 5,
                'action' => 'exam_category/create',
                'has_permission' => 0,
            ),
            441 =>
            array (
                'id' => 2922,
                'user_group_id' => 5,
                'action' => 'exam_category/edit',
                'has_permission' => 0,
            ),
            442 =>
            array (
                'id' => 2923,
                'user_group_id' => 5,
                'action' => 'exam_category/view',
                'has_permission' => 0,
            ),
            443 =>
            array (
                'id' => 2924,
                'user_group_id' => 5,
                'action' => 'exam_type',
                'has_permission' => 1,
            ),
            444 =>
            array (
                'id' => 2925,
                'user_group_id' => 5,
                'action' => 'exam_type/index',
                'has_permission' => 1,
            ),
            445 =>
            array (
                'id' => 2926,
                'user_group_id' => 5,
                'action' => 'exam_type/create',
                'has_permission' => 0,
            ),
            446 =>
            array (
                'id' => 2927,
                'user_group_id' => 5,
                'action' => 'exam_type/edit',
                'has_permission' => 0,
            ),
            447 =>
            array (
                'id' => 2928,
                'user_group_id' => 5,
                'action' => 'exam_type/view',
                'has_permission' => 1,
            ),
            448 =>
            array (
                'id' => 2929,
                'user_group_id' => 5,
                'action' => 'exam_sub_type',
                'has_permission' => 0,
            ),
            449 =>
            array (
                'id' => 2930,
                'user_group_id' => 5,
                'action' => 'exam_sub_type/index',
                'has_permission' => 0,
            ),
            450 =>
            array (
                'id' => 2931,
                'user_group_id' => 5,
                'action' => 'exam_sub_type/create',
                'has_permission' => 0,
            ),
            451 =>
            array (
                'id' => 2932,
                'user_group_id' => 5,
                'action' => 'exam_sub_type/edit',
                'has_permission' => 0,
            ),
            452 =>
            array (
                'id' => 2933,
                'user_group_id' => 5,
                'action' => 'exam_sub_type/view',
                'has_permission' => 0,
            ),
            453 =>
            array (
                'id' => 2934,
                'user_group_id' => 5,
                'action' => 'student_progress',
                'has_permission' => 1,
            ),
            454 =>
            array (
                'id' => 2935,
                'user_group_id' => 5,
                'action' => 'student_progress_result',
                'has_permission' => 1,
            ),
            455 =>
            array (
                'id' => 2936,
                'user_group_id' => 5,
                'action' => 'student_progress_result/index',
                'has_permission' => 1,
            ),
            456 =>
            array (
                'id' => 2937,
                'user_group_id' => 5,
                'action' => 'student_progress_result/create',
                'has_permission' => 0,
            ),
            457 =>
            array (
                'id' => 2938,
                'user_group_id' => 5,
                'action' => 'subject',
                'has_permission' => 1,
            ),
            458 =>
            array (
                'id' => 2939,
                'user_group_id' => 5,
                'action' => 'subject',
                'has_permission' => 1,
            ),
            459 =>
            array (
                'id' => 2940,
                'user_group_id' => 5,
                'action' => 'subject/index',
                'has_permission' => 0,
            ),
            460 =>
            array (
                'id' => 2941,
                'user_group_id' => 5,
                'action' => 'subject/create',
                'has_permission' => 0,
            ),
            461 =>
            array (
                'id' => 2942,
                'user_group_id' => 5,
                'action' => 'subject/edit',
                'has_permission' => 0,
            ),
            462 =>
            array (
                'id' => 2943,
                'user_group_id' => 5,
                'action' => 'subject/view',
                'has_permission' => 0,
            ),
            463 =>
            array (
                'id' => 2944,
                'user_group_id' => 5,
                'action' => 'subject_group',
                'has_permission' => 0,
            ),
            464 =>
            array (
                'id' => 2945,
                'user_group_id' => 5,
                'action' => 'subject_group/index',
                'has_permission' => 0,
            ),
            465 =>
            array (
                'id' => 2946,
                'user_group_id' => 5,
                'action' => 'subject_group/create',
                'has_permission' => 0,
            ),
            466 =>
            array (
                'id' => 2947,
                'user_group_id' => 5,
                'action' => 'subject_group/edit',
                'has_permission' => 0,
            ),
            467 =>
            array (
                'id' => 2948,
                'user_group_id' => 5,
                'action' => 'subject_group/view',
                'has_permission' => 0,
            ),
            468 =>
            array (
                'id' => 2949,
                'user_group_id' => 5,
                'action' => 'topic_head',
                'has_permission' => 0,
            ),
            469 =>
            array (
                'id' => 2950,
                'user_group_id' => 5,
                'action' => 'topic_head/index',
                'has_permission' => 0,
            ),
            470 =>
            array (
                'id' => 2951,
                'user_group_id' => 5,
                'action' => 'topic_head/create',
                'has_permission' => 0,
            ),
            471 =>
            array (
                'id' => 2952,
                'user_group_id' => 5,
                'action' => 'topic_head/edit',
                'has_permission' => 0,
            ),
            472 =>
            array (
                'id' => 2953,
                'user_group_id' => 5,
                'action' => 'topic_head/view',
                'has_permission' => 0,
            ),
            473 =>
            array (
                'id' => 2954,
                'user_group_id' => 5,
                'action' => 'topic',
                'has_permission' => 0,
            ),
            474 =>
            array (
                'id' => 2955,
                'user_group_id' => 5,
                'action' => 'topic/index',
                'has_permission' => 0,
            ),
            475 =>
            array (
                'id' => 2956,
                'user_group_id' => 5,
                'action' => 'topic/create',
                'has_permission' => 0,
            ),
            476 =>
            array (
                'id' => 2957,
                'user_group_id' => 5,
                'action' => 'topic/edit',
                'has_permission' => 0,
            ),
            477 =>
            array (
                'id' => 2958,
                'user_group_id' => 5,
                'action' => 'topic/view',
                'has_permission' => 0,
            ),
            478 =>
            array (
                'id' => 2959,
                'user_group_id' => 5,
                'action' => 'cards',
                'has_permission' => 0,
            ),
            479 =>
            array (
                'id' => 2960,
                'user_group_id' => 5,
                'action' => 'cards/index',
                'has_permission' => 0,
            ),
            480 =>
            array (
                'id' => 2961,
                'user_group_id' => 5,
                'action' => 'cards/create',
                'has_permission' => 0,
            ),
            481 =>
            array (
                'id' => 2962,
                'user_group_id' => 5,
                'action' => 'cards/edit',
                'has_permission' => 0,
            ),
            482 =>
            array (
                'id' => 2963,
                'user_group_id' => 5,
                'action' => 'cards/view',
                'has_permission' => 0,
            ),
            483 =>
            array (
                'id' => 2964,
                'user_group_id' => 5,
                'action' => 'card_items',
                'has_permission' => 0,
            ),
            484 =>
            array (
                'id' => 2965,
                'user_group_id' => 5,
                'action' => 'card_items/index',
                'has_permission' => 0,
            ),
            485 =>
            array (
                'id' => 2966,
                'user_group_id' => 5,
                'action' => 'card_items/create',
                'has_permission' => 0,
            ),
            486 =>
            array (
                'id' => 2967,
                'user_group_id' => 5,
                'action' => 'card_items/edit',
                'has_permission' => 0,
            ),
            487 =>
            array (
                'id' => 2968,
                'user_group_id' => 5,
                'action' => 'card_items/view',
                'has_permission' => 0,
            ),
            488 =>
            array (
                'id' => 2969,
                'user_group_id' => 5,
                'action' => 'book',
                'has_permission' => 1,
            ),
            489 =>
            array (
                'id' => 2970,
                'user_group_id' => 5,
                'action' => 'book/index',
                'has_permission' => 1,
            ),
            490 =>
            array (
                'id' => 2971,
                'user_group_id' => 5,
                'action' => 'book/create',
                'has_permission' => 0,
            ),
            491 =>
            array (
                'id' => 2972,
                'user_group_id' => 5,
                'action' => 'book/edit',
                'has_permission' => 0,
            ),
            492 =>
            array (
                'id' => 2973,
                'user_group_id' => 5,
                'action' => 'book/view',
                'has_permission' => 1,
            ),
            493 =>
            array (
                'id' => 2974,
                'user_group_id' => 5,
                'action' => 'teacher',
                'has_permission' => 1,
            ),
            494 =>
            array (
                'id' => 2975,
                'user_group_id' => 5,
                'action' => 'teacher/index',
                'has_permission' => 1,
            ),
            495 =>
            array (
                'id' => 2976,
                'user_group_id' => 5,
                'action' => 'teacher/create',
                'has_permission' => 0,
            ),
            496 =>
            array (
                'id' => 2977,
                'user_group_id' => 5,
                'action' => 'teacher/edit',
                'has_permission' => 0,
            ),
            497 =>
            array (
                'id' => 2978,
                'user_group_id' => 5,
                'action' => 'teacher/view',
                'has_permission' => 1,
            ),
            498 =>
            array (
                'id' => 2979,
                'user_group_id' => 5,
                'action' => 'teacher/password',
                'has_permission' => 0,
            ),
            499 =>
            array (
                'id' => 2980,
                'user_group_id' => 5,
                'action' => 'class_routine',
                'has_permission' => 0,
            ),
        ));
        \DB::table('user_group_permissions')->insert(array (
            0 =>
            array (
                'id' => 2981,
                'user_group_id' => 5,
                'action' => 'class_routine/index',
                'has_permission' => 0,
            ),
            1 =>
            array (
                'id' => 2982,
                'user_group_id' => 5,
                'action' => 'class_routine/create',
                'has_permission' => 0,
            ),
            2 =>
            array (
                'id' => 2983,
                'user_group_id' => 5,
                'action' => 'class_routine/edit',
                'has_permission' => 0,
            ),
            3 =>
            array (
                'id' => 2984,
                'user_group_id' => 5,
                'action' => 'class_routine/view',
                'has_permission' => 0,
            ),
            4 =>
            array (
                'id' => 2985,
                'user_group_id' => 5,
                'action' => 'attendance',
                'has_permission' => 1,
            ),
            5 =>
            array (
                'id' => 2986,
                'user_group_id' => 5,
                'action' => 'attendance/index',
                'has_permission' => 1,
            ),
            6 =>
            array (
                'id' => 2987,
                'user_group_id' => 5,
                'action' => 'attendance/create',
                'has_permission' => 0,
            ),
            7 =>
            array (
                'id' => 2988,
                'user_group_id' => 5,
                'action' => 'attendance/edit',
                'has_permission' => 0,
            ),
            8 =>
            array (
                'id' => 2989,
                'user_group_id' => 5,
                'action' => 'attendance/view',
                'has_permission' => 1,
            ),
            9 =>
            array (
                'id' => 2990,
                'user_group_id' => 5,
                'action' => 'payment',
                'has_permission' => 1,
            ),
            10 =>
            array (
                'id' => 2991,
                'user_group_id' => 5,
                'action' => 'generate_fee',
                'has_permission' => 1,
            ),
            11 =>
            array (
                'id' => 2992,
                'user_group_id' => 5,
                'action' => 'generate_fee/index',
                'has_permission' => 1,
            ),
            12 =>
            array (
                'id' => 2993,
                'user_group_id' => 5,
                'action' => 'generate_fee/create',
                'has_permission' => 0,
            ),
            13 =>
            array (
                'id' => 2994,
                'user_group_id' => 5,
                'action' => 'generate_fee/edit',
                'has_permission' => 0,
            ),
            14 =>
            array (
                'id' => 2995,
                'user_group_id' => 5,
                'action' => 'generate_fee/view',
                'has_permission' => 1,
            ),
            15 =>
            array (
                'id' => 2996,
                'user_group_id' => 5,
                'action' => 'collect_fee',
                'has_permission' => 1,
            ),
            16 =>
            array (
                'id' => 2997,
                'user_group_id' => 5,
                'action' => 'collect_fee/index',
                'has_permission' => 1,
            ),
            17 =>
            array (
                'id' => 2998,
                'user_group_id' => 5,
                'action' => 'collect_fee/create',
                'has_permission' => 0,
            ),
            18 =>
            array (
                'id' => 2999,
                'user_group_id' => 5,
                'action' => 'collect_fee/edit',
                'has_permission' => 0,
            ),
            19 =>
            array (
                'id' => 3000,
                'user_group_id' => 5,
                'action' => 'collect_fee/view',
                'has_permission' => 1,
            ),
            20 =>
            array (
                'id' => 3001,
                'user_group_id' => 5,
                'action' => 'student_payment',
                'has_permission' => 1,
            ),
            21 =>
            array (
                'id' => 3002,
                'user_group_id' => 5,
                'action' => 'student_payment/index',
                'has_permission' => 1,
            ),
            22 =>
            array (
                'id' => 3003,
                'user_group_id' => 5,
                'action' => 'student_payment/edit',
                'has_permission' => 0,
            ),
            23 =>
            array (
                'id' => 3004,
                'user_group_id' => 5,
                'action' => 'student_payment/view',
                'has_permission' => 1,
            ),
            24 =>
            array (
                'id' => 3005,
                'user_group_id' => 5,
                'action' => 'reports',
                'has_permission' => 1,
            ),
            25 =>
            array (
                'id' => 3006,
                'user_group_id' => 5,
                'action' => 'report_admission',
                'has_permission' => 0,
            ),
            26 =>
            array (
                'id' => 3007,
                'user_group_id' => 5,
                'action' => 'report_admission/all',
                'has_permission' => 0,
            ),
            27 =>
            array (
                'id' => 3008,
                'user_group_id' => 5,
                'action' => 'report_attendance',
                'has_permission' => 0,
            ),
            28 =>
            array (
                'id' => 3009,
                'user_group_id' => 5,
                'action' => 'report_attendance/all',
                'has_permission' => 0,
            ),
            29 =>
            array (
                'id' => 3010,
                'user_group_id' => 5,
                'action' => 'report_attendance_by_term',
                'has_permission' => 0,
            ),
            30 =>
            array (
                'id' => 3011,
                'user_group_id' => 5,
                'action' => 'report_attendance_by_term/all',
                'has_permission' => 0,
            ),
            31 =>
            array (
                'id' => 3012,
                'user_group_id' => 5,
                'action' => 'report_attendance_by_phase',
                'has_permission' => 0,
            ),
            32 =>
            array (
                'id' => 3013,
                'user_group_id' => 5,
                'action' => 'report_attendance_by_phase/all',
                'has_permission' => 0,
            ),
            33 =>
            array (
                'id' => 3014,
                'user_group_id' => 5,
                'action' => 'report_attendance_by_student',
                'has_permission' => 1,
            ),
            34 =>
            array (
                'id' => 3015,
                'user_group_id' => 5,
                'action' => 'report_attendance_by_student/all',
                'has_permission' => 1,
            ),
            35 =>
            array (
                'id' => 3016,
                'user_group_id' => 5,
                'action' => 'report_exam_result',
                'has_permission' => 0,
            ),
            36 =>
            array (
                'id' => 3017,
                'user_group_id' => 5,
                'action' => 'report_exam_result/all',
                'has_permission' => 0,
            ),
            37 =>
            array (
                'id' => 3018,
                'user_group_id' => 5,
                'action' => 'report_exam_result_phase',
                'has_permission' => 0,
            ),
            38 =>
            array (
                'id' => 3019,
                'user_group_id' => 5,
                'action' => 'report_exam_result_phase/all',
                'has_permission' => 0,
            ),
            39 =>
            array (
                'id' => 3020,
                'user_group_id' => 5,
                'action' => 'report_exam_result_student',
                'has_permission' => 1,
            ),
            40 =>
            array (
                'id' => 3021,
                'user_group_id' => 5,
                'action' => 'report_exam_result_student/all',
                'has_permission' => 1,
            ),
            41 =>
            array (
                'id' => 3022,
                'user_group_id' => 5,
                'action' => 'report_student_payment',
                'has_permission' => 1,
            ),
            42 =>
            array (
                'id' => 3023,
                'user_group_id' => 5,
                'action' => 'report_student_payment/all',
                'has_permission' => 1,
            ),
            43 =>
            array (
                'id' => 3024,
                'user_group_id' => 5,
                'action' => 'report_student_list',
                'has_permission' => 0,
            ),
            44 =>
            array (
                'id' => 3025,
                'user_group_id' => 5,
                'action' => 'report_student_list/all',
                'has_permission' => 0,
            ),
            45 =>
            array (
                'id' => 3026,
                'user_group_id' => 5,
                'action' => 'report_teacher_list',
                'has_permission' => 0,
            ),
            46 =>
            array (
                'id' => 3027,
                'user_group_id' => 5,
                'action' => 'report_teacher_list/all',
                'has_permission' => 0,
            ),
            47 =>
            array (
                'id' => 3028,
                'user_group_id' => 5,
                'action' => 'notice_board',
                'has_permission' => 1,
            ),
            48 =>
            array (
                'id' => 3029,
                'user_group_id' => 5,
                'action' => 'notice_board/index',
                'has_permission' => 1,
            ),
            49 =>
            array (
                'id' => 3030,
                'user_group_id' => 5,
                'action' => 'notice_board/create',
                'has_permission' => 0,
            ),
            50 =>
            array (
                'id' => 3031,
                'user_group_id' => 5,
                'action' => 'notice_board/edit',
                'has_permission' => 0,
            ),
            51 =>
            array (
                'id' => 3032,
                'user_group_id' => 5,
                'action' => 'notice_board/view',
                'has_permission' => 1,
            ),
            52 =>
            array (
                'id' => 3033,
                'user_group_id' => 5,
                'action' => 'holiday',
                'has_permission' => 1,
            ),
            53 =>
            array (
                'id' => 3034,
                'user_group_id' => 5,
                'action' => 'holiday/index',
                'has_permission' => 1,
            ),
            54 =>
            array (
                'id' => 3035,
                'user_group_id' => 5,
                'action' => 'holiday/create',
                'has_permission' => 0,
            ),
            55 =>
            array (
                'id' => 3036,
                'user_group_id' => 5,
                'action' => 'holiday/edit',
                'has_permission' => 0,
            ),
            56 =>
            array (
                'id' => 3037,
                'user_group_id' => 5,
                'action' => 'holiday/view',
                'has_permission' => 1,
            ),
            57 =>
            array (
                'id' => 3038,
                'user_group_id' => 5,
                'action' => 'message',
                'has_permission' => 1,
            ),
            58 =>
            array (
                'id' => 3039,
                'user_group_id' => 5,
                'action' => 'message/index',
                'has_permission' => 1,
            ),
            59 =>
            array (
                'id' => 3040,
                'user_group_id' => 5,
                'action' => 'message/create',
                'has_permission' => 1,
            ),
            60 =>
            array (
                'id' => 3041,
                'user_group_id' => 5,
                'action' => 'message/edit',
                'has_permission' => 1,
            ),
            61 =>
            array (
                'id' => 3042,
                'user_group_id' => 5,
                'action' => 'message/view',
                'has_permission' => 1,
            ),
            62 =>
            array (
                'id' => 3043,
                'user_group_id' => 5,
                'action' => 'setting',
                'has_permission' => 0,
            ),
            63 =>
            array (
                'id' => 3044,
                'user_group_id' => 5,
                'action' => 'attachment_type',
                'has_permission' => 1,
            ),
            64 =>
            array (
                'id' => 3045,
                'user_group_id' => 5,
                'action' => 'attachment_type/index',
                'has_permission' => 1,
            ),
            65 =>
            array (
                'id' => 3046,
                'user_group_id' => 5,
                'action' => 'attachment_type/create',
                'has_permission' => 0,
            ),
            66 =>
            array (
                'id' => 3047,
                'user_group_id' => 5,
                'action' => 'attachment_type/edit',
                'has_permission' => 0,
            ),
            67 =>
            array (
                'id' => 3048,
                'user_group_id' => 5,
                'action' => 'attachment_type/view',
                'has_permission' => 1,
            ),
            68 =>
            array (
                'id' => 3049,
                'user_group_id' => 5,
                'action' => 'student_category',
                'has_permission' => 0,
            ),
            69 =>
            array (
                'id' => 3050,
                'user_group_id' => 5,
                'action' => 'student_category/index',
                'has_permission' => 0,
            ),
            70 =>
            array (
                'id' => 3051,
                'user_group_id' => 5,
                'action' => 'student_category/create',
                'has_permission' => 0,
            ),
            71 =>
            array (
                'id' => 3052,
                'user_group_id' => 5,
                'action' => 'student_category/edit',
                'has_permission' => 0,
            ),
            72 =>
            array (
                'id' => 3053,
                'user_group_id' => 5,
                'action' => 'student_category/view',
                'has_permission' => 0,
            ),
            73 =>
            array (
                'id' => 3054,
                'user_group_id' => 5,
                'action' => 'student_group',
                'has_permission' => 0,
            ),
            74 =>
            array (
                'id' => 3055,
                'user_group_id' => 5,
                'action' => 'student_group/index',
                'has_permission' => 0,
            ),
            75 =>
            array (
                'id' => 3056,
                'user_group_id' => 5,
                'action' => 'student_group/create',
                'has_permission' => 0,
            ),
            76 =>
            array (
                'id' => 3057,
                'user_group_id' => 5,
                'action' => 'student_group/edit',
                'has_permission' => 0,
            ),
            77 =>
            array (
                'id' => 3058,
                'user_group_id' => 5,
                'action' => 'student_group/view',
                'has_permission' => 0,
            ),
            78 =>
            array (
                'id' => 3059,
                'user_group_id' => 5,
                'action' => 'term',
                'has_permission' => 0,
            ),
            79 =>
            array (
                'id' => 3060,
                'user_group_id' => 5,
                'action' => 'term/index',
                'has_permission' => 0,
            ),
            80 =>
            array (
                'id' => 3061,
                'user_group_id' => 5,
                'action' => 'term/create',
                'has_permission' => 0,
            ),
            81 =>
            array (
                'id' => 3062,
                'user_group_id' => 5,
                'action' => 'term/edit',
                'has_permission' => 0,
            ),
            82 =>
            array (
                'id' => 3063,
                'user_group_id' => 5,
                'action' => 'term/view',
                'has_permission' => 0,
            ),
            83 =>
            array (
                'id' => 3064,
                'user_group_id' => 5,
                'action' => 'phase',
                'has_permission' => 0,
            ),
            84 =>
            array (
                'id' => 3065,
                'user_group_id' => 5,
                'action' => 'phase/index',
                'has_permission' => 0,
            ),
            85 =>
            array (
                'id' => 3066,
                'user_group_id' => 5,
                'action' => 'phase/create',
                'has_permission' => 0,
            ),
            86 =>
            array (
                'id' => 3067,
                'user_group_id' => 5,
                'action' => 'phase/edit',
                'has_permission' => 0,
            ),
            87 =>
            array (
                'id' => 3068,
                'user_group_id' => 5,
                'action' => 'phase/view',
                'has_permission' => 0,
            ),
            88 =>
            array (
                'id' => 3069,
                'user_group_id' => 5,
                'action' => 'designation',
                'has_permission' => 0,
            ),
            89 =>
            array (
                'id' => 3070,
                'user_group_id' => 5,
                'action' => 'designation/index',
                'has_permission' => 0,
            ),
            90 =>
            array (
                'id' => 3071,
                'user_group_id' => 5,
                'action' => 'designation/create',
                'has_permission' => 0,
            ),
            91 =>
            array (
                'id' => 3072,
                'user_group_id' => 5,
                'action' => 'designation/edit',
                'has_permission' => 0,
            ),
            92 =>
            array (
                'id' => 3073,
                'user_group_id' => 5,
                'action' => 'designation/view',
                'has_permission' => 0,
            ),
            93 =>
            array (
                'id' => 3074,
                'user_group_id' => 5,
                'action' => 'department',
                'has_permission' => 0,
            ),
            94 =>
            array (
                'id' => 3075,
                'user_group_id' => 5,
                'action' => 'department/index',
                'has_permission' => 0,
            ),
            95 =>
            array (
                'id' => 3076,
                'user_group_id' => 5,
                'action' => 'department/create',
                'has_permission' => 0,
            ),
            96 =>
            array (
                'id' => 3077,
                'user_group_id' => 5,
                'action' => 'department/edit',
                'has_permission' => 0,
            ),
            97 =>
            array (
                'id' => 3078,
                'user_group_id' => 5,
                'action' => 'department/view',
                'has_permission' => 0,
            ),
            98 =>
            array (
                'id' => 3079,
                'user_group_id' => 5,
                'action' => 'course',
                'has_permission' => 0,
            ),
            99 =>
            array (
                'id' => 3080,
                'user_group_id' => 5,
                'action' => 'course/index',
                'has_permission' => 0,
            ),
            100 =>
            array (
                'id' => 3081,
                'user_group_id' => 5,
                'action' => 'course/create',
                'has_permission' => 0,
            ),
            101 =>
            array (
                'id' => 3082,
                'user_group_id' => 5,
                'action' => 'course/edit',
                'has_permission' => 0,
            ),
            102 =>
            array (
                'id' => 3083,
                'user_group_id' => 5,
                'action' => 'course/view',
                'has_permission' => 0,
            ),
            103 =>
            array (
                'id' => 3084,
                'user_group_id' => 5,
                'action' => 'class_type',
                'has_permission' => 0,
            ),
            104 =>
            array (
                'id' => 3085,
                'user_group_id' => 5,
                'action' => 'class_type/index',
                'has_permission' => 0,
            ),
            105 =>
            array (
                'id' => 3086,
                'user_group_id' => 5,
                'action' => 'class_type/create',
                'has_permission' => 0,
            ),
            106 =>
            array (
                'id' => 3087,
                'user_group_id' => 5,
                'action' => 'class_type/edit',
                'has_permission' => 0,
            ),
            107 =>
            array (
                'id' => 3088,
                'user_group_id' => 5,
                'action' => 'class_type/view',
                'has_permission' => 0,
            ),
            108 =>
            array (
                'id' => 3089,
                'user_group_id' => 5,
                'action' => 'education_board',
                'has_permission' => 0,
            ),
            109 =>
            array (
                'id' => 3090,
                'user_group_id' => 5,
                'action' => 'education_board/index',
                'has_permission' => 0,
            ),
            110 =>
            array (
                'id' => 3091,
                'user_group_id' => 5,
                'action' => 'education_board/create',
                'has_permission' => 0,
            ),
            111 =>
            array (
                'id' => 3092,
                'user_group_id' => 5,
                'action' => 'education_board/edit',
                'has_permission' => 0,
            ),
            112 =>
            array (
                'id' => 3093,
                'user_group_id' => 5,
                'action' => 'education_board/view',
                'has_permission' => 0,
            ),
            113 =>
            array (
                'id' => 3094,
                'user_group_id' => 5,
                'action' => 'bank',
                'has_permission' => 0,
            ),
            114 =>
            array (
                'id' => 3095,
                'user_group_id' => 5,
                'action' => 'bank/index',
                'has_permission' => 0,
            ),
            115 =>
            array (
                'id' => 3096,
                'user_group_id' => 5,
                'action' => 'bank/create',
                'has_permission' => 0,
            ),
            116 =>
            array (
                'id' => 3097,
                'user_group_id' => 5,
                'action' => 'bank/edit',
                'has_permission' => 0,
            ),
            117 =>
            array (
                'id' => 3098,
                'user_group_id' => 5,
                'action' => 'payment_type',
                'has_permission' => 0,
            ),
            118 =>
            array (
                'id' => 3099,
                'user_group_id' => 5,
                'action' => 'payment_type/index',
                'has_permission' => 0,
            ),
            119 =>
            array (
                'id' => 3100,
                'user_group_id' => 5,
                'action' => 'payment_type/create',
                'has_permission' => 0,
            ),
            120 =>
            array (
                'id' => 3101,
                'user_group_id' => 5,
                'action' => 'payment_type/edit',
                'has_permission' => 0,
            ),
            121 =>
            array (
                'id' => 3102,
                'user_group_id' => 5,
                'action' => 'payment_type/view',
                'has_permission' => 0,
            ),
            122 =>
            array (
                'id' => 3103,
                'user_group_id' => 5,
                'action' => 'payment_method',
                'has_permission' => 0,
            ),
            123 =>
            array (
                'id' => 3104,
                'user_group_id' => 5,
                'action' => 'payment_method/index',
                'has_permission' => 0,
            ),
            124 =>
            array (
                'id' => 3105,
                'user_group_id' => 5,
                'action' => 'payment_method/create',
                'has_permission' => 0,
            ),
            125 =>
            array (
                'id' => 3106,
                'user_group_id' => 5,
                'action' => 'payment_method/edit',
                'has_permission' => 0,
            ),
            126 =>
            array (
                'id' => 3107,
                'user_group_id' => 5,
                'action' => 'payment_detail',
                'has_permission' => 1,
            ),
            127 =>
            array (
                'id' => 3108,
                'user_group_id' => 5,
                'action' => 'payment_detail/index',
                'has_permission' => 1,
            ),
            128 =>
            array (
                'id' => 3109,
                'user_group_id' => 5,
                'action' => 'payment_detail/create',
                'has_permission' => 0,
            ),
            129 =>
            array (
                'id' => 3110,
                'user_group_id' => 5,
                'action' => 'payment_detail/edit',
                'has_permission' => 0,
            ),
            130 =>
            array (
                'id' => 3111,
                'user_group_id' => 5,
                'action' => 'payment_detail/view',
                'has_permission' => 1,
            ),
            131 =>
            array (
                'id' => 3112,
                'user_group_id' => 5,
                'action' => 'hall',
                'has_permission' => 1,
            ),
            132 =>
            array (
                'id' => 3113,
                'user_group_id' => 5,
                'action' => 'hall/index',
                'has_permission' => 1,
            ),
            133 =>
            array (
                'id' => 3114,
                'user_group_id' => 5,
                'action' => 'hall/create',
                'has_permission' => 0,
            ),
            134 =>
            array (
                'id' => 3115,
                'user_group_id' => 5,
                'action' => 'hall/edit',
                'has_permission' => 0,
            ),
            135 =>
            array (
                'id' => 3116,
                'user_group_id' => 5,
                'action' => 'hall/view',
                'has_permission' => 1,
            ),
            136 =>
            array (
                'id' => 3117,
                'user_group_id' => 5,
                'action' => 'application_setting',
                'has_permission' => 0,
            ),
            137 =>
            array (
                'id' => 3118,
                'user_group_id' => 5,
                'action' => 'application_setting/index',
                'has_permission' => 0,
            ),
            138 =>
            array (
                'id' => 3119,
                'user_group_id' => 5,
                'action' => 'application_setting/create',
                'has_permission' => 0,
            ),
            139 =>
            array (
                'id' => 3120,
                'user_group_id' => 5,
                'action' => 'application_setting/edit',
                'has_permission' => 0,
            ),
            140 =>
            array (
                'id' => 3121,
                'user_group_id' => 5,
                'action' => 'application_setting/view',
                'has_permission' => 0,
            ),
            141 =>
            array (
                'id' => 3122,
                'user_group_id' => 5,
                'action' => 'logout',
                'has_permission' => 1,
            ),
            142 =>
            array (
                'id' => 3123,
                'user_group_id' => 5,
                'action' => 'logout/index',
                'has_permission' => 1,
            ),
            143 =>
            array (
                'id' => 3385,
                'user_group_id' => 1,
                'action' => 'dashboard',
                'has_permission' => 1,
            ),
            144 =>
            array (
                'id' => 3386,
                'user_group_id' => 1,
                'action' => 'dashboard/index',
                'has_permission' => 1,
            ),
            145 =>
            array (
                'id' => 3387,
                'user_group_id' => 1,
                'action' => 'admission_management',
                'has_permission' => 1,
            ),
            146 =>
            array (
                'id' => 3388,
                'user_group_id' => 1,
                'action' => 'admission',
                'has_permission' => 1,
            ),
            147 =>
            array (
                'id' => 3389,
                'user_group_id' => 1,
                'action' => 'admission/index',
                'has_permission' => 1,
            ),
            148 =>
            array (
                'id' => 3390,
                'user_group_id' => 1,
                'action' => 'admission/create',
                'has_permission' => 1,
            ),
            149 =>
            array (
                'id' => 3391,
                'user_group_id' => 1,
                'action' => 'admission/edit',
                'has_permission' => 1,
            ),
            150 =>
            array (
                'id' => 3392,
                'user_group_id' => 1,
                'action' => 'admission/view',
                'has_permission' => 1,
            ),
            151 =>
            array (
                'id' => 3393,
                'user_group_id' => 1,
                'action' => 'students',
                'has_permission' => 1,
            ),
            152 =>
            array (
                'id' => 3394,
                'user_group_id' => 1,
                'action' => 'students/index',
                'has_permission' => 1,
            ),
            153 =>
            array (
                'id' => 3395,
                'user_group_id' => 1,
                'action' => 'students/create',
                'has_permission' => 1,
            ),
            154 =>
            array (
                'id' => 3396,
                'user_group_id' => 1,
                'action' => 'students/edit',
                'has_permission' => 1,
            ),
            155 =>
            array (
                'id' => 3397,
                'user_group_id' => 1,
                'action' => 'students/view',
                'has_permission' => 1,
            ),
            156 =>
            array (
                'id' => 3398,
                'user_group_id' => 1,
                'action' => 'students/installment',
                'has_permission' => 1,
            ),
            157 =>
            array (
                'id' => 3399,
                'user_group_id' => 1,
                'action' => 'guardians',
                'has_permission' => 1,
            ),
            158 =>
            array (
                'id' => 3400,
                'user_group_id' => 1,
                'action' => 'guardians/index',
                'has_permission' => 1,
            ),
            159 =>
            array (
                'id' => 3401,
                'user_group_id' => 1,
                'action' => 'guardians/edit',
                'has_permission' => 1,
            ),
            160 =>
            array (
                'id' => 3402,
                'user_group_id' => 1,
                'action' => 'guardians/password',
                'has_permission' => 1,
            ),
            161 =>
            array (
                'id' => 3403,
                'user_group_id' => 1,
                'action' => 'guardians/view',
                'has_permission' => 1,
            ),
            162 =>
            array (
                'id' => 3404,
                'user_group_id' => 1,
                'action' => 'sessions',
                'has_permission' => 1,
            ),
            163 =>
            array (
                'id' => 3405,
                'user_group_id' => 1,
                'action' => 'sessions/index',
                'has_permission' => 1,
            ),
            164 =>
            array (
                'id' => 3406,
                'user_group_id' => 1,
                'action' => 'sessions/create',
                'has_permission' => 1,
            ),
            165 =>
            array (
                'id' => 3407,
                'user_group_id' => 1,
                'action' => 'sessions/edit',
                'has_permission' => 1,
            ),
            166 =>
            array (
                'id' => 3408,
                'user_group_id' => 1,
                'action' => 'sessions/view',
                'has_permission' => 1,
            ),
            167 =>
            array (
                'id' => 3409,
                'user_group_id' => 1,
                'action' => 'user_management',
                'has_permission' => 1,
            ),
            168 =>
            array (
                'id' => 3410,
                'user_group_id' => 1,
                'action' => 'users',
                'has_permission' => 1,
            ),
            169 =>
            array (
                'id' => 3411,
                'user_group_id' => 1,
                'action' => 'users/index',
                'has_permission' => 1,
            ),
            170 =>
            array (
                'id' => 3412,
                'user_group_id' => 1,
                'action' => 'users/create',
                'has_permission' => 1,
            ),
            171 =>
            array (
                'id' => 3413,
                'user_group_id' => 1,
                'action' => 'users/edit',
                'has_permission' => 1,
            ),
            172 =>
            array (
                'id' => 3414,
                'user_group_id' => 1,
                'action' => 'users/view',
                'has_permission' => 1,
            ),
            173 =>
            array (
                'id' => 3415,
                'user_group_id' => 1,
                'action' => 'user_groups',
                'has_permission' => 1,
            ),
            174 =>
            array (
                'id' => 3416,
                'user_group_id' => 1,
                'action' => 'user_groups/index',
                'has_permission' => 1,
            ),
            175 =>
            array (
                'id' => 3417,
                'user_group_id' => 1,
                'action' => 'user_groups/create',
                'has_permission' => 1,
            ),
            176 =>
            array (
                'id' => 3418,
                'user_group_id' => 1,
                'action' => 'user_groups/edit',
                'has_permission' => 1,
            ),
            177 =>
            array (
                'id' => 3419,
                'user_group_id' => 1,
                'action' => 'user_groups/permission',
                'has_permission' => 1,
            ),
            178 =>
            array (
                'id' => 3420,
                'user_group_id' => 1,
                'action' => 'lecture_material',
                'has_permission' => 1,
            ),
            179 =>
            array (
                'id' => 3421,
                'user_group_id' => 1,
                'action' => 'lecture_material/index',
                'has_permission' => 1,
            ),
            180 =>
            array (
                'id' => 3422,
                'user_group_id' => 1,
                'action' => 'lecture_material/create',
                'has_permission' => 1,
            ),
            181 =>
            array (
                'id' => 3423,
                'user_group_id' => 1,
                'action' => 'lecture_material/edit',
                'has_permission' => 1,
            ),
            182 =>
            array (
                'id' => 3424,
                'user_group_id' => 1,
                'action' => 'lecture_material/view',
                'has_permission' => 1,
            ),
            183 =>
            array (
                'id' => 3425,
                'user_group_id' => 1,
                'action' => 'academic_calendar',
                'has_permission' => 1,
            ),
            184 =>
            array (
                'id' => 3426,
                'user_group_id' => 1,
                'action' => 'academic_calendar/index',
                'has_permission' => 1,
            ),
            185 =>
            array (
                'id' => 3427,
                'user_group_id' => 1,
                'action' => 'exam',
                'has_permission' => 1,
            ),
            186 =>
            array (
                'id' => 3428,
                'user_group_id' => 1,
                'action' => 'exams',
                'has_permission' => 1,
            ),
            187 =>
            array (
                'id' => 3429,
                'user_group_id' => 1,
                'action' => 'exams/index',
                'has_permission' => 1,
            ),
            188 =>
            array (
                'id' => 3430,
                'user_group_id' => 1,
                'action' => 'exams/create',
                'has_permission' => 1,
            ),
            189 =>
            array (
                'id' => 3431,
                'user_group_id' => 1,
                'action' => 'exams/edit',
                'has_permission' => 1,
            ),
            190 =>
            array (
                'id' => 3432,
                'user_group_id' => 1,
                'action' => 'exams/view',
                'has_permission' => 1,
            ),
            191 =>
            array (
                'id' => 3433,
                'user_group_id' => 1,
                'action' => 'result',
                'has_permission' => 1,
            ),
            192 =>
            array (
                'id' => 3434,
                'user_group_id' => 1,
                'action' => 'result/index',
                'has_permission' => 1,
            ),
            193 =>
            array (
                'id' => 3435,
                'user_group_id' => 1,
                'action' => 'result/create',
                'has_permission' => 1,
            ),
            194 =>
            array (
                'id' => 3436,
                'user_group_id' => 1,
                'action' => 'result/edit',
                'has_permission' => 1,
            ),
            195 =>
            array (
                'id' => 3437,
                'user_group_id' => 1,
                'action' => 'result/view',
                'has_permission' => 1,
            ),
            196 =>
            array (
                'id' => 3438,
                'user_group_id' => 1,
                'action' => 'exam_category',
                'has_permission' => 1,
            ),
            197 =>
            array (
                'id' => 3439,
                'user_group_id' => 1,
                'action' => 'exam_category/index',
                'has_permission' => 1,
            ),
            198 =>
            array (
                'id' => 3440,
                'user_group_id' => 1,
                'action' => 'exam_category/create',
                'has_permission' => 1,
            ),
            199 =>
            array (
                'id' => 3441,
                'user_group_id' => 1,
                'action' => 'exam_category/edit',
                'has_permission' => 1,
            ),
            200 =>
            array (
                'id' => 3442,
                'user_group_id' => 1,
                'action' => 'exam_category/view',
                'has_permission' => 1,
            ),
            201 =>
            array (
                'id' => 3443,
                'user_group_id' => 1,
                'action' => 'exam_type',
                'has_permission' => 1,
            ),
            202 =>
            array (
                'id' => 3444,
                'user_group_id' => 1,
                'action' => 'exam_type/index',
                'has_permission' => 1,
            ),
            203 =>
            array (
                'id' => 3445,
                'user_group_id' => 1,
                'action' => 'exam_type/create',
                'has_permission' => 1,
            ),
            204 =>
            array (
                'id' => 3446,
                'user_group_id' => 1,
                'action' => 'exam_type/edit',
                'has_permission' => 1,
            ),
            205 =>
            array (
                'id' => 3447,
                'user_group_id' => 1,
                'action' => 'exam_type/view',
                'has_permission' => 1,
            ),
            206 =>
            array (
                'id' => 3448,
                'user_group_id' => 1,
                'action' => 'exam_sub_type',
                'has_permission' => 1,
            ),
            207 =>
            array (
                'id' => 3449,
                'user_group_id' => 1,
                'action' => 'exam_sub_type/index',
                'has_permission' => 1,
            ),
            208 =>
            array (
                'id' => 3450,
                'user_group_id' => 1,
                'action' => 'exam_sub_type/create',
                'has_permission' => 1,
            ),
            209 =>
            array (
                'id' => 3451,
                'user_group_id' => 1,
                'action' => 'exam_sub_type/edit',
                'has_permission' => 1,
            ),
            210 =>
            array (
                'id' => 3452,
                'user_group_id' => 1,
                'action' => 'exam_sub_type/view',
                'has_permission' => 1,
            ),
            211 =>
            array (
                'id' => 3453,
                'user_group_id' => 1,
                'action' => 'student_progress',
                'has_permission' => 1,
            ),
            212 =>
            array (
                'id' => 3454,
                'user_group_id' => 1,
                'action' => 'student_progress_result',
                'has_permission' => 1,
            ),
            213 =>
            array (
                'id' => 3455,
                'user_group_id' => 1,
                'action' => 'student_progress_result/index',
                'has_permission' => 1,
            ),
            214 =>
            array (
                'id' => 3456,
                'user_group_id' => 1,
                'action' => 'student_progress_result/create',
                'has_permission' => 1,
            ),
            215 =>
            array (
                'id' => 3457,
                'user_group_id' => 1,
                'action' => 'subject',
                'has_permission' => 1,
            ),
            216 =>
            array (
                'id' => 3458,
                'user_group_id' => 1,
                'action' => 'subject',
                'has_permission' => 1,
            ),
            217 =>
            array (
                'id' => 3459,
                'user_group_id' => 1,
                'action' => 'subject/index',
                'has_permission' => 1,
            ),
            218 =>
            array (
                'id' => 3460,
                'user_group_id' => 1,
                'action' => 'subject/create',
                'has_permission' => 1,
            ),
            219 =>
            array (
                'id' => 3461,
                'user_group_id' => 1,
                'action' => 'subject/edit',
                'has_permission' => 1,
            ),
            220 =>
            array (
                'id' => 3462,
                'user_group_id' => 1,
                'action' => 'subject/view',
                'has_permission' => 1,
            ),
            221 =>
            array (
                'id' => 3463,
                'user_group_id' => 1,
                'action' => 'subject_group',
                'has_permission' => 1,
            ),
            222 =>
            array (
                'id' => 3464,
                'user_group_id' => 1,
                'action' => 'subject_group/index',
                'has_permission' => 1,
            ),
            223 =>
            array (
                'id' => 3465,
                'user_group_id' => 1,
                'action' => 'subject_group/create',
                'has_permission' => 1,
            ),
            224 =>
            array (
                'id' => 3466,
                'user_group_id' => 1,
                'action' => 'subject_group/edit',
                'has_permission' => 1,
            ),
            225 =>
            array (
                'id' => 3467,
                'user_group_id' => 1,
                'action' => 'subject_group/view',
                'has_permission' => 1,
            ),
            226 =>
            array (
                'id' => 3468,
                'user_group_id' => 1,
                'action' => 'topic_head',
                'has_permission' => 1,
            ),
            227 =>
            array (
                'id' => 3469,
                'user_group_id' => 1,
                'action' => 'topic_head/index',
                'has_permission' => 1,
            ),
            228 =>
            array (
                'id' => 3470,
                'user_group_id' => 1,
                'action' => 'topic_head/create',
                'has_permission' => 1,
            ),
            229 =>
            array (
                'id' => 3471,
                'user_group_id' => 1,
                'action' => 'topic_head/edit',
                'has_permission' => 1,
            ),
            230 =>
            array (
                'id' => 3472,
                'user_group_id' => 1,
                'action' => 'topic_head/view',
                'has_permission' => 1,
            ),
            231 =>
            array (
                'id' => 3473,
                'user_group_id' => 1,
                'action' => 'topic',
                'has_permission' => 1,
            ),
            232 =>
            array (
                'id' => 3474,
                'user_group_id' => 1,
                'action' => 'topic/index',
                'has_permission' => 1,
            ),
            233 =>
            array (
                'id' => 3475,
                'user_group_id' => 1,
                'action' => 'topic/create',
                'has_permission' => 1,
            ),
            234 =>
            array (
                'id' => 3476,
                'user_group_id' => 1,
                'action' => 'topic/edit',
                'has_permission' => 1,
            ),
            235 =>
            array (
                'id' => 3477,
                'user_group_id' => 1,
                'action' => 'topic/view',
                'has_permission' => 1,
            ),
            236 =>
            array (
                'id' => 3478,
                'user_group_id' => 1,
                'action' => 'cards',
                'has_permission' => 1,
            ),
            237 =>
            array (
                'id' => 3479,
                'user_group_id' => 1,
                'action' => 'cards/index',
                'has_permission' => 1,
            ),
            238 =>
            array (
                'id' => 3480,
                'user_group_id' => 1,
                'action' => 'cards/create',
                'has_permission' => 1,
            ),
            239 =>
            array (
                'id' => 3481,
                'user_group_id' => 1,
                'action' => 'cards/edit',
                'has_permission' => 1,
            ),
            240 =>
            array (
                'id' => 3482,
                'user_group_id' => 1,
                'action' => 'cards/view',
                'has_permission' => 1,
            ),
            241 =>
            array (
                'id' => 3483,
                'user_group_id' => 1,
                'action' => 'card_items',
                'has_permission' => 1,
            ),
            242 =>
            array (
                'id' => 3484,
                'user_group_id' => 1,
                'action' => 'card_items/index',
                'has_permission' => 1,
            ),
            243 =>
            array (
                'id' => 3485,
                'user_group_id' => 1,
                'action' => 'card_items/create',
                'has_permission' => 1,
            ),
            244 =>
            array (
                'id' => 3486,
                'user_group_id' => 1,
                'action' => 'card_items/edit',
                'has_permission' => 1,
            ),
            245 =>
            array (
                'id' => 3487,
                'user_group_id' => 1,
                'action' => 'card_items/view',
                'has_permission' => 1,
            ),
            246 =>
            array (
                'id' => 3488,
                'user_group_id' => 1,
                'action' => 'book',
                'has_permission' => 1,
            ),
            247 =>
            array (
                'id' => 3489,
                'user_group_id' => 1,
                'action' => 'book/index',
                'has_permission' => 1,
            ),
            248 =>
            array (
                'id' => 3490,
                'user_group_id' => 1,
                'action' => 'book/create',
                'has_permission' => 1,
            ),
            249 =>
            array (
                'id' => 3491,
                'user_group_id' => 1,
                'action' => 'book/edit',
                'has_permission' => 1,
            ),
            250 =>
            array (
                'id' => 3492,
                'user_group_id' => 1,
                'action' => 'book/view',
                'has_permission' => 1,
            ),
            251 =>
            array (
                'id' => 3493,
                'user_group_id' => 1,
                'action' => 'teacher',
                'has_permission' => 1,
            ),
            252 =>
            array (
                'id' => 3494,
                'user_group_id' => 1,
                'action' => 'teacher/index',
                'has_permission' => 1,
            ),
            253 =>
            array (
                'id' => 3495,
                'user_group_id' => 1,
                'action' => 'teacher/create',
                'has_permission' => 1,
            ),
            254 =>
            array (
                'id' => 3496,
                'user_group_id' => 1,
                'action' => 'teacher/edit',
                'has_permission' => 1,
            ),
            255 =>
            array (
                'id' => 3497,
                'user_group_id' => 1,
                'action' => 'teacher/view',
                'has_permission' => 1,
            ),
            256 =>
            array (
                'id' => 3498,
                'user_group_id' => 1,
                'action' => 'teacher/password',
                'has_permission' => 1,
            ),
            257 =>
            array (
                'id' => 3499,
                'user_group_id' => 1,
                'action' => 'class_routine',
                'has_permission' => 1,
            ),
            258 =>
            array (
                'id' => 3500,
                'user_group_id' => 1,
                'action' => 'class_routine',
                'has_permission' => 1,
            ),
            259 =>
            array (
                'id' => 3501,
                'user_group_id' => 1,
                'action' => 'class_routine/index',
                'has_permission' => 1,
            ),
            260 =>
            array (
                'id' => 3502,
                'user_group_id' => 1,
                'action' => 'class_routine/create',
                'has_permission' => 1,
            ),
            261 =>
            array (
                'id' => 3503,
                'user_group_id' => 1,
                'action' => 'class_routine/edit',
                'has_permission' => 1,
            ),
            262 =>
            array (
                'id' => 3504,
                'user_group_id' => 1,
                'action' => 'class_routine/view',
                'has_permission' => 1,
            ),
            263 =>
            array (
                'id' => 3505,
                'user_group_id' => 1,
                'action' => 'class_routine_calendar',
                'has_permission' => 1,
            ),
            264 =>
            array (
                'id' => 3506,
                'user_group_id' => 1,
                'action' => 'class_routine_calendar/index',
                'has_permission' => 1,
            ),
            265 =>
            array (
                'id' => 3507,
                'user_group_id' => 1,
                'action' => 'attendance',
                'has_permission' => 1,
            ),
            266 =>
            array (
                'id' => 3508,
                'user_group_id' => 1,
                'action' => 'attendance/index',
                'has_permission' => 1,
            ),
            267 =>
            array (
                'id' => 3509,
                'user_group_id' => 1,
                'action' => 'attendance/create',
                'has_permission' => 1,
            ),
            268 =>
            array (
                'id' => 3510,
                'user_group_id' => 1,
                'action' => 'attendance/edit',
                'has_permission' => 1,
            ),
            269 =>
            array (
                'id' => 3511,
                'user_group_id' => 1,
                'action' => 'attendance/view',
                'has_permission' => 1,
            ),
            270 =>
            array (
                'id' => 3512,
                'user_group_id' => 1,
                'action' => 'payment',
                'has_permission' => 1,
            ),
            271 =>
            array (
                'id' => 3513,
                'user_group_id' => 1,
                'action' => 'generate_fee',
                'has_permission' => 1,
            ),
            272 =>
            array (
                'id' => 3514,
                'user_group_id' => 1,
                'action' => 'generate_fee/index',
                'has_permission' => 1,
            ),
            273 =>
            array (
                'id' => 3515,
                'user_group_id' => 1,
                'action' => 'generate_fee/create',
                'has_permission' => 1,
            ),
            274 =>
            array (
                'id' => 3516,
                'user_group_id' => 1,
                'action' => 'generate_fee/edit',
                'has_permission' => 1,
            ),
            275 =>
            array (
                'id' => 3517,
                'user_group_id' => 1,
                'action' => 'generate_fee/view',
                'has_permission' => 1,
            ),
            276 =>
            array (
                'id' => 3518,
                'user_group_id' => 1,
                'action' => 'generate_tuition_fee',
                'has_permission' => 1,
            ),
            277 =>
            array (
                'id' => 3519,
                'user_group_id' => 1,
                'action' => 'generate_tuition_fee/index',
                'has_permission' => 1,
            ),
            278 =>
            array (
                'id' => 3520,
                'user_group_id' => 1,
                'action' => 'generate_tuition_fee/create',
                'has_permission' => 1,
            ),
            279 =>
            array (
                'id' => 3521,
                'user_group_id' => 1,
                'action' => 'generate_tuition_fee/edit',
                'has_permission' => 1,
            ),
            280 =>
            array (
                'id' => 3522,
                'user_group_id' => 1,
                'action' => 'generate_tuition_fee/view',
                'has_permission' => 1,
            ),
            281 =>
            array (
                'id' => 3523,
                'user_group_id' => 1,
                'action' => 'collect_fee',
                'has_permission' => 1,
            ),
            282 =>
            array (
                'id' => 3524,
                'user_group_id' => 1,
                'action' => 'collect_fee/index',
                'has_permission' => 1,
            ),
            283 =>
            array (
                'id' => 3525,
                'user_group_id' => 1,
                'action' => 'collect_fee/create',
                'has_permission' => 1,
            ),
            284 =>
            array (
                'id' => 3526,
                'user_group_id' => 1,
                'action' => 'collect_fee/edit',
                'has_permission' => 1,
            ),
            285 =>
            array (
                'id' => 3527,
                'user_group_id' => 1,
                'action' => 'collect_fee/view',
                'has_permission' => 1,
            ),
            286 =>
            array (
                'id' => 3528,
                'user_group_id' => 1,
                'action' => 'student_payment',
                'has_permission' => 1,
            ),
            287 =>
            array (
                'id' => 3529,
                'user_group_id' => 1,
                'action' => 'student_payment/index',
                'has_permission' => 1,
            ),
            288 =>
            array (
                'id' => 3530,
                'user_group_id' => 1,
                'action' => 'student_payment/edit',
                'has_permission' => 1,
            ),
            289 =>
            array (
                'id' => 3531,
                'user_group_id' => 1,
                'action' => 'student_payment/view',
                'has_permission' => 1,
            ),
            290 =>
            array (
                'id' => 3532,
                'user_group_id' => 1,
                'action' => 'reports',
                'has_permission' => 1,
            ),
            291 =>
            array (
                'id' => 3533,
                'user_group_id' => 1,
                'action' => 'report_admission',
                'has_permission' => 1,
            ),
            292 =>
            array (
                'id' => 3534,
                'user_group_id' => 1,
                'action' => 'report_admission/all',
                'has_permission' => 1,
            ),
            293 =>
            array (
                'id' => 3535,
                'user_group_id' => 1,
                'action' => 'report_attendance_by_term',
                'has_permission' => 1,
            ),
            294 =>
            array (
                'id' => 3536,
                'user_group_id' => 1,
                'action' => 'report_attendance_by_term/all',
                'has_permission' => 1,
            ),
            295 =>
            array (
                'id' => 3537,
                'user_group_id' => 1,
                'action' => 'report_attendance_by_phase',
                'has_permission' => 1,
            ),
            296 =>
            array (
                'id' => 3538,
                'user_group_id' => 1,
                'action' => 'report_attendance_by_phase/all',
                'has_permission' => 1,
            ),
            297 =>
            array (
                'id' => 3539,
                'user_group_id' => 1,
                'action' => 'report_attendance_by_student',
                'has_permission' => 1,
            ),
            298 =>
            array (
                'id' => 3540,
                'user_group_id' => 1,
                'action' => 'report_attendance_by_student/all',
                'has_permission' => 1,
            ),
            299 =>
            array (
                'id' => 3541,
                'user_group_id' => 1,
                'action' => 'report_exam_result',
                'has_permission' => 1,
            ),
            300 =>
            array (
                'id' => 3542,
                'user_group_id' => 1,
                'action' => 'report_exam_result/all',
                'has_permission' => 1,
            ),
            301 =>
            array (
                'id' => 3543,
                'user_group_id' => 1,
                'action' => 'report_exam_result_phase',
                'has_permission' => 1,
            ),
            302 =>
            array (
                'id' => 3544,
                'user_group_id' => 1,
                'action' => 'report_exam_result_phase/all',
                'has_permission' => 1,
            ),
            303 =>
            array (
                'id' => 3545,
                'user_group_id' => 1,
                'action' => 'report_exam_result_student',
                'has_permission' => 1,
            ),
            304 =>
            array (
                'id' => 3546,
                'user_group_id' => 1,
                'action' => 'report_exam_result_student/all',
                'has_permission' => 1,
            ),
            305 =>
            array (
                'id' => 3547,
                'user_group_id' => 1,
                'action' => 'report_student_payment',
                'has_permission' => 1,
            ),
            306 =>
            array (
                'id' => 3548,
                'user_group_id' => 1,
                'action' => 'report_student_payment/all',
                'has_permission' => 1,
            ),
            307 =>
            array (
                'id' => 3549,
                'user_group_id' => 1,
                'action' => 'report_student_list',
                'has_permission' => 1,
            ),
            308 =>
            array (
                'id' => 3550,
                'user_group_id' => 1,
                'action' => 'report_student_list/all',
                'has_permission' => 1,
            ),
            309 =>
            array (
                'id' => 3551,
                'user_group_id' => 1,
                'action' => 'report_teacher_list',
                'has_permission' => 1,
            ),
            310 =>
            array (
                'id' => 3552,
                'user_group_id' => 1,
                'action' => 'report_teacher_list/all',
                'has_permission' => 1,
            ),
            311 =>
            array (
                'id' => 3553,
                'user_group_id' => 1,
                'action' => 'notice_board',
                'has_permission' => 1,
            ),
            312 =>
            array (
                'id' => 3554,
                'user_group_id' => 1,
                'action' => 'notice_board/index',
                'has_permission' => 1,
            ),
            313 =>
            array (
                'id' => 3555,
                'user_group_id' => 1,
                'action' => 'notice_board/create',
                'has_permission' => 1,
            ),
            314 =>
            array (
                'id' => 3556,
                'user_group_id' => 1,
                'action' => 'notice_board/edit',
                'has_permission' => 1,
            ),
            315 =>
            array (
                'id' => 3557,
                'user_group_id' => 1,
                'action' => 'notice_board/view',
                'has_permission' => 1,
            ),
            316 =>
            array (
                'id' => 3558,
                'user_group_id' => 1,
                'action' => 'holiday',
                'has_permission' => 1,
            ),
            317 =>
            array (
                'id' => 3559,
                'user_group_id' => 1,
                'action' => 'holiday/index',
                'has_permission' => 1,
            ),
            318 =>
            array (
                'id' => 3560,
                'user_group_id' => 1,
                'action' => 'holiday/create',
                'has_permission' => 1,
            ),
            319 =>
            array (
                'id' => 3561,
                'user_group_id' => 1,
                'action' => 'holiday/edit',
                'has_permission' => 1,
            ),
            320 =>
            array (
                'id' => 3562,
                'user_group_id' => 1,
                'action' => 'holiday/view',
                'has_permission' => 1,
            ),
            321 =>
            array (
                'id' => 3563,
                'user_group_id' => 1,
                'action' => 'message',
                'has_permission' => 1,
            ),
            322 =>
            array (
                'id' => 3564,
                'user_group_id' => 1,
                'action' => 'message/index',
                'has_permission' => 1,
            ),
            323 =>
            array (
                'id' => 3565,
                'user_group_id' => 1,
                'action' => 'message/create',
                'has_permission' => 1,
            ),
            324 =>
            array (
                'id' => 3566,
                'user_group_id' => 1,
                'action' => 'message/edit',
                'has_permission' => 1,
            ),
            325 =>
            array (
                'id' => 3567,
                'user_group_id' => 1,
                'action' => 'message/view',
                'has_permission' => 1,
            ),
            326 =>
            array (
                'id' => 3568,
                'user_group_id' => 1,
                'action' => 'setting',
                'has_permission' => 1,
            ),
            327 =>
            array (
                'id' => 3569,
                'user_group_id' => 1,
                'action' => 'attachment_type',
                'has_permission' => 1,
            ),
            328 =>
            array (
                'id' => 3570,
                'user_group_id' => 1,
                'action' => 'attachment_type/index',
                'has_permission' => 1,
            ),
            329 =>
            array (
                'id' => 3571,
                'user_group_id' => 1,
                'action' => 'attachment_type/create',
                'has_permission' => 1,
            ),
            330 =>
            array (
                'id' => 3572,
                'user_group_id' => 1,
                'action' => 'attachment_type/edit',
                'has_permission' => 1,
            ),
            331 =>
            array (
                'id' => 3573,
                'user_group_id' => 1,
                'action' => 'attachment_type/view',
                'has_permission' => 1,
            ),
            332 =>
            array (
                'id' => 3574,
                'user_group_id' => 1,
                'action' => 'student_category',
                'has_permission' => 1,
            ),
            333 =>
            array (
                'id' => 3575,
                'user_group_id' => 1,
                'action' => 'student_category/index',
                'has_permission' => 1,
            ),
            334 =>
            array (
                'id' => 3576,
                'user_group_id' => 1,
                'action' => 'student_category/create',
                'has_permission' => 1,
            ),
            335 =>
            array (
                'id' => 3577,
                'user_group_id' => 1,
                'action' => 'student_category/edit',
                'has_permission' => 1,
            ),
            336 =>
            array (
                'id' => 3578,
                'user_group_id' => 1,
                'action' => 'student_category/view',
                'has_permission' => 1,
            ),
            337 =>
            array (
                'id' => 3579,
                'user_group_id' => 1,
                'action' => 'student_group',
                'has_permission' => 1,
            ),
            338 =>
            array (
                'id' => 3580,
                'user_group_id' => 1,
                'action' => 'student_group/index',
                'has_permission' => 1,
            ),
            339 =>
            array (
                'id' => 3581,
                'user_group_id' => 1,
                'action' => 'student_group/create',
                'has_permission' => 1,
            ),
            340 =>
            array (
                'id' => 3582,
                'user_group_id' => 1,
                'action' => 'student_group/edit',
                'has_permission' => 1,
            ),
            341 =>
            array (
                'id' => 3583,
                'user_group_id' => 1,
                'action' => 'student_group/view',
                'has_permission' => 1,
            ),
            342 =>
            array (
                'id' => 3584,
                'user_group_id' => 1,
                'action' => 'term',
                'has_permission' => 1,
            ),
            343 =>
            array (
                'id' => 3585,
                'user_group_id' => 1,
                'action' => 'term/index',
                'has_permission' => 1,
            ),
            344 =>
            array (
                'id' => 3586,
                'user_group_id' => 1,
                'action' => 'term/create',
                'has_permission' => 1,
            ),
            345 =>
            array (
                'id' => 3587,
                'user_group_id' => 1,
                'action' => 'term/edit',
                'has_permission' => 1,
            ),
            346 =>
            array (
                'id' => 3588,
                'user_group_id' => 1,
                'action' => 'term/view',
                'has_permission' => 1,
            ),
            347 =>
            array (
                'id' => 3589,
                'user_group_id' => 1,
                'action' => 'phase',
                'has_permission' => 1,
            ),
            348 =>
            array (
                'id' => 3590,
                'user_group_id' => 1,
                'action' => 'phase/index',
                'has_permission' => 1,
            ),
            349 =>
            array (
                'id' => 3591,
                'user_group_id' => 1,
                'action' => 'phase/create',
                'has_permission' => 1,
            ),
            350 =>
            array (
                'id' => 3592,
                'user_group_id' => 1,
                'action' => 'phase/edit',
                'has_permission' => 1,
            ),
            351 =>
            array (
                'id' => 3593,
                'user_group_id' => 1,
                'action' => 'phase/view',
                'has_permission' => 1,
            ),
            352 =>
            array (
                'id' => 3594,
                'user_group_id' => 1,
                'action' => 'designation',
                'has_permission' => 1,
            ),
            353 =>
            array (
                'id' => 3595,
                'user_group_id' => 1,
                'action' => 'designation/index',
                'has_permission' => 1,
            ),
            354 =>
            array (
                'id' => 3596,
                'user_group_id' => 1,
                'action' => 'designation/create',
                'has_permission' => 1,
            ),
            355 =>
            array (
                'id' => 3597,
                'user_group_id' => 1,
                'action' => 'designation/edit',
                'has_permission' => 1,
            ),
            356 =>
            array (
                'id' => 3598,
                'user_group_id' => 1,
                'action' => 'designation/view',
                'has_permission' => 1,
            ),
            357 =>
            array (
                'id' => 3599,
                'user_group_id' => 1,
                'action' => 'department',
                'has_permission' => 1,
            ),
            358 =>
            array (
                'id' => 3600,
                'user_group_id' => 1,
                'action' => 'department/index',
                'has_permission' => 1,
            ),
            359 =>
            array (
                'id' => 3601,
                'user_group_id' => 1,
                'action' => 'department/create',
                'has_permission' => 1,
            ),
            360 =>
            array (
                'id' => 3602,
                'user_group_id' => 1,
                'action' => 'department/edit',
                'has_permission' => 1,
            ),
            361 =>
            array (
                'id' => 3603,
                'user_group_id' => 1,
                'action' => 'department/view',
                'has_permission' => 1,
            ),
            362 =>
            array (
                'id' => 3604,
                'user_group_id' => 1,
                'action' => 'course',
                'has_permission' => 1,
            ),
            363 =>
            array (
                'id' => 3605,
                'user_group_id' => 1,
                'action' => 'course/index',
                'has_permission' => 1,
            ),
            364 =>
            array (
                'id' => 3606,
                'user_group_id' => 1,
                'action' => 'course/create',
                'has_permission' => 1,
            ),
            365 =>
            array (
                'id' => 3607,
                'user_group_id' => 1,
                'action' => 'course/edit',
                'has_permission' => 1,
            ),
            366 =>
            array (
                'id' => 3608,
                'user_group_id' => 1,
                'action' => 'course/view',
                'has_permission' => 1,
            ),
            367 =>
            array (
                'id' => 3609,
                'user_group_id' => 1,
                'action' => 'class_type',
                'has_permission' => 1,
            ),
            368 =>
            array (
                'id' => 3610,
                'user_group_id' => 1,
                'action' => 'class_type/index',
                'has_permission' => 1,
            ),
            369 =>
            array (
                'id' => 3611,
                'user_group_id' => 1,
                'action' => 'class_type/create',
                'has_permission' => 1,
            ),
            370 =>
            array (
                'id' => 3612,
                'user_group_id' => 1,
                'action' => 'class_type/edit',
                'has_permission' => 1,
            ),
            371 =>
            array (
                'id' => 3613,
                'user_group_id' => 1,
                'action' => 'class_type/view',
                'has_permission' => 1,
            ),
            372 =>
            array (
                'id' => 3614,
                'user_group_id' => 1,
                'action' => 'education_board',
                'has_permission' => 1,
            ),
            373 =>
            array (
                'id' => 3615,
                'user_group_id' => 1,
                'action' => 'education_board/index',
                'has_permission' => 1,
            ),
            374 =>
            array (
                'id' => 3616,
                'user_group_id' => 1,
                'action' => 'education_board/create',
                'has_permission' => 1,
            ),
            375 =>
            array (
                'id' => 3617,
                'user_group_id' => 1,
                'action' => 'education_board/edit',
                'has_permission' => 1,
            ),
            376 =>
            array (
                'id' => 3618,
                'user_group_id' => 1,
                'action' => 'education_board/view',
                'has_permission' => 1,
            ),
            377 =>
            array (
                'id' => 3619,
                'user_group_id' => 1,
                'action' => 'bank',
                'has_permission' => 1,
            ),
            378 =>
            array (
                'id' => 3620,
                'user_group_id' => 1,
                'action' => 'bank/index',
                'has_permission' => 1,
            ),
            379 =>
            array (
                'id' => 3621,
                'user_group_id' => 1,
                'action' => 'bank/create',
                'has_permission' => 1,
            ),
            380 =>
            array (
                'id' => 3622,
                'user_group_id' => 1,
                'action' => 'bank/edit',
                'has_permission' => 1,
            ),
            381 =>
            array (
                'id' => 3623,
                'user_group_id' => 1,
                'action' => 'payment_type',
                'has_permission' => 1,
            ),
            382 =>
            array (
                'id' => 3624,
                'user_group_id' => 1,
                'action' => 'payment_type/index',
                'has_permission' => 1,
            ),
            383 =>
            array (
                'id' => 3625,
                'user_group_id' => 1,
                'action' => 'payment_type/create',
                'has_permission' => 1,
            ),
            384 =>
            array (
                'id' => 3626,
                'user_group_id' => 1,
                'action' => 'payment_type/edit',
                'has_permission' => 1,
            ),
            385 =>
            array (
                'id' => 3627,
                'user_group_id' => 1,
                'action' => 'payment_type/view',
                'has_permission' => 1,
            ),
            386 =>
            array (
                'id' => 3628,
                'user_group_id' => 1,
                'action' => 'payment_method',
                'has_permission' => 1,
            ),
            387 =>
            array (
                'id' => 3629,
                'user_group_id' => 1,
                'action' => 'payment_method/index',
                'has_permission' => 1,
            ),
            388 =>
            array (
                'id' => 3630,
                'user_group_id' => 1,
                'action' => 'payment_method/create',
                'has_permission' => 1,
            ),
            389 =>
            array (
                'id' => 3631,
                'user_group_id' => 1,
                'action' => 'payment_method/edit',
                'has_permission' => 1,
            ),
            390 =>
            array (
                'id' => 3632,
                'user_group_id' => 1,
                'action' => 'payment_detail',
                'has_permission' => 1,
            ),
            391 =>
            array (
                'id' => 3633,
                'user_group_id' => 1,
                'action' => 'payment_detail/index',
                'has_permission' => 1,
            ),
            392 =>
            array (
                'id' => 3634,
                'user_group_id' => 1,
                'action' => 'payment_detail/create',
                'has_permission' => 1,
            ),
            393 =>
            array (
                'id' => 3635,
                'user_group_id' => 1,
                'action' => 'payment_detail/edit',
                'has_permission' => 1,
            ),
            394 =>
            array (
                'id' => 3636,
                'user_group_id' => 1,
                'action' => 'payment_detail/view',
                'has_permission' => 1,
            ),
            395 =>
            array (
                'id' => 3637,
                'user_group_id' => 1,
                'action' => 'hall',
                'has_permission' => 1,
            ),
            396 =>
            array (
                'id' => 3638,
                'user_group_id' => 1,
                'action' => 'hall/index',
                'has_permission' => 1,
            ),
            397 =>
            array (
                'id' => 3639,
                'user_group_id' => 1,
                'action' => 'hall/create',
                'has_permission' => 1,
            ),
            398 =>
            array (
                'id' => 3640,
                'user_group_id' => 1,
                'action' => 'hall/edit',
                'has_permission' => 1,
            ),
            399 =>
            array (
                'id' => 3641,
                'user_group_id' => 1,
                'action' => 'hall/view',
                'has_permission' => 1,
            ),
            400 =>
            array (
                'id' => 3642,
                'user_group_id' => 1,
                'action' => 'application_setting',
                'has_permission' => 1,
            ),
            401 =>
            array (
                'id' => 3643,
                'user_group_id' => 1,
                'action' => 'application_setting/index',
                'has_permission' => 1,
            ),
            402 =>
            array (
                'id' => 3644,
                'user_group_id' => 1,
                'action' => 'application_setting/create',
                'has_permission' => 1,
            ),
            403 =>
            array (
                'id' => 3645,
                'user_group_id' => 1,
                'action' => 'application_setting/edit',
                'has_permission' => 1,
            ),
            404 =>
            array (
                'id' => 3646,
                'user_group_id' => 1,
                'action' => 'application_setting/view',
                'has_permission' => 0,
            ),
            405 =>
            array (
                'id' => 3647,
                'user_group_id' => 1,
                'action' => 'logout',
                'has_permission' => 1,
            ),
            406 =>
            array (
                'id' => 3648,
                'user_group_id' => 1,
                'action' => 'logout/index',
                'has_permission' => 1,
            ),
        ));
    }
}
