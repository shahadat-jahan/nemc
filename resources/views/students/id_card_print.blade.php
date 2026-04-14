@extends('layouts.print')
@push('style')
    <link href="{{asset('assets/global/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12 mt-5">
            <div class="card  m-auto card-bg-color" style="width: 34rem;">
                <div class="card-body id-card-container">
                    <div class="row no-gutters">
                        <div class="col-sm-2">
                            <img class="nemc-logo" src="{{asset('assets/global/img/nemc-logo.png')}}">
                        </div>
                        <div class="col-sm-10">
                            <div class="nemc-title pl-4">
                                <p class="uv-name mb-0 text-uppercase">North East Medical College</p>
                                <p class="uv-location">Sylhet, Bangladesh.</p>
                            </div>
                        </div>
                    </div>
                    <div id="bg-logo">
                        <div class="row">
                            <div class="col-sm-8">
                                <p class="text-uppercase mb-0 font-weight-bold student-name">{{$studentInfo->full_name_en}}</p>
                                <div class="row student-info no-gutters">
                                    <div class="col-sm-6">
                                        <p class="mb-0">Student ID No.</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0"> : {{$studentInfo->student_id}}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0">Course</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0">: {{$studentInfo->course->title}}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0">Session</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0">: {{$studentInfo->session->title}}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0" style="color: #ed381e;">Blood Group</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0"  style="color: #ed381e;">: {{!empty($studentInfo->blood_group)? $studentInfo->blood_group : 'N/A'}}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0">Duration</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php
                                        $duration = abs($studentInfo->session->sessionDetails->where('course_id', $studentInfo->course_id)->first()->sessionPhaseDetails->sum('duration'));
                                        $startYear = $studentInfo->session->start_year;
                                        $sessionStartDate = \Carbon\Carbon::create($startYear, 1, 1)->format('M\' y');
                                        $sessionEndYear = \Carbon\Carbon::create($startYear, 1, 1)->addYear($duration)->addMonth(11)->format('M\' y');
                                        ?>
                                        <p class="mb-0">: {{$sessionStartDate.' - '.$sessionEndYear}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 text-center">
                                <div class="image-box">
                                    <div>
                                        @if($studentInfo->photo)
                                            <img class="student-img" src="{{asset($studentInfo->photo)}}" alt="Applicant image">
                                        @else
                                            <img class="student-img" src="{{asset('assets/global/img/male_avater.png')}}" alt="Applicant image">
                                        @endif
                                        {{--<img class="student-img" src="https://cdn2.iconfinder.com/data/icons/education-people/512/25-512.png"/>--}}
                                    </div>
                                </div>
                                <div class="signature">
                                    {{--                                    <img src="http://www.stickpng.com/assets/images/586f5cbb3817baaba563b3c1.png" width="70"/>--}}
                                    <br>
                                    <br>
                                    <small>Principal's Signature</small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="row">
            <div class="col-sm-12">
                <div class="card  text-center card-bg-color" style="width: 34rem;">
                    <div class="card-body card-back">
                        <h6 class="card-title">This card is not transferebale/ exchangable<br>
                            If found, please return to..
                        </h6>
                        <h5 class="text-uppercase">North East Medical College</h5>
                        <p class="card-text mb-0">South Surma, Sylhet, Bangladesh</p>
                        <p class="card-text mb-0">Email: info@nemc.edu.bd</p>
                        <p class="card-text mb-0">nemc1998@gmail.com</p>
                        <p class="card-text mb-0">Phone: +8801738564792</p>
                        <p class="card-text mb-0">www.nemc.edu.bd</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
