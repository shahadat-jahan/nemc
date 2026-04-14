@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Applicant's
                                Detail: {{$applicant->full_name_en ?? 'N/A'}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('admission.index') }}" class="btn btn-primary m-btn m-btn--icon"
                           title="Applicants"><i class="fa fa-list"></i> Applicants</a>
                    </div>
                </div>

                <div class="m-portlet__body">

                    <!--Applicant detail new start-->
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
                                                        @if($applicant->photo)
                                                            <img src="{{asset($applicant->photo)}}"
                                                                 alt="Applicant image">
                                                        @else
                                                            <img src="{{getAvatar($applicant->gender)}}"
                                                                 alt="Applicant image">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="m-card-profile__details">
                                                    <span
                                                        class="m-card-profile__name">{{$applicant->full_name_en ?? 'N/A'}}</span>
                                                    @if(!empty($student->$applicant))
                                                        <a href=""
                                                           class="m-card-profile__email m-link">{{ $applicant->email ?? 'N/A' }}</a>
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
                                                        <i class="m-nav__link-icon far fa-check-square"></i>
                                                        <span
                                                            class="m-nav__link-text">Status: {{App\Services\UtilityServices::$admissionStatus[$applicant->status] ?? 'N/A'}}</span>
                                                    </div>
                                                </li>
                                                <li class="m-nav__item">
                                                    <div class="m-nav__link">
                                                        <i class="m-nav__link-icon fas fa-mobile-alt"></i>
                                                        <span
                                                            class="m-nav__link-text">{{!empty($applicant->phone) ? $applicant->phone : ($applicant->mobile ?? 'N/A')}}</span>
                                                    </div>
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
                                                        <a class="nav-link m-tabs__link active show" data-toggle="tab"
                                                           href="#personal_info" role="tab" aria-selected="true">
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
                                                           href="#parent_asset_info" role="tab" aria-selected="false">
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
                                                                class="text-center pb-2">Personal Information</h5></div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="card mb-2">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-6"><p>Session
                                                                            : {{$applicant->session->title ?? 'N/A'}}</p>
                                                                    </div>
                                                                    <div class="col-md-6"><p>Course
                                                                            : {{$applicant->course->title ?? 'N/A'}}</p>
                                                                    </div>
                                                                    <div class="col-md-6"><p>Gender
                                                                            : {{$applicant->gender ?? 'N/A'}}</p></div>
                                                                    <div class="col-md-6"><p>Date of Birth
                                                                            : {{$applicant->date_of_birth ?? 'N/A'}}</p>
                                                                    </div>
                                                                    <div class="col-md-6"><p>Birth
                                                                            Place
                                                                            : {{$applicant->place_of_birth ?? 'N/A'}}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6"></div>
                                                                    <div class="col-md-6"></div>
                                                                </div>
                                                                <p class="mb-0"><b>Address :</b>
                                                                    {{ $applicant->present_address ?? 'N/A' }}</p>
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
                                                                    <td>{{$applicant->admissionParent->father_name ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->mother_name ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->father_phone ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->mother_phone ?? 'N/A'}}</td>
                                                                    <td>
                                                                        <a href="mailto:{{$applicant->admissionParent->father_email ?? ''}}">{{$applicant->admissionParent->father_email ?? 'N/A'}}</a>
                                                                    </td>
                                                                    <td>{{$applicant->admissionParent->mother_email ?? 'N/A'}}</td>
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
                                                                    <td>{{$applicant->studentCategory->title ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admission_roll_no ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->form_fillup_date ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->test_score ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->merit_score ?? 'N/A'}}</td>
                                                                    <td>
                                                                        @if(!empty($applicant->merit_position))
                                                                            {{number_format($applicant->merit_position, 2)}}
                                                                        @else
                                                                            N/A
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
                                                                class="text-center pb-2">Educational Information</h5>
                                                        </div>
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
                                                                @forelse($applicant->admissionEducationHistories as $education)
                                                                    <tr>
                                                                        <td>{{$educationLevel[$education->education_level] ?? 'N/A'}}</td>
                                                                        <td>{{$education->educationBoard->title ?? 'N/A'}}</td>
                                                                        <td>{{$education->institution ?? 'N/A'}}</td>
                                                                        <td>{{$education->gpa ?? 'N/A'}}</td>
                                                                        <td>{{$education->gpa_biology ?? 'N/A'}}</td>
                                                                        <td>{{$education->pass_year ?? 'N/A'}}</td>
                                                                        <td>{{$education->extra_activity ?? 'N/A'}}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="7" class="text-center">No records
                                                                            found
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
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
                                                                class="text-center pb-2">Parents Asset Information</h5>
                                                        </div>

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
                                                                    <td>{{$applicant->admissionParent->annual_income ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->annual_income_grade ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->movable_property ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->movable_property_grade ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->immovable_property ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->immovable_property_grade ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->total_asset ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->total_asset_grade ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionParent->finance_during_study ?? 'N/A'}}</td>
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
                                                                    <td>{{$applicant->admissionEmergencyContact->full_name ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionEmergencyContact->relation ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionEmergencyContact->phone ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionEmergencyContact->email ?? 'N/A'}}</td>
                                                                    <td>{{$applicant->admissionEmergencyContact->address ?? 'N/A'}}</td>
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
                                                                @forelse($applicant->admissionAttachments as $attachment)
                                                                    <tr>
                                                                        <td>{{$attachment->attachmentType->title ?? 'N/A'}}</td>
                                                                        <td>{{$attachment->remarks ?? 'N/A'}}</td>
                                                                        <td>
                                                                            <a href="{{asset($attachment->file_path ?? '')}}"
                                                                               target="_blank"><i
                                                                                    class="fa fa-download"></i></a></td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="3" class="text-center">No
                                                                            attachments found
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
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
                    <!--Applicant detail new end-->

                </div>
            </div>
        </div>
    </div>

@endsection
