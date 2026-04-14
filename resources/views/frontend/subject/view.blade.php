@extends('frontend.layouts.default')
@section('pageTitle', 'Designation')

@push('style')
    <style>
        .form-control[disabled] {
            border-color: #f4f5f8 !important;
            color: #6f727d;
            background-color: #f4f5f8 !important;
        }
        .m-checkbox>input:disabled ~ span {
            opacity: 1 !important;
            filter: alpha(opacity=60);
        }
        .m-checkbox>input:checked ~ span {
            border: 1px solid #bdc3d4;
            background: #f4f5f8 !important;
        }
        select.form-control {
            -moz-appearance: none !important;
            -webkit-appearance: none !important;
            appearance: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-lg fa-info-circle pr-2"></i>Subject Details</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                {{--<a href="{{ url('admin/subject') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-address-book pr-2"></i>Subjects</a>--}}
                <a href="{{ route('frontend.subject.index') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-address-book pr-2"></i>Subjects</a>
            </div>
        </div>

        <!--begin::Form-->
        <div class="m-form m-form--fit m-form--label-align-right">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title', $subject->title) }}" placeholder="Subject Title" disabled/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('code') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> Code </label>
                            <input type="text" class="form-control m-input" name="code" value="{{ old('code', $subject->code) }}" placeholder="Subject Code" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_group_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> Subject Group </label>
                            <select class="form-control m-input" name="subject_group_id" disabled>
                                <option value=" ">---- Select Subject Group ----</option>
                                @foreach($subjectGroups as $subjectGroup)
                                    <option value="{{$subjectGroup->id}}" {{$subjectGroup->id == $subject->subject_group_id ? 'selected' : ' '}}>{{$subjectGroup->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"> Department </label>
                            <select class="form-control m-input" name="department_id" disabled>
                                <option value=" ">---- Select Department ----</option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}" {{$department->id == $subject->department_id ? 'selected' : ' '}}>{{$department->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @if(!empty($subject->examCategories))
                    @php
                        $subjectExamCategory = $subject->examCategories->map(function ($category){
                            return $category->id;
                        });
                    @endphp

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="m-form__group form-group checkbox-width {{ $errors->has('examCategories') ? 'has-danger' : '' }}">
                                <label for=""> Exam Category</label>
                                <div class="m-checkbox-inline">
                                    @foreach($examCategories as $examCategory)
                                        <label class="m-checkbox">
                                            {{--<input type="checkbox" name="examCategories[]" value="{{$examCategory->id}}"> {{$examCategory->title}}--}}
                                            <input type="checkbox" name="examCategories[]" value="{{$examCategory->id}}" {{in_array($examCategory->id, $subjectExamCategory->toArray()) ? 'checked' : ''}} disabled> {{$examCategory->title}}
                                            <span></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif    

                @if(!empty($subject->examSubTypes))
                    @php
                        $subjectSubExamType = $subject->examSubTypes->map(function ($SubType){
                            return $SubType->id;
                        });
                    @endphp

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="m-form__group form-group checkbox-width {{ $errors->has('examSubTypes') ? 'has-danger' : '' }}">
                                <label for=""> Exam Sub Types</label>
                                <div class="m-checkbox-inline">
                                    @foreach($examSubTypes as $examSubType)
                                        <label class="m-checkbox">
                                            {{--<input type="checkbox" name="examSubTypes[]" value="{{$examSubType->id}}"> {{$examSubType->title}}--}}
                                            <input type="checkbox" name="examSubTypes[]" value="{{$examSubType->id}}" {{in_array($examSubType->id, $subjectSubExamType->toArray()) ? 'checked' : ''}} disabled> {{$examSubType->title}}
                                            <span></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif    

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('status') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Select Status </label>
                            <select class="form-control m-input " name="status" disabled>
                                <option value="1" {{ $subject->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $subject->status == 0  ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--end::Form-->
    </div>
@endsection

