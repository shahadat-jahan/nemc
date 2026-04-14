@extends('layouts.default')

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Edit User Group</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('admin/user_groups') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-users pr-2"></i>User Group</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/user_groups/'.$userGroup->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('group_name') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Group Name </label>
                            <input type="text" class="form-control md-input" name="group_name" value="{{ old('group_name', $userGroup->group_name) }}" placeholder="Group Name" />
                            @if ($errors->has('group_name'))
                                <div class="form-control-feedback">{{ $errors->first('group_name') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('description') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Description </label>
                            <input type="text" class="form-control md-input" name="description" value="{{ old('description', $userGroup->description) }}" placeholder="Description" />
                            @if ($errors->has('description'))
                                <div class="form-control-feedback">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/user_groups') }}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection
