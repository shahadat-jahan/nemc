@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)


@push('style')
    <!--hide id column from table-->
   {{-- <style>
        .table th:nth-child(2) {
            display: none;
        }
        .table tbody td:nth-child(2) {
            display: none;
        }
    </style>--}}

    <style>
        .table td {
            padding-top: 0.6rem !important;
            padding-bottom: .6rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
        }
        .dropdown-menu{
            left: -44rem;
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
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul pr-2"></i>Topic List</h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value=" ">---- Select Course ----</option>
                                            @foreach($courses as $course)
                                                <option value="{{$course->id}}">{{$course->title}}</option>
                                            @endforeach
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
                                        <select class="form-control m-input m-bootstrap-select m_selectpicker" name="teacher_id" id="teacher-id" data-live-search="true">
                                            <option value=" ">---- Select Teacher ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="title" placeholder="Topic Name">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        {{--<select class="form-control m-input m-bootstrap-select m_selectpicker" name="topic_head_id" id="topic_head_id" data-live-search="true">--}}
                                        <select class="form-control m_selectpicker" name="topic_head_id" id="topic_head_id" data-live-search="true">
                                            <option value="">---- Select Topic Head ----</option>
                                            @foreach($topicHeads as $topicHead)
                                                <option value="{{$topicHead->id}}">{{$topicHead->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="clearfix"><hr/></div>

                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i> Search</button>
                                        <button type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</button>
                                    </div>
                                </div>
                            </div><br/>

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
        //serial number for list page before and after filter
        $(document).ready(function(e){
            $('#searchForm').on('submit',function(){
              topicHead = $('#topic_head_id').val();
              if (topicHead > 0) {
                  $("table th:nth-child(2)").css({"display":"block", "width":"auto"});
                  $("table th:nth-child(1)").css("display", "none");
                  setTimeout(function(){
                      $("table tbody tr td:nth-child(2)").css("display", "block");
                      $("table tbody tr td:nth-child(1)").css("display", "none");
                  }, 1000);



              }
            });
        });

        //get subject group by course id
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
                            $('#subject_group_id').append('<option value="'+subjectGroup.id+'">'+subjectGroup.title+'</option>')
                        }

                    }
                    mApp.unblockPage()
                })
            }

        });

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
                            $('#subject_id').append('<option value="'+subject.id+'">'+subject.title+'</option>')
                        }

                    }
                    mApp.unblockPage()
                })
            }

        });

        //get teacher by subject id
        $('#subject_id').change(function (e) {
            subjectId = $('#subject_id').val();
            console.log('subject for teacher' +subjectId);
            // load subject
            if (subjectId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route(customRoute('teacher.list.subject'))}}', {subjectId: subjectId}, function (response) {
                    if (response.data){
                        $("#teacher-id").html('<option value="">--Select--</option>');
                        if (response.data.length > 0){
                            for (i in response.data){
                                teacher = response.data[i];
                                $("#teacher-id").append('<option value="' + teacher.id + '">' + teacher.full_name + '</option>');
                            }
                        }
                        $("#teacher-id").selectpicker('refresh');

                    }
                    mApp.unblockPage()
                })
            }

        });
    </script>
@endpush
