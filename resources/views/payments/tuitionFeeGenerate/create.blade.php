@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('student.tuition.fee.list') }}" class="btn btn-primary m-btn m-btn--icon" title="Class Absent Fee"><i class="far fa-credit-card"></i> Student Tuition Fee</a>
                    </div>
                </div>

                <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('student.tuition.fee.save') }}" method="post" id="nemc-general-form">
                    @csrf
                    <div class="m-portlet__body">

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label">Session </label>
                                    <select class="form-control m-input" name="session_id" id="session_id">
                                        <option value="">---- Select Session ----</option>
                                        {!! select($sessions) !!}
                                    </select>
                                    @if ($errors->has('session_id'))
                                        <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            @php $authUser = Auth::guard('web')->user(); @endphp
                            @if($authUser->user_group_id == 7)
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                                        <label class="form-control-label">Course </label>
                                        <!-- Staff - Accounts (MBBS)-->
                                        @if($authUser->adminUser->course_id == 1)
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                <option value="1" {{ app()->request->course_id == 1 ? 'selected' : ''}}> MBBS </option>
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif
                                            <!-- Staff - Accounts (BDS)-->
                                        @elseif($authUser->adminUser->course_id == 2)
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                <option value="2" {{ app()->request->course_id == 2 ? 'selected' : ''}}> BDS </option>
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif
                                            <!-- Staff - Accounts (when no course with user(MBBS and BDS))-->
                                        @else
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                {!! select($courses, app()->request->course_id) !!}
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif

                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                                        <label class="form-control-label">Course </label>
                                        <select class="form-control m-input" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                        @if ($errors->has('course_id'))
                                            <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('student_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label">Student </label>
                                    <select class="form-control m-input m-bootstrap-select m_selectpicker" name="student_id" id="student_id" data-live-search="true">
                                        <option value="">---- Select Student ----</option>
                                    </select>
                                    @if ($errors->has('student_id'))
                                        <div class="form-control-feedback">{{ $errors->first('student_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div
                                    class="form-group  m-form__group {{ $errors->has('student_user_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Student ID
                                    </label>
                                    <input type="text" class="form-control m-input" name="student_user_id"
                                           id="student-user-id"
                                           value="{{app()->request->student_user_id}}" placeholder="Student ID"/>
                                    @if ($errors->has('student_user_id'))
                                        <div class="form-control-feedback">{{ $errors->first('student_user_id') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Fee title
                                    </label>
                                    <input type="text" class="form-control m-input" name="title" value="Tuition Fee"
                                           placeholder="Fee title" disabled/>
                                    @if ($errors->has('title'))
                                        <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group ">
                                    <label class="form-control-label"><span class="text-danger">*</span> Bill Month From</label>
                                    <input type="text" class="form-control m-input m_datepicker_1" name="bill_month_from" value="{{ old('bill_month_from') }}" placeholder="Date for bill month from" autocomplete="off">
                                    <small id="emailHelp" class="form-text text-muted">Focus on month and year only, day will be taken automatically</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Bill Month To </label>
                                    <input type="text" class="form-control m-input m_datepicker_1" name="bill_month_to" id="bill_month_to" value="{{ old('bill_month_to') }}" placeholder="Date for bill month to" autocomplete="off">
                                    <small id="emailHelp" class="form-text text-muted">Focus on month and year only, day will be taken automatically</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <a href="{{ route('student.absent.fee.list') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>

    <script>

        var baseUrl = '{!! url('/') !!}/';
        var studentId = '<?php echo app()->request->student_id; ?>';
        var students = [];

        $("#phase_id").css("pointer-events","none");

        function makeStudentIdAndUserId(sessionId, courseId){
            if (courseId > 0 && sessionId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('<?php echo e(route('student.info.session.course')); ?>', {
                    courseId: courseId, sessionId: sessionId, _token: "<?php echo e(csrf_token()); ?>"
                }, function (response) {
                    students = response;
                    $("#student_id").html('<option value="">---- Select Student ----</option>');
                    for (var i = 0; i < response.length; i++) {
                        selected = (studentId == response[i].id) ? 'selected' : '';
                        $("#student_id").append('<option data-user-id="' + response[i].user.user_id + '" value="' + response[i].id + '" ' + selected + '>' + response[i].full_name_en + ' (' + 'Roll No-' + response[i].roll_no + ')' + '</option>');
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

        $('#student_id').change(function (e) {
            e.preventDefault();
            //selectedGroups = _.filter(selectedGroups, function(item) { return item.type == 3});
            studentId = $(this).val();
            if(studentId > 0){
                selectedStudent = _.head(_.filter(students, function(item) { return item.id == studentId}));
                $('#phase_id').val(selectedStudent.phase_id);
                studentUserId = $('#student_id option:selected').attr('data-user-id');
                $('#student-user-id').val(studentUserId);
            }
        });

        $('#student-user-id').keyup(function (e) {
            e.preventDefault();

            $("#student_id").val('');
            $('.m_selectpicker').selectpicker('refresh');
        });


        $('#nemc-general-form').validate({
            rules:{
                session_id: {
                    required: function () {
                        return $("#student-user-id").val() == 0;
                    },
                    min: 1,
                },
                course_id: {
                    required: function () {
                        return $("#student-user-id").val() == 0;
                    },
                    min: 1
                },
                student_id: {
                    required: function () {
                        return $("#session_id").val() > 0 || $("#course_id").val() > 0;
                    },
                    min: 1,
                    remote: {
                        url: "{{route('payment.absent.fee.check')}}",
                        type: "post",
                        data: {
                            student_id: function() {
                                return $( "#student_id" ).val();
                            },
                            phase_id: function() {
                                return $( "#phase_id" ).val();
                            },
                            _token: "{{ csrf_token() }}",
                        }
                    }
                },
                student_user_id: {
                    required: true,
                    min: 1,
                    remote: {
                        url: "{{route('check.userId.exist')}}",
                        type: "post",
                        data: {
                            user_id: function () {
                                return $("#student-user-id").val();
                            },
                            _token: "{{ csrf_token() }}",
                        },
                        dataFilter: function (response) {
                            // Reverse the response logic: true -> false, false -> true
                            return response === "true" ? "false" : "true";
                        }
                    }
                },
                bill_month_from: {
                    required: true,
                },
                // check tuition fee is already generated for the current date range or not
                bill_month_to: {
                    required: true,
                    //min: 1,
                    remote: {
                        url: "{{route('student.tuitionFee.paid.monthTo')}}",
                        type: "post",
                        data: {
                            student_id: function () {
                                return $("#student_id").val();
                            },
                            billMonthTo: function () {
                                return $("#bill_month_to").val();
                            },
                            _token: "{{ csrf_token() }}",
                        }
                    }
                },
            },
            messages: {
                session_id: {
                    required: 'This field is required when a student ID is not provided.'
                },
                course_id: {
                    required: 'This field is required when a student ID is not provided.'
                },
                student_id: {
                    required: 'This field is required when session or course are provided.',
                    remote: 'Payment already generated',
                },
                student_user_id: {
                    remote: 'No student found with this ID'
                },
                bill_month_to: {
                    remote: 'Tuition Fee already generated for this range. Please decrease " Bill Month To" value '
                }
            }
        });

        $(document).ready(function() {
            $(".m_datepicker_1").datepicker( {
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
            });

        });

    </script>
@endpush
