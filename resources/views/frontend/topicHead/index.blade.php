@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <!--hide id column from table-->
    <style>
        .table th:first-child {
            display: none;
        }
        .table tbody td:first-child {
            display: none;
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
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul pr-2"></i>Topic Head List</h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="title" placeholder="Topic Head Name">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value=" ">---- Select Course ----</option>
                                            @foreach($courses as $course)
                                                <option value="{{$course->id}}">{{$course->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="subject_group_id" id="subject_group_id">
                                            <option value=" ">---- Select Subject Group ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="subject_id" id="subject_id">
                                            <option value=" ">---- Select Subject ----</option>
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

                $.get('{{route('frontend.subjectGroup.course')}}', {courseId: courseId}, function (response) {
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

                $.get('{{route('frontend.subjects.course.group')}}', {courseId: courseId, subjectGroupId: subjectGroupId}, function (response) {
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
    </script>
@endpush
