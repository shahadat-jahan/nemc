@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        .pl0 {
            padding-left: 0;
        }
        .plr0{
            padding-left: 0;
            padding-right: 0;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Teacher Details</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{url()->previous()}}" class="btn btn-primary m-btn m-btn--icon mr-2" title="Applicants"><i class="fa fa-undo-alt"></i> Back</a>
                        <a target="_blank" href="{{route('teacher.single.print', $teacher->id)}}" class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fas fa-print"></i> Print</a>
                    </div>
                </div>

                <div class="m-portlet__body" style="padding: 1.2rem 1.3rem !important;">

                    <div class="row">
                       <div class="col-md-12">
                           <div class="row pt-4 pl-2 pr-2">
                               <div class="col-md-12">
                                   <div class="table-responsive">
                                       <table class="table table-bordered">
                                           <thead>
                                           <tr>
                                               <th scope="col">Image</th>
                                               <th scope="col">First Name</th>
                                               <th scope="col">Last Name</th>
                                               <th scope="col">birth Date</th>
                                               <th scope="col">Department</th>
                                               <th scope="col">Designation</th>
                                               <th scope="col">Phone</th>
                                               <th scope="col">Email</th>
                                               <th scope="col">Course</th>
                                               <th scope="col">Status</th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                               <tr>
                                                   <td>
                                                       @if($teacher->photo)
                                                           <img src="{{asset($teacher->photo)}}" class="card-img" alt="Teacher image" style="width: 40%;">
                                                       @else
                                                           <img src="{{asset('assets/global/img/male_avater.png')}}" class="card-img" alt="Teacher image" style="width: 40%;">
                                                       @endif
                                                   </td>
                                                   <td>{{$teacher->first_name}}</td>
                                                   <td>{{$teacher->last_name}}</td>
                                                   <td>{{$teacher->dob}}</td>
                                                   <td>{{$teacher->department->title}}</td>
                                                   <td>{{$teacher->designation->title}}</td>
                                                   <td>{{!empty($teacher->phone)? $teacher->phone : '--'}}</td>
                                                   <td>{{!empty($teacher->email)? $teacher->email : '--'}}</td>
                                                   <td>{{$teacher->course->title}}</td>
                                                   <td> @if($teacher->status == 1) Active @else Inactive @endif</td>
                                               </tr>
                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
