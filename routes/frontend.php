<?php

Route::group(['middleware' => ['web'], 'as' => 'frontend.'], function () {
    Route::get('/', 'FrontEnd\StudentParentController@index');
    Route::get('/home', 'FrontEnd\StudentParentController@home');
    //Route::get('/', 'FrontEnd\Auth\LoginController@login');
    Route::get('/frontend', 'FrontEnd\Auth\LoginController@login');
    Route::get('login', 'FrontEnd\Auth\LoginController@login')->name('login.form');
    Route::post('login', 'FrontEnd\Auth\LoginController@doLogin')->name('login');

//    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    Route::prefix('nemc')->middleware(['web', 'student.parent.auth'])->namespace('FrontEnd')->group(function () {
        Route::get('/dashboard', 'DashboardController@index');

        //student
        Route::get('students/get-data', 'StudentController@getData');
        Route::get('students/', 'StudentController@index')->name('students.index');
        Route::get('students/{id}', 'StudentController@show')->name('students.view')->where(['id' => '[0-9]+']);
        Route::get('students/lists', 'StudentController@getListsBySessionIdAndCourseId')->name('student.info.session.course');
        Route::get('students/{id}/attachment', 'StudentController@getAttachmentsList')->name('students.attachment.list');
        Route::get('students/{id}/attachment/data-table', 'StudentController@attachmentsListDataTable')->name('students.attachment.datatable');

        Route::get('students/{id}/attendance', 'StudentController@getAttendanceByStudent')->name('students.attendance');
        Route::get('students/{id}/card-item', 'StudentController@getCardItemsByStudent')->name('students.card-item');
        Route::get('students/{id}/exam-result', 'StudentController@getExamResultByStudent')->name('students.exam-result');
        Route::get('students/{id}/attendance/phase', 'StudentController@getAttendanceByStudentAndPhase')->name('students.attendance.phase');
        Route::get('students/{id}/card-item/{cardId}', 'StudentController@getCardItemDetailByStudent')->name('students.card-item-detail');
        Route::get('students/{id}/exam-result/phase', 'StudentController@getExamResultByStudentAndPhase')->name('students.xam-result.phase');
        Route::get('students/id_card/{id}', 'StudentController@generateIdCard')->name('students.idCard');
        Route::get('students/lists/session-course-phase', 'StudentController@getStudentsBySessionCoursePhase')->name('students.list.session.course.phase');

        Route::get('students/change-password/{id}', 'StudentController@changePasswordForm')->name('student.password-change.form');
        Route::post('students/change-password/{id}', 'StudentController@changePassword')->name('student.password-change');
        Route::resource('students', 'StudentController')->names([
            'index' => 'students.index',
            'show' => 'students.show',
        ]);

        //parent
        Route::get('guardians/get-data', 'GuardianController@getData');
        Route::get('guardians/', 'GuardianController@index')->name('guardians.index');
        Route::get('guardians/{id}', 'GuardianController@show')->name('guardians.show');
        Route::get('guardians/change-password/{id}', 'GuardianController@changePasswordForm')->name('guardian.password-change.form');
        Route::post('guardians/change-password/{id}', 'GuardianController@changePassword')->name('guardian.password-change');

        //subject
        Route::get('subject/get-data', 'SubjectController@getData');
        Route::get('subject/list-by-session-phase', 'SubjectController@getSubjectsBySessionCourseAndPhase')->name('subjects.session.course.phase');
        Route::get('subject/list-by-session-course', 'SubjectController@getSubjectGroupsBySessionAndCourse')->name('subjects.session.course');
        Route::get('subject/list-by-course-group', 'SubjectController@getSubjectsByCourseAndSubjectGroup')->name('subjects.course.group');
        Route::get('subject/group-id', 'SubjectController@getSubjectsByGroupId')->name('subjects.group');

        Route::resource('subject', 'SubjectController')->names([
            'index' => 'subject.index',
            'show' => 'subject.show',
        ]);

        //subject group
        Route::get('subject_group/get-data', 'SubjectGroupController@getData');
        Route::get('subject_group/list-by-session-course-phase', 'SubjectGroupController@getSubjectGroupBySessionCoursePhase')->name('SubjectGroup.session.course.phase');
        Route::get('subject_group/list-by-course', 'SubjectGroupController@getSubjectGroupByCourse')->name('subjectGroup.course');
        Route::resource('subject_group', 'SubjectGroupController');

        //topic head
        Route::get('topic_head/get-data', 'TopicHeadController@getData');
        Route::get('topic_head/subject', 'TopicHeadController@getTopicHead')->name('topic_head.subject_id');
        Route::resource('topic_head', 'TopicHeadController');

        //topic
        Route::get('topic/get-data', 'TopicController@getData');
        //Route::get('topic_assign', 'TopicController@topicToTeacher')->name('assign.topic.form');
        //Route::post('topic_assign/save', 'TopicController@assignTopicToTeacher')->name('assign.topic.save');
        //Route::get('topic/subject', 'TopicController@getTopicsBySubjecId')->name('topic.subjects');
        Route::resource('topic', 'TopicController');

        //cards
        Route::get('cards/get-data', 'CardController@getData');
        Route::get('cards/subjects/{subjectId}', 'CardController@getCardsBySubjectId');
        Route::resource('cards', 'CardController');

        //cards items
        Route::get('card_items', 'CardController@cardItems')->name('cardItems.index');
        Route::get('card_items/datatable', 'CardController@getItemsData');



        //reports
        Route::get('report_exam_result', 'ReportExamResultController@index')->name('report.exam_result.category.index');
        Route::get('report_exam_result/type/excel', 'ReportExamResultController@exportResultsByCategory')->name('report.exam_result.category.excel');
        Route::get('report_exam_result_phase', 'ReportExamResultController@resultByPhase')->name('report.exam_result.phase.index');
       // Route::get('report_exam_result/phase/excel', 'ReportExamResultController@exportResultsByPhase')->name('report.exam_result.phase.excel');
        //Route::get('report_exam_result_student', 'ReportExamResultController@resultByStudent')->name('report.exam_result.student.index');
       // Route::get('report_exam_result_student/excel', 'ReportExamResultController@exportResultsByStudent')->name('report.exam_result.student.excel');

        //attendance by student
        Route::get('report_attendance_by_student', 'ReportController@attendanceByStudentReport')->name('report.attendance.student');
        Route::get('report_attendance_by_student/excel', 'ReportController@attendanceByStudentReportInExcel')->name('report.attendance.student.excel');
        Route::get('report_attendance_by_student/pdf', 'ReportController@attendanceByStudentReportInPdf')->name('report.attendance.student.pdf');

        //book
        Route::get('book/get-data', 'BookController@getData');
        Route::resource('book', 'BookController')->names([
            'index' => 'book.index',
            'show' => 'book.show',
        ]);

        //lecture material
        Route::get('lecture_material/get-data', 'LectureMaterialController@getData');
        Route::get('lecture_material/get-data/{id}', 'LectureMaterialController@getLectureMaterialByRoutineId')->name('lecture.material.list');
        Route::resource('lecture_material', 'LectureMaterialController')->names([
            'index' => 'lecture_material.index',
            'show' => 'lecture_material.show',
        ]);

        //teacher
        Route::get('teacher/get-data', 'TeacherController@getData');
        Route::get('teacher/subject', 'TeacherController@getTeachersBySubjectId')->name('teacher.list.subject');
        // evaluation actions within TeacherController
        Route::get('teacher/{teacherId}/evaluation/create', 'TeacherController@evaluationCreate')->name('teacher.evaluation.create');
        Route::post('teacher/{teacherId}/evaluation', 'TeacherController@evaluationStore')->name('teacher.evaluation.store');
        Route::get('teacher/evaluation/{id}/edit', 'TeacherController@evaluationEdit')->name('teacher.evaluation.edit');
        Route::put('teacher/evaluation/{id}', 'TeacherController@evaluationUpdate')->name('teacher.evaluation.update');

        Route::resource('teacher', 'TeacherController')->names([
            'index' => 'teacher.index',
            'show' => 'teacher.show',
        ]);

        //class routine
        Route::get('class_routine/get-data', 'ClassRoutineController@getData');
        Route::get('class_routine/getClasses/{id}', 'ClassRoutineController@getClasses');
        Route::get('class_routine/list', 'ClassRoutineController@routineLIst')->name('class_routine.list');
        Route::get('class_routine/list/pdf', 'ClassRoutineController@routineLIstPdf')->name('class_routine.list.pdf');
        Route::get('class_routine/print', 'ClassRoutineController@printClassRoutine')->name('class_routine.print');
        Route::get('class_routine/phaseterm', 'ClassRoutineController@getPhaseAndTerm')->name('phase.term.list');
        Route::post('class_routine/check-schedule-exist', 'ClassRoutineController@checkScheduleExist')->name('class_routine.schedule.check');
        //Route::get('class_routine/{id}/individual', 'ClassRoutineController@editIndividualClassRoutine')->name('class_routine.edit.single');
        //Route::put('class_routine/{id}/individual', 'ClassRoutineController@updateIndividualClassRoutine')->name('class_routine.update.single');
        Route::get('class_routine/{id}/individual/detail', 'ClassRoutineController@getIndividualClassDetail')->name('class_routine.info.single');
        Route::get('class_routine_calendar', 'ClassRoutineController@getCalendar')->name('class_routine.calendar');
        //Route::resource('class_routine', 'ClassRoutineController');
        Route::get('class_routine/{id}/{flag}', 'ClassRoutineController@show');
        Route::resource('class_routine', 'ClassRoutineController')->names([
            'index' => 'class_routine.index',
            'show' => 'class_routine.show',
        ]);

        //holiday setup
        Route::get('holiday/get-data', 'HolidayController@getData');
        Route::resource('holiday', 'HolidayController')->names([
            'index' => 'holiday.index',
            'show' => 'holiday.show',
        ]);



        //attendance
        Route::get('attendance/get-data/{id}', 'AttencanceController@getAttendanceByRoutineId')->name('attendance.list.single');
        Route::get('attendance/get-data', 'AttencanceController@getData');
        Route::resource('attendance', 'AttencanceController')->names([
            'index' => 'attendance.index',
            'show' => 'attendance.show',
        ]);

        //notice board
        Route::get('notice_board/check-new-notice', 'NoticeBoardController@checkNewNotice');
        Route::get('notice_board/get-data', 'NoticeBoardController@getData');
        Route::resource('notice_board', 'NoticeBoardController')->names([
            'index' => 'notice_board.index',
            'show' => 'notice_board.show',
        ]);


        //report
        Route::get('report_exam_result_student', 'ReportExamResultController@resultByStudent')->name('report.exam_result.student.index');
        Route::get('report_exam_result_student/excel', 'ReportExamResultController@exportResultsByStudent')->name('report.exam_result.student.excel');
        Route::get('report_exam_result_student/pdf', 'ReportExamResultController@resultsByStudentPdf')->name('report.exam_result.student.pdf');
        Route::get('exams/lists/session-course-phase-term', 'ExamController@getExamsBySessionCoursePhaseTermType')->name('exam.list.session.course.phase.term.type');
        Route::get('report_exam_result', 'ReportExamResultController@index')->name('report.exam_result.category.index');
        Route::get('report_exam_result/type/excel', 'ReportExamResultController@exportResultsByCategory')->name('report.exam_result.category.excel');
        Route::get('report_exam_result/type/pdf', 'ReportExamResultController@resultsByCategoryPdf')->name('report.exam_result.category.pdf');
        //students payment
//        Route::get('report_student_payment', 'ReportController@studentPaymentReport');
//        Route::get('report_student_payment/excel', 'ReportController@exportStudentPaymentReport')->name('report.paymnet.student.excel');



        //exam setup
        Route::get('exams', 'ExamController@getExams')->name('exams.list');
        Route::get('exams/get-data', 'ExamController@getExamsDatatable')->name('exams.datatable');
        Route::get('exams/{id}', 'ExamController@getExamDetail')->where('id', '[0-9]+')->name('exams.view');
        Route::get('exams/lists/session-course-phase-term-subject', 'ExamController@getExamsBySessionCoursePhaseTermSubject')->name('exam.list.session.course.phase.term.subject');
        Route::get('exams/subjects', 'ExamController@getExamsSubjects')->name('subjects.list.examId');
        //exam result
        Route::get('result/get-data', 'ResultController@getData');
        Route::get('result/show/{examId}/{subjectId}', 'ResultController@showExamSubjectResult')->where(['examId' => '[0-9]+', 'subjectId' => '[0-9]+'])->name('exam.subject.result.show');
        Route::get('result', 'ResultController@index')->where(['examId' => '[0-9]+', 'subjectId' => '[0-9]+'])->name('result.index');
        Route::get('result/{id}', 'ResultController@show')->where(['examId' => '[0-9]+', 'subjectId' => '[0-9]+'])->name('result.show');

        //academic calendar
        Route::get('academic_calendar', 'AcademicCalendarController@index')->name('get.academic.calender.data');
        Route::get('academic_calendar_pdf', 'AcademicCalendarController@generatePdf')->name('academic.calender.data.pdf');


        //message
        Route::get('message/get-data', 'MessageController@getData');
        Route::post('message', 'MessageController@store')->name('message.store');
        Route::get('message', 'MessageController@index')->name('message.list');
        Route::get('message/{id}', 'MessageController@show')->name('message.show');

        //message reply
        Route::post('message_reply/{message_id}', 'MessageController@saveReplyMessage')->name('message.reply');


        //Notifications
        Route::resource('notifications', 'NotificationController');

        //dashboard requests
        Route::get('dashboard/student-card-blocks', 'DashboardController@getStudentCardBlocksData')->name('dashboard.student.card-blocks');
        Route::get('dashboard/student-attendance-summary', 'DashboardController@getSubjectWiseStudentAttendanceSummary')->name('dashboard.student.attendance-summary');
        Route::get('dashboard/get-today-class-routine', 'DashboardController@studentTodayClassRoutine')->name('table.class.routine.today');
        Route::get('dashboard/get-last-week-class-routine', 'DashboardController@studentLastWeekClassAttendance')->name('table.class.routine.last.week');
        Route::get('dashboard/student-card-items', 'DashboardController@studentCardItemsResult')->name('chart.card-items.student');
        Route::get('dashboard/student-upcoming-exams', 'DashboardController@studentUpcomingExams')->name('table.exams.upcoming');

        //update notification
        Route::post('update-seen-status', 'NotificationController@updateSeenStatus')->name('notification.update-status');

        //change password
        Route::get('change-password', 'UsersController@changePassword')->name('user.change-password');
        Route::post('change-password', 'UsersController@updatePassword')->name('user.change-password.post');
        Route::get('cancel-password', 'UsersController@cancelPassword')->name('user.cancel-password');

        // *************************************************** generate fee *********************************************
        Route::get('generate_fee', 'PaymentController@generateStudentFee')->name('generate.student.fee.list');
        Route::get('generate_fee/{id}', 'PaymentController@showSingleStudentFee')->name('generate.student.fee.view');

        // *************************************************** collect fee *********************************************
        Route::get('collect_fee', 'PaymentController@collectStudentFee')->name('get.student.development.fee');
        Route::get('collect_fee/{id}', 'PaymentController@showStudentFee')->where('id', '[0-9]+')->name('student.fee.single.view');
        Route::get('collect_fee_single', 'PaymentController@collectSingleStudentFeeDetails')->name('get.single.student.fee');
        Route::get('collect_fee_single_roll', 'PaymentController@getSingleStudentRollNumber')->name('get.single.student.roll');
        //student payments
        Route::get('student_payment', 'PaymentController@getStudentPaymentByStudentIdAndDate')->name('student.payment.list');
        //Route::get('student_payment/{id}/edit', 'PaymentController@StudentPaymentEdit')->name('student.payment.edit');
        //Route::put('student_payment/{id}', 'PaymentController@studentPaymentUpdate')->name('student.payment.update');
        Route::get('student_payment/{id}', 'PaymentController@studentPaymentView')->name('student.payment.view');


        Route::get('logout', 'Auth\LoginController@logout');
    });


    /*Route::group(['middleware' => ['web', 'student.parent.auth']], function () {
        Route::get('/dashboard', 'HomeDashboardController@index');
        Route::get('logout', 'FrontEnd\Auth\LoginController@logout');
    });*/

});
