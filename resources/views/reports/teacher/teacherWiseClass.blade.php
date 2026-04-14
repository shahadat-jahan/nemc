@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item, .m-stack--demo.m-stack--hor .m-stack__demo-item {
            padding: 29px;
        }

        th.custom-border, td.custom-border {
            border-left-width: 6px;
            border-left-color: #f4f5f8;
        }
    </style>

@endpush
@section('content')

    <?php
    $sessionId   = (isset(app()->request->session_id) && !empty(app()->request->session_id)) ? app()->request->session_id : '';
    $courseId    = (isset(app()->request->course_id) && !empty(app()->request->course_id)) ? app()->request->course_id : '';
    $phaseId     = (isset(app()->request->phase_id) && !empty(app()->request->phase_id)) ? app()->request->phase_id : '';
    $termId      = (isset(app()->request->term_id) && !empty(app()->request->term_id)) ? app()->request->term_id : '';
    $subjectId   = (isset(app()->request->subject_id) && !empty(app()->request->subject_id)) ? app()->request->subject_id : '';
    $classTypeId = (isset(app()->request->class_type_id) && !empty(app()->request->class_type_id)) ? app()->request->class_type_id : '';
    $fromDate    = (isset(app()->request->from_date) && !empty(app()->request->from_date)) ? app()->request->from_date : '';
    $toDate      = (isset(app()->request->to_date) && !empty(app()->request->to_date)) ? app()->request->to_date : '';
    ?>
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
                        <form id="nemc-general-form" role="form" method="get">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m_selectpicker" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m_selectpicker" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m_selectpicker" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m_selectpicker" name="term_id" id="term_id">
                                            <option value="">---- Select Term----</option>
                                            {!! select($terms, app()->request->term_id) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="subject_id"
                                                id="subject_id" data-live-search="true">
                                            <option value="">---- Select Subject ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control" name="class_type_id"
                                            id="class_type_id" data-live-search="true">
                                        <option value="">---- Select Class Type ----</option>
                                        {!! select($classTypes, app()->request->class_type_id) !!}
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group  m-form__group">
                                        <input type="text" class="form-control m_datepicker" name="from_date"
                                               value="{{app()->request->from_date}}" id="from_date"
                                               placeholder="Date From" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group  m-form__group">
                                        <input type="text" class="form-control m_datepicker" name="to_date"
                                               value="{{app()->request->to_date}}" id="to_date" placeholder="Date To"
                                               autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        @if(!empty($teacherWiseClass) || !empty($teacherWiseClass))
                                            <a href="{{route('report.teacher.all.class.excel', [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'phase_id' => app()->request->phase_id,
                                        'term_id' => app()->request->term_id,
                                        'subject_id' => app()->request->subject_id,
                                        'class_type_id' => app()->request->class_type_id,
                                        'from_date' => app()->request->from_date,
                                        'to_date' => app()->request->to_date,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-export"></i>
                                                Export</a>
                                        @endif
                                        <button class="btn btn-primary m-btn m-btn--icon search-result"><i
                                                class="fa fa-search"></i> Search
                                        </button>
                                        <a class="btn btn-default m-btn m-btn--icon"
                                           href="{{url('admin/report_teacher_wise_class')}}">
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @php
                            $assign=$teacherWiseClass['assign'];
                        @endphp
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-center">Teacher Wise Class (Assign)</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">SL</th>
                                            <th scope="col">Teacher Name</th>
                                            <th scope="col" class="text-center">Total Class</th>
                                            <th scope="col" class="text-center">Taken Class</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($assign))
                                            @php $sl=1; @endphp
                                            @foreach($assign as $key=>$value)
                                                <tr>
                                                    <td rowspan="2" class="text-center">{{$sl}}</td>
                                                    <td rowspan="2">
                                                        @php
                                                            $teacher_id=$key;
                                                            $teachers=getTeacherNameByTeacherId($teacher_id);
                                                            $first_name=!empty($teachers->first_name) ? $teachers->first_name :' ';
                                                            $last_name=!empty($teachers->last_name) ? $teachers->last_name :' ';
                                                            $full_name=$first_name.' '.$last_name
                                                        @endphp
                                                        <a href="{{ url('admin/teacher/'.$teacher_id) }}"
                                                           target="_blank">
                                                            {{!empty($full_name) ? $full_name :'---'}}
                                                        </a>
                                                    </td>
                                                    <td rowspan="2" class="text-center">{{$value}}</td>
                                                    <td rowspan="2" class="text-center">
                                                        {{getTotalClass($teacher_id,$sessionId,$phaseId, $termId, $subjectId, $classTypeId, false, $fromDate, $toDate, $courseId)}}
                                                    </td>
                                                <tr/>
                                                @php $sl++; @endphp
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>
    <script>
        var sessionId = '{{ app()->request->session_id }}';
        var courseId = '{{ app()->request->course_id }}';
        var phaseId = '{{ app()->request->phase_id }}';
        var subjectId = '{{ app()->request->subject_id }}';
        var phaseInfo = [];
        var total_terms = '';
        var selectedPhase = '';

        $('#course_id, #session_id').change(function () {
            courseId = 1;
            sessionId = $('#session_id').val();
            $.get('{{route('phase.term.list')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                if (response.data) {
                    phaseInfo = response.data;
                    //console.log(phaseInfo);
                }
            })
        });

        $('#phase_id').change(function () {
            phaseId = $(this).val();
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            selectedPhase = _.find(phaseInfo, function (o) {
                return o.phase.id == phaseId;
            });
            if (selectedPhase) {
                console.log(`x === undefined`)
                totalTerms = selectedPhase.total_terms;
            } else {
                console.log(`x !== undefined`)
                totalTerms = ''
            }
            //total_terms=selectedPhase.total_terms ? selectedPhase.total_terms :'';
            //console.log(selectedPhase);
            $('#term_id').html('<option value="">---- Select ----</option>');
            for (var i = 1; i <= totalTerms; i++) {
                $('#term_id').append('<option value="' + i + '"> Term ' + i + '</option>')
            }

            // load subjects
            $.get('{{route('subjects.session.course.phase')}}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId
            }, function (response) {
                if (response.data) {
                    $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                    for (i in response.data) {
                        subject = response.data[i];
                        selected = (subjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="' + subject.id + '" ' + selected + '>' + subject.title + '</option>')
                    }
                }
                $('.m_selectpicker').selectpicker('refresh');
                mApp.unblockPage();
            })
        });

        if (phaseId > 0) {
            console.log(phaseId)
            // load subjects
            $.get('{{route('subjects.session.course.phase')}}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId
            }, function (response) {
                if (response.data) {
                    $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                    for (i in response.data) {
                        subject = response.data[i];
                        selected = (subjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="' + subject.id + '" ' + selected + '>' + subject.title + '</option>')
                    }
                }
                $('.m_selectpicker').selectpicker('refresh');
                mApp.unblockPage();
            })
        }

        //search form dropdown validation
        //        $('.search-result').click(function () {
        //            valid = true;
        //            $('#nemc-general-form select').each(function () {
        //                if (($(this).val() == '')){
        //                    valid = false;
        //                }
        //            });
        //
        //            if(valid == false){
        //                sweetAlert('Session, course, student & date from fields are required to search', 'error');
        //                return false;
        //            }else if($('#from_date').val() == ''){
        //                sweetAlert('Session, course, student & date from fields are required to search', 'error');
        //                return false;
        //            }else{
        //                $('#nemc-general-form').submit();
        //            }
        //        });

        $(".m_datepicker").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            //format: 'yyyy-mm-dd',
            autoClose: true,
        });

    </script>
@endpush
