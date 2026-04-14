@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Static Routine</h3>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form" method="POST"
            action="{{ route('static_routine.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Session</label>
                            <select class="form-control m-input" name="session_id" id="session_id">
                                <option value="">---- Select Session ----</option>
                                {!! select($sessions, old('session_id')) !!}
                            </select>
                            @if ($errors->has('session_id'))
                                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('phase_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Phase
                            </label>
                            <select class="form-control m-input" name="phase_id" id="phase_id">
                                <option value="">---- Select Session ----</option>
                                {!! select($phases, old('phase_id')) !!}
                            </select>
                            @if ($errors->has('phase_id'))
                                <div class="form-control-feedback">{{ $errors->first('phase_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title') }}"
                                placeholder="Enter routine title">
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('description') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Description</label>
                            <textarea class="form-control m-input" name="description" rows="3" placeholder="Enter routine description">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <div class="form-control-feedback">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('routine_file') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Routine File</label>
                            <input type="file" class="form-control m-input" name="routine_file">
                            <span class="m-form__help">
                                Allowed file types: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Max: 1MB)
                            </span>
                            @if ($errors->has('routine_file'))
                                <div class="form-control-feedback">{{ $errors->first('routine_file') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ route('static_routine.index') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i>
                        Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
@endsection
