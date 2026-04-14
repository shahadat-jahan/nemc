@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Group of Class Routine</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('class_routine/create'))
                            <a href="{{ route('class_routine.create') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-plus pr-2"></i>Create</a>
                        @endif
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m_selectpicker" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m_selectpicker" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m_selectpicker" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases) !!}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m_selectpicker" name="term_id">
                                            <option value="">---- Select Term ----</option>
                                            {!! select($terms) !!}
                                        </select>
                                    </div>
                                </div>

{{--                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <select class="form-control m-input" name="term_id" id="term_id">--}}
{{--                                           <option value="">---- Select ----</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m_selectpicker" name="subject_id" id="subject_id">
                                            <option value="">---- Select Subject ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="teacher_id"
                                                id="teacher_id_filter" data-live-search="true">
                                            <option value="">---- Select Teacher ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker"
                                                name="class_type_id"
                                                id="class_type_id" data-live-search="true">
                                            <option value="">---- Select Class Types ----</option>
                                            {!! select($classTypes) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input m_datepicker_1" name="class_date"
                                               placeholder="Class Date" autocomplete="off" readonly/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" >
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input m_year_picker" name="year"
                                               placeholder="Year" value="{{date('Y')}}"
                                               autocomplete="off" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i> Search</button>
                                        <button type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="table m-table table-responsive">
                                        @include('common/datatable')
                                    </div>
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
        var phaseInfo = [];
        var total_terms='';
        var selectedPhase='';

        $('#course_id, #session_id').change(function () {
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            $.get('{{route('phase.term.list')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                 if (response.data){
                     phaseInfo = response.data;
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



            selectedPhase = _.find(phaseInfo, function(o) { return o.phase.id  == phaseId; });
            if (selectedPhase) {
              console.log(`x === undefined`)
              totalTerms=selectedPhase.total_terms;
            } else {
              console.log(`x !== undefined`)
              totalTerms=''
            }

            // load subjects
            $.get('{{route('subjects.session.course.phase')}}', {sessionId: sessionId, courseId: courseId, phaseId: phaseId}, function (response) {
                if (response.data){
                    $('#subject_id').html('<option value="">---- Select Subject----</option>');
                    for (i in response.data){
                        subject = response.data[i];
                        $('#subject_id').append('<option value="'+subject.id+'">'+subject.title+'</option>')
                    }
                    $('.m_selectpicker').selectpicker('refresh');
                }
                mApp.unblockPage();
            })
        });

        $('#subject_id').change(function(e){
            e.preventDefault();
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            subjectId = $(this).val();

            $.get('{{route('teacher.list.subject')}}', {subjectId: subjectId}, function(response){
                $("#teacher_id_filter").html('<option value="">---- Select Teacher ----</option>');
                if (response.data.length > 0){
                    for (i in response.data){
                        item = response.data[i];
                        $("#teacher_id_filter").append('<option value="' + item.id + '">' + item.full_name + '</option>');
                    }
                    $('.m_selectpicker').selectpicker('refresh');
                }
                mApp.unblockPage();
            });

        });

        $(".m_datepicker_1").datepicker( {
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
        });
    </script>
@endpush
