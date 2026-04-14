@extends('layouts.default')
@section('pageTitle', 'Designation')

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>Edit Department</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/department') }}" class="btn btn-primary m-btn m-btn--icon"><i class="far fa-building pr-2"></i>Departments</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/department/' .$department->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title', $department->title) }}" placeholder="Department Title"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Department Head </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="department_lead_id" data-live-search="true">
                                <option value=" ">---- Select Department Head----</option>
                                @foreach($departmentLeads as $departmentLead)
                                   {{-- <option value="{{$departmentLead->user_id}}">{{$departmentLead->first_name.' '.$departmentLead->last_name}}</option>--}}
                                    @if(isset($department->teacher))
                                        <option value="{{$departmentLead->id}}" {{ $departmentLead->id == $department->teacher->id ? 'selected' : ' ' }}>{{$departmentLead->first_name.' '.$departmentLead->last_name}}</option>
                                    @else
                                        <option value="{{$departmentLead->id}}">{{$departmentLead->first_name.' '.$departmentLead->last_name}}</option>
                                    @endif

{{--                                        @if (!empty($department->user->teacher))--}}
{{--                                        <option value="{{$departmentLead->id}}" {{ $departmentLead->id == $department->user->teacher->user_id ? 'selected' : ' ' }}>{{$departmentLead->first_name.' '.$departmentLead->last_name}}</option>--}}
{{--                                        @else--}}
{{--                                         <option value="{{$departmentLead->id}}">{{$departmentLead->first_name.' '.$departmentLead->last_name}}</option>--}}
{{--                                        @endif--}}
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Description </label>
                            <textarea class="form-control m-input" name="description" placeholder="Description">{{ old('description', $department->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Select Status </label>
                            <select class="form-control m-input " name="status">
                                <option value="1" {{ $department->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $department->status == 0  ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/department') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

