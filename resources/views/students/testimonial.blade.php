@extends('layouts.default')
@section('pageTitle', 'Student|Id Card')

@push('style')
    <link href="https://fonts.googleapis.com/css?family=Pinyon+Script" rel="stylesheet">
    @endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Student's Testimonial</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ URL::previous() }}" class="btn btn-primary m-btn m-btn--icon mr-1" title="Applicants"><i class="fa fa-undo-alt"></i> Back</a>
                        <a href="{{route('students.testimonial.print', [$studentInfo->id])}}" class="btn btn-primary m-btn m-btn--icon" title="Applicants" target="_blank"><i class="fas fa-print"></i> Print Testimonial</a>
                    </div>
                </div>

                <div class="m-portlet__body">

                    <div class="m-section__content">

                        <!--Student detail new start-->
                        <div class="m-grid__item m-grid__item--fluid m-wrapper">

                            <div class="m-content p-0">
                                <div class="container testimonial">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="borderimg">
                                                <div class="text-center mt-3">
                                                    <h1 class="text-uppercase uv-title display-4">North East Medical College</h1>
                                                    <h3>Sylhet, Bangladesh.</h3>
                                                    <img src="{{asset('assets/global/img/nemc-logo.png')}}">
                                                    <h2 class="text-uppercase">Testimonial</h2>
                                                </div>
                                                <div class="testimonial-content">
                                                    <p class="mb-0 testimonial-student-name">This is to certify that ................................................<span>{{$studentInfo->full_name_en}}</span></p>
                                                    <p class="mb-0 student-father-name"> Son / Daughter of ...................................................<span>{{$studentInfo->parent->father_name}}</span></p>
                                                    was admitted to North East Medical College,Sylhet during the year
                                                    <p class="mb-0 start-year">...........<span>{{$studentInfo->session->start_year}}</span>(Session ...................<span class="course-session">{{$studentInfo->session->title}}</span>),
                                                        University Registration No</p>
                                                    <p class="mb-0 registration-no">.................. <span>{{$studentInfo->student_id}}</span>He/She Passed the Final Professional M.B.B.S.</p>
                                                    <p class="mb-0 exam-year">Examination of ............<span>2025</span> held in the month of ..................<span class="exam-month">jan,2025</span></p>
                                                      under Shahjalal University of Science & Techknology, Sylhet. He/She bears a good moral character.

                                                    <div class="d-flex justify-content-between testimonial-footer">
                                                        <div>
                                                            <p>Dated, Sylhet</p>
                                                            <p>The ..............</p>
                                                        </div>
                                                        <div>
                                                            <p>Principal</p>
                                                            <p>North East Medical College</p>
                                                            <p>Sylhet</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Student detail new end-->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
