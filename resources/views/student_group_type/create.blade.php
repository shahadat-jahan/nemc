@extends('layouts.default')
@section('pageTitle', $pageTitle)
@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Add Student Group</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ route('student_group_type.index') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="fa fa-users pr-2"></i>Student Group Types</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"
              action="{{ route('student_group_type.store') }}" method="POST"
              id="nemc-general-form">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Group type title
                            </label>
                            <input type="text" class="form-control m-input" name="title"
                                   placeholder="Group Type Title"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('class_type_ids') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Class type</label>
                            <select class="form-control m_selectpicker"
                                    name="class_type_ids[]" multiple>
                                <option value="">---- Select class type ----</option>
                                {!! select($classTypes) !!}
                            </select>
                            @if ($errors->has('class_type_ids'))
                                <div class="form-control-feedback">{{ $errors->first('class_type_ids') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div
                            class="form-group  m-form__group {{ $errors->has('exam_category_ids') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Exam category</label>
                            <select class="form-control m_selectpicker" name="exam_category_ids[]" multiple>
                                <option value="">---- Select exam category ----</option>
                                {!! select($examCategories) !!}
                            </select>
                            @if ($errors->has('exam_category_ids'))
                                <div class="form-control-feedback">{{ $errors->first('exam_category_ids') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Description</label>
                            <textarea class="form-control m-input" name="description"
                                      placeholder="Description"></textarea>
                            @if ($errors->has('description'))
                                <div class="form-control-feedback">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ route('student_group_type.index') }}" class="btn btn-outline-brand"><i
                            class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
