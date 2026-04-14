<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{

    public function up(){

        Schema::table('users', function(Blueprint $table) {
            $table->foreign('user_group_id')->references('id')->on('user_groups');
        });

        Schema::table('user_group_permissions', function(Blueprint $table) {
            $table->foreign('user_group_id')->references('id')->on('user_groups');
        });

        Schema::table('departments', function(Blueprint $table) {
            $table->foreign('department_lead_id')->references('id')->on('users');
        });

        Schema::table('admin_users', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('designation_id')->references('id')->on('designations');
        });

        Schema::table('exam_sub_types', function(Blueprint $table) {
            $table->foreign('exam_type_id')->references('id')->on('exam_types');
        });

        Schema::table('session_details', function(Blueprint $table) {
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('course_id')->references('id')->on('courses');
        });

        Schema::table('session_phase_details', function(Blueprint $table) {
            $table->foreign('session_detail_id')->references('id')->on('session_details');
            $table->foreign('phase_id')->references('id')->on('phases');
        });

        Schema::table('session_phase_detail_subjects', function(Blueprint $table) {
            $table->foreign('session_phase_detail_id')->references('id')->on('session_phase_details');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });

        Schema::table('subject_groups', function(Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses');
        });

        Schema::table('subjects', function(Blueprint $table) {
            $table->foreign('subject_group_id')->references('id')->on('subject_groups');
            $table->foreign('department_id')->references('id')->on('departments');
        });

        Schema::table('subject_exam_sub_types', function(Blueprint $table) {
            $table->foreign('exam_sub_type_id')->references('id')->on('exam_sub_types');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });

        Schema::table('subject_exam_categories', function(Blueprint $table) {
            $table->foreign('exam_category_id')->references('id')->on('exam_categories');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });

        Schema::table('teachers', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('designation_id')->references('id')->on('designations');
        });

        Schema::table('topic_heads', function(Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects');
        });

        Schema::table('topics', function(Blueprint $table) {
            $table->foreign('topic_head_id')->references('id')->on('topic_heads');
        });

        Schema::table('topic_teachers', function(Blueprint $table) {
            $table->foreign('topic_id')->references('id')->on('topics');
            $table->foreign('teacher_id')->references('id')->on('teachers');
        });

        Schema::table('exams', function(Blueprint $table) {
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('exam_category_id')->references('id')->on('exam_categories');
            $table->foreign('phase_id')->references('id')->on('phases');
            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('batch_type_id')->references('id')->on('batch_types');
        });

        Schema::table('exam_subjects', function(Blueprint $table) {
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('subject_group_id')->references('id')->on('subject_groups');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('card_id')->references('id')->on('cards');
            $table->foreign('card_item_id')->references('id')->on('card_items');
            $table->foreign('exam_type_id')->references('id')->on('exam_types');
        });

        Schema::table('exam_subject_marks', function(Blueprint $table) {
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('subject_id')->references('id')->on('subjects');
//            $table->foreign('exam_type_id')->references('id')->on('exam_types');
            $table->foreign('exam_sub_type_id')->references('id')->on('exam_sub_types');
//            $table->foreign('student_group_id')->references('id')->on('student_groups');
        });

        Schema::table('exam_subject_student_groups', function(Blueprint $table) {
            $table->foreign('exam_subject_id')->references('id')->on('exam_subjects');
            $table->foreign('exam_sub_type_id')->references('id')->on('exam_sub_types');
            $table->foreign('student_group_id')->references('id')->on('student_groups');
        });

        Schema::table('admission_students', function(Blueprint $table) {
            $table->foreign('admission_parent_id')->references('id')->on('admission_parents');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('student_category_id')->references('id')->on('student_categories');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('nationality')->references('id')->on('countries');
        });

        Schema::table('admission_emergency_contacts', function(Blueprint $table) {
            $table->foreign('admission_student_id')->references('id')->on('admission_students');
        });

        Schema::table('admission_education_histories', function(Blueprint $table) {
            $table->foreign('admission_student_id')->references('id')->on('admission_students');
            $table->foreign('education_board_id')->references('id')->on('education_boards');
        });

        Schema::table('admission_attachments', function(Blueprint $table) {
            $table->foreign('admission_student_id')->references('id')->on('admission_students');
            $table->foreign('attachment_type_id')->references('id')->on('attachment_types');
        });

        Schema::table('students', function(Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('guardians');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('student_category_id')->references('id')->on('student_categories');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('nationality')->references('id')->on('countries');
            $table->foreign('batch_type_id')->references('id')->on('batch_types');
            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('phase_id')->references('id')->on('phases');
            $table->foreign('followed_by_session_id')->references('id')->on('sessions');
        });

        Schema::table('emergency_contacts', function(Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
        });

        Schema::table('education_histories', function(Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('education_board_id')->references('id')->on('education_boards');
        });

        Schema::table('guardians', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('student_groups', function(Blueprint $table) {
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('course_id')->references('id')->on('courses');
        });

        Schema::table('student_group_students', function(Blueprint $table) {
            $table->foreign('student_group_id')->references('id')->on('student_groups');
            $table->foreign('student_id')->references('id')->on('students');
        });
        Schema::table('student_roll_no', function(Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('phase_id')->references('id')->on('phases');
            $table->foreign('batch_type_id')->references('id')->on('batch_types');
        });

        Schema::table('cards', function(Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('phase_id')->references('id')->on('phases');
        });

        Schema::table('card_items', function(Blueprint $table) {
            $table->foreign('card_id')->references('id')->on('cards');
        });

        Schema::table('class_routines', function(Blueprint $table) {
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('batch_type_id')->references('id')->on('batch_types');
            $table->foreign('phase_id')->references('id')->on('phases');
            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('class_type_id')->references('id')->on('class_types');
            $table->foreign('topic_id')->references('id')->on('topics');
            $table->foreign('hall_id')->references('id')->on('halls');
        });

        Schema::table('class_routine_student_groups', function(Blueprint $table) {
            $table->foreign('class_routine_id')->references('id')->on('class_routines');
            $table->foreign('student_group_id')->references('id')->on('student_groups');
            $table->foreign('teacher_id')->references('id')->on('teachers');
        });

        Schema::table('class_routine_session_batch_types', function(Blueprint $table) {
            $table->foreign('class_routine_id')->references('id')->on('class_routines');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('batch_type_id')->references('id')->on('batch_types');
        });

        Schema::table('exam_results', function(Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('exam_subject_mark_id')->references('id')->on('exam_subject_marks');
            $table->foreign('responsible_teacher_id')->references('id')->on('teachers');
        });

        Schema::table('exam_result_histories', function(Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('exam_subject_mark_id')->references('id')->on('exam_subject_marks');
        });

        Schema::table('payment_details', function(Blueprint $table) {
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->foreign('student_category_id')->references('id')->on('student_categories');
            $table->foreign('course_id')->references('id')->on('courses');
        });

        Schema::table('attencance', function(Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('class_routine_id')->references('id')->on('class_routines');
        });

        Schema::table('attachments', function(Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('attachment_type_id')->references('id')->on('attachment_types');
        });

        Schema::table('student_fees', function(Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
        });

        Schema::table('student_fee_details', function(Blueprint $table) {
            $table->foreign('student_fee_id')->references('id')->on('student_fees');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
        });

        Schema::table('student_payments', function(Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('bank_id')->references('id')->on('banks');
        });

        Schema::table('student_payment_details', function(Blueprint $table) {
            $table->foreign('student_payment_id')->references('id')->on('student_payments');
            $table->foreign('student_fee_id')->references('id')->on('student_fees');
            $table->foreign('student_fee_detail_id')->references('id')->on('student_fee_details');
        });

        Schema::table('class_routine_histories', function(Blueprint $table) {
            $table->foreign('class_routine_id')->references('id')->on('class_routines');
            $table->foreign('teacher_id')->references('id')->on('teachers');
        });

        Schema::table('phase_promotion_histories', function(Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('promoted_from')->references('id')->on('phases');
            $table->foreign('promoted_to')->references('id')->on('phases');
            $table->foreign('promoted_by')->references('id')->on('users');
        });

        Schema::table('holidays', function(Blueprint $table) {
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('batch_type_id')->references('id')->on('batch_types');
        });

        Schema::table('notice_boards', function(Blueprint $table) {
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('batch_type_id')->references('id')->on('batch_types');
        });

        Schema::table('books', function(Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects');
        });

        Schema::table('lecture_materials', function(Blueprint $table) {
            $table->foreign('class_routine_id')->references('id')->on('class_routines');
        });

        Schema::table('messages', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('message_replies', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('message_id')->references('id')->on('messages');
        });
    }

    public function down(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_group_id']);
        });

        Schema::table('user_group_permissions', function (Blueprint $table) {
            $table->dropForeign(['user_group_id']);
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['department_lead_id']);
        });

        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['designation_id']);
        });

        Schema::table('exam_sub_types', function (Blueprint $table) {
            $table->dropForeign(['exam_type_id']);
        });

        Schema::table('session_details', function (Blueprint $table) {
            $table->dropForeign(['session_id']);
            $table->dropForeign(['course_id']);
        });

        Schema::table('session_phase_details', function (Blueprint $table) {
            $table->dropForeign(['session_detail_id']);
            $table->dropForeign(['phase_id']);
        });

        Schema::table('session_phase_detail_subjects', function (Blueprint $table) {
            $table->dropForeign(['session_phase_detail_id']);
            $table->dropForeign(['subject_id']);
        });

        Schema::table('subject_groups', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign(['subject_group_id']);
            $table->dropForeign(['department_id']);
        });

        Schema::table('subject_exam_sub_types', function (Blueprint $table) {
            $table->dropForeign(['exam_sub_type_id']);
            $table->dropForeign(['subject_id']);
        });

        Schema::table('subject_exam_categories', function (Blueprint $table) {
            $table->dropForeign(['exam_category_id']);
            $table->dropForeign(['subject_id']);
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['designation_id']);
        });

        Schema::table('topic_heads', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign(['topic_head_id']);
        });

        Schema::table('topic_teachers', function (Blueprint $table) {
            $table->dropForeign(['topic_id']);
            $table->dropForeign(['teacher_id']);
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->dropForeign(['session_id']);
            $table->dropForeign(['course_id']);
            $table->dropForeign(['exam_category_id']);
            $table->dropForeign(['phase_id']);
            $table->dropForeign(['term_id']);
            $table->dropForeign(['batch_type_id']);
        });

        Schema::table('exam_subjects', function (Blueprint $table) {
            $table->dropForeign(['exam_id']);
            $table->dropForeign(['subject_group_id']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['card_id']);
            $table->dropForeign(['card_item_id']);
            $table->dropForeign(['exam_type_id']);
        });

        Schema::table('exam_subject_marks', function (Blueprint $table) {
            $table->dropForeign(['exam_id']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['exam_sub_type_id']);
        });

        Schema::table('exam_subject_student_groups', function (Blueprint $table) {
            $table->dropForeign(['exam_subject_id']);
            $table->dropForeign(['exam_sub_type_id']);
            $table->dropForeign(['student_group_id']);
        });

        Schema::table('admission_students', function (Blueprint $table) {
            $table->dropForeign(['admission_parent_id']);
            $table->dropForeign(['course_id']);
            $table->dropForeign(['student_category_id']);
            $table->dropForeign(['session_id']);
            $table->dropForeign(['nationality']);
        });

        Schema::table('admission_emergency_contacts', function (Blueprint $table) {
            $table->dropForeign(['admission_student_id']);
        });

        Schema::table('admission_education_histories', function (Blueprint $table) {
            $table->dropForeign(['admission_student_id']);
            $table->dropForeign(['education_board_id']);
        });

        Schema::table('admission_attachments', function (Blueprint $table) {
            $table->dropForeign(['admission_student_id']);
            $table->dropForeign(['attachment_type_id']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['course_id']);
            $table->dropForeign(['student_category_id']);
            $table->dropForeign(['session_id']);
            $table->dropForeign(['nationality']);
            $table->dropForeign(['batch_type_id']);
            $table->dropForeign(['term_id']);
            $table->dropForeign(['phase_id']);
            $table->dropForeign(['followed_by_session_id']);
        });

        Schema::table('emergency_contacts', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        Schema::table('education_histories', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['education_board_id']);
        });

        Schema::table('guardians', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('student_groups', function (Blueprint $table) {
            $table->dropForeign(['session_id']);
            $table->dropForeign(['course_id']);
        });

        Schema::table('student_group_students', function (Blueprint $table) {
            $table->dropForeign(['student_group_id']);
            $table->dropForeign(['student_id']);
        });

        Schema::table('student_roll_no', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['phase_id']);
            $table->dropForeign(['batch_type_id']);
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['term_id']);
            $table->dropForeign(['phase_id']);
        });

        Schema::table('card_items', function (Blueprint $table) {
            $table->dropForeign(['card_id']);
        });

        Schema::table('class_routines', function (Blueprint $table) {
            $table->dropForeign(['session_id']);
            $table->dropForeign(['course_id']);
            $table->dropForeign(['batch_type_id']);
            $table->dropForeign(['phase_id']);
            $table->dropForeign(['term_id']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['class_type_id']);
            $table->dropForeign(['topic_id']);
            $table->dropForeign(['hall_id']);
        });

        Schema::table('class_routine_student_groups', function (Blueprint $table) {
            $table->dropForeign(['class_routine_id']);
            $table->dropForeign(['student_group_id']);
            $table->dropForeign(['teacher_id']);
        });

        Schema::table('class_routine_session_batch_types', function (Blueprint $table) {
            $table->dropForeign(['class_routine_id']);
            $table->dropForeign(['session_id']);
            $table->dropForeign(['batch_type_id']);
        });

        Schema::table('exam_results', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['exam_subject_mark_id']);
            $table->dropForeign(['responsible_teacher_id']);
        });

        Schema::table('exam_result_histories', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['exam_subject_mark_id']);
        });

        Schema::table('payment_details', function (Blueprint $table) {
            $table->dropForeign(['payment_type_id']);
            $table->dropForeign(['student_category_id']);
            $table->dropForeign(['course_id']);
        });

        Schema::table('attencance', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['class_routine_id']);
        });

        Schema::table('attachments', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['attachment_type_id']);
        });

        Schema::table('student_fees', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        Schema::table('student_fee_details', function (Blueprint $table) {
            $table->dropForeign(['student_fee_id']);
            $table->dropForeign(['payment_type_id']);
        });

        Schema::table('student_payments', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['payment_type_id']);
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['bank_id']);
        });

        Schema::table('student_payment_details', function (Blueprint $table) {
            $table->dropForeign(['student_payment_id']);
            $table->dropForeign(['student_fee_id']);
            $table->dropForeign(['student_fee_detail_id']);
        });

        Schema::table('class_routine_histories', function (Blueprint $table) {
            $table->dropForeign(['class_routine_id']);
            $table->dropForeign(['teacher_id']);
        });

        Schema::table('phase_promotion_histories', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['promoted_from']);
            $table->dropForeign(['promoted_to']);
            $table->dropForeign(['promoted_by']);
        });

        Schema::table('holidays', function (Blueprint $table) {
            $table->dropForeign(['session_id']);
            $table->dropForeign(['batch_type_id']);
        });

        Schema::table('notice_boards', function (Blueprint $table) {
            $table->dropForeign(['session_id']);
            $table->dropForeign(['batch_type_id']);
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('message_replies', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['message_id']);
        });

        Schema::table('lecture_materials', function (Blueprint $table) {
            $table->dropForeign(['class_routine_id']);
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
