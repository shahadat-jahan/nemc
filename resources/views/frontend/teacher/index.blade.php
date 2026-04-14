@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        .error {
            color: #f4516c;
            font-size: 0.8em;
        }
        .m-form .form-control-feedback {
            margin-top: 0;
            font-size: .85rem;
            padding-left: 6px;
            color: #E91E63;
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
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul pr-2"></i>Teacher List</h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="department_id" >
                                            <option value=" ">---- Select Department ----</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}">{{$department->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" >
                                            <option value=" ">---- Select Course ----</option>
                                            @foreach($courses as $course)
                                                <option value="{{$course->id}}">{{$course->title}}</option>
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

    <!-- Include message modal-->
    @include('frontend.common.messageModal')

@endsection


