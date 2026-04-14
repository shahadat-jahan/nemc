@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul pr-2"></i>Payment Detail List</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('payment_detail/create'))
                            <a href="{{route('payment_detail.create') }}" class="btn btn-primary m-btn m-btn--icon"><i
                                    class="fa fa-plus pr-2"></i>Create</a>
                        @endif
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="payment_type_id">
                                            <option value=" ">---- Select payment type ----</option>
                                            {!! select($paymentTypes) !!}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="student_category_id">
                                            <option value=" ">---- Select student category ----</option>
                                            {!! select($studentCategories) !!}
                                        </select>
                                    </div>
                                </div>

                                {{--                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">--}}
                                {{--                                    <div class="form-group">--}}
                                {{--                                        <select class="form-control" name="session_id">--}}
                                {{--                                            <option value=" ">---- Select session ----</option>--}}
                                {{--                                            {!! select($sessions) !!}--}}
                                {{--                                        </select>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id">
                                            <option value=" ">---- Select course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i>
                                            Search
                                        </button>
                                        <button type="reset" class="btn btn-default reset"><i
                                                class="fas fa-sync-alt search-reset"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <br/>
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
