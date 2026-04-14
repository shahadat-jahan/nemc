@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css">
    <style>
        .holiday-event .fc-title {
            padding-left: 20px;
        }

        /* Scheduled class */
        .bg-light-gray {
            background: #e7e7e7 !important;
        }

        /* Attended class */
        .bg-light-green {
            background: #92d59f !important;
        }

        /* Suspend class */
        .bg-light-yellow {
            background: #f5da81 !important;
        }

        .fc .fc-axis, .fc button, .fc-day-grid-event .fc-content, .fc-list-item-marker, .fc-list-item-time, .fc-time-grid-event .fc-time, .fc-time-grid-event.fc-short .fc-content {
            white-space: normal;
        }

        .fc-unthemed .fc-event.fc-start .fc-content:before, .fc-unthemed .fc-event-dot.fc-start .fc-content:before {
            background: none;
            top: 8px;
        }

        .fc-unthemed .fc-event .fc-content, .fc-unthemed .fc-event-dot .fc-content {
            padding: 5px;
        }

        /*.fc-scroller>.fc-day-grid, .fc-scroller>.fc-time-grid {*/
        /*    width: 170%;*/
        /*}*/
        /*.fc-scroller {*/
        /*    overflow-x: auto !important;*/
        /*}*/
        /*#calendar > div.fc-view-container > div > table > thead > tr > td > div > table > thead > tr > th.fc-day-header.fc-widget-header.fc-sun {*/
        /*    width: 18%;*/
        /*}*/
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fa fa-calendar-alt fa-md pr-2"></i>Class Routine (Calendar)</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('class_routine.index') }}" class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fa fa-clock"></i> Class Routines</a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" action="{{route(customRoute('class_routine.calendar'))}}" role="form" method="get">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="subject_group_id" id="subject_group_id">
                                            <option value=" ">---- Select Subject Group ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="subject_id" id="subject_id">
                                            <option value=" ">---- Select Subject ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="term_id">
                                            <option value="">---- Select Term ----</option>
                                            {!! select($terms, app()->request->term_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" >
                                    <div class="form-group">
                                        <select class="form-control" name="year">
                                            <option value="">---- Select Year ----</option>
                                            {!! select($years, isset(app()->request->year) ? app()->request->year : date('Y')) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i> Search</button>
                                        <a href="{{ route(customRoute('class_routine.calendar')) }}" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>
    <script>

        var eventData = {!! json_encode($eventData ?? []) !!};

        $('#calendar').fullCalendar({
            header: {
                left: 'title',
                center: '',
                right: 'prev,next',
            },
            events: eventData,
            eventClick: function(calEvent, jsEvent, view) {
                // console.log(calEvent);
            },
            eventRender: function(event, element) {
                element.find('span.fc-title').html(element.find('span.fc-title').text());

            }
        });

        //get subject group by course id
        var subjectGroupId = '{{ app()->request->subject_group_id }}';
        var subjectId = '{{ app()->request->subject_id }}';

        $('#course_id').change(function (e) {
            courseId = $(this).val();
            // load subject group
            if (courseId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route(customRoute('subjectGroup.course'))}}', {courseId: courseId}, function (response) {
                    if (response.data){
                        $('#subject_group_id').html('<option value="">---- Select ----</option>');
                        for (i in response.data){
                            subjectGroup = response.data[i];
                            selected = (subjectGroupId == subjectGroup.id) ? 'selected' : '';
                            console.log('selected' +selected);
                            $('#subject_group_id').append('<option value="'+subjectGroup.id+'" '+selected+'>'+subjectGroup.title+'</option>')
                        }

                    }
                    mApp.unblockPage()
                })
            }

        });

        if (subjectGroupId > 0){
            $('#course_id').trigger('change');
        }

        //get subject by course id and subject group id

        $('#course_id, #subject_group_id').change(function (e) {
            courseId = $('#course_id').val();
            subjectGroupId = $('#subject_group_id').val();
            // load subject
            if (courseId > 0 && subjectGroupId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route(customRoute('subjects.course.group'))}}', {courseId: courseId, subjectGroupId: subjectGroupId}, function (response) {
                    if (response.data){
                        $('#subject_id').html('<option value="">---- Select ----</option>');
                        for (i in response.data){
                            subject = response.data[i];
                            selected = (subjectId == subject.id) ? 'selected' : '';
                            $('#subject_id').append('<option value="'+subject.id+'" '+selected+'>'+subject.title+'</option>')
                        }

                    }
                    mApp.unblockPage()
                })
            }

        });

    </script>
@endpush
