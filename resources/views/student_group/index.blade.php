@extends('layouts.default')
@section('pageTitle', $pageTitle)
@section('content')
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
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('student_group/create'))
                            <a href="{{ route('student_group.create') }}" class="btn btn-primary m-btn m-btn--icon"><i
                                    class="fa fa-plus pr-2"></i>Create</a>
                        @endif
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker"
                                                name="department_id"
                                                data-live-search="true">
                                            <option value="">---- Select Department ----</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}">{{$department->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="group_name"
                                               placeholder="Group Name"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="type">
                                            <option value="">---- Select Group type ----</option>
                                            {!! select($groupTypes) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                        </div>
                    </form>

                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
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

@endsection
