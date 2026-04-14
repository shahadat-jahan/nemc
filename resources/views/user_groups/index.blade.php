@extends('layouts.default')
@section('pageTitle', 'User Group')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">User Group</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('user_groups/create'))
                            <a href="{{ url('admin/user_groups/create') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-plus pr-2"></i>Create</a>
                        @endif
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <div class="table m-table">
                                    <table class="table table-bordered table-hover" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>GROUP NAME</th>
                                            <th>DESCRIPTION</th>
                                            <th class="text-center">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($results as $userGroup)
                                            <tr>
                                                <td>{{ $userGroup->id }}</td>
                                                <td>{{ $userGroup->group_name }}</td>
                                                <td>{{ $userGroup->description }}</td>
                                                <td class="text-center">
                                                    @if (hasPermission('user_groups/edit'))
                                                        <a href="{{ url('admin/user_groups/'.$userGroup->id.'/edit') }}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>
                                                    @endif
                                                    @if (hasPermission('user_groups/permission'))
                                                        <a href="{{ url('admin/user_groups/'.$userGroup->id.'/permission') }}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Setting"><i class="flaticon-cogwheel-1"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
