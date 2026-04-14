@extends('frontend.layouts.default')
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
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <form id="searchForm" role="form" method="get">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="term_id" id="term_id">
                                            <option value="">---- Select Term ----</option>
                                            {!! select($terms, app()->request->term_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="exam_category_id" id="exam_category_id">
                                            <option value="">---- Select Exam Category ----</option>
                                            {!! select($examCategories, app()->request->exam_category_id) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary result-search m-btn m-btn--icon"><i class="fa fa-search"></i> Search</button>
                                        <a href="{{route('frontend.result.index')}}" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="m-section__content mt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    @include('common/datatable')
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

    <script>

        $('.result-search').click(function () {
            if ( ($('#session_id').val() < 1) || ($('#course_id').val() < 1)){
                sweetAlert('Session & course is required', 'error');
                return false;
            }else{
                $('#searchForm').submit();
            }
        })

    </script>

@endpush
