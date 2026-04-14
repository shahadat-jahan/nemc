<?php

/**
 * Memu list
 * @return array
 */
return [
    'dashboard'            => [
        'title'    => 'Dashboard',
        'icon'     => 'flaticon-dashboard',
        'actions'  => ['index'],
        'children' => []
    ],
    'admission_management' => [
        'title'    => 'Admission',
        'icon'     => 'fas fa-university',
        'actions'  => [],
        'children' => [
            'admission' => ['title'   => 'Applicants', 'icon' => 'fas fa-user-graduate',
                            'actions' => ['index', 'create', 'edit', 'view', 'transfer', 'delete']
            ],
        ]
    ],
    'students_management'  => [
        'title'    => 'Student Management',
        'icon'     => 'fas fa-user-graduate',
        'actions'  => [],
        'children' => [
            'students'      => [
                'title'   => 'Students', 'icon' => 'fas fa-user-graduate',
                'actions' => ['index', 'create', 'edit', 'view', 'installment', 'password', 'attachment']
            ],
            'students-roll' => ['title' => 'Students Roll', 'icon' => 'fas fa-list', 'actions' => ['index', 'edit',]],
        ]
    ],

    'guardians'       => [
        'title'    => 'Parent Management',
        'icon'     => 'fas fa-user',
        'actions'  => ['index', 'edit', 'password', 'view'],
        'children' => []
    ],
    'sessions'        => [
        'title'    => 'Session Management',
        'icon'     => 'flaticon-calendar-2',
        'actions'  => ['index', 'create', 'edit', 'view'],
        'children' => []
    ],
    'user_management' => [
        'title'    => 'User Management',
        'icon'     => 'fa fa-users',
        'actions'  => [],
        'children' => [
            'users'         => [
                'title'   => 'Users', 'icon' => 'fa fa-user',
                'actions' => ['index', 'create', 'edit', 'view', 'password', 'permission']
            ],
            'user_groups'   => [
                'title'   => 'User Groups', 'icon' => 'fa fa-users',
                'actions' => ['index', 'create', 'edit', 'permission']
            ],
            'activity-logs' => ['title'   => 'User Activity Logs', 'icon' => 'fa fa-history',
                                'actions' => ['index', 'view']
            ]
        ]
    ],

    'lecture_material' => [
        'title'    => 'Lecture Material',
        'icon'     => 'fas fa-file-upload',
        'actions'  => ['index', 'create', 'edit', 'view'],
        'children' => []
    ],

    'academic_calendar' => [
        'title'    => 'Academic Calendar',
        'icon'     => 'fas fa-calendar-alt',
        'actions'  => ['index'],
        'children' => []
    ],

    'exam'             => [
        'title'    => 'Examination',
        'icon'     => 'fas fa-archway',
        'actions'  => [],
        'children' => [
            'exams'         => [
                'title'   => 'Exam Setup', 'icon' => 'fas fa-archway ',
                'actions' => ['index', 'create', 'edit', 'view', 'delete']
            ],
            'result'        => [
                'title'   => 'Exam Result', 'icon' => 'fa fa-puzzle-piece',
                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'exam_category' => [
                'title'   => 'Exam Category', 'icon' => 'far fa-list-alt',
                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'exam_type'     => [
                'title' => 'Exam Type', 'icon' => 'fas fa-list-alt', 'actions' => ['index', 'create', 'edit', 'view']
            ],
            'exam_sub_type' => [
                'title' => 'Exam Sub Type', 'icon' => 'fas fa-list', 'actions' => ['index', 'create', 'edit', 'view']
            ]
        ]
    ],
    'student_progress' => [
        'title'    => 'Selection for promotion',
        'icon'     => 'fa fa-user-shield',
        'actions'  => [],
        'children' => [
            'student_progress_result' => [
                'title'   => 'Selected students',
                'icon'    => 'fa fa-puzzle-piece ',
                'actions' => ['index', 'create']
            ],
            /*'student_progress_attendance' => ['title' => 'Attendance', 'icon' => 'fa fa-user-tag', 'actions' => ['index', 'create']],*/
        ]
    ],

    'subject' => [
        'title'    => 'Subjects',
        'icon'     => 'fas fa-book',
        'actions'  => [],
        'children' => [
            'subject_group' => ['title'   => 'Subject Group', 'icon' => 'fas fa-address-book',
                                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'subject'       => ['title'   => 'Subject', 'icon' => 'fas fa-book-open',
                                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'topic_head'    => ['title'   => 'Topic Head', 'icon' => 'fas fa-book-reader',
                                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'topic'         => ['title'   => 'Topics', 'icon' => 'fas fa-address-book',
                                'actions' => ['index', 'create', 'edit', 'view']
            ],
            /*'topic_assign' => ['title' => 'Assign Topic', 'icon' => 'fas fa-tag', 'actions' => ['index']],*/
            'lesson_plan'   => ['title'   => 'Lesson Plans', 'icon' => 'fas fa-file-upload',
                                'actions' => ['index', 'create', 'edit', 'view', 'delete']
            ],
            'cards'         => ['title'   => 'Cards', 'icon' => 'fa fa-clipboard-list',
                                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'card_items'    => ['title'   => 'Items', 'icon' => 'fa fa-clipboard-list',
                                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'book'          => ['title'   => 'Books', 'icon' => 'fas fa-book-open',
                                'actions' => ['index', 'create', 'edit', 'view']
            ],
        ]
    ],

    'teacher' => [
        'title'    => 'Teacher',
        'icon'     => 'fas fa-user-tie',
        'actions' => ['index', 'create', 'edit', 'view', 'password', 'evaluation'],
        'children' => []
    ],

    'class_routine' => [
        'title'    => 'Class Routine',
        'icon'     => 'fa fa-clock',
        'actions'  => [],
        'children' => [
            'class_routine'          => [
                'title'   => 'Class Routine Group',
                'icon'    => 'fa fa-list-alt',
                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'class_routine_calendar' => ['title'   => 'Class Routine Calendar', 'icon' => 'far fa-calendar-alt',
                                         'actions' => ['index']
            ],
            'class_routine/list'     => [
                'title'   => 'Class Routine List',
                'icon'    => 'far fa-list-alt',
                'actions' => ['list']
            ],
            'static_routine'         => [
                'title'   => 'Static Routine',
                'icon'    => 'fas fa-calendar-alt',
                'actions' => ['index', 'create', 'edit', 'view', 'delete'],
            ],
        ]
    ],
    'attendance'    => [
        'title'    => 'Attendance',
        'icon'     => 'fa fa-user-tag',
        'actions'  => ['index', 'create', 'edit', 'view'],
        'children' => []
    ],

    /*'payment' => [
        'title' => 'Payment', 'icon' => 'far fa-credit-card', 'actions' => [],
        'children' => [
            'payment_generate' => ['title' => 'Generate Payments', 'icon' => 'far fa-credit-card', 'actions' => ['index', 'create', 'edit', 'view']],
            'payment_collect' => ['title' => 'Collect Payments', 'icon' => 'far fa-credit-card', 'actions' => ['index', 'create', 'edit', 'view']],
        ]
    ],*/

    /*'collect_fee' => [
        'title' => 'Collect Fee', 'icon' => 'far fa-credit-card', 'actions' => ['index', 'create', 'edit', 'view'],
        'children' => []
    ],

    'generate_fee' => [
        'title' => 'Generate Fee', 'icon' => 'far fa-credit-card', 'actions' => ['index', 'create', 'edit', 'view'],
        'children' => []
    ],*/

    'payment' => [
        'title'    => 'Payments',
        'icon'     => 'far fa-credit-card',
        'actions'  => [],
        'children' => [
            'generate_fee'         => [
                'title'   => 'Generate Fee', 'icon' => 'far fa-credit-card',
                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'generate_tuition_fee' => ['title'   => 'Generate Tuition Fee', 'icon' => 'far fa-credit-card',
                                       'actions' => ['index', 'create', 'edit', 'view']
            ],
            'collect_fee'          => ['title'   => 'Collect Fee', 'icon' => 'far fa-credit-card',
                                       'actions' => ['index', 'create', 'edit', 'view']
            ],
            'student_payment'      => ['title'   => 'Student Payment', 'icon' => 'far fa-credit-card',
                                       'actions' => ['index', 'edit', 'view']
            ],
        ]
    ],

    /*'collect_fee' => [
        'title' => 'Collect Fee', 'icon' => 'far fa-credit-card', 'actions' => [],
        'children' => [
            'collect_development_fee' => ['title' => 'Development Fee', 'icon' => 'far fa-credit-card', 'actions' => ['index', 'create', 'edit', 'view']],
            'collect_tuition_fee' => ['title' => 'Tuition Fee', 'icon' => 'far fa-credit-card', 'actions' => ['index', 'create', 'edit', 'view']],
            'collect_absent' => ['title' => 'Absent Fee', 'icon' => 'far fa-credit-card', 'actions' => ['index', 'create', 'edit', 'view']],
            'collect_other' => ['title' => 'Others Fee', 'icon' => 'far fa-credit-card', 'actions' => ['index', 'create', 'edit', 'view']],
        ]
    ],*/

    /* 'generate_fee' => [
         'title' => 'Generate Fee', 'icon' => 'far fa-credit-card', 'actions' => [],
         'children' => [
             'generate_absent_fee' => ['title' => 'Absent Fee', 'icon' => 'far fa-credit-card', 'actions' => ['index', 'create', 'edit', 'view']],
             'generate_other_fee' => ['title' => 'Others Fee', 'icon' => 'far fa-credit-card', 'actions' => ['index', 'create', 'edit', 'view']],
         ]
     ],*/

    'campaigns' => [
        'title'    => 'Campaigns',
        'icon'     => 'fas fa-bullhorn',
        'actions'  => [],
        'children' => [
            'campaigns' => ['title' => 'Campaign List', 'icon' => 'fas fa-list', 'actions' => ['index', 'create', 'edit', 'view', 'rerun']],
        ]
    ],

    'reports' => [
        'title'    => 'Reports',
        'icon'     => 'fa fa-chart-pie',
        'actions'  => [],
        'children' => [
            'report_admission'              => ['title'   => 'Admission', 'icon' => 'fas fa-university',
                                                'actions' => ['all']
            ],
            'report_student_admission'      => [
                'title' => 'Student Admission', 'icon' => 'fas fa-university', 'actions' => ['all']
            ],
            'report_attendance'             => ['title'   => 'Attendance', 'icon' => 'fa fa-user-tag',
                                                'actions' => ['all']
            ],
            'report_comparative_attendance' => [
                'title'   => 'Comparative Attendance',
                'icon'    => 'fa fa-user-tag',
                'actions' => ['all']
            ],
            'report_attendance_by_phase'    => ['title'   => 'Attendance By Phase', 'icon' => 'fa fa-user-tag',
                                                'actions' => ['all']
            ],
            'report_attendance_by_student'  => ['title'   => 'Attendance By Student', 'icon' => 'fa fa-user-tag',
                                                'actions' => ['all']
            ],
            'report_exam_result'            => ['title'   => 'Exam Result', 'icon' => 'fa fa-puzzle-piece',
                                                'actions' => ['all']
            ],
            'report_exam_result_student'    => ['title'   => 'Exam Result by Student', 'icon' => 'fa fa-puzzle-piece',
                                                'actions' => ['all']
            ],
            'reports-due-by-session'        => [
                'title'   => 'Due by Session',
                'icon'    => 'fa fa-file-invoice-dollar',
                'actions' => ['all']
            ],
            'report_student_payment'        => ['title'   => 'Single Student Payments', 'icon' => 'fa fa-puzzle-piece',
                                                'actions' => ['all']
            ],
            'report_all_student_payment'    => ['title'   => 'All Student Payments', 'icon' => 'fa fa-puzzle-piece',
                                                'actions' => ['all']
            ],
            'report_student_list'           => ['title'   => 'Student List', 'icon' => 'fas fa-users',
                                                'actions' => ['all']
            ],
            'report_teacher_list'           => ['title'   => 'Teacher List', 'icon' => 'fas fa-user-tie',
                                                'actions' => ['all']
            ],
            'report_teacher_wise_class'     => ['title'   => 'Teacher Wise Class', 'icon' => 'fa fa-puzzle-piece',
                                                'actions' => ['all']
            ],
            'report_parent_list'            => ['title'   => 'Parent List', 'icon' => 'fas fa-user-tie',
                                                'actions' => ['all']
            ],
            'report_sms_email_report'       => ['title'   => 'SMS Email Report', 'icon' => 'fas fa-user-tie',
                                                'actions' => ['all']
            ],
            'report_campaign_report'        => ['title'   => 'Campaign Report', 'icon' => 'fas fa-user-tie',
                                                'actions' => ['all']
            ],
            'report_new_campaign' => ['title' => 'SMS/Email Campaign Report', 'icon' => 'fas fa-bullhorn', 'actions' => ['index']],
        ]
    ],
    /*'pages' => [
        'title' => 'Pages', 'icon' => 'icon-doc', 'actions' => ['index', 'create', 'edit', 'view'],
        'children' => []
    ],*/

    'notice_board' => [
        'title'    => 'Notice Board',
        'icon'     => 'fas fa-user-tie',
        'actions'  => ['index', 'create', 'edit', 'view'],
        'children' => []
    ],
    'holiday'      => [
        'title'    => 'Holiday',
        'icon'     => 'fas fa-calendar-times',
        'actions'  => ['index', 'create', 'edit', 'view'],
        'children' => []
    ],

    'message' => [
        'title'    => 'Messages',
        'icon'     => 'fas fa-envelope-open',
        'actions'  => ['index', 'create', 'edit', 'view'],
        'children' => []
    ],

    'setting' => [
        'title'    => 'Settings',
        'icon'     => 'fas fa-cogs',
        'actions'  => [],
        'children' => [
            'attachment_type'     => [
                'title'    => 'Attachment Type', 'icon' => 'fas fa-file',
                'actions'  => ['index', 'create', 'edit', 'view'], 'children' => []
            ],
            'attachment'          => [
                'title' => 'Attachment', 'icon' => 'fas fa-file', 'actions' => ['index', 'create', 'delete']
            ],
            'student_category'    => [
                'title'   => 'Student Category', 'icon' => 'fas fa-user-graduate',
                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'student_group'       => [
                'title'   => 'Student Group', 'icon' => 'fa fa-user-friends',
                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'student_group_type'  => [
                'title'   => 'Student Group Type',
                'icon'    => 'fa fa-users',
                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'term'                => [
                'title' => 'Term', 'icon' => 'fas fa-sitemap', 'actions' => ['index', 'create', 'edit', 'view']
            ],
            'phase'               => [
                'title' => 'Phase', 'icon' => 'fab fa-accessible-icon', 'actions' => ['index', 'create', 'edit', 'view']
            ],
            'designation'         => [
                'title' => 'Designation', 'icon' => 'fas fa-user-tie', 'actions' => ['index', 'create', 'edit', 'view']
            ],
            'department'          => [
                'title' => 'Department', 'icon' => 'far fa-building', 'actions' => ['index', 'create', 'edit', 'view']
            ],
            'course'              => [
                'title' => 'Course', 'icon' => 'fas fa-book-reader', 'actions' => ['index', 'create', 'edit', 'view']
            ],
            'class_type'          => [
                'title' => 'Class Type', 'icon' => 'fas fa-university', 'actions' => ['index', 'create', 'edit', 'view']
            ],
            'education_board'     => [
                'title'   => 'Education Board', 'icon' => 'fas fa-chalkboard-teacher',
                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'bank'                => [
                'title' => 'Bank', 'icon' => 'fas fa-building', 'actions' => ['index', 'create', 'edit']
            ],
            'payment_type'        => [
                'title'   => 'Payment Type', 'icon' => 'far fa-credit-card',
                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'payment_method'      => [
                'title' => 'Payment Method', 'icon' => 'fas fa-file-invoice', 'actions' => ['index', 'create', 'edit']
            ],
            'payment_detail'      => [
                'title'   => 'Payment Detail', 'icon' => 'far fa-credit-card',
                'actions' => ['index', 'create', 'edit', 'view']
            ],
            'hall'                => [
                'title' => 'Class Room', 'icon' => 'far fa-building', 'actions' => ['index', 'create', 'edit', 'view']
            ],
            'application_setting' => ['title'   => 'Application Settings', 'icon' => 'fas fa-cogs',
                                      'actions' => ['index', 'create', 'edit', 'view']
            ],
        ]
    ],

    'logout' => [
        'title'    => 'Logout',
        'icon'     => 'flaticon-logout',
        'actions'  => ['index'],
        'children' => []
    ]
];
