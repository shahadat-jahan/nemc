@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .form-control-feedback {
            color: #f4516c;
        }
    </style>

@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <form id="nemc-general-form" role="form" method="get">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="student_category_id">
                                            <option value="">---- Select Student Category ----</option>
                                            {!! select($studentCategories, app()->request->student_category_id) !!}

                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="roll_no"
                                               value="{{app()->request->roll_no}}" placeholder="Roll No"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="email"
                                               value="{{app()->request->email}}" placeholder="Email"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="phone"
                                               value="{{app()->request->phone}}" placeholder="Phone"/>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="roll_no" value="{{app()->request->roll_no}}" placeholder="Roll No"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="email" value="{{app()->request->email}}" placeholder="Email"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="phone" value="{{app()->request->phone}}" placeholder="Phone"/>
                                    </div>
                                </div>
                            </div>--}}

                            <div class="row mb-3">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        @if(isset($students) and $students->isNotEmpty() )
                                            <a target="_blank" href="{{route('student.list.print', [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'phase_id' => app()->request->phase_id,
                                        'student_category_id' => app()->request->student_category_id,
                                        'roll_no' => app()->request->roll_no,
                                        'email' => app()->request->email,
                                        'phone' => app()->request->phone,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-print"></i>
                                                Print</a>

                                            <a target="_blank" href="{{route('report.student.list.excel', [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'phase_id' => app()->request->phase_id,
                                        'student_category_id' => app()->request->student_category_id,
                                        'roll_no' => app()->request->roll_no,
                                        'email' => app()->request->email,
                                        'phone' => app()->request->phone,
                                        ])}}" class="btn btn-primary m-btn m-btn--icon"><i
                                                    class="fa fa-file-export"></i> Export</a>
                                        @endif
                                        <button class="btn btn-primary m-btn m-btn--icon search-result"><i
                                                class="fa fa-search"></i> Search
                                        </button>
                                        <a href="{{route('student.list.report')}}" type="reset"
                                           class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i>
                                            Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @isset($students)
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-center">Student List</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th scope="col">Roll No.</th>
                                                <th scope="col">User Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Session</th>
                                                <th scope="col">Course</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Phase</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($students as $student)
                                                <tr>
                                                    <td>{{$student->roll_no}}</td>
                                                    <td>{{$student->user->user_id}}</td>
                                                    <td>{{$student->full_name_en}}</td>
                                                    <td>{{!empty($student->mobile) ? $student->mobile : "--"}}</td>
                                                    <td>{{!empty($student->email) ? $student->email : "--"}}</td>
                                                    <td>{{$student->session->title}}</td>
                                                    <td>{{$student->course->title}}</td>
                                                    <td>{{$student->studentCategory->title}}</td>
                                                    <td>{{$student->phase->title}}</td>
                                                    <td>{{$studentStatus[$student->status]}}</td>
                                                    <td><a href="{{route('student.single.report', $student->id)}}"
                                                           class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                           title="View"><i class="flaticon-eye"></i></a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endisset

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        //form validation
        $('#nemc-general-form').validate({
            rules: {
                session_id: {
                    required: true,
                    min: 1
                },
                course_id: {
                    required: true,
                    min: 1
                }
            },

            messages: {
                session_id: {
                    required: "Session field is require",
                },
                course_id: {
                    required: "Course field is require",
                },
            }
        });
    </script>
@endpush
