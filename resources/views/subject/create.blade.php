@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Subject</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/subject') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-address-book pr-2"></i>Subjects</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/subject') }}" method="post">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title') }}" placeholder="Subject Title"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('code') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject Code </label>
                            <input type="text" class="form-control m-input" name="code" value="{{ old('code') }}" placeholder="Subject Code"/>
                            @if ($errors->has('code'))
                                <div class="form-control-feedback">{{ $errors->first('code') }}</div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_group_id') ? 'has-danger' : ''}}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject Group </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="subject_group_id" data-live-search="true">
                                <option value=" ">---- Select Subject Group ----</option>
                                @foreach($subjectGroups as $subjectGroup)
                                    <option value="{{$subjectGroup->id}}" {{ old('subject_group_id') == $subjectGroup->id ? 'selected' : '' }}>{{$subjectGroup->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('subject_group_id'))
                                <div class="form-control-feedback">{{ $errors->first('subject_group_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Department </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="department_id" data-live-search="true">
                                <option value=" ">---- Select Department ----</option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}" {{ old('department_id') == $department->id ? 'selected' : ''}}>{{$department->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{--<div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="m-form__group form-group checkbox-width {{ $errors->has('examCategories') ? 'has-danger' : '' }}">
                            <label for=""><span class="text-danger">*</span> Exam Category</label>
                            <div class="m-checkbox-inline">
                                @foreach($examCategories as $examCategory)
                                <label class="m-checkbox">
                                    <input type="checkbox" name="examCategories[]" value="{{$examCategory->id}}" {{ (collect(old('examCategories'))->contains($examCategory->id)) ? 'checked':'' }}> {{$examCategory->title}}
                                    <span></span>
                                </label>
                                @endforeach
                            </div>
                            @if ($errors->has('examCategories'))
                                <div class="form-control-feedback">{{ $errors->first('examCategories') }}</div>
                            @endif
                        </div>
                    </div>
                </div>--}}

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="m-form__group form-group checkbox-width {{ $errors->has('examSubTypes') ? 'has-danger' : '' }}">
                            <label for=""><span class="text-danger">*</span> Exam Sub Types</label>
                            <div class="m-checkbox-inline">
                                @foreach($examSubTypes as $examSubType)
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="examSubTypes[]" value="{{$examSubType->id}}" {{ (collect(old('examSubTypes'))->contains($examSubType->id)) ? 'checked':'' }}> {{$examSubType->title}}
                                        <span></span>
                                    </label>
                                @endforeach
                            </div>
                            @if ($errors->has('examSubTypes'))
                                <div class="form-control-feedback">{{ $errors->first('examSubTypes') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/subject') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

