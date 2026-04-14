@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        .m-form.m-form--label-align-right .m-form__group > label {
            text-align: left;
        }
    </style>
@endpush

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Submit Attendance</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('class_routine.index') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="fa fa-clock pr-2"></i>Class Routine</a>
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="m-section__content">
                <div class="card">
                    <div class="card-header">
                        Class Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <!-- Lecture class -->
                                @if($classRoutine->class_type_id == 1 || $classRoutine->class_type_id == 9)
                                    <h4 class="text-center">Teacher and Topic</h4>
                                    <ul class="list-group list-group-horizontal-xl w-75 m-auto">
                                        @if($classRoutine->topic)
                                            <li class="list-group-item">Topic Title
                                                : {{$classRoutine->topic->title}}</li>
                                        @endif
                                        @if($classRoutine->teacher)
                                            <li class="list-group-item">Teacher Name
                                                : {{$classRoutine->teacher->full_name}}</li>
                                        @endif
                                    </ul>
                                    <!-- Practical class -->
                                @else
                                    @if(isset($classRoutine->studentGroupTeacher))
                                        <h4 class="text-center">Teacher and Student Group</h4>
                                        <ul class="list-group list-group-horizontal-xl w-75 m-auto">
                                            @foreach($classRoutine->studentGroupTeacher as $key => $teacher)
                                                <li class="list-group-item"><p>Teacher Name : {{$teacher->full_name}},
                                                        Group Name
                                                        : {{$classRoutine->studentGroup[$key]->group_name}}</p></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endif
                                <br>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Session :</div>
                                                <div class="col-md-8">
                                                    {{$classRoutine->session->title}}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Phase :</div>
                                                <div class="col-md-8">{{$classRoutine->phase->title}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Type :</div>
                                                <div class="col-md-8">{{$classRoutine->classType->title}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Date :</div>
                                                <div
                                                    class="col-md-8">{{date('d/m/Y', strtotime($classRoutine->class_date))}}</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Subject :</div>
                                                <div class="col-md-8">{{$classRoutine->subject->title}} ({{$courseName}}
                                                    )
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Day :</div>
                                                <div class="col-md-8">{{getDayName($classRoutine->class_date)}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Class Room :</div>
                                                <div
                                                    class="col-md-8">{{isset($classRoutine->hall) ? $classRoutine->hall->title : 'n/a'}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Time :</div>
                                                <div
                                                    class="col-md-8">{{parseClassTimeInTwelveHours($classRoutine->start_from).' - '.(parseClassTimeInTwelveHours($classRoutine->end_at))}}</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Students
                    </div>

                    <div class="card-body">
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right"
                              action="{{ route('attendance.store') }}" method="post" id="nemc-general-form">
                            @csrf
                            <input type="hidden" name="class_routine_id" value="{{$classRoutine->id}}">
                            <input type="hidden" name="mode" value="{{$mode}}">
                            <div class="m-portlet__body">
                                @php
                                    $user = Auth::guard('web')->user();
                                @endphp
                                <div class="m-radio-inline">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="m-radio">
                                                <input type="radio" id="all-present" name="all_status"
                                                       class="all-status" value="1" checked> All Present
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col-6">
                                            <label class="m-radio">
                                                <input type="radio" id="all-absent" name="all_status"
                                                       class="all-status" value="0"> All Absent
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m--hide comment-row">
                                    <div class="col-12">
                                        <div class="form-group  m-form__group">
                                                <textarea class="form-control m-input" name="comment" rows="3"
                                                          value="{{ old('comment') }}"
                                                          placeholder="Comment on all student absent"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                    <div class="row">
                                        @if(!empty($students))
                                            @foreach($students->sortBy('roll_no') as $student)
                                                <div class="col-6">
                                                    <div class="row">
                                                        <label class="col-10 col-form-label">{{$student->full_name_en}}
                                                            (Roll- {{$student->roll_no}})</label>
                                                        <div class="col-2">
                                                            <label class="m-checkbox"><input type="checkbox"
                                                                                             name="students[]"
                                                                                             class="students-id"
                                                                                             value="{{$student->id}}"
                                                                                             checked>
                                                                <span class="mt-2"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                                <?php unset($student) ?>
                                        @endif

                                        @if(!empty($oldStudents))
                                            @foreach($oldStudents->sortBy('roll_no') as $oldStudent)
                                                <div class="col-6">
                                                    <div class="row">
                                                        <label
                                                            class="col-10 col-form-label">{{$oldStudent->full_name_en}}
                                                            ({{ $oldStudent->session->title }}
                                                            )(Roll: {{ $oldStudent->roll_no }})</label>
                                                        <div class="col-2">
                                                            <label class="m-checkbox">
                                                                <input type="checkbox"
                                                                       class="students-id"
                                                                       name="old_students[]"
                                                                       value="{{$oldStudent->id}}"
                                                                       checked>
                                                                <span class="mt-2"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                                <?php unset($oldStudent) ?>
                                        @endif
                                    </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit" style="margin-left: 6px;">
                                <div class="m-form__actions text-center">
                                    <a href="{{ URL::previous() }}" class="btn btn-outline-brand"><i
                                            class="fa fa-times"></i> Cancel</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $('.all-status').change(function () {
            if ($(this).val() == 0) {
                $('.students-id').prop('checked', false);
                $('.comment-row').removeClass('m--hide');
                $('.comment-row').slideDown('slow');
            } else {
                /*$('.comment-row').fadeOut('slow', function () {
                    $(this).addClass('m--hide');
                });*/
                $('.students-id').prop('checked', true);
                $('.comment-row').addClass('m--hide');
                $('.comment-row').slideUp('slow');
            }
        });


        $('#nemc-general-form').validate({
            rules: {
                all_status: {
                    required: true,
                },
                comment: {
                    required: function (element) {
                        return ($('#all-absent').attr('checked') == true);
                    },
                },
            },
            messages: {}
        });
    </script>
@endpush
