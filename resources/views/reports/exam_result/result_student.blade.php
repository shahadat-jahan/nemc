@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item, .m-stack--demo.m-stack--hor .m-stack__demo-item {
            padding: 29px;
        }

        .table thead th {
            vertical-align: top;
            text-align: center;
        }
    </style>

@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <form id="searchForm" role="form" method="get">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control" name="term_id" id="term_id">
                                        <option value="">---- Select Term ----</option>
                                        {!! select($terms, app()->request->term_id) !!}
                                    </select>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control" name="exam_category_id" id="exam_category_id">
                                        <option value="">---- Select Exam Category ----</option>
                                        {!! select($examCategories, app()->request->exam_category_id) !!}
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control" name="exam_id" id="exam_id">
                                        <option value="">---- Select Exam ----</option>

                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control m-bootstrap-select m_selectpicker" name="subject_id"
                                            id="subject_id" data-live-search="true">
                                        <option value="">---- Select Subject ----</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control m-bootstrap-select m_selectpicker" name="student_id"
                                            id="student_id" data-live-search="true">
                                        <option value="">---- Select Student----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        @if(!empty($examResult))
                                            <a target="_blank" href="{{route('report.exam_result.student.pdf', [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'phase_id' => app()->request->phase_id,
                                        'term_id' => app()->request->term_id,
                                        'exam_id' => app()->request->exam_id,
                                        'student_id' => app()->request->student_id,
                                        'exam_category_id' => app()->request->exam_category_id,
                                        'subject_id' => app()->request->subject_id,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-pdf"></i>
                                                PDF</a>
                                            <a href="{{route('report.exam_result.student.excel', [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'phase_id' => app()->request->phase_id,
                                        'term_id' => app()->request->term_id,
                                        'exam_id' => app()->request->exam_id,
                                        'student_id' => app()->request->student_id,
                                        'exam_category_id' => app()->request->exam_category_id,
                                        'subject_id' => app()->request->subject_id,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-export"></i>
                                                Export</a>
                                        @endif
                                        <button class="btn btn-primary m-btn m-btn--icon search-result">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a class="btn btn-default m-btn m-btn--icon"
                                           href="{{url('admin/report_exam_result_student')}}">
                                            <i class="fas fa-sync-alt search-reset"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @php
                        $passPercentage = Setting::getSiteSetting()->pass_mark;
                        $examSubjectMarkIds = [];
                    @endphp
                    @if(!empty($examResult) && $examResult->isNotEmpty())
                        <div class="row mt-4">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                <div class="row">
                                    <div class=" col-md-4 m-stack m-stack--ver m-stack--general m-stack--demo">
                                        <div class="m-stack__item m-stack__item--center">
                                            Exam Type: {{$terms[app()->request->term_id]}}
                                        </div>
                                    </div>
                                    <div class=" col-md-4 m-stack m-stack--ver m-stack--general m-stack--demo">
                                        <div class="m-stack__item m-stack__item--center">
                                            Exam Name: {{$exam->title}}
                                        </div>
                                    </div>
                                    <div class=" col-md-4 m-stack m-stack--ver m-stack--general m-stack--demo">
                                        <div class="m-stack__item m-stack__item--center">
                                            Subject: {{$subject->title}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <h4 class="text-center mt-4">Student: {{$student->full_name_en}}(Roll No-{{$student->roll_no}}
                            )</h4>
                        <div class="row mt-4">
                            <div class="table m-table table-responsive">
                                <table class="table table-bordered table-hover" id="exam-results">
                                    <thead class="text-center">
                                    <tr>
                                        @php
                                            $examTotalMarks = 0;
                                            $examTypeMarksArr = [];
                                        @endphp
                                        @foreach($examTypeSubType as $type)
                                            @php
                                                $examTypeMarks = 0;
                                                $colspan = count($type->examSubTypes) + 1;
                                            @endphp
                                            @foreach($type->examSubTypes as $subType)
                                                @foreach($subType->examSubjectMark as $mark)
                                                    @php
                                                        $examTypeMarks               += $mark->total_marks;
                                                        $examTypeMarksArr[$type->id] = $examTypeMarks;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                            <th class="align-middle" colspan="{{$colspan}}">{{$type->title}}
                                                ({{$examTypeMarks}})
                                            </th>
                                            @php
                                                $examTotalMarks += $examTypeMarks;
                                            @endphp
                                        @endforeach
                                        <th class="align-middle" rowspan="2">Result</th>
                                        <th rowspan="2" class="align-middle">Comment</th>
                                    </tr>
                                    <tr>
                                        @foreach($examTypeSubType as $type)
                                            @foreach($type->examSubTypes->sortBy('id') as $subType)
                                                @foreach($subType->examSubjectMark as $mark)
                                                    @php
                                                        $examSubjectMarkIds[] = $mark->id;
                                                    @endphp
                                                    <th class="align-middle">{{$subType->title}}
                                                        <br>({{$mark->total_marks}})
                                                    </th>
                                                @endforeach
                                            @endforeach
                                            <th class="align-middle">Total</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @php
                                            $totalMarksByExamType = [];
                                            $totalGrace = 0;
                                        @endphp
                                        @foreach($examResult as $studentResult)
                                            @php
                                                $total = 0;
                                                $totalMark = 0;
                                            @endphp
                                            @foreach($studentResult->sortBy('id') as $result)
                                                @php
                                                    $examType     = $result->examSubjectMark->examSubType->examType;
                                                    $examTypeId   = $examType->id;
                                                    $resultStatus = 'Pass';
                                                    $colour       = '';
                                                    $marks        = $result->marks;
                                                    $grace_marks  = $result->grace_marks;
                                                    $totalMark    = $marks + $grace_marks;
                                                    $total       += $totalMark;
                                                    $totalGrace += $grace_marks;

                                                    if (!isset($totalMarksByExamType[$examTypeId])) {
                                                        $totalMarksByExamType[$examTypeId] = 0;
                                                    }
                                                    $totalMarksByExamType[$examTypeId] += $totalMark;

                                                    $special = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->whereNotNull('special_status')->where('student_id', $result->student_id)->count();
                                                    $absent  = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 4)->where('student_id', $result->student_id)->count();
                                                    $grace   = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->whereNotNull('grace_marks')->where('student_id', $result->student_id)->count();

                                                    if ($special > 0) {
                                                        $resultStatus = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('special_status', 1)->where('student_id', $result->student_id)->count() > 0 ? 'Pass(SC)' : 'Fail(SC)';
                                                        $textColor = '';
                                                    }
                                                @endphp
                                                <td class="text-center align-middle">{{$result->pass_status === 4 ? '-' : $totalMark}}</td>
                                            @endforeach
                                            <td class="text-center align-middle">{{$total}}</td>
                                        @endforeach
                                        <td class="text-center align-middle">
                                            @php
                                                $failCount = 0;
                                                $passCount = 0;

                                                foreach ($examTypeMarksArr as $key => $typeTotalMark)
                                                {
                                                    $typeMark        = $totalMarksByExamType[$key];
                                                    $checkPercentage = ($typeMark * 100) / $typeTotalMark;

                                                    if ($passPercentage > $checkPercentage){
                                                            ++$failCount;
                                                    }else{
                                                        ++$passCount;
                                                    }
                                                }

                                                if ($special < 1) {
                                                    if ($absent > 0) {
                                                        $resultStatus = 'Absent';
                                                        $textColor = 'text-warning';
                                                    } elseif ($failCount > 0) {
                                                        $resultStatus = 'Fail';
                                                        $textColor = 'text-danger';
                                                    } elseif ($failCount == 0 && $grace > 0) {
                                                        $resultStatus = "Pass(Grace - " .$totalGrace.")";
                                                        $textColor = 'text-info';
                                                    } else {
                                                        $resultStatus = 'Pass';
                                                        $textColor = 'text-success';
                                                    }
                                                }
                                            @endphp
                                            <span class="{{$textColor}}">{{$resultStatus}}</span>
                                        </td>
                                        <td class="text-center align-middle">{{ $result->remarks ?: '--'}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>
    <script>
        var phaseInfo = [];
        var total_terms = '';
        var selectedPhase = '';

        $('#course_id, #session_id').change(function () {
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            $.get('{{route('phase.term.list')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                if (response.data) {
                    phaseInfo = response.data;
                    //console.log(phaseInfo);
                }
            })
        });

        //search form dropdown validation
        $('.search-result').click(function () {
            valid = true;
            $('#searchForm select').each(function () {
                var name = $(this).attr('name');
                if (name != 'class_type_id') {
                    if (($(this).val() == '')) {
                        valid = false;
                    }
                }
            });

            if (valid == false) {
                sweetAlert('All fields are required to search', 'error');
                return false;
            } else {
                $('#searchForm ').submit();

                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });
            }
        });

        var examId = '{{app()->request->exam_id}}';

        $('#session_id, #course_id, #phase_id, #term_id, #exam_category_id').change(function () {
            sessionId = $('#session_id').val();
            courseId = $('#course_id').val();
            phaseId = $('#phase_id').val();
            termId = $('#term_id').val();
            examCategoryId = $('#exam_category_id').val();

            if (sessionId > 0 && courseId > 0 && phaseId > 0 && termId > 0 && examCategoryId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('exam.list.session.course.phase.term.type')}}', {
                    sessionId: sessionId,
                    courseId: courseId,
                    phaseId: phaseId,
                    termId: termId,
                    examCategoryId: examCategoryId
                }, function (response) {
                    if (response.exams) {
                        $('#exam_id').html('<option value="">---- Select Exam ----</option>');
                        for (i in response.exams) {
                            exam = response.exams[i];
                            selected = (exam.id == examId) ? 'selected' : '';
                            $('#exam_id').append('<option value="' + exam.id + '" ' + selected + '>' + exam.title + '</option>')
                        }
                    }
                    mApp.unblockPage()
                });
            }
        });

        var subjectId = '{{ app()->request->subject_id }}';

        $('#exam_id').change(function () {
            if ($(this).val() > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });


                $.get('{{route('subjects.list.examId')}}', {examId: $(this).val()}, function (response) {
                    if (response.subjects) {
                        $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                        for (i in response.subjects) {
                            subject = response.subjects[i];
                            selected = (subjectId == subject.id) ? 'selected' : '';
                            $('#subject_id').append('<option value="' + subject.id + '" ' + selected + '>' + subject.title + '</option>')
                        }
                    }
                    $('.m_selectpicker').selectpicker('refresh');
                    mApp.unblockPage();
                });
            }
        });

        //get subject group by session, course and phase id
        {{--var subjectGroupId = '{{ app()->request->subject_group_id }}';--}}

        {{--$('#phase_id').change(function () {--}}
        {{--    phaseId = $(this).val();--}}
        {{--    courseId = $('#course_id').val();--}}
        {{--    sessionId = $('#session_id').val();--}}

        {{--    mApp.blockPage({--}}
        {{--        overlayColor: "#000000",--}}
        {{--        type: "loader",--}}
        {{--        state: "primary",--}}
        {{--        message: "Please wait..."--}}
        {{--    });--}}

        {{--    // selectedPhase = _.find(phaseInfo, function (o) {--}}
        {{--    //     return o.phase.id == phaseId;--}}
        {{--    // });--}}
        {{--    // if (selectedPhase) {--}}
        {{--    //     console.log(`x === undefined`)--}}
        {{--    //     totalTerms = selectedPhase.total_terms;--}}
        {{--    // } else {--}}
        {{--    //     console.log(`x !== undefined`)--}}
        {{--    //     totalTerms = ''--}}
        {{--    // }--}}
        {{--    // $('#term_id').html('<option value="">---- Select Term ----</option>');--}}
        {{--    // for (var i = 1; i <= totalTerms; i++) {--}}
        {{--    //     $('#term_id').append('<option value="' + i + '"> Term ' + i + '</option>')--}}
        {{--    // }--}}

        {{--    // load subject group--}}
        {{--    $.get('{{route('SubjectGroup.session.course.phase')}}', {--}}
        {{--        sessionId: sessionId,--}}
        {{--        courseId: courseId,--}}
        {{--        phaseId: phaseId--}}
        {{--    }, function (response) {--}}
        {{--        if (response.data) {--}}
        {{--            $('#subject_group_id').html('<option value="">---- Select Subject Group ----</option>');--}}
        {{--            for (i in response.data) {--}}
        {{--                subjectGroup = response.data[i];--}}
        {{--                selected = (subjectGroupId == subjectGroup.id) ? 'selected' : '';--}}
        {{--                $('#subject_group_id').append('<option value="' + subjectGroup.id + '" ' + selected + '>' + subjectGroup.title + '</option>')--}}
        {{--            }--}}
        {{--            $('.m_selectpicker').selectpicker('refresh');--}}
        {{--            mApp.unblockPage();--}}

        {{--        }--}}
        {{--    })--}}
        {{--});--}}
        //get subject by session, course and subject group
        {{--var subjectId = '{{ app()->request->subject_id }}';--}}

            {{--$('#subject_group_id').change(function () {--}}
            {{--    sessionId = $('#session_id').val();--}}
            {{--    courseId = $('#course_id').val();--}}

            {{--    mApp.blockPage({--}}
            {{--        overlayColor: "#000000",--}}
            {{--        type: "loader",--}}
            {{--        state: "primary",--}}
            {{--        message: "Please wait..."--}}
            {{--    });--}}

            {{--    // load subjects--}}
            {{--    $.get('{{route('subjects.group')}}', {--}}
            {{--        sessionId: sessionId,--}}
            {{--        courseId: courseId,--}}
            {{--        subjectGroupId: $(this).val()--}}
            {{--    }, function (response) {--}}
            {{--        if (response.data) {--}}
            {{--            $('#subject_id').html('<option value="">---- Select Subject ----</option>');--}}
            {{--            for (i in response.data) {--}}
            {{--                subject = response.data[i]--}}
            {{--                selected = (subjectId == subject.id) ? 'selected' : '';--}}
            {{--                $('#subject_id').append('<option value="' + subject.id + '" ' + selected + '>' + subject.title + '</option>')--}}
            {{--            }--}}
            {{--        }--}}
            {{--        $('.m_selectpicker').selectpicker('refresh');--}}
            {{--        mApp.unblockPage();--}}
            {{--    })--}}
            {{--});--}}

        if (examId > 0) {
            $('#exam_category_id').trigger('change');

            $.get('{{route('subjects.list.examId')}}', {examId: examId}, function (response) {
                if (response.subjects) {
                    $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                    for (i in response.subjects) {
                        subject = response.subjects[i];
                        selected = (subjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="' + subject.id + '" ' + selected + '>' + subject.title + '</option>')
                    }
                }
                $('.m_selectpicker').selectpicker('refresh');
            });
        }


        //get student by session and course id
        var studentId = '<?php echo app()->request->student_id; ?>';

        function makeStudentIdAndUserId(sessionId, courseId) {
            if (courseId > 0 && sessionId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('<?php echo e(route('student.info.session.course')); ?>', {
                    courseId: courseId,
                    sessionId: sessionId,
                    _token: "<?php echo e(csrf_token()); ?>"
                }, function (response) {
                    $("#student_id").html('<option value="">---- Select Student ----</option>');
                    for (var i = 0; i < response.length; i++) {
                        selected = (studentId == response[i].id) ? 'selected' : '';
                        $("#student_id").append('<option value="' + response[i].id + '" ' + selected + '>' + response[i].full_name_en + ' (' + 'Roll No-' + response[i].roll_no + ')' + '</option>');
                    }
                    $('.m_selectpicker').selectpicker('refresh');
                    mApp.unblockPage();
                });
            }
        }


        $('#session_id, #course_id').change(function (e) {
            e.preventDefault();
            sessionId = $('#session_id').val();
            courseId = $('#course_id').val();
            makeStudentIdAndUserId(sessionId, courseId);
        });

        if (studentId > 0) {
            makeStudentIdAndUserId($('#session_id').val(), $('#course_id').val())
        }
    </script>
@endpush
