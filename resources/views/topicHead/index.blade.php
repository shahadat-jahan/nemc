@extends('layouts.default')
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
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('topic_head/create'))
                            <a href="{{route('topic_head.create') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-plus pr-2"></i>Create</a>
                        @endif
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
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
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
        $(document).ready(function () {
            let courseId = $('#course_id').val();
            let subjectGroupId = $('#subject_group_id').val();

            // On course change, load subject groups
            $('#course_id').change(function () {
                courseId = $(this).val();
                    mApp.blockPage({
                        overlayColor: "#000000",
                        type: "loader",
                        state: "primary",
                        message: "Please wait..."
                    });

                    $.get('{{ route('SubjectGroup.course') }}', {courseId}, function (response) {
                        if (response.data) {
                            const $subjectGroup = $('#subject_group_id');
                            $subjectGroup.html('<option value="">---- Select Subject Group ----</option>');
                            response.data.forEach(group => {
                                $subjectGroup.append(`<option value="${group.id}">${group.title}</option>`);
                            });
                        }
                        mApp.unblockPage();
                    });
            });

            // On course or subject group change, load subjects
            $('#course_id, #subject_group_id').change(function () {
                let subjectGroupId = $('#subject_group_id').val();
                    mApp.blockPage({
                        overlayColor: "#000000",
                        type: "loader",
                        state: "primary",
                        message: "Please wait..."
                    });

                    $.get('{{ route('subjects.course.group') }}', {courseId, subjectGroupId}, function (response) {
                        if (response.data) {
                            const $subject = $('#subject_id');
                            $subject.html('<option value="">---- Select Subject ----</option>');
                            response.data.forEach(sub => {
                                $subject.append(`<option value="${sub.id}">${sub.title}</option>`);
                            });
                        }
                        mApp.unblockPage();
                    });
            });

            // If course is already selected on page load
            if (courseId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{ route('SubjectGroup.course') }}', {courseId}, function (response) {
                    if (response.data) {
                        const $subjectGroup = $('#subject_group_id');
                        $subjectGroup.html('<option value="">---- Select Subject Group ----</option>');
                        response.data.forEach(group => {
                            $subjectGroup.append(`<option value="${group.id}">${group.title}</option>`);
                        });
                    }
                    mApp.unblockPage();
                });
            }

            if (courseId > 0 && subjectGroupId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{ route('subjects.course.group') }}', {courseId, subjectGroupId}, function (response) {
                    if (response.data) {
                        const $subject = $('#subject_id');
                        $subject.html('<option value="">---- Select ----</option>');
                        response.data.forEach(sub => {
                            $subject.append(`<option value="${sub.id}">${sub.title}</option>`);
                        });
                    }
                    mApp.unblockPage();
                });
            }

        });
    </script>
@endpush
