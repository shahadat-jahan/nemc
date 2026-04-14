@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .table td {
            padding-top: 0.6rem !important;
            padding-bottom: .6rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
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
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Student's
                                Detail: {{$student->full_name_en}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('frontend.students.index') }}" class="btn btn-primary m-btn m-btn--icon"><i
                                class="fa fa-list"></i> Student</a>
                    </div>
                </div>

                <div class="m-portlet__body">

                    <div class="m-section__content">

                        <!--Student detail new start-->
                        <div class="m-grid__item m-grid__item--fluid m-wrapper">

                            <div class="m-content p-0">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-4">
                                        <div class="m-portlet m-portlet--full-height  ">
                                            <div class="m-portlet__body">
                                                <div class="m-card-profile">
                                                    <div class="m-card-profile__title m--hide">
                                                        Your Profile
                                                    </div>
                                                    <div class="m-card-profile__pic">
                                                        <div class="m-card-profile__pic-wrapper">
                                                            @if($student->photo)
                                                                <img src="{{asset($student->photo)}}"
                                                                     alt="Student Photo">
                                                            @else
                                                                <img
                                                                    src="{{ $student->gender == 'male' ? asset('assets/global/img/male_avater.png') : asset('assets/global/img/female_avater.png')}}"
                                                                    alt="Student image">
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="m-card-profile__details">
                                                        <span
                                                            class="m-card-profile__name">{{$student->full_name_en}}</span>
                                                        @if(!empty($student->email))
                                                            <a href=""
                                                               class="m-card-profile__email m-link">{{ $student->email }}</a>
                                                        @endif
                                                    </div>

                                                </div>
                                                <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                                    <li class="m-nav__section m--hide">
                                                        <span class="m-nav__section-text">Section</span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <div class="m-nav__link">
                                                            <i class="m-nav__link-icon fas fa-calendar-alt"></i>
                                                            <span
                                                                class="m-nav__link-text">ID : {{$student->student_id}}</span>
                                                        </div>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <div class="m-nav__link">
                                                            <i class="m-nav__link-icon fas fa-mobile-alt"></i>
                                                            <span
                                                                class="m-nav__link-text">{{!empty($student->mobile) ? $student->mobile : 'N/A'}}</span>
                                                        </div>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <div class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-calendar-2"></i>
                                                            <span
                                                                class="m-nav__link-text">Session: {{$student->session->title}}</span>
                                                        </div>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <div class="m-nav__link">
                                                            <i class="m-nav__link-icon far fa-check-square"></i>
                                                            <span
                                                                class="m-nav__link-text">Status: {{$studentStatus[$student->status]}}</span>
                                                        </div>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a class="m-nav__link"
                                                           href="{{route('frontend.students.attendance', [$student->id])}}">
                                                            <i class="m-nav__link-icon fa fa-user-tag"></i>
                                                            <span class="m-nav__link-text">Attendance</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a class="m-nav__link"
                                                           href="{{route('frontend.students.card-item', [$student->id])}}">
                                                            <i class="m-nav__link-icon fa fa-clipboard-list"></i>
                                                            <span class="m-nav__link-text">Card Items</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a class="m-nav__link"
                                                           href="{{route('frontend.students.exam-result', [$student->id])}}">
                                                            <i class="m-nav__link-icon fa fa-puzzle-piece"></i>
                                                            <span class="m-nav__link-text">Exam Results</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 col-lg-8">
                                        <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-tools">
                                                    <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--left m-tabs-line--primary"
                                                        role="tablist">
                                                        <li class="nav-item m-tabs__item">
                                                            <a class="nav-link m-tabs__link active show"
                                                               data-toggle="tab" href="#personal_info" role="tab"
                                                               aria-selected="true">
                                                                <i class="flaticon-share m--hide"></i>
                                                                Personal
                                                            </a>
                                                        </li>
                                                        <li class="nav-item m-tabs__item">
                                                            <a class="nav-link m-tabs__link" data-toggle="tab"
                                                               href="#admission_info" role="tab" aria-selected="false">
                                                                Admission
                                                            </a>
                                                        </li>
                                                        <li class="nav-item m-tabs__item">
                                                            <a class="nav-link m-tabs__link" data-toggle="tab"
                                                               href="#education_info" role="tab" aria-selected="false">
                                                                Education
                                                            </a>
                                                        </li>


                                                        <li class="nav-item m-tabs__item">
                                                            <a class="nav-link m-tabs__link" data-toggle="tab"
                                                               href="#parent_asset_info" role="tab"
                                                               aria-selected="false">
                                                                Parent's Asset
                                                            </a>
                                                        </li>

                                                        <li class="nav-item m-tabs__item">
                                                            <a class="nav-link m-tabs__link" data-toggle="tab"
                                                               href="#contact_info" role="tab" aria-selected="false">
                                                                Contact
                                                            </a>
                                                        </li>

                                                        <li class="nav-item m-tabs__item">
                                                            <a class="nav-link m-tabs__link" data-toggle="tab"
                                                               href="#attachment_info" role="tab" aria-selected="false">
                                                                Attachment
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane active show" id="personal_info">
                                                    <div class="row pt-4 pl-2 pr-2">
                                                        <div class="col-md-12">
                                                            <div class="m-list-search__result-category"><h5
                                                                    class="text-center pb-2">Personal Information</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="card mb-2">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6"><p>Session
                                                                                : {{$student->session->title}}</p></div>
                                                                        <div class="col-md-6"><p>Course
                                                                                : {{$student->course->title}}</p></div>
                                                                        <div class="col-md-6"><p>Gender
                                                                                : {{$student->gender}}</p></div>
                                                                        <div class="col-md-6"><p>Date of Birth
                                                                                : {{$student->date_of_birth}}</p></div>
                                                                        <div class="col-md-6"><p>Birth
                                                                                Place: {{$student->place_of_birth}}</p>
                                                                        </div>
                                                                        <div class="col-md-6"><p>Available Credit
                                                                                <small>(for
                                                                                    tuition)</small>: {{($student->student_category_id == 2) ? 'USD' : 'Tk'}} {{formatAmount($student->available_amount_for_tuition)}}
                                                                            </p></div>
                                                                        <div class="col-md-6"><p>Available Credit
                                                                                <small>(for
                                                                                    development)</small>: {{($student->student_category_id == 2) ? 'USD' : 'Tk'}} {{formatAmount($student->available_amount_for_development)}}
                                                                            </p></div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6"></div>
                                                                        <div class="col-md-6"></div>
                                                                    </div>
                                                                    <p class="mb-0"><b>Address</b>
                                                                        : {{ isset($student->address) ? $student->address : 'N/A' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Father's Name</th>
                                                                        <th>Mother's Name</th>
                                                                        <th>Father's Phone</th>
                                                                        <th>Mother's Phone</th>
                                                                        <th>Father's Email</th>
                                                                        <th>Mother's Email</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tr>
                                                                        <td>{{$student->parent->father_name}}</td>
                                                                        <td>{{$student->parent->mother_name}}</td>
                                                                        <td>{{$student->parent->father_phone}}</td>
                                                                        <td>{{$student->parent->mother_phone}}</td>
                                                                        <td>
                                                                            <a href="mailto:{{$student->parent->father_email}}">{{$student->parent->father_email}}</a>
                                                                        </td>
                                                                        <td>{{$student->parent->mother_email}}</td>
                                                                    </tr>
                                                                    <tbody>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="admission_info">
                                                    <div class="row pt-4 pl-2 pr-2">
                                                        <div class="col-md-12">
                                                            <div class="m-list-search__result-category mb-2"><h5
                                                                    class="text-center pb-2">AdmisAdon Information</h5>
                                                            </div>
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
                                                <div class="tab-pane" id="education_info">
                                                    <div class="row pt-4 pl-2 pr-2">
                                                        <div class="col-md-12">
                                                            <div class="m-list-search__result-category mb-2"><h5
                                                                    class="text-center pb-2">Educational
                                                                    Information</h5></div>
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
                                                <div class="tab-pane" id="parent_asset_info">
                                                    <div class="row pt-4 pl-2 pr-2">
                                                        <div class="col-md-12">
                                                            <div class="m-list-search__result-category"><h5
                                                                    class="text-center pb-2">Parents Asset
                                                                    Information</h5></div>

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
                                                <div class="tab-pane" id="contact_info">
                                                    <div class="row pt-4 pl-2 pr-2">
                                                        <div class="col-md-12">
                                                            <div class="m-list-search__result-category"><h5
                                                                    class="text-center pb-2">Emergency Contact
                                                                    Information</h5></div>
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
                                                <div class="tab-pane" id="attachment_info">
                                                    <div class="row pt-4 pl-2 pr-2">
                                                        <div class="col-md-12">
                                                            <div class="m-list-search__result-category"><h5
                                                                    class="text-center pb-2">Attachments</h5></div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Type</th>
                                                                        <th>Remark</th>
                                                                        <th>Download</th>
                                                                    </tr>
                                                                    </thead>
                                                                    @foreach($student->attachments as $attachment)
                                                                        <tr>
                                                                            <td>{{($attachment->attachmentType) ? $attachment->attachmentType->title : ''}}</td>
                                                                            <td>{{$attachment->remarks}}</td>
                                                                            <td>
                                                                                <a href="{{asset($attachment->file_path)}}"
                                                                                   target="_blank"><i
                                                                                        class="fa fa-download"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
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
                        </div>
                        <!--Student detail new end-->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
