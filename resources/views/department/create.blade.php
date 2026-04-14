@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Department</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/department') }}" class="btn btn-primary m-btn m-btn--icon"><i class="far fa-building pr-2"></i>Departments</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/department') }}" method="post">
            @csrf
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title') }}" placeholder="Department Title"/>
                                @if ($errors->has('title'))
                                    <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                                @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Department Head </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="department_lead_id" data-live-search="true">
                                <option value=" ">---- Select Department Head ----</option>
                                @isset($departmentLeads)
                                    @foreach($departmentLeads as $departmentLead)
                                        <option value="{{$departmentLead->id}}" {{ old('department_lead_id') == $departmentLead->id ? 'selected' : '' }}>{{$departmentLead->first_name.' '.$departmentLead->last_name}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Description </label>
                            <textarea class="form-control m-input" name="description" placeholder="Description">{{ old('description') }}</textarea>
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

