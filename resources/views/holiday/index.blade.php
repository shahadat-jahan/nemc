@extends('layouts.default')
@section('pageTitle', $pageTitle)
<?php
$year = !empty(request()->year) ? request()->year : date('Y');
?>
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul pr-2"></i>Holiday List</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{route('holiday.calendar') }}" class="btn btn-primary m-btn m-btn--icon mr-2"><i class="fas fa-calendar-alt pr-2"></i>Calender View</a>
                        @if (hasPermission('holiday/create'))
                            <a href="{{route('holiday.create') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-plus pr-2"></i>Create</a>
                        @endif
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="title" placeholder="Holiday title">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select name="month" class="form-control" id="month">
                                            <option value="">---- Select Month ----</option>
                                            {!! select($months, request()->month) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m_year_picker" value="{{date('Y')}}"
                                               name="year"
                                               id="year" autocomplete="off" readonly/>
                                    </div>
                                </div>


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

