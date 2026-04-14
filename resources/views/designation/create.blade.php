@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Designation</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                @if (hasPermission('designation/create'))
                    <a href="{{ url('admin/designation') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-users pr-2"></i>Designations</a>
                @endif
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/designation') }}" method="post">
            @csrf
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title') }}" placeholder="Designation Title"/>
                                @if ($errors->has('title'))
                                    <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                                @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('org_order') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Organization Order </label>
                            <input type="text" class="form-control m-input" name="org_order" value="{{ old('org_order') }}" placeholder="Organization Order"/>
                                @if ($errors->has('org_order'))
                                    <div class="form-control-feedback">{{ $errors->first('org_order') }}</div>
                                @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Description </label>
                            <input type="text" class="form-control m-input" name="description" value="{{ old('description') }}" placeholder="Description"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/designation') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

