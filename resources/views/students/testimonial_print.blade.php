@extends('layouts.print')
@push('style')
    <link href="{{asset('assets/global/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Pinyon+Script" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <style>
        .testimonial-additional-info{
            position: relative;
        }
        .start-year{
            font-weight: bold;
            position: absolute;
            left: 2rem;
            top: 27px;
        }
        .course-session{
            font-weight: bold;
            position: absolute;
            left: 19rem;
            top: 27px;
        }
        .registration-no{
            font-weight: bold;
            position: absolute;
            left: 1rem;
            top: 56px;
        }

        .exam-year{
            font-weight: bold;
            position: absolute;
            left: 16rem;
            top: 85px;
        }

        .exam-month{
            font-weight: bold;
            position: absolute;
            left: 47rem;
            top: 85px;
        }
    </style>
@endpush

@section('content')
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
                        <p class="mb-0 testimonial-student-name">This is to certify that .......................................................<span>{{$studentInfo->full_name_en}}</span></p>
                        <p class="mb-0 student-father-name"> Son / Daughter of ..........................................................<span>{{$studentInfo->parent->father_name}}</span></p>
                        <p class="testimonial-additional-info">
                            was admitted to North East Medical College,Sylhet during the year ...........<span class="start-year">{{$studentInfo->session->start_year}}</span>(Session ...................<span class="course-session">{{$studentInfo->session->title}}</span>),
                            University Registration No .................. <span class="registration-no">{{$studentInfo->student_id}}</span>He/She Passed the Final Professional M.B.B.S. Examination of ............<span class="exam-year">2025</span> held in the month of ..................<span class="exam-month">jan,2025</span> under Shahjalal University of Science & Techknology, Sylhet.
                            He/She bears a good moral character.
                        </p>
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
@endsection
