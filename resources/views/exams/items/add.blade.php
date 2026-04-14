@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
<style>
    .custom-select {
        height: calc(2.25rem + 4px) !important;
    }

    .disabled-button {
        cursor: not-allowed;
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
                <a href="{{ route('exams.list') }}" class="btn btn-primary m-btn m-btn--icon"><i class="far fa-list-alt pr-2"></i>Exams</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('exams.item.save', [$itemId]) }}" id="nemc-general-form" method="post">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Session </label>
                            <select class="form-control m-input" name="session_id" id="session_id">
                                <option value="">---- Select Session ----</option>
                                {!! select($sessions) !!}
                            </select>
                            @if ($errors->has('session_id'))
                                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                            <select class="form-control m-input" name="course_id" id="course_id">
                                <option value="">---- Select Course ----</option>
                                {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                            </select>
                            @if ($errors->has('course_id'))
                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('phase_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Phase </label>
                            <select class="form-control m-input" name="phase_id" id="phase_id">
                                <option value="">---- Select Phase ----</option>
                                {!! select($phases) !!}
                            </select>
                            @if ($errors->has('phase_id'))
                                <div class="form-control-feedback">{{ $errors->first('phase_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('term_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Term </label>
                            <select class="form-control m-input" name="term_id" id="term_id">
                                <option value="">---- Select Term ----</option>
                                {!! select($terms) !!}
                            </select>
                            @if ($errors->has('term_id'))
                                <div class="form-control-feedback">{{ $errors->first('term_id') }}</div>
                            @endif
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Student Group Type </label>
                            <select class="form-control m-input" name="student_group_type_id" id="student_group_type_id">
                                <option value="">---- Select Group Type ----</option>
                                {!! select($groupTypes) !!}
                            </select>
                            @if ($errors->has('student_group_type_id'))
                                <div class="form-control-feedback">{{ $errors->first('student_group_type_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group  m-form__group {{ $errors->has('student_group_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Student Group </label>
                            <div class="input-group">
                                <select class="custom-select" name="student_group_id" id="student_group_id" aria-label="Example select with button addon">
                                    <option value="">---- Select Student Group ----</option>
                                    @if(!empty($studentGroups))
                                    <option value="all">Group - All</option>
                                    @endif
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-success" id="search-students" type="button">Click to Search
                                    </button>
                                </div>
                            </div>
                            @if ($errors->has('student_group_id'))
                                <div class="form-control-feedback">{{ $errors->first('student_group_id') }} test</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Teacher </label>
                            <select class="form-control m-input m-bootstrap m_selectpicker" name="teacher_id"
                                    id="teacher_id"
                                    data-live-search="true">
                                <option value="">---- Select Teacher ----</option>
                                {!! select($teachers) !!}
                            </select>
                            @if ($errors->has('teacher_id'))
                                <div class="form-control-feedback">{{ $errors->first('teacher_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="Exam of {{$itemInfo->card->title.' - '.$itemInfo->title}}" placeholder="Date"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                <div class="row seperator-title m--hide">
                    <div class="col">
                        <h3 class="m-form__heading-title">Students</h3>
                        <hr>
                    </div>
                </div>
                <div class="row" id="all-students"></div>
            </div>
            <div class="m-form__actions text-center">
                <div class="m-form__actions">
                    <a href="{{ route('cardItems.index') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i>
                        Cancel</a>
                    <button type="submit" id="save-button" class="btn btn-success disabled-button" disabled><i
                            class="fa fa-save"></i>
                        Save
                    </button>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.0/handlebars.min.js"></script>

    <script id="students-marks" type="text/x-handlebars-template">
        @{{#each students}}
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group  m-form__group">
                <div style="padding-top: 32px"> Name : @{{ full_name_en }}</div>
                <input type="hidden" class="form-control m-input" name="student_id[]" value="@{{ id }}" placeholder="Name"/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <div style="padding-top: 32px">Roll : @{{ roll_no }}</div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <label class="form-control-label">Exam Date </label>
                <input type="text" class="form-control m-input m_datepicker_1" name="clear_date[]" placeholder="Date" autocomplete="off"/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <label class="form-control-label"> Marks </label>
                <!--if youse this then page page take auto reload when give value -->
               {{-- <input type="number" class="form-control m-input" name="marks[]" min="0" max="{{$itemMaxMark}}" placeholder="Marks"/>--}}
                <input type="text" class="form-control m-input" name="marks[]" placeholder="Marks"/>
                <span class="help-text">Max marks: {{$itemMaxMark}}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group  m-form__group">
                <label class="form-control-label"> Remarks </label>
                <input type="text" class="form-control m-input" name="remarks[]" placeholder="Remarks" autocomplete="off"/>
            </div>
        </div>
        @{{/each}}
    </script>

    <script>

        //get student group by session, course and student group type
        $('#session_id, #course_id, #student_group_type_id').change(function (e) {
            e.preventDefault();
            const departmentId = '{{$itemInfo->card->subject->department_id}}';
            var sessionId = $('#session_id').val();
            var courseId = $('#course_id').val();
            var phaseId = $('#phase_id').val();
            var studentGroupTypeId = $('#student_group_type_id').val();

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            if(sessionId > 0 && courseId > 0 && phaseId > 0 && studentGroupTypeId > 0){
                $.get('{{route('studentGroup.by.session.course.groupType')}}', {sessionId: sessionId, courseId:
                    courseId, phaseId: phaseId, studentGroupTypeId: studentGroupTypeId, departmentId: departmentId}, function
                    (response) {
                    var department = "";
                    if (response.data) {
                        $('#student_group_id').html('<option value="">---- Select Student Group ----</option> <option value="all"> Group - All </option>');
                        for (i in response.data) {
                            studentGroup = response.data[i];
                            if (studentGroup.department_id) {
                                department = ' - ' + studentGroup.department.title;
                            }
                            $('#student_group_id').append('<option value="' + studentGroup.id + '">' + studentGroup.group_name + department + '</option>')
                        }
                    }
                });
            }
            mApp.unblockPage()
        });

        itemId = '{{$itemId}}';
        var form = $('#nemc-general-form').validate({
            rules:{
                session_id:{
                    required: true,
                },
                course_id:{
                    required: true,
                },
                phase_id:{
                    required: true,
                },
                term_id:{
                    required: true,
                },
                teacher_id:{
                    required: true,
                },
                title:{
                    required: true,
                },
                student_group_type_id: {
                    required: true,
                    min: 1
                },
                student_group_id: {
                    required: true,
                    remote: {
                        url: "{{route('studentGroupAlreadyGetMark.check')}}",
                        type: "post",
                        data: {
                            session_id: function() {
                                return $("#session_id" ).val();
                            },
                            course_id: function() {
                                return $("#course_id" ).val();
                            },
                            phase_id: function() {
                                return $("#phase_id" ).val();
                            },
                            term_id: function() {
                                return $("#term_id" ).val();
                            },

                            student_group_id: function() {
                                return $("#student_group_id" ).val();
                            },

                            itemId: function() {
                                return itemId;
                            },
                            _token: "{{ csrf_token() }}",
                        }
                    }
                },
            },
            messages: {
                student_group_id:{
                    remote: 'Exam Mark is provided for this group of student'
                },
            },
        });

        $('#search-students').click(function (e) {
            e.preventDefault();

            if (form.element("#student_group_id")) {
                sessionId = $('#session_id').val();
                courseId = $('#course_id').val();
                phaseId = $('#phase_id').val();
                termId = $('#term_id').val();
                studentGroupId = $('#student_group_id').val();

                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                if (sessionId > 0 && courseId > 0 && phaseId > 0 && termId > 0 && itemId > 0 && (studentGroupId > 0 || studentGroupId == 'all')) {
                    $.get('{{route('students.list.session.course.phase.term')}}', {sessionId: sessionId, courseId: courseId, phaseId: phaseId, termId: termId, studentGroupId: studentGroupId, itemId: itemId}, function (response) {
                        template   = $('#students-marks').html();
                        templateData = Handlebars.compile(template);
                        $('#all-students').html(templateData(response));
                        $('.seperator-title').removeClass('m--hide');
                        $(".m_datepicker_1").datepicker( {
                            todayHighlight: !0,
                            orientation: "bottom left",
                            format: 'dd/mm/yyyy',
                            autoclose: true,
                        });
                        $('#save-button').prop('disabled', false).removeClass('disabled-button');
                    })
                }
                mApp.unblockPage()
            } else {
                $('#all-students').html('');
                $('#save-button').prop('disabled', true).addClass('disabled-button');
            }
        });

        window.setInterval(function() {
            if (form.errorList.length > 0) {
                $('#all-students').html('');
                $('#save-button').prop('disabled', true).addClass('disabled-button');
            }
        }, 1000);

        // push 1st exam field date to all exam date field
        $(document).on('change','#all-students .col-xs-12:nth-child(3) .m_datepicker_1',function(){
           if ($(".m_datepicker_1").val()){
               var examDate = $(".m_datepicker_1").val();
               $(".m_datepicker_1").val(examDate);
           }
        });
    </script>
@endpush
