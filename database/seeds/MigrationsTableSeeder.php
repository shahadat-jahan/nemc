<?php

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'migration' => '2014_10_12_000000_create_users_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'migration' => '2014_10_12_092428_create_user_groups_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'migration' => '2014_10_12_100000_create_password_resets_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'migration' => '2018_10_30_093417_create_user_group_permissions_table',
                'batch' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'migration' => '2018_11_20_053539_create_notifications_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'migration' => '2019_01_03_080136_create_pages_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'migration' => '2019_01_29_115705_create_courses_table',
                'batch' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'migration' => '2019_01_29_123904_create_class_types_table',
                'batch' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'migration' => '2019_01_29_124446_create_departments_table',
                'batch' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'migration' => '2019_01_29_124925_create_exam_categories_table',
                'batch' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'migration' => '2019_01_29_125834_create_exam_types_table',
                'batch' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'migration' => '2019_01_29_125931_create_exam_sub_types_table',
                'batch' => 1,
            ),
            12 => 
            array (
                'id' => 13,
                'migration' => '2019_01_30_040048_create_payment_types_table',
                'batch' => 1,
            ),
            13 => 
            array (
                'id' => 14,
                'migration' => '2019_01_30_042811_create_phases_table',
                'batch' => 1,
            ),
            14 => 
            array (
                'id' => 15,
                'migration' => '2019_01_30_043651_create_terms_table',
                'batch' => 1,
            ),
            15 => 
            array (
                'id' => 16,
                'migration' => '2019_01_30_044255_create_sessions_table',
                'batch' => 1,
            ),
            16 => 
            array (
                'id' => 17,
                'migration' => '2019_01_30_044811_create_session_details_table',
                'batch' => 1,
            ),
            17 => 
            array (
                'id' => 18,
                'migration' => '2019_01_30_045632_create_subject_groups_table',
                'batch' => 1,
            ),
            18 => 
            array (
                'id' => 19,
                'migration' => '2019_01_30_050636_create_subjects_table',
                'batch' => 1,
            ),
            19 => 
            array (
                'id' => 20,
                'migration' => '2019_01_30_052952_create_session_subjects_table',
                'batch' => 1,
            ),
            20 => 
            array (
                'id' => 21,
                'migration' => '2019_01_30_053411_create_subject_exam_sub_types_table',
                'batch' => 1,
            ),
            21 => 
            array (
                'id' => 22,
                'migration' => '2019_01_30_053912_create_subject_exam_categories_table',
                'batch' => 1,
            ),
            22 => 
            array (
                'id' => 23,
                'migration' => '2019_01_30_061403_create_teachers_table',
                'batch' => 1,
            ),
            23 => 
            array (
                'id' => 24,
                'migration' => '2019_01_30_065112_create_designations_table',
                'batch' => 1,
            ),
            24 => 
            array (
                'id' => 25,
                'migration' => '2019_01_30_070121_create_topic_heads_table',
                'batch' => 1,
            ),
            25 => 
            array (
                'id' => 26,
                'migration' => '2019_01_30_070445_create_topics_table',
                'batch' => 1,
            ),
            26 => 
            array (
                'id' => 27,
                'migration' => '2019_01_30_081748_create_topic_teachers_table',
                'batch' => 1,
            ),
            27 => 
            array (
                'id' => 28,
                'migration' => '2019_01_30_082212_create_exams_table',
                'batch' => 1,
            ),
            28 => 
            array (
                'id' => 29,
                'migration' => '2019_01_30_082849_create_exam_subjects_table',
                'batch' => 1,
            ),
            29 => 
            array (
                'id' => 30,
                'migration' => '2019_01_30_083953_create_exam_subject_marks_table',
                'batch' => 1,
            ),
            30 => 
            array (
                'id' => 31,
                'migration' => '2019_01_30_091311_create_student_categories_table',
                'batch' => 1,
            ),
            31 => 
            array (
                'id' => 32,
                'migration' => '2019_01_30_095715_create_admission_students_table',
                'batch' => 1,
            ),
            32 => 
            array (
                'id' => 33,
                'migration' => '2019_01_30_103550_create_countries_table',
                'batch' => 1,
            ),
            33 => 
            array (
                'id' => 34,
                'migration' => '2019_01_30_121617_create_admission_parents_table',
                'batch' => 1,
            ),
            34 => 
            array (
                'id' => 35,
                'migration' => '2019_01_30_122923_create_admission_emergency_contacts_table',
                'batch' => 1,
            ),
            35 => 
            array (
                'id' => 36,
                'migration' => '2019_01_31_040507_create_admission_student_education_histories_table',
                'batch' => 1,
            ),
            36 => 
            array (
                'id' => 37,
                'migration' => '2019_01_31_041514_create_education_boards_table',
                'batch' => 1,
            ),
            37 => 
            array (
                'id' => 38,
                'migration' => '2019_01_31_042447_create_students_table',
                'batch' => 1,
            ),
            38 => 
            array (
                'id' => 39,
                'migration' => '2019_01_31_053217_create_emergency_contacts_table',
                'batch' => 1,
            ),
            39 => 
            array (
                'id' => 40,
                'migration' => '2019_01_31_055432_create_student_education_histories_table',
                'batch' => 1,
            ),
            40 => 
            array (
                'id' => 41,
                'migration' => '2019_01_31_125930_create_guardians_table',
                'batch' => 1,
            ),
            41 => 
            array (
                'id' => 42,
                'migration' => '2019_02_01_042649_create_batch_types_table',
                'batch' => 1,
            ),
            42 => 
            array (
                'id' => 43,
                'migration' => '2019_02_01_050457_create_cards_table',
                'batch' => 1,
            ),
            43 => 
            array (
                'id' => 44,
                'migration' => '2019_02_01_051929_create_items_table',
                'batch' => 1,
            ),
            44 => 
            array (
                'id' => 45,
                'migration' => '2019_02_01_052918_create_class_routines_table',
                'batch' => 1,
            ),
            45 => 
            array (
                'id' => 46,
                'migration' => '2019_02_01_060137_create_exam_result_histories_table',
                'batch' => 1,
            ),
            46 => 
            array (
                'id' => 47,
                'migration' => '2019_02_01_060729_create_exam_results_table',
                'batch' => 1,
            ),
            47 => 
            array (
                'id' => 48,
                'migration' => '2019_02_01_062721_create_student_groups_table',
                'batch' => 1,
            ),
            48 => 
            array (
                'id' => 49,
                'migration' => '2019_02_01_063918_create_student_group_students',
                'batch' => 1,
            ),
            49 => 
            array (
                'id' => 50,
                'migration' => '2019_02_01_082226_create_payment_details_table',
                'batch' => 1,
            ),
            50 => 
            array (
                'id' => 51,
                'migration' => '2019_02_01_084155_create_attencances_table',
                'batch' => 1,
            ),
            51 => 
            array (
                'id' => 52,
                'migration' => '2019_02_01_090053_create_attachments_table',
                'batch' => 1,
            ),
            52 => 
            array (
                'id' => 53,
                'migration' => '2019_02_01_090100_create_attachment_types_table',
                'batch' => 1,
            ),
            53 => 
            array (
                'id' => 54,
                'migration' => '2019_02_01_090841_create_student_fees_table',
                'batch' => 1,
            ),
            54 => 
            array (
                'id' => 55,
                'migration' => '2019_02_01_091221_create_student_fee_details_table',
                'batch' => 1,
            ),
            55 => 
            array (
                'id' => 56,
                'migration' => '2019_02_01_095156_create_admin_users_table',
                'batch' => 1,
            ),
            56 => 
            array (
                'id' => 57,
                'migration' => '2019_02_01_113505_create_student_payments_table',
                'batch' => 1,
            ),
            57 => 
            array (
                'id' => 58,
                'migration' => '2019_02_04_105527_create_class_routine_histories_table',
                'batch' => 1,
            ),
            58 => 
            array (
                'id' => 59,
                'migration' => '2019_02_04_110113_create_phase_promotion_histories_table',
                'batch' => 1,
            ),
            59 => 
            array (
                'id' => 60,
                'migration' => '2019_02_05_052624_create_session_phase_details_table',
                'batch' => 1,
            ),
            60 => 
            array (
                'id' => 61,
                'migration' => '2019_02_08_061019_create_admission_attachments_table',
                'batch' => 1,
            ),
            61 => 
            array (
                'id' => 62,
                'migration' => '2019_02_12_060335_create_student_roll_no_table',
                'batch' => 1,
            ),
            62 => 
            array (
                'id' => 63,
                'migration' => '2019_02_19_124726_create_holidays_table',
                'batch' => 1,
            ),
            63 => 
            array (
                'id' => 64,
                'migration' => '2019_02_19_124726_create_notice_boards_table',
                'batch' => 1,
            ),
            64 => 
            array (
                'id' => 65,
                'migration' => '2019_02_22_070445_create_books_table',
                'batch' => 1,
            ),
            65 => 
            array (
                'id' => 66,
                'migration' => '2019_02_25_100148_create_halls_table',
                'batch' => 1,
            ),
            66 => 
            array (
                'id' => 67,
                'migration' => '2019_03_01_082613_create_class_routine_session_batch_types_table',
                'batch' => 1,
            ),
            67 => 
            array (
                'id' => 68,
                'migration' => '2019_03_01_101322_create_messages_table',
                'batch' => 1,
            ),
            68 => 
            array (
                'id' => 69,
                'migration' => '2019_03_01_101339_create_message_replies_table',
                'batch' => 1,
            ),
            69 => 
            array (
                'id' => 70,
                'migration' => '2019_03_07_070121_create_lecture_materials_table',
                'batch' => 1,
            ),
            70 => 
            array (
                'id' => 71,
                'migration' => '2019_03_07_081235_create_class_routine_student_groups_table',
                'batch' => 1,
            ),
            71 => 
            array (
                'id' => 72,
                'migration' => '2019_03_10_123904_create_application_settings_table',
                'batch' => 1,
            ),
            72 => 
            array (
                'id' => 73,
                'migration' => '2019_03_19_061716_create_exam_subject_student_groups',
                'batch' => 1,
            ),
            73 => 
            array (
                'id' => 74,
                'migration' => '2019_03_28_120343_create_jobs_table',
                'batch' => 1,
            ),
            74 => 
            array (
                'id' => 75,
                'migration' => '2019_04_25_093757_create_payment_methods_table',
                'batch' => 1,
            ),
            75 => 
            array (
                'id' => 76,
                'migration' => '2019_04_25_102830_create_banks_table',
                'batch' => 1,
            ),
            76 => 
            array (
                'id' => 77,
                'migration' => '2019_04_26_050845_create_student_payment_details_table',
                'batch' => 1,
            ),
            77 => 
            array (
                'id' => 78,
                'migration' => '2019_04_26_103641_create_cron_logs_table',
                'batch' => 1,
            ),
            78 => 
            array (
                'id' => 79,
                'migration' => '2020_12_31_171657_create_foreign_keys',
                'batch' => 1,
            ),
            79 => 
            array (
                'id' => 80,
                'migration' => '2019_05_22_043340_alter_teacher_table_to_update_phone_and_email',
                'batch' => 2,
            ),
            80 => 
            array (
                'id' => 81,
                'migration' => '2019_05_22_091901_add_change_password_to_users_table',
                'batch' => 3,
            ),
            81 => 
            array (
                'id' => 82,
                'migration' => '2019_05_30_060355_alter_topic_head_table_to_change_title',
                'batch' => 4,
            ),
            82 => 
            array (
                'id' => 83,
                'migration' => '2019_05_30_060640_alter_topics_table_to_update_title',
                'batch' => 4,
            ),
            83 => 
            array (
                'id' => 84,
                'migration' => '2019_06_24_060640_alter_cards_table_to_update_title',
                'batch' => 5,
            ),
            84 => 
            array (
                'id' => 85,
                'migration' => '2019_06_24_103643_add_column_serial_number_and_modify_title_column_to_items_table',
                'batch' => 5,
            ),
            85 => 
            array (
                'id' => 86,
                'migration' => '2019_07_04_094441_add_column_serial_no_to_topics_table',
                'batch' => 6,
            ),
            86 => 
            array (
                'id' => 87,
                'migration' => '2019_07_05_094938_create_failed_jobs_table',
                'batch' => 6,
            ),
        ));
        
        
    }
}