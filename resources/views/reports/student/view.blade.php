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
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Student's Detail: {{$student->full_name_en}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{url()->previous()}}" class="btn btn-primary m-btn m-btn--icon mr-2" title="Applicants"><i class="fa fa-undo-alt"></i> Back</a>
                        <a target="_blank" href="{{route('student.single.print', $student->id)}}" class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fas fa-print"></i> Print</a>
                    </div>
                </div>

                <div class="m-portlet__body" style="padding: 1.2rem 1.3rem !important;">

                    <div class="row">
                       <div class="col-md-12">
                           <div class="row pt-4 pl-2 pr-2">
                               <div class="col-md-12">
                                   <div class="m-list-search__result-category mb-2"><h5 class="text-center pb-2">Personal Information</h5></div>
                               </div>
                               <div class="col-md-12">
                                   <div class="table-responsive">
                                       <table class="table table-bordered">
                                           <thead>
                                           <tr>
                                               <th>Image</th>
                                               <th>Name</th>
                                               <th>Email</th>
                                               <th>Session</th>
                                               <th>Course</th>
                                               <th>Gender</th>
                                               <th>Date of Birth</th>
                                               <th>Birth Place</th>
                                               <th>Available Credit(tuition)</th>
                                               <th>Available Credit(development)</th>
                                               <th>Status</th>
                                           </tr>
                                           </thead>
                                           <tr>
                                               <td>
                                                   @if($student->photo)
                                                       <img class="img-fluid" src="{{asset($student->photo)}}" alt="Applicant image">
                                                   @else
                                                       <img class="img-fluid" src="{{asset('assets/global/img/male_avater.png')}}" alt="Applicant image">
                                                   @endif
                                               </td>
                                               <td>{{$student->full_name_en}}</td>
                                               <td>{{!empty($student->email) ? $student->email : 'n/a' }}</td>
                                               <td>{{$student->session->title}}</td>
                                               <td>{{$student->course->title}}</td>
                                               <td>{{$student->gender}}</td>
                                               <td>{{$student->date_of_birth}}</td>
                                               <td>{{$student->place_of_birth}}</td>
                                               <td>{{($student->student_category_id == 2) ? 'USD' : 'Tk'}} {{formatAmount($student->available_amount_for_tuition)}}</td>
                                               <td>{{($student->student_category_id == 2) ? 'USD' : 'Tk'}} {{formatAmount($student->available_amount_for_development)}}</td>
                                               <td>{{$studentStatus[$student->status]}}</td>
                                           </tr>
                                           <tbody>

                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>

                       </div>
                       <div class="col-md-12">
                           <div class="row pt-4 pl-2 pr-2">
                               <div class="col-md-12">
                                   <div class="m-list-search__result-category mb-2"><h5 class="text-center pb-2">Admission Information</h5></div>
                               </div>
                               <div class="col-md-12">
                                   <div class="table-responsive">
                                       <table class="table table-bordered">
                                           <thead>
                                           <tr>
                                               <th>Category</th>
                                               <th>Roll</th>
                                               <th>Form Fillup date</th>
                                               <th>Test Score</th>
                                               <th>Merit position</th>
                                               <th>Merit Score</th>
                                           </tr>
                                           </thead>
                                           <tr>
                                               <td>{{$student->studentCategory->title}}</td>
                                               <td>{{$student->admission_roll_no}}</td>
                                               <td>{{$student->form_fillup_date}}</td>
                                               <td>{{$student->test_score}}</td>
                                               <td>{{$student->merit_score}}</td>
                                               <td>
                                                   @if(!empty($student->merit_position))
                                                       {{number_format($student->merit_position, 2)}}
                                                   @endif
                                               </td>
                                           </tr>
                                           <tbody>

                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="row pt-4 pl-2 pr-2">
                               <div class="col-md-12">
                                   <div class="m-list-search__result-category mb-2"><h5 class="text-center pb-2">Educational Information</h5></div>
                               </div>
                               <div class="col-md-12">
                                   <div class="table-responsive">
                                       <table class="table table-bordered">
                                           <thead>
                                           <tr>
                                               <th>Level</th>
                                               <th>Board</th>
                                               <th>Institute</th>
                                               <th>GPA</th>
                                               <th>GPA (Biology)</th>
                                               <th>Pass Year</th>
                                               <th>Extra Curriculum Activities</th>
                                           </tr>
                                           </thead>
                                           @foreach($student->educations as $education)
                                               <tr>
                                                   <td>{{$educationLevel[$education->education_level]}}</td>
                                                   <td>{{$education->educationBoard->title}}</td>
                                                   <td>{{$education->institution}}</td>
                                                   <td>{{$education->gpa}}</td>
                                                   <td>{{$education->gpa_biology}}</td>
                                                   <td>{{$education->pass_year}}</td>
                                                   <td>{{$education->extra_activity}}</td>
                                               </tr>
                                           @endforeach
                                           <tbody>

                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="row pt-4 pl-2 pr-2">
                               <div class="col-md-12">
                                   <div class="m-list-search__result-category"><h5 class="text-center pb-2">Parents Asset Information</h5></div>

                               </div>
                               <div class="col-md-12">
                                   <div class="table-responsive">
                                       <table class="table table-bordered">
                                           <thead>
                                           <tr>
                                               <th>Annual Income</th>
                                               <th>Annual Income Grade</th>
                                               <th>Movable Property</th>
                                               <th>Movable Property Grade</th>
                                               <th>Immovable Property</th>
                                               <th>Immovable Property Grade</th>
                                               <th>Total Assets</th>
                                               <th>Total Assets Grade</th>
                                               <th>Finance</th>
                                           </tr>
                                           </thead>
                                           <tr>
                                               <td>{{$student->parent->annual_income}}</td>
                                               <td>{{$student->parent->annual_income_grade}}</td>
                                               <td>{{$student->parent->movable_property}}</td>
                                               <td>{{$student->parent->movable_property_grade}}</td>
                                               <td>{{$student->parent->immovable_property}}</td>
                                               <td>{{$student->parent->immovable_property_grade}}</td>
                                               <td>{{$student->parent->total_asset}}</td>
                                               <td>{{$student->parent->total_asset_grade}}</td>
                                               <td>{{$student->parent->finance_during_study}}</td>
                                           </tr>
                                           <tbody>

                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="row pt-4 pl-2 pr-2">
                               <div class="col-md-12">
                                   <div class="m-list-search__result-category"><h5 class="text-center pb-2">Emergency Contact Information</h5></div>
                               </div>
                               <div class="col-md-12">
                                   <div class="table-responsive">
                                       <table class="table table-bordered">
                                           <thead>
                                           <tr>
                                               <th>Name</th>
                                               <th>Relation</th>
                                               <th>Phone</th>
                                               <th>Email</th>
                                               <th>Address</th>
                                           </tr>
                                           </thead>
                                           <tr>
                                               <td>{{($student->emergencyContact->full_name) ?: 'n/a'}}</td>
                                               <td>{{($student->emergencyContact->relation) ?: 'n/a'}}</td>
                                               <td>{{($student->emergencyContact->phone) ?: 'n/a'}}</td>
                                               <td>{{($student->emergencyContact->email) ?: 'n/a'}}</td>
                                               <td>{{($student->emergencyContact->address) ?: 'n/a'}}</td>
                                           </tr>
                                           <tbody>

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
