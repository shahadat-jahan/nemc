<?php

use Illuminate\Support\Facades\Mail;

//Route::any('{query}', function() {
//    return view('service-discontinued'); // Redirects to the service discontinued page for any route
//})->where('query', '.*');

Route::get('admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('admin/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Queue Monitor Routes
Route::prefix('jobs')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', '\romanzipp\QueueMonitor\Controllers\ShowQueueMonitorController')->name('queue-monitor::index');
    Route::delete('monitors/{monitor}', '\romanzipp\QueueMonitor\Controllers\DeleteMonitorController')->name('queue-monitor::destroy');
    Route::delete('purge', '\romanzipp\QueueMonitor\Controllers\PurgeMonitorsController')->name('queue-monitor::purge');
});

Route::prefix('admin')->middleware(['web'])->group(function () {
    Route::get('test', 'TestController@index');
    Route::get('phn/test', 'TestController@emailPhone');

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('remove_fee', 'StatusController@removeFee');
    Route::get('remove_fee_extra', 'StatusController@remove_fee_extra');
    //Route::get('development_fee_update', 'StatusController@developmentFeeUpdate');

    Route::get('/', 'Auth\LoginController@login');
    Route::get('login', 'Auth\LoginController@login')->name('admin/login');
    Route::post('login', 'Auth\LoginController@doLogin')->name('login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('sms/test', function () {
        $client   = new \GuzzleHttp\Client();
        $response = $client->post('https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2', [
            'json' => [
                "username"    => "NEMPLdt058",
                "password"    => "Nemc@1998",
                "apicode"     => "1",
                "msisdn"      => "01912969336",
                "countrycode" => "880",
                "cli"         => "NEMC",
                "messagetype" => "1",
                "message"     => "Hello Test",
                "messageid"   => "0",
            ],
        ]);
        dd($response->getBody()->getContents());
    });

    Route::get('email/test', function () {
        $template = 'emails.defaultEmailTemplate';
        $subject  = 'Test email';
        $to       = 'shahadat.uddin@vivasoftltd.com';
        $cc       = 'protik.hore@vivasoftltd.com';
        if ($to) {
            Mail::send($template, ['body' => 'Test Message'], function ($message) use ($subject, $to, $cc) {
                $message->subject($subject);
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to(trim($to));
                if ($cc) {
                    $message->cc($cc);
                }
            });
        }

        dd('Done');
    });

    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('users', 'UsersController@index')->name('users');
        Route::get('users/profile', 'UsersController@profile');
        Route::get('users/getData', 'UsersController@getData');
        Route::get('users/create', 'UsersController@create')->name('users/create');
        Route::post('users/user-id/exist', 'UsersController@checkUserIdExist')->name('check.userId.exist');
        Route::post('users/check-email', 'UsersController@userUniqueEmailCheck')->name('user.email.unique');
        Route::get('users/change-password/{id}', 'UsersController@userChangePasswordForm')->name(
            'user.password-change.form',
        );
        Route::post('users/change-password/{id}', 'UsersController@userChangePassword')->name('user.password-change');

        Route::resource('users', 'UsersController');

        Route::get('user_groups/{id}/permission', 'UserGroupsController@permission');
        Route::post('user_groups/{id}/permission', 'UserGroupsController@updatePermission');
        //teacher permission
        Route::get('user_teacher_permission/{id}', 'UserGroupsController@getTeacherCurrentGroupPermission')->name(
            'teacher.group.permission',
        );
        Route::post('user_teacher_permission', 'UserGroupsController@updateTeacherPermission')->name(
            'teacher.extra.permission',
        );
        //user permission
        Route::get('admin_user_permission/{id}', 'UserGroupsController@getUserCurrentGroupPermission')->name(
            'admin.user.group.permission',
        );
        Route::post('admin_user_permission', 'UserGroupsController@updateAdminUserPermission')->name(
            'user.extra.permission',
        );

        Route::get('user_groups', 'UserGroupsController@index')->name('user_groups');
        Route::resource('user_groups', 'UserGroupsController');

        //user activity logs
        Route::get('activity-logs', 'ActivityLogsController@index')->name('activity.logs');
        Route::get('activity-logs/data', 'ActivityLogsController@data')->name('activity.logs.data');
        Route::get('activity-logs/{id}', 'ActivityLogsController@show')->name('activity.logs.show');

        //sessions
        // `routes/web.php`
        Route::get('sessions/{id}/archive', 'SessionController@archiveSession')->name('sessions.archive');
        Route::get('sessions/{id}/restore', 'SessionController@restoreSession')->name('sessions.restore');
        Route::post('sessions/check-batch', 'SessionController@checkBatchIsUnique')->name('session.batch.unique');
        Route::get('sessions/get-data', 'SessionController@getData');
        Route::resource('sessions', 'SessionController');

        //clone session
        Route::get('session_clone/{id}', 'SessionController@cloneSession')->name('session.clone');
        Route::post('session_clone/create', 'SessionController@saveCloneSessionData')->name('session.clone.save');

        //admission
        Route::post('admission/check-email', 'AdmissionController@checkEmail')->name('admission.email.unique');
        Route::post('admission/check-roll', 'AdmissionController@checkRollIsUnique')->name('admission.roll.unique');
        Route::post('admission/check-mobile', 'AdmissionController@checkMobile')->name('admission.mobile.unique');
        Route::get('admission/get-data', 'AdmissionController@getData');
        Route::get('admission/transfer_student/{id}', 'AdmissionController@transfertoStudent')->name(
            'admission.transfer.student.form',
        );
        Route::post('admission/transfer_student/{id}', 'AdmissionController@transferStudentData')->name(
            'admission.transfer.student',
        );
        Route::post('admission/applicants_import', 'AdmissionController@applicantsImport')->name(
            'admission.applicants.import',
        );
        //update single applicant status
        Route::put(
            'admission/admission_applicant_update/{applicantId}',
            'AdmissionController@updateSingleApplicantStatus',
        );
        Route::resource('admission', 'AdmissionController');

        //student
        Route::get('students/get-data', 'StudentController@getData');
        Route::post('students/check-student-id', 'StudentController@checkStudentDataUnique')->name(
            'admission.student_info.unique',
        );
        Route::post('students/check-student-mobile', 'StudentController@checkStudentMobileUnique')->name(
            'student.mobile.unique',
        );
        Route::post('students/check-student-registration', 'StudentController@checkStudentRegistrationUnique')->name(
            'student.registration.unique',
        );
        Route::get('students/get-admission-info', 'StudentController@getBatchInfo')->name(
            'admission.student.batch.info',
        );
        Route::get('students/lists', 'StudentController@getListsBySessionIdAndCourseId')->name(
            'student.info.session.course',
        );
        Route::get('students/{id}/installment', 'StudentController@installmentsList')->name(
            'students.installment.list',
        );
        Route::get('students/{id}/installment/data-table', 'StudentController@installmentsListDataTable')->name(
            'students.installment.datatable',
        );
        Route::get('students/{id}/installment/create', 'StudentController@makeInstallments')->name(
            'students.installment',
        );
        Route::post('students/{id}/installment/create', 'StudentController@saveInstallments')->name(
            'students.installment.post',
        );
        Route::get('students/{id}/installment/edit', 'StudentController@editInstallments')->name(
            'students.installment.edit',
        );
        Route::put('students/{id}/installment/', 'StudentController@updateInstallments')->name(
            'students.installment.update',
        );
        Route::get('students/{id}/attachment', 'StudentController@getAttachmentsList')->name(
            'students.attachment.list',
        );
        Route::get('students/{id}/attachment/data-table', 'StudentController@attachmentsListDataTable')->name(
            'students.attachment.datatable',
        );
        Route::get('students/{id}/attachment/create', 'StudentController@addAttachment')->name(
            'students.attachment.form',
        );
        Route::post('students/{id}/attachment', 'StudentController@saveAttachments')->name('students.attachment.post');
        Route::get('students/{id}/attachment/delete/{attachmentId}', 'StudentController@deleteAttachment')->name(
            'students.attachment.delete',
        );
        Route::get('students/lists/session-course', 'StudentController@getStudentsBySessionCoursePhaseTerm')->name(
            'students.list.session.course.phase.term',
        );
        Route::get('students/lists/session-course-phase', 'StudentController@getStudentsBySessionCoursePhase')->name(
            'students.list.session.course.phase',
        );
        Route::get('students/{id}/attendance', 'StudentController@getAttendanceByStudent')->name('students.attendance');
        Route::get('students/{id}/attendance/phase', 'StudentController@getAttendanceByStudentAndPhase')->name(
            'students.attendance.phase',
        );
        Route::get('students/{id}/card-item', 'StudentController@getCardItemsByStudent')->name('students.card-item');
        Route::get('students/{id}/card-item/phase', 'StudentController@getCardItemsByStudentAndPhase')->name(
            'students.card-item.phase',
        );
        Route::get('students/{id}/card-item/{cardId}', 'StudentController@getCardItemDetailByStudent')->name(
            'students.card-item-detail',
        );
        Route::get('students/{id}/exam-result', 'StudentController@getExamResultByStudent')->name(
            'students.exam-result',
        );
        Route::get('students/{id}/exam-result/phase', 'StudentController@getExamResultByStudentAndPhase')->name(
            'students.xam-result.phase',
        );
        Route::get('students/change-password/{id}', 'StudentController@changePasswordForm')->name(
            'student.password-change.form',
        );
        Route::post('students/change-password/{id}', 'StudentController@changePassword')->name(
            'student.password-change',
        );
        Route::get('students-roll', 'StudentController@studentsRoll')->name('students.roll');
        Route::put('students-roll-update', 'StudentController@studentsRollUpdate')->name('students.roll.update');
        Route::post('students/profile', 'StudentController@studentsProfile')->name('students.profile');
        Route::get('students/get-info', 'StudentController@getInfo')->name('students.getInfo');

        Route::resource('students', 'StudentController');

        //student id card
        Route::get('students/id_card/{id}', 'StudentController@generateIdCard')->name('students.idCard');
        //print student id card
        Route::get('students/id_card_print/{id}', 'StudentController@printIdCard')->name('students.card.print');
        //student testimonial
        Route::get('students/testimonial/{id}', 'StudentController@generateTestimonial')->name('students.testimonial');
        //print student testimonial
        Route::get('students/testimonial_print/{id}', 'StudentController@printTestimonial')->name(
            'students.testimonial.print',
        );

        //student fuzzy search
        Route::get('fuzzy-search-student', 'StudentController@fuzzySearch');

        //parents
        Route::get('guardians/get-data', 'GuardianController@getData');
        Route::get('guardians/info', 'GuardianController@getInfoByUserId')->name('guardian.info.userid');
        Route::get('guardians/change-password/{id}', 'GuardianController@changePasswordForm')->name(
            'guardian.password-change.form',
        );
        Route::post('guardians/change-password/{id}', 'GuardianController@changePassword')->name(
            'guardian.password-change',
        );
        Route::resource('guardians', 'GuardianController');

        //        Route::get('guardians/send/sms/{id}', 'GuardianController@sendTestSMS')->name('guardians.sms');

        //attachment
        Route::post('attachment/upload', 'AttachmentController@uploadAttachment')->name('attachment.upload');
        Route::post('attachment/image/crop', 'AttachmentController@cropImage')->name('attachment.crop.image');

        //student category
        Route::get('student_category/get-data', 'StudentCategoryController@getData');
        Route::resource('student_category', 'StudentCategoryController');

        //student groups
        Route::get('student_group/get-data', 'StudentGroupController@getData');
        Route::resource('student_group', 'StudentGroupController');

        Route::get('student_group_max_end_roll', 'StudentGroupController@getMaxEndRollNumber')->name(
            'student_group.max.end.roll',
        );
        Route::get(
            'student_group_list',
            'StudentGroupController@getStudentGroupBySessionIdCourseIdAndGroupTypeId',
        )->name('studentGroup.by.session.course.groupType');
        Route::get('student_group_list_subject', 'StudentGroupController@getStudentGroupBySubject')->name(
            'studentGroup.by.subject',
        );

        //student group type
        Route::get('student_group_type/get-data', 'StudentGroupTypeController@getData');
        Route::resource('student_group_type', 'StudentGroupTypeController');

        //term
        Route::get('term/get-data', 'TermController@getData');
        Route::resource('term', 'TermController');

        //phase
        Route::get('phase/get-data', 'PhaseController@getData');
        Route::resource('phase', 'PhaseController');

        //class Type
        Route::get('class_type/get-data', 'ClassTypeController@getData');
        Route::resource('class_type', 'ClassTypeController');

        //education board
        Route::get('education_board/get-data', 'EducationBoardController@getData');
        Route::resource('education_board', 'EducationBoardController');

        //exam category
        Route::get('exam_category/get-data', 'ExamController@getData');
        Route::resource('exam_category', 'ExamController');

        //exam type
        Route::get('exam_type/get-data', 'ExamTypeController@getData');
        Route::resource('exam_type', 'ExamTypeController');

        //exam sub type
        Route::get('exam_sub_type/get-data', 'ExamSubTypeController@getData');
        Route::resource('exam_sub_type', 'ExamSubTypeController');

        //exam setup
        Route::get('exams', 'ExamController@getExams')->name('exams.list');
        Route::get('exams/get-data', 'ExamController@getExamsDatatable')->name('exams.datatable');
        Route::get('exams/create', 'ExamController@createExam')->name('exams.create');
        Route::post('exams/create', 'ExamController@saveExam')->name('exams.save');
        Route::get('exams/{id}', 'ExamController@getExamDetail')->where('id', '[0-9]+')->name('exams.view');
        Route::get('exams/edit/{id}', 'ExamController@editExam')->name('exams.edit');
        Route::put('exams/{id}', 'ExamController@updateExam')->name('exams.update');
        Route::get('exams/subtypes/subject', 'ExamController@getExamSubTypes')->name('exams.sub-types-list.subject');
        Route::get(
            'exams/lists/session-course-phase-term',
            'ExamController@getExamsBySessionCoursePhaseTermType',
        )->name('exam.list.session.course.phase.term.type');
        Route::get(
            'exams/lists/session-course-phase-term-subject',
            'ExamController@getExamsBySessionCoursePhaseTermSubject',
        )->name('exam.list.session.course.phase.term.subject');
        Route::get('exams/subjects', 'ExamController@getExamsSubjects')->name('subjects.list.examId');
        Route::get('exams/exam-types', 'ExamController@getExamsTypesSubtypes')->name(
            'exam-types-subtypes.list.examId.subjectId',
        );
        Route::get('exams/check-exam-exist', 'ExamController@checkExamExist')->name('check.exam.exist');
        Route::post('exams/toggle-status', 'ExamController@toggleStatus')->name('exams.toggleStatus');
        Route::delete('exams/{id}', 'ExamController@deleteExam')->name('exams.delete');

        //exam marks setup
        Route::get('exams/mark/{id}', 'ExamController@setupExamMarks')->name('exams.mark.setup');
        Route::post('exams/mark/{id}', 'ExamController@saveExamMarks')->name('exams.mark.save');

        //exam result
        Route::get('result/get-data', 'ResultController@getData');
        Route::post('check-exam-result-published', 'ResultController@checkResultIsPublished')->name(
            'result.publish.check',
        );
        Route::get('result/show/{examId}/{subjectId}/{studentId?}', 'ResultController@showExamSubjectResult')
            ->where(['examId' => '[0-9]+', 'subjectId' => '[0-9]+', 'studentId' => '[0-9]+'])
            ->name('exam.subject.result.show');
        Route::get('result/{examId}/{subjectId}', 'ResultController@editExamSubject')->where(
            ['examId' => '[0-9]+', 'subjectId' => '[0-9]+'],
        )->name('exam.subject.make.edit');
        Route::put('result/{examId}/{subjectId}', 'ResultController@updateExamSubjectResult')->where(
            ['examId' => '[0-9]+', 'subjectId' => '[0-9]+'],
        )->name('exam.subject.result.update');
        Route::get('result/student/edit/{examId}/{subjectId}/{studentId}', 'ResultController@editStudentResult')
            ->where(['examId' => '[0-9]+', 'subjectId' => '[0-9]+', 'studentId' => '[0-9]+'])->name(
                'exam.subject.student.result.edit',
            );
        Route::post('result/student/edit/{examId}/{subjectId}/{studentId}', 'ResultController@updateStudentResult')
            ->where(['examId' => '[0-9]+', 'subjectId' => '[0-9]+', 'studentId' => '[0-9]+'])->name(
                'exam.subject.student.result.update',
            );
        Route::post('result/publish', 'ResultController@publishSingleExamResult')->name('result.publish');
        Route::post('result/export-exam-results', 'ResultController@exportExamResults')->name('export.exam.results');

        Route::post('result/toggle-edit-permission', 'ResultController@toggleEditPermission')->name(
            'result.toggle.edit.permission',
        );
        Route::post('result/edit-request-submit', 'ResultController@editRequestsubmit')->name(
            'result.edit.request.submit',
        );
        Route::resource('result', 'ResultController');

        //student progress
        Route::get('student_progress_result', 'StudentProgressController@getStudentsResults')->name(
            'student_progress_result',
        );
        Route::post(
            'student_progress_result/{student_id}/{phase_id}/{session_id}',
            'StudentProgressController@changeStudentPhaseStatus',
        );
        Route::get('student_progress_attendance', 'StudentProgressController@getStudentsAttendance');

        Route::get('course/get-data', 'CourseController@getData');
        Route::resource('course', 'CourseController');

        Route::get('designation/get-data', 'DesignationController@getData');
        Route::resource('designation', 'DesignationController');

        //department
        Route::get('department/get-data', 'DepartmentController@getData');
        Route::get(
            'department/list/session-course-phase',
            'DepartmentController@getDepartmentBySessionCoursePhase',
        )->name('departments.list.session.course.phase');
        Route::resource('department', 'DepartmentController');

        //subject
        Route::get('subject/get-data', 'SubjectController@getData');
        Route::get('subject/list-by-session-phase', 'SubjectController@getSubjectsBySessionCourseAndPhase')->name(
            'subjects.session.course.phase',
        );
        Route::get(
            'subject/group/list-by-session-phase',
            'SubjectController@getSubjectGroupsBySessionCourseAndPhase',
        )->name('subjects.group.session.course.phase');
        Route::get('subject/list-by-session-course', 'SubjectController@getSubjectGroupsBySessionAndCourse')->name(
            'subjects.session.course',
        );
        Route::get('subject/list-by-course-group', 'SubjectController@getSubjectsByCourseAndSubjectGroup')->name(
            'subjects.course.group',
        );
        Route::get('subject/course', 'SubjectController@getSubjectsByCourse')->name('subjects.course-id');
        Route::get('subject/group-id', 'SubjectController@getSubjectsByGroupId')->name('subjects.group');
        Route::resource('subject', 'SubjectController');

        //book
        Route::get('book/get-data', 'BookController@getData');
        Route::resource('book', 'BookController');

        //cards items
        Route::get('card_items', 'CardController@cardItems')->name('cardItems.index');
        Route::get('card_items/datatable', 'CardController@getItemsData');
        Route::get('card_items/create/{cardId?}', 'CardController@createCardItems')->name('cardItems.create');
        Route::post('card_items', 'CardController@saveCardItems')->name('cardItems.store');
        Route::get('card_items/{id}/edit', 'CardController@editCardItems')->name('cardItems.edit');
        Route::get('card_items/{id}', 'CardController@viewCardItems')->name('cardItems.view');
        Route::post('card_items/{id}', 'CardController@updateCardItems')->name('cardItems.update');
        Route::post('card_items/item-serial-number/exist', 'CardController@checkCardItemSerialNumberExist')->name(
            'check.ItemSerialNumber.exist',
        );
        Route::get('card_item_max_serial', 'CardController@getItemMaxSerialByCardId')->name('item.serial.cardId');
        Route::get('card_item_list', 'CardController@getItemNamesByCardId')->name('item.list.cardId');

        Route::get('exams/item/{id}/create', 'CardController@createItemExam')->name('exams.item.create');
        Route::post('exams/item/{id}', 'CardController@saveItemExam')->name('exams.item.save');

        Route::post('student_group_exam_mark', 'CardController@checkStudentGroupAlreadyGetMarkForItemExam')->name(
            'studentGroupAlreadyGetMark.check',
        );

        //cards
        Route::get('cards/get-data', 'CardController@getData');
        Route::get('cards/subjects/{subjectId}', 'CardController@getCardsBySubjectId');
        Route::resource('cards', 'CardController');

        //class routine
        Route::patch('class_routine/toggle-status', 'ClassRoutineController@toggleStatus')->name('class_routine.toggleStatus');
        Route::get('class_routine/get-data', 'ClassRoutineController@getData');
        Route::get('class_routine/getClasses/{id}/{isSpecificRoutine}', 'ClassRoutineController@getClasses');
        Route::get('class_routine/list', 'ClassRoutineController@routineLIst')->name('class_routine.list');
        Route::get('class_routine/list/pdf', 'ClassRoutineController@routineLIstPdf')->name('class_routine.list.pdf');
        Route::get('class_routine/print', 'ClassRoutineController@printClassRoutine')->name('class_routine.print');
        Route::get('class_routine/print/file', 'ClassRoutineController@printClassRoutineFile')->name(
            'class_routine.file.print',
        );
        Route::get('class_routine/phaseterm', 'ClassRoutineController@getPhaseAndTerm')->name('phase.term.list');
        Route::post('class_routine/check-schedule-exist', 'ClassRoutineController@checkScheduleExist')->name(
            'class_routine.schedule.check',
        );
        Route::get('class_routine/{id}/individual', 'ClassRoutineController@editIndividualClassRoutine')->name(
            'class_routine.edit.single',
        );
        Route::put('class_routine/{id}/individual', 'ClassRoutineController@updateIndividualClassRoutine')->name(
            'class_routine.update.single',
        );
        Route::get('class_routine_calendar', 'ClassRoutineController@getCalendar')->name('class_routine.calendar');
        Route::get('class_routine_calendar_days', 'ClassRoutineController@getAllClassDaysExceptHolidays')->name(
            'classRoutine.classDates.except.holiday',
        );
        Route::get(
            'student/group/list/{phase_id}/{course_id}/{session_id}/{subject_id}/{class_type_id}',
            'ClassRoutineController@getStudentGroupList',
        )->name('student.group.list');
        Route::get('class_routine/single', 'ClassRoutineController@getClassById')->name('class.single');
        Route::get('class-routine/fetch-by-month', 'ClassRoutineController@fetchByMonth')->name(
            'class_routine.fetchByMonth',
        );
        Route::get('class_routine/{id}/individual/detail', 'ClassRoutineController@getIndividualClassDetail')->name(
            'class_routine.info.single',
        );
        Route::resource('class_routine', 'ClassRoutineController');
        Route::get('class_routine/{id}/{flag}', 'ClassRoutineController@show');

        // Static Routine routes
        Route::get('static_routine/get-data', 'StaticRoutineController@getData');
        Route::get(
            'static_routine/get_by_phase_session',
            'StaticRoutineController@getStaticRoutinesByPhaseAndSession',
        )->name('static_routine.get_by_phase_session');
        Route::resource('static_routine', 'StaticRoutineController');

        //attendance
        Route::get('attendance/get-data/{id}', 'AttencanceController@getAttendanceByRoutineId')->name(
            'attendance.list.single',
        );
        Route::get('attendance/get-data', 'AttencanceController@getData');
        Route::resource('attendance', 'AttencanceController');
        Route::get('attendance/pdf/{class}', 'AttencanceController@pdf')->name('attendance.pdf');
        Route::post('attendance/send/sms', 'AttencanceController@queueSMS');
        Route::get('attendance/send/sms-details', 'AttencanceController@queueSMSDetails');
        Route::post('attendance/send/bulk/sms', 'AttencanceController@queueBulkSMS');
        Route::post('attendance/send/notification/parents', 'AttencanceController@sendNotificationsToParents')->name(
            'attendance.send.notification.parents',
        );

        //subject group
        Route::get('subject_group/get-data', 'SubjectGroupController@getData');
        Route::get(
            'subject_group/list-by-session-course-phase',
            'SubjectGroupController@getSubjectGroupBySessionCoursePhase',
        )->name('SubjectGroup.session.course.phase');
        Route::get('subject_group/list-by-course', 'SubjectGroupController@getSubjectGroupByCourse')->name(
            'SubjectGroup.course',
        );
        Route::resource('subject_group', 'SubjectGroupController');

        //topic head
        Route::get('topic_head/get-data', 'TopicHeadController@getData');
        Route::get('topic_head/subject', 'TopicHeadController@getTopicHead')->name('topic_head.subject_id');
        Route::resource('topic_head', 'TopicHeadController');

        //topic
        Route::get('topic/get-data', 'TopicController@getData');
        Route::get('topic_assign', 'TopicController@topicToTeacher')->name('assign.topic.form');
        Route::post('topic_assign/save', 'TopicController@assignTopicToTeacher')->name('assign.topic.save');
        Route::get('topic/subject', 'TopicController@getTopicsBySubjecId')->name('topic.subjects');
        Route::get('topic/list-by-subject', 'TopicController@listBySubject')->name('topic.list-by-subject');

        // Lesson Plan routes
        Route::get('lesson_plan', 'LessonPlanController@index')->name('lesson.plan.index');
        Route::get('lesson_plan/get-data', 'LessonPlanController@getData')->name('lesson.plan.data');
        Route::get('lesson_plan/{id}', 'LessonPlanController@show')->name('lesson.plan.show');
        Route::get('lesson_plan/{id}/edit', 'LessonPlanController@edit')->name('lesson.plan.edit');
        Route::put('lesson_plan/{id}', 'LessonPlanController@update')->name('lesson.plan.update');
        Route::get('lesson_plan/{id}/delete', 'LessonPlanController@delete')->name('lesson.plan.delete');
        Route::get('lesson_plan/{id}/pdf', 'LessonPlanController@exportPdf')->name('lesson.plan.pdf');
        Route::get('lesson_plan/{id}/download-pdf', 'LessonPlanController@downloadPdf')->name('lesson.plan.download.pdf');

        Route::get('topic/{id}/lesson_plan/create', 'LessonPlanController@create')->name('topic.lesson.plan.create');
        Route::post('topic/{id}/lesson_plan', 'LessonPlanController@store')->name('topic.lesson.plan.store');
        Route::get('topic/{id}/lesson_plan', 'LessonPlanController@indexByTopicId')->name('topic.lesson.plan.index');
        Route::get('topic/{id}/lesson_plan/get-data', 'LessonPlanController@getDataById')->name(
            'topic.lesson.plan.data.id',
        );
        Route::get('topic/{id}/lesson_plan/{teacherId}', 'LessonPlanController@allLessonPlansByTeacherId')->name(
            'topic.lesson.plan.by.teacher.id',
        );

        Route::resource('topic', 'TopicController');

        //attachment Type
        Route::get('attachment_type/get-data', 'AttachmentController@getData');
        Route::resource('attachment_type', 'AttachmentController');

        //teacher
        Route::get('teacher/get-data', 'TeacherController@getData');
        Route::get('teacher/change-password/{id}', 'TeacherController@changePasswordForm')->name(
            'teacher.password-change.form',
        );
        Route::post('teacher/change-password/{id}', 'TeacherController@changePassword')->name(
            'teacher.password-change',
        );
        Route::get('teacher/subject', 'TeacherController@getTeachersBySubjectId')->name('teacher.list.subject');
        Route::post('teacher/check-username', 'TeacherController@checkTeacherUserNameUnique')->name(
            'teacher.username.unique',
        );
        Route::post('teacher/check-email', 'TeacherController@teacherUniqueEmailCheck')->name('teacher.email.unique');
        Route::post('teacher/check-phone', 'TeacherController@teacherUniquePhoneCheck')->name('teacher.phone.unique');
        Route::get('teacher/attendance-pdf/{id}', 'TeacherController@attendancePdf')->name('teacher.attendance.pdf');
        Route::resource('teacher', 'TeacherController');

        //payment generate
        //Route::get('payment_generate', 'PaymentController@payment_generate_list')->name('payment.generate.list');
        Route::get('payment_generate/{id}', 'PaymentController@getBillDetail')->where(['id' => '[0-9]+'])->name(
            'payment.generate.show',
        );
        //Route::get('payment_generate/{id}/edit', 'PaymentController@editBillDetail')->where(['id' => '[0-9]+'])->name('payment.generate.edit');
        Route::get('payment_generate/create', 'PaymentController@generate_payment')->name('payment.generate.create');

        //payment collect
        Route::get('payment_collect', 'PaymentController@getStudentFee')->name('get.student.fee');
        Route::get('payment_collect/detail/{studentFeeId}', 'PaymentController@getStudentFeeDetails')->name(
            'student.fee.detail',
        );
        Route::get('payment_collect/create', 'PaymentController@findAndGetAttachmentId')->name(
            'collect.fee.attachment',
        );
        Route::post('payment_collect/save', 'PaymentController@saveStudentCollectedFee')->name(
            'receive.student.payment.save',
        );

        // *************************************************** generate fee *********************************************
        Route::get('generate_fee', 'PaymentController@generateStudentFee')->name('generate.student.fee.list');
        Route::get('generate_fee/{id}', 'PaymentController@showSingleStudentFee')->name('generate.student.fee.view');
        Route::get('generate_fee/{id}/edit', 'PaymentController@editSingleStudentFee')->name(
            'generate.student.fee.edit',
        );
        Route::get('generate_fee_detail/{id}/edit', 'PaymentController@editSingleInstallmentOfDevelopmentFee')->name(
            'development.installment-fee.single.edit',
        );
        Route::put('generate_fee_detail/{id}', 'PaymentController@updateSingleInstallmentOfDevelopmentFee')->name(
            'development.installment-fee.single.update',
        );
        Route::put('generate_fee/{id}', 'PaymentController@updateSingleStudentFee')->name(
            'generate.student.fee.update',
        );

        // *************************************************** generate tuition fee *********************************************
        Route::get('generate_tuition_fee', 'PaymentController@studentTuitionFeeList')->name('student.tuition.fee.list');
        Route::get('generate_tuition_fee/create', 'PaymentController@generateStudentTuitionFee')->name(
            'student.tuition.fee.create',
        );
        Route::get('generate_tuition_fee/{id}', 'PaymentController@showSingleStudentTuitionFee')->name(
            'student.tuition.fee.view',
        );
        Route::get('generate_tuition_fee/{id}/edit', 'PaymentController@editSingleStudentTuitionFee')->name(
            'student.tuition.fee.edit',
        );
        Route::put('generate_tuition_fee/{id}', 'PaymentController@updateSingleStudentTuitionFee')->name(
            'student.tuition.fee.update',
        );
        Route::get('adjust_tuition_fee/{id}/edit', 'PaymentController@adjustStudentTuitionFee')->name(
            'student.tuition.fee.adjust',
        );
        Route::put('adjust_tuition_fee/{id}', 'PaymentController@updateAdjustedTuitionFee')->name(
            'student.tuition.fee.adjust.update',
        );

        Route::post('generate_tuition_fee', 'PaymentController@saveStudentTuitionFee')->name(
            'student.tuition.fee.save',
        );
        // check student tuition fee already generated for current date range
        Route::post('student_tuitionFee_old', 'PaymentController@checkStudentTuitionFeeGeneratedForBillMonthTo')->name(
            'student.tuitionFee.paid.monthTo',
        );
        //staff dashboard fee-payment chart data for BD students
        Route::get('fees_payments', 'PaymentController@getFeesWithPaymentByCourseAndPhase')->name(
            'fees.payments.course.phase',
        );
        //staff dashboard fee-payment chart data for Foreign students
        Route::get('foreign_fees_payments', 'PaymentController@getForeignFeesWithPaymentByCourseAndPhase')->name(
            'foreign.fees.payments.course.phase',
        );

        // *************************************************** collect fee *********************************************
        Route::get('collect_fee', 'PaymentController@collectStudentFee')->name('get.student.development.fee');
        Route::get('collect_fee/{id}', 'PaymentController@showStudentFee')->where('id', '[0-9]+')->name(
            'student.fee.single.view',
        );
        /* Route::get('student_payment/{id}/edit', 'PaymentController@StudentPaymentEdit')->name('student.payment.edit');
        Route::put('student_payment/{id}', 'PaymentController@studentPaymentUpdate')->name('student.payment.update');*/
        Route::get('collect_fee/collect', 'PaymentController@studentFeeCollectForm')->name('student.fee.collect.form');
        Route::post('collect_fee/collect', 'PaymentController@saveStudentPaymentData')->name(
            'student.fee.collect.save',
        );
        Route::get('collect_fee_invoice_pdf/{id}/{stream?}', 'PaymentController@generateInvoicePdf')->name(
            'student.fee.collect.pdf',
        );
        Route::post('collect_fee/bulk_collect', 'PaymentController@saveBulkPayment')->name('bulk.payment.save');

        Route::get('collect_fee_single', 'PaymentController@collectSingleStudentFeeDetails')->name(
            'get.single.student.fee',
        );
        Route::get('collect_fee_single_roll', 'PaymentController@getSingleStudentRollNumber')->name(
            'get.single.student.roll',
        );
        Route::get('collect_fee_due_check', 'paymentcontroller@collectfeestudentduecheck')->name(
            'get.single.student.due',
        );
        Route::get('collect_fee_single_id', 'PaymentController@getSingleStudentAmount')->name(
            'get.single.student.amount',
        );
        Route::get('collect_fee_single_user_id', 'PaymentController@getSingleStudentAmountByUserId')->name(
            'student.amount.by.userId',
        );

        //generate absent fee
        Route::get('generate_absent_fee', 'PaymentController@payment_generate_list')->name('student.absent.fee.list');
        Route::get('generate_absent_fee/create', 'PaymentController@generate_payment')->name(
            'student.absent.fee.create',
        );
        Route::get('generate_absent_fee_count', 'PaymentController@getSingleStudentAbsentClassNumber')->name(
            'check.absentClassNumber.by.studentInfo',
        );
        Route::post('generate_absent_fee/check', 'PaymentController@checkPayment')->name('payment.absent.fee.check');
        Route::post('generated_absent_fee_phase/check', 'PaymentController@checkAbsentFeeAlreadyGenerated')->name(
            'absent.fee.generated.check',
        );
        Route::post('generate_absent_fee', 'PaymentController@savePayment')->name('student.absent.fee.save');

        //student payments
        Route::get('student_payment', 'PaymentController@getStudentPaymentByStudentIdAndDate')->name(
            'student.payment.list',
        );
        Route::get('student_payment/{id}/edit', 'PaymentController@StudentPaymentEdit')->name('student.payment.edit');
        Route::put('student_payment/{id}', 'PaymentController@studentPaymentUpdate')->name('student.payment.update');
        Route::get('student_payment/{id}', 'PaymentController@studentPaymentView')->name('student.payment.view');

        //payment type
        Route::get('payment_type/get-data', 'PaymentTypeController@getData');
        Route::resource('payment_type', 'PaymentTypeController');

        //payment method
        Route::get('payment_method/get-data', 'PaymentMethodController@getData');
        Route::resource('payment_method', 'PaymentMethodController');

        //bank
        Route::get('bank/get-data', 'BankController@getData');
        Route::resource('bank', 'BankController');

        //holiday setup
        Route::get('holiday/get-data', 'HolidayController@getData');
        Route::get('holiday/calendar', 'HolidayController@getCalendar')->name('holiday.calendar');
        Route::resource('holiday', 'HolidayController');

        //payment detail
        Route::get('payment_detail/get-data', 'PaymentDetailController@getData');
        Route::resource('payment_detail', 'PaymentDetailController');

        //notice board
        Route::get('notice_board/check-new-notice', 'NoticeBoardController@checkNewNotice');
        Route::get('notice_board/get-data', 'NoticeBoardController@getData');
        Route::resource('notice_board', 'NoticeBoardController');

        //hall setup
        Route::get('hall/get-data', 'HallController@getData');
        Route::resource('hall', 'HallController');

        //lecture material
        Route::get('lecture_material/get-data/{id}', 'LectureMaterialController@getLectureMaterialByRoutineId')->name(
            'lecture.material.list',
        );
        Route::get('lecture_material/get-data', 'LectureMaterialController@getData');
        Route::resource('lecture_material', 'LectureMaterialController');

        //message
        Route::get('message/get-data', 'MessageController@getData');
        Route::post('message', 'MessageController@store')->name('message.store');
        Route::resource('message', 'MessageController');

        //message reply
        Route::post('message_reply/{message_id}', 'MessageController@saveReplyMessage')->name('message.reply');

        /*Route::get('messages/get-data', 'Admin\MessageController@getData');
        Route::post('messages/{id}', 'Admin\MessageController@post_comment')->name('storage.comment.post');
        Route::resource('messages', 'Admin\MessageController');*/

        //Notifications
        Route::resource('notifications', 'NotificationController');

        //reports
        Route::get('report_exam_result', 'ReportExamResultController@index')->name('report.exam_result.category.index');
        Route::get('report_exam_result/type/excel', 'ReportExamResultController@exportResultsByCategory')->name(
            'report.exam_result.category.excel',
        );
        Route::get('report_exam_result/type/pdf', 'ReportExamResultController@resultsByCategoryPdf')->name(
            'report.exam_result.category.pdf',
        );

        Route::get('report_exam_result_phase', 'ReportExamResultController@resultByPhase')->name(
            'report.exam_result.phase.index',
        );
        Route::get('report_exam_result/phase/excel', 'ReportExamResultController@exportResultsByPhase')->name(
            'report.exam_result.phase.excel',
        );
        Route::get('report_exam_result/phase/pdf', 'ReportExamResultController@resultsByPhasePdf')->name(
            'report.exam_result.phase.pdf',
        );

        Route::get('report_exam_result_student', 'ReportExamResultController@resultByStudent')->name(
            'report.exam_result.student.index',
        );
        Route::get('report_exam_result_student/excel', 'ReportExamResultController@exportResultsByStudent')->name(
            'report.exam_result.student.excel',
        );
        Route::get('report_exam_result_student/pdf', 'ReportExamResultController@resultsByStudentPdf')->name(
            'report.exam_result.student.pdf',
        );

        Route::get('report_admission', 'ReportController@admissionReport');
        Route::get('report_admission/{type}', 'ReportController@admissionReportByType')->name('report.admission.type');
        Route::get('report_admission/print/{type}', 'ReportController@printAdmissionReportByType')->name(
            'report.admission.print.type',
        );
        Route::get('report_admission/excel/{type}', 'ReportController@exportAdmissionReportByType')->name(
            'report.admission.excel.type',
        );
        //single applicant detail
        Route::get('report_admission_applicant/{id}', 'ReportController@applicantSingleReport')->name(
            'applicant.single.report',
        );
        //single applicant detail print
        Route::get('report_admission_applicant_print/{id}', 'ReportController@applicantSingleDetailPrint')->name(
            'applicant.single.print',
        );

        // student admission report
        Route::get('report_student_admission', 'ReportController@studentAdmissionReport');
        Route::get('report_student_admission/{type}', 'ReportController@studentAdmissionReportByType')->name(
            'report.student.admission.type',
        );
        Route::get(
            'report_student_admission/excel/{type}',
            'ReportController@exportStudentAdmissionReportByType',
        )->name('report.student.admission.excel.type');
        Route::get('report_student_admission/print/{type}', 'ReportController@printStudentAdmissionReportByType')->name(
            'report.student.admission.print.type',
        );
        //single student applicant detail
        Route::get('report_single_student_admission/{id}', 'ReportController@admissionSingleStudentReport')->name(
            'admission.student.single.report',
        );
        //single student applicant detail print
        Route::get(
            'report_single_student_admission_print/{id}',
            'ReportController@admissionSingleStudentDetailPrint',
        )->name('admission.student.single.print');
        //Route::get('report_student_admission/{all}', 'ReportController@allStudentAdmissionReport')->name('report.all.student.admission');

        //attendance report
        Route::get('report_attendance', 'ReportController@attendanceReport');
        Route::get('report_attendance/excel', 'ReportController@attendanceReportInExcel')->name(
            'report.attendance.excel',
        );
        Route::get('report_attendance/pdf', 'ReportController@attendanceReportInPdf')->name('report.attendance.pdf');
        //comparative attendance report
        Route::get('report_comparative_attendance', 'ReportController@comparativeAttendanceReport');
        Route::get('report_comparative_attendance/pdf', 'ReportController@comparativeAttendanceReportPdf')->name(
            'report.comparative_attendance.pdf',
        );
        Route::get('report_comparative_attendance/excel', 'ReportController@comparativeAttendanceReportExcel')->name(
            'report.comparative_attendance.excel',
        );
        //attendance by term
        Route::get('report_attendance_by_term', 'ReportController@attendanceByTermReport');
        Route::get('report_attendance_by_term/excel', 'ReportController@attendanceByTermReportInExcel')->name(
            'report.attendance.term.excel',
        );
        Route::get('report_attendance_by_term/pdf', 'ReportController@attendanceByTermReportInPdf')->name(
            'report.attendance.term.pdf',
        );
        //attendance by phase
        Route::get('report_attendance_by_phase', 'ReportController@attendanceByPhaseReport');
        Route::get('report_attendance_by_phase/excel', 'ReportController@attendanceByPhaseReportInExcel')->name(
            'report.attendance.phase.excel',
        );
        Route::get('report_attendance_by_phase/pdf', 'ReportController@attendanceByPhaseReportInPdf')->name(
            'report.attendance.phase.pdf',
        );
        //attendance by student
        Route::get('report_attendance_by_student', 'ReportController@attendanceByStudentReport');
        Route::get('report_attendance_by_student/excel', 'ReportController@attendanceByStudentReportInExcel')->name(
            'report.attendance.student.excel',
        );
        Route::get('report_attendance_by_student/pdf', 'ReportController@attendanceByStudentReportInPdf')->name(
            'report.attendance.student.pdf',
        );

        //Due reports
        Route::get('reports-due-by-session', 'ReportController@dueBySession');
        Route::get('reports-due-by-session/pdf', 'ReportController@dueBySessionPdf')->name('report.due.session.pdf');
        Route::get('reports-due-by-session/excel', 'ReportController@dueBySessionExcel')->name(
            'report.due.session.excel',
        );

        //students payment reports
        //single student
        Route::get('report_student_payment', 'ReportController@studentPaymentReport');
        Route::get('report_student_payment/pdf', 'ReportController@studentPaymentReportPdf')->name(
            'report.payment.student.pdf',
        );
        Route::get('report_student_payment/excel', 'ReportController@exportStudentPaymentReport')->name(
            'report.payment.student.excel',
        );
        //all students
        Route::get('report_all_student_payment', 'ReportController@allStudentPaymentReport');
        Route::get('report_all_student_payment/pdf', 'ReportController@allStudentPaymentReportPdf')->name(
            'report.payment.all.student.pdf',
        );
        Route::get('report_all_student_payment/excel', 'ReportController@exportAllStudentPaymentReport')->name(
            'report.payment.all.student.excel',
        );

        //student list and detail print today Class Routine
        Route::get('report_student_list', 'ReportController@studentListReport')->name('student.list.report');
        Route::get('print_student_list', 'ReportController@studentListPrint')->name('student.list.print');
        Route::get('report_all_student/excel', 'ReportController@exportStudentListReport')->name(
            'report.student.list.excel',
        );
        Route::get('report_student_list/{id}', 'ReportController@studentSingleReport')->name('student.single.report');
        Route::get('report_student_single_print/{id}', 'ReportController@studentSinglePrint')->name(
            'student.single.print',
        );

        //teacher list and detail print
        Route::get('report_teacher_list', 'ReportController@teacherListReport')->name('teacher.list.report');
        Route::get('print_teacher_list', 'ReportController@teacherListPrint')->name('teacher.list.print');
        Route::get('teacher_list_pdf', 'ReportController@teacherListPdf')->name('teacher.list.pdf');
        Route::get('teacher_list_export', 'ReportController@teacherListExport')->name('teacher.list.export');
        Route::get('report_teacher_list/{id}', 'ReportController@teacherSingleReport')->name('teacher.single.report');
        Route::get('report_teacher_single_print/{id}', 'ReportController@teacherSinglePrint')->name(
            'teacher.single.print',
        );
        Route::get('report_teacher_wise_class', 'ReportController@teacherWiseClass');
        Route::get('report_teacher_wise_class/excel', 'ReportController@exportTeacherWiseClassReport')->name(
            'report.teacher.all.class.excel',
        );

        //parent list and detail print
        Route::get('report_parent_list', 'ReportController@parentListReport')->name('parent.list.report');
        Route::get('pdf_parent_list', 'ReportController@parentListPdf')->name('parent.list.pdf');
        Route::get('report_parent_excel', 'ReportController@exportParentReport')->name('report.parent.list.excel');

        //sms email report
        Route::get('report_sms_email_report', 'ReportController@SMSEmailReport')->name('sms.email.report');
        Route::get('sms_email_history/get-data', 'ReportController@getData');
        Route::get('report_campaign_report', 'ReportController@campaignReport')->name('campaign.report');
        Route::get('campaign_logs/get-data', 'ReportController@campaignGetData');
        //dashboard requests
        Route::get('dashboard/get-today-attendance', 'DashboardController@todayAttendance')->name(
            'chart.attendance.today',
        );
        Route::get('dashboard/get-today-routine', 'DashboardController@todayClassRoutine')->name('table.routine.today');
        Route::get('dashboard/get-last-week-routine', 'DashboardController@lastWeekClassRoutine')->name(
            'table.routine.last.week',
        );
        Route::get('dashboard/card-items', 'DashboardController@cardItemsResult')->name('chart.card-items.phase');
        Route::get('dashboard/upcoming-exams', 'DashboardController@upcomingExams')->name('table.exams.upcoming');
        Route::get('dashboard/get-monthly-attendance', 'DashboardController@monthlyAttendance')->name(
            'chart.attendance.month',
        );

        //application setting
        Route::get('application_setting', 'ApplicationSettingController@index')->name('application.setting.index');
        Route::put('application_setting/{id}/edit', 'ApplicationSettingController@update')->name(
            'application.setting.update',
        );

        //academic calender
        Route::get('academic_calendar', 'AcademicCalendarController@index')->name('get.academic.calender.data');
        Route::get('academic_calendar_pdf', 'AcademicCalendarController@generatePdf')->name(
            'academic.calender.data.pdf',
        );

        //Pages
        /*Route::get('pages/getData', 'Admin\PageController@getData');
        Route::resource('pages', 'Admin\PageController');*/

        //update notification
        Route::post('update-seen-status', 'NotificationController@updateSeenStatus')->name(
            'notification.update-status',
        );

        //change password
        Route::get('change-password', 'UsersController@changePassword')->name('user.change-password');
        Route::post('change-password', 'UsersController@updatePassword')->name('user.change-password.post');
        Route::get('cancel-password', 'UsersController@cancelPassword')->name('user.cancel-password');

        Route::get('local/student/mobile/email/export', 'ExcelImportExportController@localStudentMobileEmailExport');
        Route::get(
            'local/student/parent/mobile/email/export',
            'ExcelImportExportController@localStudentParentMobileEmailExport'
        );

        // Campaigns
        Route::group(['prefix' => 'campaigns', 'as' => 'campaigns.'], function () {
            Route::get('/', 'CampaignController@index')->name('index');
            Route::get('/get-data', 'CampaignController@getData')->name('get-data');
            Route::get('/create', 'CampaignController@create')->name('create');
            Route::post('/store', 'CampaignController@store')->name('store');
            Route::get('/search-recipients', 'CampaignController@searchRecipients')->name('search-recipients');
            Route::get('/{id}', 'CampaignController@show')->name('show');
            Route::get('/{id}/edit', 'CampaignController@edit')->name('edit');
            Route::put('/{id}/update', 'CampaignController@update')->name('update');
            Route::get('/{id}/rerun', 'CampaignController@rerun')->name('rerun');
        });

        // Campaign Reports (New SMS/Email Feature)
        Route::get('report_new_campaign', 'CampaignReportController@index')->name('report.new_campaign.index');
        Route::get('report_new_campaign/excel', 'CampaignReportController@exportExcel')->name('report.new_campaign.excel');
        Route::get('report_new_campaign/pdf', 'CampaignReportController@exportPdf')->name('report.new_campaign.pdf');
    });
});

/*Route::view('/{path?}', 'app');
Route::view('/{path}/{id}', 'app');*/
