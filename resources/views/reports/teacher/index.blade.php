@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .form-control-feedback{
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
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}</h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <form id="nemc-general-form" role="form" method="get">
                        <div class="row">
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
                                    <select class="form-control" name="department_id" id="department_id">
                                        <option value="">---- Select Department ----</option>
                                        {!! select($departments, app()->request->department_id) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <input type="text" class="form-control m-input" name="name" value="{{app()->request->name}}" placeholder="First name or Last name"/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <input type="text" class="form-control m-input" name="phone" value="{{app()->request->phone}}" placeholder="Phone"/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <input type="text" class="form-control m-input" name="email" value="{{app()->request->email}}" placeholder="Email"/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status">
                                        <option value="2">All</option>
                                        {!! select(getStatus(), app()->request->status ?? 2) !!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                <div class="pull-right search-action-btn">
                                    @if(isset($teachers) and $teachers->isNotEmpty() )
                                        <a target="_blank" href="{{route('teacher.list.pdf', [
                                    'course_id' => app()->request->course_id,
                                    'department_id' => app()->request->department_id,
                                    'name' => app()->request->name,
                                    'email' => app()->request->email,
                                    'phone' => app()->request->phone,
                                    'status' => app()->request->status,
                                ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-pdf"></i>
                                            PDF</a>
                                        <a target="_blank" href="{{route('teacher.list.export', [
                                    'course_id' => app()->request->course_id,
                                    'department_id' => app()->request->department_id,
                                    'name' => app()->request->name,
                                    'email' => app()->request->email,
                                    'phone' => app()->request->phone,
                                    'status' => app()->request->status,
                                ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-export"></i>
                                            Export</a>
                                    @endif
                                    <button class="btn btn-primary m-btn m-btn--icon search-result"><i class="fa fa-search"></i> Search</button>
                                    <a href="{{--{{route('student.list.report')}}--}}" type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</a>
                                </div>
                            </div>
                        </div>
                        </form>

                        @isset($teachers)
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-center">Teacher List</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th scope="col">Sl No.</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Full Name</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Designation</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Course</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($teachers as $key => $teacher)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>
                                                        @if($teacher->photo)
                                                            <img src="{{asset($teacher->photo)}}" class="card-img" alt="Teacher image" style="width: 40px;">
                                                        @else
                                                            <img src="{{$teacher->gender == 'male' ? asset('assets/global/img/male_avater.png') : asset('assets/global/img/female_avater.png')}}" class="card-img" alt="Teacher image" style="width: 40px;">
                                                        @endif
                                                    </td>

                                                    <td>{{$teacher->first_name}} {{$teacher->last_name}}</td>
                                                    <td>{{$teacher->department->title}}</td>
                                                    <td>{{$teacher->designation->title}}</td>
                                                    <td>{{!empty($teacher->phone)? $teacher->phone : '--'}}</td>
                                                    <td>{{!empty($teacher->email)? $teacher->email : '--'}}</td>
                                                    <td>{{$teacher->course->title}}</td>
                                                    <td>{{$teacher->status == 1 ? 'Active' : 'Inactive'}}</td>
                                                    <td><a href="{{route('teacher.single.report', $teacher->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a></td>
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
            rules:{
                course_id: {
                    required: true,
                },
                department_id: {
                    required: true,
                }
            },
            messages: {

                course_id: {
                    required: "Course field is require",
                },
                department_id: {
                    required: "Session field is require",
                },
            }
        });
    </script>
@endpush
