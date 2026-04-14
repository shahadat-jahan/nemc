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
                            </div>

                            <div class="row mb-3">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        @if(isset($parents) and $parents->isNotEmpty() )
                                            <div class="btn-group" data-hover="dropdown">
                                                <button type="button"
                                                        class="btn btn-primary m-btn m-btn--icon pdf-dropdown-btn"
                                                        data-toggle="dropdown" data-trigger="hover" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i class="fa fa-file-pdf"></i> PDF Download <i
                                                        class="pt-1 fa fa-angle-down angle-icon"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right w-100">
                                                    <a class="dropdown-item"
                                                       href="{{ route('parent.list.pdf', array_merge(request()->all(), ['page_layout' => 'A4-landscape'])) }}"
                                                       target="_blank">
                                                        <i class="fas fa-arrows-alt-h"></i> Landscape
                                                    </a>
                                                    <a class="dropdown-item"
                                                       href="{{ route('parent.list.pdf', array_merge(request()->all(), ['page_layout' => 'A4-portrait'])) }}"
                                                       target="_blank">
                                                        <i class="fas fa-arrows-alt-v"></i> Portrait
                                                    </a>
                                                </div>
                                            </div>
                                            <a target="_blank" href="{{route('report.parent.list.excel', [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'phase_id' => app()->request->phase_id,
                                        'student_category_id' => app()->request->student_category_id,
                                        ])}}" class="btn btn-primary m-btn m-btn--icon"><i
                                                    class="fa fa-file-export"></i>
                                                Export</a>
                                        @endif
                                        <button class="btn btn-primary m-btn m-btn--icon search-result"><i
                                                class="fa fa-search"></i> Search
                                        </button>
                                        <a href="{{route('parent.list.report')}}" type="reset"
                                           class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i>
                                            Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @isset($parents)
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-center">Parent List</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th scope="col" style="vertical-align: middle">User ID.</th>
                                                <th scope="col" style="vertical-align: middle">Student Name</th>
                                                <th scope="col" style="vertical-align: middle">Father Name</th>
                                                <th scope="col" style="vertical-align: middle">Mother Name</th>
                                                <th scope="col" style="vertical-align: middle">Father Phone & Email</th>
                                                <th scope="col" style="vertical-align: middle">Student Session</th>
                                                <th scope="col" style="vertical-align: middle">Student Course</th>
                                                <th scope="col" style="vertical-align: middle">Student Category</th>
                                                <th scope="col" style="vertical-align: middle">Student Phase</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($parents as $parent)
                                                <tr>
                                                    <td style="vertical-align: middle">{{$parent->user->user_id}}</td>
                                                    <td style="vertical-align: middle">
                                                        @php $count = $parent->students->count();@endphp
                                                        @foreach($parent->students as $student)
                                                            @if($student->followed_by_session_id ==  app()->request->session_id and $student->course_id ==  app()->request->course_id)
                                                                {{$student->full_name_en .'(Roll no-' .$student->roll_no. ')'}} {{$count > 1 ? ',' : ''}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td style="vertical-align: middle">{{$parent->father_name}}</td>
                                                    <td style="vertical-align: middle">{{$parent->mother_name}}</td>
                                                    <td style="vertical-align: middle">
                                                        {{$parent->father_phone}}
                                                        @if(!empty($parent->father_email))
                                                            <br>{{$parent->father_email}}
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle">{{$parent->students->where('followed_by_session_id', app()
                                                    ->request->session_id)->where('course_id', app()->request->course_id)->first()->session->title}}</td>
                                                    <td style="vertical-align: middle">{{$parent->students->where('followed_by_session_id', app()
                                                    ->request->session_id)->where('course_id', app()->request->course_id)->first()->course->title}}</td>
                                                    <td style="vertical-align: middle">{{$parent->students->where('followed_by_session_id', app()
                                                    ->request->session_id)->where('course_id', app()->request->course_id)->first()->studentCategory->title}}</td>
                                                    <td style="vertical-align: middle">{{$parent->students->where('followed_by_session_id', app()
                                                    ->request->session_id)->where('course_id', app()->request->course_id)->first()->phase->title}}</td>
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
        $('.btn-group[data-hover="dropdown"]').hover(
            function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(200);
            },
            function () {
                $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(200);
            }
        );

        $('.btn-group[data-hover="dropdown"]').hover(
            function () {
                $(this).find('.angle-icon').removeClass('fa-angle-down').addClass('fa-angle-up');
            },
            function () {
                $(this).find('.angle-icon').removeClass('fa-angle-up').addClass('fa-angle-down');
            }
        );

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
