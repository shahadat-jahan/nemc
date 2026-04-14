@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        .table thead th {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@endpush
@section('content')
    @php
        $courseId = (isset(app()->request->course_id) && !empty(app()->request->course_id)) ? app()->request->course_id : '';
        $sessionId = (isset(app()->request->session_id) && !empty(app()->request->session_id)) ? app()->request->session_id : '';
        $phaseId = (isset(app()->request->phase_id) && !empty(app()->request->phase_id)) ? app()->request->phase_id : '';
    @endphp
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
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select required class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select required class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select required class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions_list, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="roll_no"
                                               value="{{app()->request->roll_no}}" placeholder="Roll No"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="reg_no"
                                               value="{{app()->request->reg_no}}" placeholder="Reg No"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary result-search m-btn m-btn--icon"><i
                                                class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="m-section__content mt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table m-table table-responsive">

                                    @if(count($studentsResults) > 0)
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th rowspan="2">Roll No</th>
                                                <th rowspan="2">Reg No</th>
                                                <th class="text-left" rowspan="2">Name</th>
                                                {{--                                                                                                    @php--}}
                                                {{--                                                                                                    $arr_subjects = array();--}}
                                                {{--                                                                                                    $subject_ids_count = [];--}}
                                                {{--                                                                                                    foreach ($examsGroup as $key => $examsgroup_value) {--}}
                                                {{--                                                                                                        $arr_subjects[$examsgroup_value->subject_id] = $examsgroup_value->subject_id;--}}
                                                {{--                                                                                                        $subject_ids_count[]                         = $examsgroup_value->subject_id;--}}
                                                {{--                                                                                                    }--}}
                                                {{--                                                                                                    $subject_ids_count = array_count_values($subject_ids_count);--}}
                                                {{--                                                                                                    @endphp--}}
                                                {{--                                                                                                @foreach($arr_subjects as $subject)--}}
                                                {{--                                                                                                    <th colspan="{{$subject_ids_count[$subject]}}">--}}
                                                {{--                                                                                                        {{ \App\Models\Subject::where(['id' => $subject])->pluck('title')->first() }}--}}
                                                {{--                                                                                                    </th>--}}
                                                {{--                                                                                                @endforeach--}}
                                                <th rowspan="2">Action</th>
                                            </tr>
                                            {{--                                            <tr>--}}
                                            {{--                                                @foreach($examsGroup as $examsgroup_v)--}}
                                            {{--                                                    <th>{{$examsgroup_v->title}}</th>--}}
                                            {{--                                                @endforeach--}}
                                            {{--                                            </tr>--}}
                                            </thead>
                                            <tbody>
                                            @foreach($studentsResults->groupBy('student_id') as $students)
                                                <tr>
                                                    <td class="text-center">{{$students->first()->roll_no}}</td>
                                                    <td class="text-center">{{$students->first()->reg_no}}</td>
                                                    <td>{{$students->first()->full_name_en}}</td>
                                                    {{--                                                    @isset($arr_subjects)--}}
                                                    {{--                                                        @foreach($examsGroup as $examsgroup_v)--}}
                                                    {{--                                                            <td>--}}
                                                    {{--                                                                @php--}}
                                                    {{--                                                                $resultRow = $students->where('exam_id', $examsgroup_v->id)->where('subject_id', $examsgroup_v->subject_id)->first();--}}
                                                    {{--                                                                @endphp--}}
                                                    {{--                                                                @isset($resultRow->result_status)--}}
                                                    {{--                                                                    {{$resultRow->result_status}}--}}
                                                    {{--                                                                @endisset</td>--}}
                                                    {{--                                                            <td>{{isset($resultRow->pass_status) ? \App\Services\UtilityServices::$passStatus[$resultRow->pass_status] : ''}}</td>--}}
                                                    {{--                                                        @endforeach--}}
                                                    {{--                                                    @endisset--}}
                                                    {{--                                                    @if(isset($arr_subjects))--}}
                                                    <td class="text-center">
                                                        @php
                                                            if (!empty($students->first()->promoted)) {
                                                                $status     = ' - Promoted';
                                                                $statusCode = 1;
                                                                $className  = 'btn-danger';
                                                                $btnTitle   = 'Revert promoted student status';
                                                                $btnIcon    = '<i class="fa fa-user-times"></i>';
                                                            } elseif (!empty($students->first()->demoted)) {
                                                                $status     = ' - Demoted';
                                                                $statusCode = 2;
                                                                $className  = 'btn-danger';
                                                                $btnTitle   = 'Revert demoted student status';
                                                                $btnIcon    = '<i class="fa fa-user-times"></i>';
                                                            } else {
                                                                $status     = '';
                                                                $statusCode = '';
                                                                $className  = 'm-btn--hover-brand';
                                                                $btnTitle   = 'Approve for Prof Exam';
                                                                $btnIcon    = '<i class="fa fa-user-check"></i>';
                                                            }
                                                        @endphp
                                                        <a href="#"
                                                           class="m-portlet__nav-link btn {{$className}} m-btn m-btn--icon m-btn--icon-only m-btn--pill modal-student-progress"
                                                           data-student-id="{{$students->first()->student_id}}"
                                                           data-student-roll="{{$students->first()->roll_no}}"
                                                           data-student-reg="{{$students->first()->reg_no}}"
                                                           data-student-name="{{$students->first()->full_name_en}}"
                                                           data-phase-id="{{$phaseId}}"
                                                           data-course-id="{{$courseId}}"
                                                           data-session-id="{{$sessionId}}"
                                                           data-status-code="{{$statusCode}}"
                                                           title="{{$btnTitle}}">
                                                            {!! $btnIcon !!}
                                                        </a>
                                                        {!! $status !!}
                                                        <!--                                                        <a href="#" class="m-portlet__nav-link btn {{$className}} m-btn m-btn--icon m-btn--icon-only m-btn--pill modal-student-progress"
                                                           data-student-id="{{$students->first()->student_id}}" data-student-roll="{{$students->first()->roll_no}}"
                                                           data-student-name="{{$students->first()->full_name_en}}" data-phase-id="{{$students->first()->phase_id}}"
                                                           data-course-id="{{$students->first()->course_id}}"
                                                           data-session-id="{{$students->first()->session_id}}"
                                                           title="{{$btnTitle}}">
                                                            {!! $btnIcon !!}
                                                        </a>-->
                                                    </td>
                                                    {{--                                                    @else--}}
                                                    {{--                                                        <td>No Exam found--}}
                                                    {{--                                                    @endif--}}
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approve-student-for-prof" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approve Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="m-form m-form--fit m-form--label-align-right form-validation" action="" method="post"
                      enctype="multipart/form-data" id="approve-student-form">
                    @csrf
                    <input type="hidden" name="student_id" id="student_id">
                    <input type="hidden" name="phase_id" id="phase-id">
                    <input type="hidden" name="course_id" id="course-id">
                    <input type="hidden" name="session-id" id="session-id">
                    <input type="hidden" name="promoteStatus" id="promoteStatus">
                    <div class="modal-body pt-2">
                        <div class="row no-gutters">
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Roll No </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                <div class="form-group  m-form__group" id="std-roll"></div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Reg No </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                <div class="form-group  m-form__group" id="std-reg"></div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Name </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                <div class="form-group  m-form__group" id="std-name"></div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Attach With</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                <div class="form-group  m-form__group">
                                    <select class="form-control" name="followed_by_session_id"
                                            id="followed_by_session_id">
                                        {!! select($sessions) !!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Date</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                <div class="form-group  m-form__group">
                                    <input type="text" class="form-control m-input m_datepicker" name="promotion_date"
                                           placeholder="Date" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Status</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                <div class="m-radio-inline-inline mt-2">
                                    <label class="m-radio ml-2">
                                        <input id="promoted" type="radio" name="promotion" value="1"> Promoted
                                        <span></span>
                                    </label>
                                    <label class="m-radio ml-2">
                                        <input id="demoted" type="radio" name="promotion" value="0">Not Promoted
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Remark</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                <div class="form-group  m-form__group">
                                    <textarea type="text" class="form-control m-input remarks" name="remarks"
                                              autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-brand" data-dismiss="modal"><i
                                class="fa fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-success approve-student"><i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            var courseId = '{{$courseId}}';
            var sessionId = '{{$sessionId}}';
            var phaseId = '{{$phaseId}}';

            $(".m_datepicker").datepicker({
                todayHighlight: !0,
                orientation: "auto",
                format: 'dd/mm/yyyy',
                autoclose: true,
            }).datepicker("setDate", 'now');

            $('.modal-student-progress').on('click', function (e) {
                e.preventDefault();
                var $promoted = $('#promoted');
                var $demoted = $('#demoted');
                var $followedBySessionId = $('#followed_by_session_id');
                var statusCode = $(this).data('status-code');

                $followedBySessionId.find('option:eq(0)').prop('selected', true);
                $promoted.prop('checked', true);
                $demoted.prop('checked', false);
                $promoted.prop('disabled', false).parent().css('cursor', '');
                $demoted.prop('disabled', false).parent().css('cursor', '');

                if (statusCode === 1) {
                    $promoted.prop('checked', false);
                    $promoted.prop('disabled', true)
                        .parent().css('cursor', 'not-allowed');
                    $demoted.prop('checked', true);
                    $followedBySessionId.find('option:eq(1)').prop('selected', true);
                } else if (statusCode === 2) {
                    $demoted.prop('checked', false);
                    $promoted.prop('checked', true);
                    $demoted.prop('disabled', true)
                        .parent().css('cursor', 'not-allowed');
                    $followedBySessionId.find('option:eq(0)').prop('selected', true);
                }

                $('#std-roll').text($(this).data('student-roll'));
                $('#std-reg').text($(this).data('student-reg'));
                $('#std-name').text($(this).data('student-name'));
                $('#student_id').val($(this).data('student-id'));
                $('#phase-id').val($(this).data('phase-id'));
                $('#course-id').val($(this).data('course-id'));
                $('#session-id').val($(this).data('session-id'));
                $('#promoteStatus').val($(this).data('status-code'));

                $('#approve-student-for-prof').modal('show');
            });

            $('#promoted').on('click', function (e) {
                $('#followed_by_session_id').find('option:eq(0)').prop('selected', true);
            });

            $('#demoted').on('click', function (e) {
                $('#followed_by_session_id').find('option:eq(1)').prop('selected', true);
            });

            $('.approve-student').click(function () {
                $('#approve-student-form').validate({
                    rules: {
                        promotion_date: {
                            required: true,
                        }
                    },
                    submitHandler: function (form) {
                        studentId = $('#student_id').val();
                        phaseId = $('#phase-id').val();
                        sessionId = $('#session-id').val();

                        $.ajax({
                            type: "POST",
                            url: baseUrl + 'admin/student_progress_result/' + studentId + '/' + phaseId + '/' + sessionId,
                            data: $(form).serialize(),
                            success: function (response) {
                                console.log(response);
                                if (response.status) {
                                    window.location = response.redirect_url;
                                }
                                window.location.reload();
                            },
                            error: function (response) {
                                toastr.error('Something want Wrong', 'Error!');
                                $('#approve-student-for-prof').modal('hide');
                            }
                        });
                        return false;
                    }
                });
            })
        });
    </script>

@endpush
