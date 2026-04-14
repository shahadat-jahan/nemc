@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .table td {
            padding-top: 0.6rem !important;
            padding-bottom: .6rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
        }
    </style>
@endpush

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>{{$pageTitle}}</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ route('frontend.result.index') }}" class="btn btn-primary m-btn m-btn--icon"><i class="far fa-list-alt pr-2"></i>Exam Results</a>
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="m-section__content">
                <div class="card">
                    <div class="card-header">
                        Common Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Session :</div>
                                                <div class="col-md-8">{{$examInfo->session->title}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Phase :</div>
                                                <div class="col-md-8">{{$examInfo->phase->title}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Subject :</div>
                                                <div class="col-md-8">{{$subject->title}}</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Course :</div>
                                                <div class="col-md-8">{{$examInfo->course->title}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Term :</div>
                                                <div class="col-md-8">{{$examInfo->term->title}}</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $passPercentage = Setting::getSiteSetting()->pass_mark;
                    $examSubjectMarkIds = [];
                    $examSubjectMarks = $examInfo->examMarks->where('subject_id', $subject->id)->first();
                @endphp
                <div class="card mt-3">
                    <div class="card-header">
                        Students Results
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="table m-table table-responsive">
                                    <table class="table table-bordered table-hover" id="exam-results">
                                        <thead class="text-center">
                                        <tr>
                                            <th rowspan="2" class="align-middle">Roll No</th>
                                            <th rowspan="2" class="align-middle">Reg No</th>
                                            <th rowspan="2" class="align-middle">Student Name</th>
                                            @php
                                                $examTotalMarks = 0;
                                                $examTypeMarksArr = [];
                                            @endphp
                                            @foreach($examTypeSubType as $type)
                                                @php
                                                    $examTypeMarks = 0;
                                                    $colspan       = count($type->examSubTypes);
                                                @endphp
                                                @foreach($type->examSubTypes as $subType)
                                                    @foreach($subType->examSubjectMark as $mark)
                                                        @php
                                                            $examTypeMarks               += $mark->total_marks;
                                                            $examTypeMarksArr[$type->id] = $examTypeMarks;
                                                        @endphp
                                                    @endforeach
                                                @endforeach
                                                <th colspan="{{$colspan}}" class="align-middle">{{$type->title}}
                                                    ({{$examTypeMarks}})
                                                </th>
                                                @php
                                                    $examTotalMarks += $examTypeMarks;
                                                @endphp
                                            @endforeach
                                            <th rowspan="2" class="align-middle">Result</th>
                                            <th rowspan="2" class="align-middle">Date</th>
                                            <th rowspan="2" class="align-middle">Comment</th>
                                            <th rowspan="2" class="align-middle">Action</th>
                                        </tr>
                                        <tr>
                                            @foreach($examTypeSubType as $type)
                                                @foreach($type->examSubTypes->sortBy('id') as $subType)
                                                    @foreach($subType->examSubjectMark as $mark)
                                                        @php
                                                            $examSubjectMarkIds[] = $mark->id;
                                                        @endphp
                                                        <th class="align-middle">{{$subType->title}}
                                                            ({{$mark->total_marks}})
                                                        </th>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($examResult->groupBy('student_id') as $studentId => $studentResult)
                                            <tr>
                                                <td class="text-center align-middle">{{$studentResult->first()->student->roll_no}}</td>
                                                <td class="text-center align-middle">{{$studentResult->first()->student->reg_no ?? ''}}</td>
                                                <td class="align-middle"><a
                                                        href="{{route('students.show', $studentResult->first()->student->id)}}">{{$studentResult->first()->student->full_name_en}}</a>
                                                </td>
                                                @php
                                                    $totalMark = 0;
                                                    $totalGrace = 0;
                                                    $totalMarksByExamType = [];
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
                                                        $totalGrace  += $grace_marks;

                                                        if (!isset($totalMarksByExamType[$examTypeId])) {
                                                            $totalMarksByExamType[$examTypeId] = 0; // Initialize total if not already set
                                                        }
                                                        $totalMarksByExamType[$examTypeId] += $totalMark;

                                                        $special = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->whereNotNull('special_status')->where('student_id', $studentId)->count();
                                                        $absent  = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 4)->where('student_id', $studentId)->count();
                                                        $grace   = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 3)->where('student_id', $studentId)->count();

                                                        if ($special > 0) {
                                                            $resultStatus = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('special_status', 1)->where('student_id', $studentId)->count() > 0 ? 'Pass' : 'Fail';
                                                            $colour = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('special_status', 1)->where('student_id', $studentId)->count() > 0 ? 'text-success' : 'text-warning';
                                                        }
                                                    @endphp
                                                    <td class="text-center align-middle">{{$result->pass_status === 4 ? '-' : $totalMark}}</td>
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

                                                        if ($special < 1){
                                                            if ($absent > 0) {
                                                                // Case: Only absent, no pass or fail
                                                                $resultStatus = 'Absent';
                                                            } elseif ($absent == 0 && $failCount > 0) {
                                                                // Case: Fail if there's a fail count & no absences
                                                                $resultStatus = 'Fail';
                                                            } elseif ($absent == 0 && $failCount == 0 && $grace > 0) {
                                                                // Case: Pass with grace if no absences or fails, but grace is applied
                                                                $resultStatus = 'Pass(Grace - '.$totalGrace.')';
                                                            }
                                                        }
                                                    @endphp
                                                    <span class="{{$colour}}">{{$resultStatus}}</span>
                                                </td>
                                                <td class="text-center align-middle">{{isset($result->result_date) ? $result->result_date : formatDate($result->created_at, 'd/m/Y')}}</td>
                                                <td class="text-center align-middle">{{ $result->remarks ?: '--'}}</td>
                                                <td class="text-center align-middle">
                                                    @php $authUser = Auth::guard('web')->user();
                                                            foreach ($examInfo->examSubjects->where('subject_id', $subject->id) as $examSubject){
                                                                $isPublish = $examSubject->result_published;
                                                                }
                                                    @endphp
                                                    @if(hasPermission('result/edit'))
                                                        @if($isPublish == 0 && ($authUser->adminUser || $authUser->teacher))
                                                            <a href="#"
                                                               class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill modal-student-result"
                                                               data-exam-id="{{$examInfo->id}}"
                                                               data-subject-id="{{$subject->id}}"
                                                               data-student-id="{{$result->student_id}}"
                                                               title="Edit">
                                                                <i class="flaticon-edit"></i>
                                                            </a>
                                                        @elseif( $isPublish == 1 && ($authUser->user_group_id == 1 || $authUser->user_group_id == 12) && $examInfo->exam_category_id == 1)
                                                            <a href="#"
                                                               class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill modal-student-result"
                                                               data-exam-id="{{$examInfo->id}}"
                                                               data-subject-id="{{$subject->id}}"
                                                               data-student-id="{{$result->student_id}}"
                                                               title="Edit">
                                                                <i class="flaticon-edit"></i>
                                                            </a>
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                    @else
                                                        <span>--</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="edit-student-result" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form class="m-form m-form--fit m-form--label-align-right form-validation"  action="" method="post" enctype="multipart/form-data" id="update-student-result-form">
                @csrf
                <input type="hidden" name="exam_id" id="exam-id">
                <input type="hidden" name="subject_id" id="subject-id">
                <input type="hidden" name="student_id" id="student-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Result</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-2" id="edit-result-modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-brand" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success update-student-result"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')

    <script>

        $(document).on('click', '.modal-student-result', function (e) {
            e.preventDefault();
            examId = $(this).data('exam-id');
            subjectId = $(this).data('subject-id');
            studentId = $(this).data('student-id');

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get(baseUrl+'admin/result/student/edit/'+examId+'/'+subjectId+'/'+studentId, {}, function (response) {
                $('#exam-id').val(examId);
                $('#subject-id').val(subjectId);
                $('#student-id').val(studentId);
                $('#edit-result-modal-body').html(response);
                $('#edit-student-result').modal('show');

                mApp.unblockPage();
            });
        });

        $.validator.addMethod("check_remarks", function (value, element) {
            var flag = true;
            remarkStatus = true;

            $('.exam-remark').each(function () {
                if ($(this).val() == ''){
                    remarkStatus = false;
                }
            });
            if(remarkStatus == false){
                flag =  false;
            }
            return flag;

        }, "Required");

        $.validator.addMethod("check_mark_empty", function (value, element) {
            var flag = true;
            rowStatus = true;

            $('.sub_type_mark').each(function () {
                if (($('.exam-remark').val() == 1) || ($('.exam-remark').val() == 2) || ($('.exam-remark').val() == 3)){
                    if ($(this).val() == ''){
                        rowStatus = false;
                    }
                }
            });

            if(rowStatus == false){
                flag =  false;
            }
            return flag;

        }, "Required");





        $('.update-student-result').click(function () {

            $.validator.addClassRules('exam-remark', {check_remarks: true});
            $.validator.addClassRules('sub_type_mark', {
                check_mark_empty: function(value, element){
                    return ( ($('.exam-remark').val() == 1) || ($('.exam-remark').val() == 2) || ($('.exam-remark').val() == 3) )
                },
            });

            $('#update-student-result-form').validate({
                rules:{
                    remark: {
                        required: true,
                        min: 1
                    }
                },
                submitHandler: function (form) {
                    examId = $('#exam-id').val();
                    subjectId = $('#subject-id').val();
                    studentId = $('#student-id').val();

                    $.ajax({
                        type: "POST",
                        url: baseUrl+'admin/result/student/edit/'+examId+'/'+subjectId+'/'+studentId,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status){
                                window.location = response.redirect_url;
                            }
                        }
                    });
                    return false;
                }
            });
        })

    </script>
@endpush

