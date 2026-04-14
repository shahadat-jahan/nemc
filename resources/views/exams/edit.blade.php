@extends('layouts.default')
@section('pageTitle', $pageTitle)
<?php
$totalRows = !empty(count($examInfo->examSubjects)) ? count($examInfo->examSubjects) : 0;
?>
@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>{{$pageTitle}}</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ route('exams.list') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="far fa-list-alt pr-2"></i>Exams</a>
            </div>
        </div>

        <div class="card mt-3 card-items exam-subjects col-12 p-0 m--hide" data-row="{{$totalRows}}">
            <div class="card-header">
                <span>Setup Individual Subject</span>
                <button type="button" class="btn btn-danger btn-sm remove-row pull-right"><i class="fa fa-times"
                                                                                             title="Remove"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div
                            class="form-group  m-form__group {{ $errors->has('subject_group_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject Group </label>
                            <select class="form-control m-input subject_group" name="subject_group_id[{{$totalRows}}]"
                                    id="subject_group_id">
                                <option value="">-- Subject Group --</option>
                                {!! select($subjectGroups) !!}
                            </select>
                            @if ($errors->has('subject_group_id'))
                                <div class="form-control-feedback">{{ $errors->first('subject_group_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group  m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject </label>
                            <select class="form-control m-input subject-list" name="subject_id[{{$totalRows}}]"
                                    id="subject_id">
                                <option value="">-- Subject --</option>
                            </select>
                            @if ($errors->has('subject_id'))
                                <div class="form-control-feedback">{{ $errors->first('subject_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 examType">
                        <div class="form-group  m-form__group {{ $errors->has('exam_type_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Type </label>
                            <select class="form-control m-input exam_types" name="exam_type_id[{{$totalRows}}]">
                                <option value="">-- Type --</option>
                                {!! select($examType) !!}
                            </select>
                            @if ($errors->has('exam_type_id'))
                                <div class="form-control-feedback">{{ $errors->first('exam_type_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 cardExam m--hide">
                        <div class="form-group  m-form__group {{ $errors->has('card_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Card </label>
                            <select class="form-control m-input cards" name="card_id[{{$totalRows}}]">
                                <option value="">-- Select Card --</option>
                            </select>
                            @if ($errors->has('card_id'))
                                <div class="form-control-feedback">{{ $errors->first('card_id') }}</div>
                            @endif
                        </div>
                    </div>
                    {{--                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">--}}
                    {{--                        <div class="form-group  m-form__group {{ $errors->has('exam_date') ? 'has-danger' : '' }}">--}}
                    {{--                            <label class="form-control-label"><span class="text-danger">*</span> Date </label>--}}
                    {{--                            <input type="text" class="form-control m-input exam_dates m_datepicker_11"--}}
                    {{--                                   name="exam_date[{{$totalRows}}]" placeholder="Date" autocomplete="off"/>--}}
                    {{--                            <span class="help-text text-warning"><small>Not required if you select to configure exam group</small></span>--}}
                    {{--                            @if ($errors->has('exam_date'))--}}
                    {{--                                <div class="form-control-feedback">{{ $errors->first('exam_date') }}</div>--}}
                    {{--                            @endif--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group  m-form__group {{ $errors->has('exam_time') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Time </label>
                            <input type="text" class="form-control m-input m_datetimepicker-2 exam_times"
                                   name="exam_time[{{$totalRows}}]" placeholder="Time" autocomplete="off" readonly required/>
                            <span class="help-text text-warning"><small>It will be used as a common time for exam groups.</small></span>
                            @if ($errors->has('exam_time'))
                                <div class="form-control-feedback">{{ $errors->first('exam_time') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 written-option m--hide mt-5">
                        <div class="m-checkbox-inline pl-2">
                            <label class="m-checkbox">
                                <input type="checkbox" name="written_option[{{$totalRows}}]" value="1"> Configure
                                Written Exam Group ?
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 practical-option m--hide mt-5">
                        <div class="m-checkbox-inline pl-2">
                            <label class="m-checkbox">
                                <input type="checkbox" name="practical_option[{{$totalRows}}]" value="1"> Configure
                                Practical Exam Group ?
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="written m--hide">
                    <div class="d-flex justify-content-center text-danger">Please configure at least one sub-type!</div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div
                                class="form-group  m-form__group {{ $errors->has('exam_sub_type') ? 'has-danger' : '' }}">
                                <label class="form-control-label">Exam Sub Type </label>
                                <select class="form-control m-input written_exam_sub_type"
                                        name="written_exam_sub_type[{{$totalRows}}][]">
                                    <option value="">--Exam Sub Type --</option>
                                </select>
                                @if ($errors->has('exam_sub_type'))
                                    <div class="form-control-feedback">{{ $errors->first('exam_sub_type') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group  m-form__group {{ $errors->has('exam_date') ? 'has-danger' : '' }}">
                                <label class="form-control-label"><span class="text-danger">*</span> Date </label>
                                <input type="text" class="form-control m-input m_datepicker_22 written_exam_date"
                                       name="written_exam_date[{{$totalRows}}][]" placeholder="Date"
                                       autocomplete="off"/>
                                @if ($errors->has('exam_date'))
                                    <div class="form-control-feedback">{{ $errors->first('exam_date') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="practical m--hide">
                    <div class="d-flex justify-content-center text-danger">Please configure at least one sub-type!</div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div
                                class="form-group  m-form__group {{ $errors->has('exam_sub_type') ? 'has-danger' : '' }}">
                                <label class="form-control-label">Exam Sub Type </label>
                                <select class="form-control m-input practical_exam_sub_type"
                                        name="practical_exam_sub_type[{{$totalRows}}][]">
                                    <option value="">--Exam Sub Type --</option>
                                </select>
                                @if ($errors->has('exam_sub_type'))
                                    <div class="form-control-feedback">{{ $errors->first('exam_sub_type') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div
                                class="form-group  m-form__group {{ $errors->has('student_groups') ? 'has-danger' : '' }}">
                                <label class="form-control-label"> Student Group </label>
                                <select class="form-control m-input student_groups"
                                        name="practical_student_groups[{{$totalRows}}][]">
                                    <option value="">-- Student Group --</option>
                                    @foreach($studentGroups as $studentGroup)
                                        <option value="{{$studentGroup->id}}">{{$studentGroup->group_name}}
                                            - {{$studentGroup->department->title ?? ''}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('student_groups'))
                                    <div class="form-control-feedback">{{ $errors->first('student_groups') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group  m-form__group {{ $errors->has('exam_date') ? 'has-danger' : '' }}">
                                <label class="form-control-label"><span class="text-danger">*</span> Date </label>
                                <input type="text" class="form-control m-input m_datepicker_22 practical_exam_date"
                                       name="practical_exam_date[{{$totalRows}}][]" placeholder="Date"
                                       autocomplete="off"/>
                                @if ($errors->has('exam_date'))
                                    <div class="form-control-feedback">{{ $errors->first('exam_date') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-separator m-separator--dashed m-separator--lg" style="width: 100%"></div>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('exams.update', [$examInfo->id]) }}"
              method="post" id="nemc-general-form">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Session </label>
                            <select class="form-control m-input" name="session_id" id="session_id">
                                <option value="">-- Select Session --</option>
                                {!! select($sessions, $examInfo->session_id) !!}
                            </select>
                            @if ($errors->has('session_id'))
                                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                            <select class="form-control m-input" name="course_id" id="course_id">
                                <option value="">-- Select Course --</option>
                                {!! select($courses, $examInfo->course_id) !!}
                            </select>
                            @if ($errors->has('course_id'))
                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('phase_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Phase </label>
                            <select class="form-control m-input" name="phase_id" id="phase_id">
                                <option value="">-- Select Phase --</option>
                                {!! select($phases, $examInfo->phase_id) !!}
                            </select>
                            @if ($errors->has('phase_id'))
                                <div class="form-control-feedback">{{ $errors->first('phase_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('term_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Term </label>
                            <select class="form-control m-input" name="term_id" id="term_id">
                                <option value="">---- Select Term ----</option>
                            </select>
                            @if ($errors->has('term_id'))
                                <div class="form-control-feedback">{{ $errors->first('term_id') }}</div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div
                            class="form-group  m-form__group {{ $errors->has('exam_category_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Exam Category </label>
                            <select class="form-control m-input" name="exam_category_id" id="exam_category_id">
                                <option value="">-- Select Exam --</option>
                                {!! select($examCategories, $examInfo->exam_category_id) !!}
                            </select>
                            @if ($errors->has('exam_category_id'))
                                <div class="form-control-feedback">{{ $errors->first('exam_category_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input " name="title" value="{{$examInfo->title}}"
                                   placeholder="Title"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Status</label>
                            <select class="form-control m-input" name="status">
                                <option value="0" {{$examInfo->status == 0 ? 'selected' : ''}}>Inactive</option>
                                <option value="1" {{$examInfo->status == 1 ? 'selected' : ''}}>Active</option>

                            </select>
                            @if ($errors->has('exam_category_id'))
                                <div class="form-control-feedback">{{ $errors->first('exam_category_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        <div class="row pl-4 pr-4 seperator-title">
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                <h4 class="m-form__heading-title" style="margin-left: -22px">Subjects</h4>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                <button type="button"
                                        class="btn btn-success btn-sm m-btn m-btn--icon add-subject pull-right"
                                        title="Add"><i class="fa fa-plus"></i> Add Subject
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row" id="all-subjects">
                    @if(!empty($examInfo->examSubjects->toArray()))
                            <?php $i = $totalRows ?>
                        @foreach($examInfo->examSubjects as $key => $examSubject)
                                <?php
                                $rowId = $i - 1;
                                $checkWrittenDate = $examSubject->examSubTypes->filter(function ($item) {
                                    return $item->pivot->student_group_id == '';
                                })->toArray();
                                $checkStudentGroup = $examSubject->studentGroups->toArray();

                                $hideClass = '';
                                if (Auth::guard('web')->check()) {
                                    $user = Auth::guard('web')->user();
                                    if ($user->teacher) {
                                        if (!in_array($examSubject->subject_id, getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id))) {
                                            $hideClass = 'm--hide';
                                        }
                                    }
                                }
                                ?>
                            <input type="hidden" name="exam_subject_id[{{$rowId}}]" value="{{$examSubject->id}}">
                            <div class="card mt-3 card-items exam-subjects col-12 p-0 {{$hideClass}}"
                                 data-row="{{$rowId}}">
                                <div class="card-header">
                                    <span>Setup Individual Subject</span>
                                    <button type="button" class="btn btn-danger btn-sm remove-row pull-right"><i
                                            class="fa fa-times" title="Remove"></i></button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <div
                                                class="form-group  m-form__group {{ $errors->has('subject_group_id') ? 'has-danger' : '' }}">
                                                <label class="form-control-label"><span class="text-danger">*</span>
                                                    Subject Group </label>
                                                <select class="form-control m-input subject_group"
                                                        name="subject_group_id[{{$rowId}}]" id="subject_group_id">
                                                    <option value="">-- Subject Group --</option>
                                                    {!! select($subjectGroups, $examSubject->subject_group_id) !!}
                                                </select>
                                                @if ($errors->has('subject_group_id'))
                                                    <div
                                                        class="form-control-feedback">{{ $errors->first('subject_group_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <div
                                                class="form-group  m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                                                <label class="form-control-label"><span class="text-danger">*</span>
                                                    Subject </label>
                                                <select class="form-control m-input subject-list"
                                                        name="subject_id[{{$rowId}}]" id="subject_id">
                                                    <option value="">-- Subject --</option>
                                                    @foreach($subjectLists[$examSubject->subject_group_id] as $subject)
                                                        <option
                                                            value="{{$subject->id}}" {{$examSubject->subject_id == $subject->id ? 'selected' : ''}}>{{$subject->title}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('subject_id'))
                                                    <div
                                                        class="form-control-feedback">{{ $errors->first('subject_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 examType">
                                            <div
                                                class="form-group  m-form__group {{ $errors->has('exam_type_id') ? 'has-danger' : '' }}">
                                                <label class="form-control-label"><span class="text-danger">*</span>Exam
                                                    Type </label>
                                                <select class="form-control m-input exam_types"
                                                        name="exam_type_id[{{$rowId}}]">
                                                    <option value="">--Exam Type --</option>
                                                    {!! select($examType, $examSubject->exam_type_id) !!}
                                                </select>
                                                @if ($errors->has('exam_type_id'))
                                                    <div
                                                        class="form-control-feedback">{{ $errors->first('exam_type_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div
                                            class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 cardExam {{empty($examSubject->card_id) ? 'm--hide' : ''}}">
                                            <div
                                                class="form-group  m-form__group {{ $errors->has('card_id') ? 'has-danger' : '' }}">
                                                <label class="form-control-label"><span class="text-danger">*</span>
                                                    Card </label>
                                                <select class="form-control m-input cards" name="card_id[{{$rowId}}]">
                                                    <option value="">-- Select Card --</option>
                                                    {!! select($cards, $examSubject->card_id) !!}
                                                </select>
                                                @if ($errors->has('card_id'))
                                                    <div
                                                        class="form-control-feedback">{{ $errors->first('card_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        {{--                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">--}}
                                        {{--                                            <div--}}
                                        {{--                                                class="form-group  m-form__group {{ $errors->has('exam_date') ? 'has-danger' : '' }}">--}}
                                        {{--                                                <label class="form-control-label"><span class="text-danger">*</span>--}}
                                        {{--                                                    Date </label>--}}
                                        {{--                                                <input type="text"--}}
                                        {{--                                                       class="form-control m-input exam_dates m_datepicker_1"--}}
                                        {{--                                                       name="exam_date[{{$rowId}}]"--}}
                                        {{--                                                       value="{{(empty($checkWrittenDate) && empty($checkStudentGroup)) ? $examSubject->exam_date : ''}}"--}}
                                        {{--                                                       placeholder="Date" autocomplete="off"/>--}}
                                        {{--                                                <span class="help-text text-warning"><small>Not required if you select to configure exam group</small></span>--}}
                                        {{--                                                @if ($errors->has('exam_date'))--}}
                                        {{--                                                    <div--}}
                                        {{--                                                        class="form-control-feedback">{{ $errors->first('exam_date') }}</div>--}}
                                        {{--                                                @endif--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                            <div
                                                class="form-group  m-form__group {{ $errors->has('exam_time') ? 'has-danger' : '' }}">
                                                <label class="form-control-label"><span class="text-danger">*</span>
                                                    Time </label>
                                                <input type="text"
                                                       class="form-control m-input m_datetimepicker exam_times"
                                                       name="exam_time[{{$rowId}}]"
                                                       value="{{!empty($examSubject->exam_time) ? $examSubject->exam_date. ' '.parseClassTime($examSubject->exam_time) : ''}}"
                                                       placeholder="Time" autocomplete="off" readonly required/>
                                                <span class="help-text text-warning"><small>It will be used as a common time for exam groups.</small></span>
                                                @if ($errors->has('exam_time'))
                                                    <div
                                                        class="form-control-feedback">{{ $errors->first('exam_time') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div
                                            class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 written-option {{in_array($examSubject->exam_type_id, [4,5,6]) ? 'm--hide' : ''}} mt-5">
                                            <div class="m-checkbox-inline pl-2">
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="written_option[{{$rowId}}]"
                                                           value="1" {{in_array($examSubject->exam_type_id, [1,3]) && !empty($examSubject->examSubTypes->toArray()) ? 'checked' : ''}}>
                                                    Configure Written Exam Group ?
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div
                                            class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 practical-option {{!in_array($examSubject->exam_type_id, [4,5,6]) ? 'm--hide' : ''}} mt-5">
                                            <div class="m-checkbox-inline pl-2">
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="practical_option[{{$rowId}}]"
                                                           value="1" {{in_array($examSubject->exam_type_id, [4,5,6]) ? 'checked' : ''}}>
                                                    Configure Practical Exam Group ?
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if($examSubject->exam_type_id == 1 || $examSubject->exam_type_id == 3)
                                        <div
                                            class="written {{in_array($examSubject->exam_type_id, [4,5,6]) ? 'm--hide' : ''}}">
                                            <div class="d-flex justify-content-center text-danger">Please configure at
                                                least one sub-type!
                                            </div>
                                            @foreach($examSubject->examSubTypes as $stKey => $rowType)
                                                    <?php
                                                    if (($rowType->pivot->exam_date != '') && ($rowType->pivot->exam_date != '0000-00-00')) {
                                                        $writtenExamDate = formatDate($rowType->pivot->exam_date, 'd/m/Y');
                                                    } else {
                                                        $writtenExamDate = null;
                                                    }
                                                    ?>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div
                                                            class="form-group  m-form__group {{ $errors->has('exam_sub_type') ? 'has-danger' : '' }}">
                                                            <label class="form-control-label">Exam Sub Type </label>
                                                            <select class="form-control m-input written_exam_sub_type"
                                                                    name="written_exam_sub_type[{{$rowId}}][{{$stKey}}]">
                                                                <option value="">--Exam Sub Type --</option>
                                                                @if(!empty($examSubject->examSubTypes->toArray()))
                                                                    @foreach($examSubject->examSubTypes as $type)
                                                                        <option
                                                                            value="{{$type->id}}" {{($rowType->pivot->exam_sub_type_id == $type->id) ? 'selected' : ''}}>{{$type->title}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @if ($errors->has('exam_sub_type'))
                                                                <div
                                                                    class="form-control-feedback">{{ $errors->first('exam_sub_type') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div
                                                            class="form-group  m-form__group {{ $errors->has('exam_date') ? 'has-danger' : '' }}">
                                                            <label class="form-control-label"><span class="text-danger">*</span>
                                                                Date </label>
                                                            <input type="text"
                                                                   class="form-control m-input m_datepicker_2 written_exam_date"
                                                                   name="written_exam_date[{{$rowId}}][{{$stKey}}]"
                                                                   value="{{$writtenExamDate}}" placeholder="Date"
                                                                   autocomplete="off"/>
                                                            @if ($errors->has('exam_date'))
                                                                <div
                                                                    class="form-control-feedback">{{ $errors->first('exam_date') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if(in_array($examSubject->exam_type_id,[4,5,6]))
                                        <div
                                            class="practical {{!in_array($examSubject->exam_type_id,[4,5,6]) ? 'm--hide' : ''}}">
                                            <div class="d-flex justify-content-center text-danger">Please configure at
                                                least one sub-type!
                                            </div>
                                            @foreach($examSubject->examSubTypes as $gKey => $rowGroup)
                                                    <?php
                                                    if (($rowGroup->pivot->exam_date != '') && ($rowGroup->pivot->exam_date != '0000-00-00')) {
                                                        $practicalExamDate = formatDate($rowGroup->pivot->exam_date, 'd/m/Y');
                                                    } else {
                                                        $practicalExamDate = null;
                                                    }
                                                    ?>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div
                                                            class="form-group  m-form__group {{ $errors->has('exam_sub_type') ? 'has-danger' : '' }}">
                                                            <label class="form-control-label">Exam Sub Type </label>
                                                            <select class="form-control m-input practical_exam_sub_type"
                                                                    name="practical_exam_sub_type[{{$rowId}}][{{$gKey}}]">
                                                                <option value="">--Exam Sub Type --</option>
                                                                @if(!empty($examSubject->examSubTypes->toArray()))
                                                                    @foreach($examSubject->examSubTypes->unique() as $type)
                                                                        <option
                                                                            value="{{$type->id}}" {{($rowGroup->pivot->exam_sub_type_id == $type->id) ? 'selected' : ''}}>{{$type->title}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @if ($errors->has('exam_sub_type'))
                                                                <div
                                                                    class="form-control-feedback">{{ $errors->first('exam_sub_type') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div
                                                            class="form-group  m-form__group {{ $errors->has('student_groups') ? 'has-danger' : '' }}">
                                                            <label class="form-control-label"> Student Group </label>
                                                            <select class="form-control m-input student_groups"
                                                                    name="practical_student_groups[{{$rowId}}][{{$gKey}}]">
                                                                <option value="">---- Student Group ----</option>
                                                                @foreach($studentGroups->where('department_id',$examSubject->subject->department_id) as $sGroup)
                                                                    <option
                                                                        value="{{$sGroup->id}}" {{$rowGroup->pivot->student_group_id == $sGroup->id ? 'selected' : ''}}>
                                                                        {{$sGroup->group_name}}{{isset($sGroup->department) ? ' - '.$sGroup->department->title : ''}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('student_groups'))
                                                                <div
                                                                    class="form-control-feedback">{{ $errors->first('student_groups') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div
                                                            class="form-group  m-form__group {{ $errors->has('exam_date') ? 'has-danger' : '' }}">
                                                            <label class="form-control-label"><span class="text-danger">*</span>
                                                                Date </label>
                                                            <input type="text"
                                                                   class="form-control m-input m_datepicker_2 practical_exam_date"
                                                                   name="practical_exam_date[{{$rowId}}][{{$gKey}}]"
                                                                   value="{{$practicalExamDate}}" placeholder="Date"
                                                                   autocomplete="off"/>
                                                            @if ($errors->has('exam_date'))
                                                                <div
                                                                    class="form-control-feedback">{{ $errors->first('exam_date') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    @endif
                                    <div class="m-separator m-separator--dashed m-separator--lg"
                                         style="width: 100%"></div>
                                </div>
                            </div>
                                <?php $i--; ?>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="m-form__actions text-center">
                <div class="m-form__actions">
                    <a href="{{ route('exams.list') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>

    <script>

        var studentGroups = '';
        var examId = '{{ $examInfo->id }}';
        var sessionId = '{{$examInfo->session_id}}';
        var courseId = '{{$examInfo->course_id}}';
        var phaseId = '{{$examInfo->phase_id}}';
        var termId = '{{$examInfo->term_id}}';
        var examCategoryId = '{{$examInfo->exam_category_id}}';
        var mainExamId = '{{$examInfo->main_exam_id}}';
        var phaseInfo = [];
        var total_terms = '';
        var selectedPhase = '';

        $('#course_id, #session_id').change(function () {
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            $.get('{{route('phase.term.list')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                if (response.data) {
                    phaseInfo = response.data;
                    console.log(phaseInfo);
                }
            })
        });

        $(".m_datepicker_1, .m_datepicker_2").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
        });

        $(".m_datetimepicker").datetimepicker({
            format: "hh:ii",
            showMeridian: !0,
            todayHighlight: !0,
            autoclose: !0,
            startView: 1,
            minView: 0,
            maxView: 1,
            forceParse: 0,
        });

        $('#all-subjects .exam_times').each(function () {
            splitTime = $(this).val().split(' ');
            $(this).val(splitTime[1]);
        })

        function checkExam() {
            var examExist = $('#all-subjects').find('.exam-exist').length;
            examExist > 0
                ? $('#saveButton').prop('disabled', true).css('cursor', 'not-allowed')
                : $('#saveButton').prop('disabled', false).css('cursor', 'pointer');
        }

        function checkdata() {
            return ($('#session_id').val() > 0) && ($('#course_id').val() > 0) && ($('#phase_id').val() > 0) && ($('#term_id').val() > 0) && ($('#exam_category_id').val() > 0);
        }

        $('#phase_id').change(function () {
            phaseId = $(this).val();
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();

            console.log(phaseInfo);

            selectedPhase = _.find(phaseInfo, function (o) {
                return o.phase.id == phaseId;
            });
            if (selectedPhase) {
                console.log(`x === undefined`)
                totalTerms = selectedPhase.total_terms;
            } else {
                console.log(`x !== undefined`)
                totalTerms = ''
            }
            $('#term_id').html('<option value="">---- Select ----</option>');
            for (var i = 1; i <= totalTerms; i++) {
                selected = (termId == i) ? 'selected' : '';
                $('#term_id').append('<option value="' + i + '" ' + selected + '> Term ' + i + '</option>')
            }

            // selectedBatchGroup = _.filter(studentGroups, function (o) {
            //     return (o.session_id == sessionId) && (o.course_id == courseId);
            // });
            // if (selectedBatchGroup.length > 0) {
            //     for (s in selectedBatchGroup) {
            //         $('.student_groups').append('<option value="' + selectedBatchGroup[s].id + '">' + selectedBatchGroup[s].group_name + '</option>')
            //     }
            // }


            // load subjects
            $.get('{{route('subjects.group.session.course.phase')}}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId
            }, function (response) {
                if (response.data) {
                    $('#subject_group_id').html('<option value="">---- Select ----</option>');
                    for (i in response.data) {
                        subjectGroup = response.data[i];
                        $('#subject_group_id').append('<option value="' + subjectGroup.id + '">' + subjectGroup.title + '</option>')
                    }

                }
            })
        });


        $('#exam_category_id').change(function () {
            if ($(this).val() == 2) {
                $('.cardExam').removeClass('m--hide')
                // $('.examType').addClass('m--hide')
            } else {
                // $('.examType').removeClass('m--hide')
                $('.cardExam').addClass('m--hide')
            }
        });

        if (sessionId > 0 && courseId > 0) {
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get('{{route('phase.term.list')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                if (response.data) {
                    $('#phase_id').html('<option value="">---- Select ----</option>');
                    phaseInfo = response.data;
                    for (i in phaseInfo) {
                        phaseSelected = (phaseId == phaseInfo[i].phase.id) ? 'selected' : '';
                        $('#phase_id').append('<option value="' + phaseInfo[i].phase.id + '" ' + phaseSelected + '>' + phaseInfo[i].phase.title + '</option>')
                    }

                    phaseId = $('#phase_id').val();
                    courseId = $('#course_id').val();
                    sessionId = $('#session_id').val();

                    selectedPhase = _.find(phaseInfo, function (o) {
                        return o.phase.id == phaseId;
                    });
                    $('#term_id').html('<option value="">---- Select ----</option>');
                    for (var i = 1; i <= selectedPhase.total_terms; i++) {
                        selected = (termId == i) ? 'selected' : '';
                        $('#term_id').append('<option value="' + i + '" ' + selected + '> Term ' + i + '</option>')
                    }
                }
                mApp.unblockPage()
            });
        }

        $('.subject_group').change(function () {
            current = $(this);
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            // load subjects
            $.get('{{route('subjects.group')}}', {
                sessionId: sessionId,
                courseId: courseId,
                subjectGroupId: $(this).val()
            }, function (response) {
                if (response.data) {
                    row = current.parents('.exam-subjects').find('.subject-list');
                    row.html('<option value="">---- Select ----</option>');
                    for (i in response.data) {
                        subject = response.data[i];
                        row.append('<option value="' + subject.id + '">' + subject.title + '</option>')
                    }
                }
                mApp.unblockPage()
            })
        });

        //load card by subject id
        $('.subject-list').change(function () {
            current = $(this);
            if ($('#exam_category_id').val() == 2) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                // load subjects
                $.get(baseUrl + 'admin/cards/subjects/' + current.val(), {}, function (response) {
                    if (response.data) {
                        row = current.parents('.exam-subjects').find('.cards');
                        row.html('<option value="">---- Select ----</option>');
                        for (i in response.data) {
                            subject = response.data[i];
                            row.append('<option value="' + subject.id + '">' + subject.title + '</option>')
                        }
                    }
                })
            }
            examType.trigger('change');
                    mApp.unblockPage()
        });

        $('.exam_types').change(function () {
            current = $(this);
            subjectId = current.parents('.exam-subjects').find('.subject-list').val();
            rowId = current.parents('.exam-subjects').attr('data-row');
            categoryId = $('#exam_category_id').val();

            // applicable for Term, Prof exam category
            if (['3', '7'].includes(categoryId)) {
                // Check exam
                $.get('{{route('check.exam.exist')}}', {
                    sessionId: sessionId,
                    courseId: courseId,
                    phaseId: phaseId,
                    termId: termId,
                    categoryId: categoryId,
                    subjectId: subjectId,
                    examTypeId: current.val(),
                }, function (response) {
                    const label = current.parent().find('.form-control-label');
                    label.html('<span class="text-danger">* </span> Exam Type');

                    if (current.parents('.exam-subjects').hasClass('exam-exist')) {
                        current.parents('.exam-subjects').removeClass('exam-exist');
                        checkExam();
                    }

                    if (response.data) {
                        label.html('<span class="text-danger">* Exam already exists for this type.</span>');
                        current.parents('.exam-subjects').addClass('exam-exist');
                        checkExam();
                    }
                });
            }
            $.get('{{route('studentGroup.by.subject')}}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId,
                categoryId: categoryId,
                subjectId: subjectId
            }, function (response) {
                var department = "";
                if (response) {
                    studentGroups = response;
                    $('.student_groups').html('<option value="">---- Student Group ----</option>');
                    for (i in studentGroups) {
                        studentGroup = studentGroups[i];
                        if (studentGroup.department_id) {
                            department = ' - ' + studentGroup.department.title;
                        }
                        $('.student_groups').append('<option value="' + studentGroup.id + '">' + studentGroup.group_name + department + '</option>')
                    }
                }
            });

            if ($(this).val() == 1 || $(this).val() == 3) {
                current.parents('.exam-subjects').find('.practical-option').addClass('m--hide');
                current.parents('.exam-subjects').find('.practical-option').find('input:checkbox').prop("checked", false);
                current.parents('.exam-subjects').find('.written-option').removeClass('m--hide');
                current.parents('.exam-subjects').find('.practical').addClass('m--hide');
                current.parents('.exam-subjects').find('.practical').find(".row:gt(0)").remove();
            } else if ($(this).val() == 4 || $(this).val() == 5 || $(this).val() == 6) {
                current.parents('.exam-subjects').find('.written-option').addClass('m--hide');
                current.parents('.exam-subjects').find('.written-option').find('input:checkbox').prop("checked", false);
                current.parents('.exam-subjects').find('.practical-option').removeClass('m--hide');
                current.parents('.exam-subjects').find('.written').addClass('m--hide');
                current.parents('.exam-subjects').find('.written').find(".row:gt(0)").remove();
            } else {
                current.parents('.exam-subjects').find('.written-option').addClass('m--hide');
                current.parents('.exam-subjects').find('.practical-option').addClass('m--hide');
                current.parents('.exam-subjects').find('.written').find(".row:gt(0)").remove();
                current.parents('.exam-subjects').find('.practical').find(".row:gt(0)").remove();
                current.parents('.exam-subjects').find('.practical-option').find('input:checkbox').prop("checked", false);
                current.parents('.exam-subjects').find('.written-option').find('input:checkbox').prop("checked", false);
            }

            if ($(this).val() == 1 || $(this).val() == 3 || $(this).val() == 4 || $(this).val() == 5 || $(this).val() == 6) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('exams.sub-types-list.subject')}}', {
                    subjectId: subjectId,
                    examTypeId: $(this).val()
                }, function (response) {
                    if (response.data) {
                        if (current.val() == 1 || current.val() == 3) {
                            row = current.parents('.exam-subjects').find('.written_exam_sub_type');
                        } else {
                            row = current.parents('.exam-subjects').find('.practical_exam_sub_type');
                        }

                        row.html('<option value="">---- Select ----</option>');
                        for (i in response.data) {
                            subType = response.data[i];
                            row.append('<option value="' + subType.id + '">' + subType.title + '</option>')
                        }

                        x = 1;

                        if (current.val() == 1 || current.val() == 3) {
                            if (response.data.length > 1) {
                                for (var j = 1; j < response.data.length; j++) {
                                    copySubType = current.parents('.exam-subjects').find('.written .row:first');
                                    copySubTypeRow = copySubType.clone(true);
                                    copySubTypeRow.find('.written_exam_sub_type').attr('name', 'written_exam_sub_type[' + rowId + '][' + j + ']');
                                    copySubTypeRow.find('.written_exam_date').attr('name', 'written_exam_date[' + rowId + '][' + j + ']');
                                    current.parents('.exam-subjects').find('.written').append(copySubTypeRow);
                                }
                            }
                        } else {
                            // selectedBatchGroup = _.filter(studentGroups, function (o) {
                            //     return (o.session_id == sessionId) && (o.course_id == courseId) && (o.phase_id == phaseId);
                            // });
                            totalBatch = studentGroups.length;
                            console.log(totalBatch)
                            if (response.data.length == 0) {
                                totalBatch = totalBatch - 1;
                            }
                            for (var k = 1; k <= totalBatch; k++) {
                                // for (var k = 1; k <= (totalBatch + 2); k++) {
                                copyNewSubType = current.parents('.exam-subjects').find('.practical .row:first');
                                copyNewSubTypeRow = copyNewSubType.clone(true);
                                copyNewSubTypeRow.find('.practical_exam_sub_type').attr('name', 'practical_exam_sub_type[' + rowId + '][' + x + ']');
                                copyNewSubTypeRow.find('.student_groups').attr('name', 'practical_student_groups[' + rowId + '][' + x + ']');
                                copyNewSubTypeRow.find('.practical_exam_date').attr('name', 'practical_exam_date[' + rowId + '][' + x + ']');
                                current.parents('.exam-subjects').find('.practical').append(copyNewSubTypeRow);
                                x++;
                            }

                            if (response.data.length > 1) {
                                for (var j = 1; j < response.data.length; j++) {
                                    copySubType = current.parents('.exam-subjects').find('.practical .row:first');
                                    copySubTypeRow = copySubType.clone(true);
                                    copySubTypeRow.find('.practical_exam_sub_type').attr('name', 'practical_exam_sub_type[' + rowId + '][' + x + ']');
                                    copySubTypeRow.find('.student_groups').attr('name', 'practical_student_groups[' + rowId + '][' + x + ']');
                                    copySubTypeRow.find('.practical_exam_date').attr('name', 'practical_exam_date[' + rowId + '][' + x + ']');
                                    current.parents('.exam-subjects').find('.practical').append(copySubTypeRow);
                                    x++;
                                }
                            }
                        }
                        /*if(response.data.length > 1){
                            for(var j= 1; j<response.data.length; j++){
                                if (current.val() == 3){
                                    copySubType = current.parents('.exam-subjects').find('.written .row:first');
                                    copySubTypeRow = copySubType.clone(true);
                                    copySubTypeRow.find('.written_exam_sub_type').attr('name', 'writtten_exam_sub_type['+j+'][]');
                                    copySubTypeRow.find('.m_datepicker_2').attr('name', 'written_exam_date['+j+'][]');
                                    current.parents('.exam-subjects').find('.written').append(copySubTypeRow);

                                }else{
                                    selectedBatchGroup = _.filter(studentGroups, function(o) { return (o.session_id == sessionId) && (o.course_id == courseId); });
                                    for (k in selectedBatchGroup){
                                        copyNewSubType = current.parents('.exam-subjects').find('.practical .row:first');
                                        copyNewSubTypeRow = copyNewSubType.clone(true);
                                        copyNewSubTypeRow.find('.practical_exam_sub_type').attr('name', 'practical_exam_sub_type['+x+'][]');
                                        copyNewSubTypeRow.find('.student_groups').attr('name', 'practical_student_groups['+x+'][]');
                                        copyNewSubTypeRow.find('.m_datepicker_2').attr('name', 'practical_exam_date['+x+'][]');
                                        current.parents('.exam-subjects').find('.practical').append(copyNewSubTypeRow);
                                        x++;
                                    }

                                    copySubType = current.parents('.exam-subjects').find('.practical .row:first');
                                    copySubTypeRow = copySubType.clone(true);
                                    copySubTypeRow.find('.practical_exam_sub_type').attr('name', 'practical_exam_sub_type['+x+'][]');
                                    copySubTypeRow.find('.student_groups').attr('name', 'practical_student_groups['+x+'][]');
                                    copySubTypeRow.find('.m_datepicker_2').attr('name', 'practical_exam_date['+x+'][]');
                                    current.parents('.exam-subjects').find('.practical').append(copySubTypeRow);
                                    x++;
                                }
                            }
                        }*/

                        current.parents('.exam-subjects').find(".m_datepicker_22").datepicker({
                            todayHighlight: !0,
                            orientation: "bottom left",
                            format: 'dd/mm/yyyy',
                            autoClose: true,
                        });
                        console.log('date 2')
                    }
                    mApp.unblockPage()
                });

                mApp.unblockPage()
            }

            // _.filter(examSubTypes, function(o) { return o.exam_type_id == $(this).val(); });


        });

        $('.written-option input:checkbox').click(function () {
            $(this).parents('.exam-subjects').find('.written').toggleClass('m--hide');
        });

        $('.practical-option input:checkbox').click(function () {
            $(this).parents('.exam-subjects').find('.practical').toggleClass('m--hide');
        })

        // code for add
        $('.add-subject').on('click', function () {
            if (checkdata() != true) {
                sweetAlert('Select Session, Course, Phase, Term & Exam category first', 'error');
                return false;
            }
            rowSize = $('.card-items').attr('data-row');
            examSubjects = $('.exam-subjects:first');
            examSubjectRow = examSubjects.clone(true);
            examSubjectRow.removeClass('card-items');

            examSubjectRow.find('.subject_group').attr('name', 'subject_group_id[' + rowSize + ']');
            examSubjectRow.find('.subject-list').attr('name', 'subject_id[' + rowSize + ']');
            examSubjectRow.find('.exam_types').attr('name', 'exam_type_id[' + rowSize + ']');
            examSubjectRow.find('.cards').attr('name', 'card_id[' + rowSize + ']');
            examSubjectRow.find('.exam_dates').attr('name', 'exam_date[' + rowSize + ']');
            examSubjectRow.find('.exam_times').attr('name', 'exam_time[' + rowSize + ']');

            examSubjectRow.find('.written-option').find('input:checkbox').attr('name', 'written_option[' + rowSize + ']');
            examSubjectRow.find('.practical-option').find('input:checkbox').attr('name', 'practical_option[' + rowSize + ']')

            examSubjectRow.find('.written_exam_sub_type').attr('name', 'written_exam_sub_type[' + rowSize + '][0]');
            examSubjectRow.find('.written_exam_date').attr('name', 'written_exam_date[' + rowSize + '][0]');
            examSubjectRow.find('.practical_exam_sub_type').attr('name', 'practical_exam_sub_type[' + rowSize + '][0]');
            examSubjectRow.find('.student_groups').attr('name', 'practical_student_groups[' + rowSize + '][0]');
            examSubjectRow.find('.practical_exam_date').attr('name', 'practical_exam_date[' + rowSize + '][0]');


            /*examSubjectRow.find('.practical_exam_sub_type').attr('name', 'practical_exam_sub_type['+x+'][]');
            copyNewSubTypeRow.find('.student_groups').attr('name', 'practical_student_groups['+x+'][]');
            copyNewSubTypeRow.find('.practical_exam_sub_type').attr('name', 'practical_exam_sub_type['+x+'][]');
            copyNewSubTypeRow.find('.student_groups').attr('name', 'practical_student_groups['+x+'][]');
            copyNewSubTypeRow.find('.m_datepicker_2').attr('name', 'practical_exam_date['+x+'][]');*/


            // examSubjectRow.find('.exam-subjects').attr('name', 'mbbs_phase_subjects['+i+'][]');
            // examSubjectRow.find('.exam-subjects').addClass('m-bootstrap-select').addClass('m_selectpicker');
            // examSubjectRow.find('.exam-subjects').attr('data-live-search', true);
            // $('#all-subjects').append(examSubjectRow.removeClass('m--hide'));
            $('#all-subjects').prepend(examSubjectRow.removeClass('m--hide'));


            // $(".m_selectpicker").selectpicker();

            examSubjectRow.find(".m_datepicker_11").datepicker({
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
                autoClose: true,
            });

            console.log('date 1')

            examSubjectRow.find(".m_datetimepicker-2").datetimepicker({
                format: "hh:ii",
                showMeridian: !0,
                todayHighlight: !0,
                autoclose: !0,
                startView: 1,
                minView: 0,
                maxView: 1,
                forceParse: 0,
            });
            console.log('time 1')

            $('.card-items').attr('data-row', (parseInt(rowSize) + 1));
        });

        // code for remove
        $('.remove-row').on('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to remove this",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    current = $(this);
                    $(this).parents('.exam-subjects').remove();
                    checkExam();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    return false;
                }
            });
        });


        /*$.validator.addMethod("item_title", function (value, element) {
            var flag = true;
            $(".item-title").each(function (i, j) {
                if ($.trim($(this).val()) == '') {
                    flag = false;
                    $(this).parents('.form-group').addClass('has-danger');
                }else{
                    $(this).parents('.form-group').removeClass('has-danger');
                }
            });
            return flag;

        }, "");*/

        $('#nemc-general-form').validate({
            rules: {
                session_id: {
                    required: true,
                    min: 1
                },
                course_id: {
                    required: true,
                    min: 1
                },
                phase_id: {
                    required: true,
                    min: 1
                },
                term_id: {
                    required: true,
                    min: 1
                },
                exam_category_id: {
                    required: true,
                    min: 1
                },
                title: {
                    required: true,
                },
                'exam_date[]': {
                    required: true,
                },
                'exam_time[]': {
                    required: true,
                }
            },
            errorPlacement: function (error, element) {
                if (element.hasClass('m-bootstrap-select')) {
                    error.insertAfter('.m-bootstrap-select.m_');
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    </script>
@endpush
