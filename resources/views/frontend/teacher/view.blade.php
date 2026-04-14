@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>Teacher Detail</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('nemc/teacher') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="fas fa-user-tie pr-2"></i>Teachers</a>
            </div>
        </div>

        <!--begin::Form-->
        <div class="m-form m-form--fit m-form--label-align-right">
            <div class="m-portlet__body">
                <!-- new design start-->
                <div class="m-section__content">
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
                                                        @if ($teacher->photo)
                                                            <img src="{{ asset($teacher->photo) }}" class="card-img"
                                                                 alt="Teacher image">
                                                        @else
                                                            <img src="{{ asset('assets/global/img/male_avater.png') }}"
                                                                 class="card-img" alt="Teacher image">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="m-card-profile__details">
                                                    <span class="m-card-profile__name"> </span>

                                                    <span class="m-card-profile__name">{{$teacher->full_name}}</span>
                                                    <a href="" class="m-card-profile__email m-link"
                                                       style="word-break: break-all;">{{$teacher->email}}</a>
                                                </div>
                                            </div>
                                            <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                                                <li class="m-nav__separator m-nav__separator--fit"></li>
                                                <li class="m-nav__section m--hide">
                                                    <span class="m-nav__section-text">Section</span>
                                                </li>
                                                <li class="m-nav__item">
                                                    <div class="m-nav__link">
                                                        <i class="m-nav__link-icon fas fa-id-card-alt"></i>
                                                        <span class="m-nav__link-title">
														<span class="m-nav__link-wrap">
															<span
                                                                class="m-nav__link-text">ID :{{!empty($teacher->user->user_id)? $teacher->user->user_id : 'n/a'}}</span>
														</span>
													</span>
                                                    </div>
                                                </li>
                                                <li class="m-nav__item">
                                                    <div class="m-nav__link">
                                                        <i class="m-nav__link-icon far fa-check-square"></i>
                                                        <span class="m-nav__link-text">Status: @if($teacher->status == 1)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-8">
                                    <div class="m-portlet m-portlet--full-height m-portlet--tabs">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-tools">
                                                <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--left m-tabs-line--primary"
                                                    role="tablist">
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link active show"
                                                           data-toggle="tab" href="#teacher_profile" role="tab"
                                                           aria-selected="true">
                                                            Profile
                                                        </a>
                                                    </li>
                                                    @if(hasPermission('teacher/evaluation'))
                                                    <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link"
                                                           data-toggle="tab" href="#teacher_evaluations" role="tab"
                                                           aria-selected="false">
                                                            Student Evaluations
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="tab-content">
                                            {{-- Profile tab --}}
                                            <div class="tab-pane active show" id="teacher_profile">
                                                <div class="p-4">
                                                    <p>Department
                                                        : {{!empty($teacher->department->title) ? $teacher->department->title : 'N/A'}}</p>
                                                    <hr>
                                                    <p>Course
                                                        : {{!empty($teacher->course->title) ? $teacher->course->title : 'N/A'}}</p>
                                                    <hr>
                                                    <p>Designation
                                                        : {{!empty($teacher->designation->title) ? $teacher->designation->title : 'N/A'}}</p>
                                                    <hr>
                                                    <p>Phone Number
                                                        : {{ $teacher->share_phone == 1 ? (!empty($teacher->phone) ? $teacher->phone : 'N/A') : 'N/A'}}</p>
                                                    <hr>
                                                    <p>Share Phone: {{$teacher->share_phone == 0 ? 'No' : 'Yes'}}</p>
                                                    <hr>
                                                    <p>Gender
                                                        : {{!empty($teacher->gender) ? $teacher->gender : 'N/A'}}</p>
                                                    <hr>
                                                    <p>Email
                                                        : {{ $teacher->share_email == 1 ? (!empty($teacher->email) ? $teacher->email : 'N/A') : 'N/A'}}</p>
                                                    <hr>
                                                    <p>Share Email : {{$teacher->share_email == 0 ? 'No' : 'Yes'}}</p>
                                                </div>
                                            </div>

                                            {{-- Evaluations tab --}}
                                            <div class="tab-pane" id="teacher_evaluations">
                                                <div class="p-4">
                                                    <div class="d-flex justify-content-between mb-3">
                                                        @if(Auth::guard('student_parent')->check())
                                                            @php
                                                                $user = Auth::guard('student_parent')->user();
                                                                $isStudent = $user->student !== null;
                                                            @endphp
                                                            @if($isStudent)
                                                                @if($hasEvaluated)
                                                                    <a href="{{ route('frontend.teacher.evaluation.edit', $userEvaluation->id) }}"
                                                                       class="btn btn-warning m-btn m-btn--icon">
                                                                        <span>
                                                                            <i class="fas fa-edit"></i>
                                                                            <span>Update My Evaluation</span>
                                                                        </span>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('frontend.teacher.evaluation.create', $teacher->id) }}"
                                                                       class="btn btn-primary m-btn m-btn--icon">
                                                                        <span>
                                                                            <i class="fas fa-clipboard-check"></i>
                                                                            <span>Evaluate This Teacher</span>
                                                                        </span>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>

                                                    @if($totalEvaluations > 0)
                                                        <div class="row pt-3">
                                                            <div class="col-md-6">
                                                                <h5>Average Rating</h5>
                                                                <div class="d-flex justify-content-between">
                                                                    <span
                                                                        class="m-form__help">Based on {{$isStudent ?
                                                                        'your current phase evaluation' : 'all
                                                                        evaluations' }}</span>
                                                                    <span
                                                                        style="font-size: 1.5rem; font-weight: 600"
                                                                        class="m--font-brand">
                                                                            {{ number_format($averageRating, 2) }} / 5.00
                                                                    </span>
                                                                </div>

                                                                <div class="progress m-progress--sm">
                                                                    <div class="progress-bar m--bg-brand"
                                                                         role="progressbar"
                                                                         style="width: {{ ($averageRating / 5) * 100 }}%;"
                                                                         aria-valuenow="{{ $averageRating }}"
                                                                         aria-valuemin="0" aria-valuemax="5"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h5>Role Model</h5>
                                                                <div
                                                                    class="d-flex justify-content-between">
                                                                    <span class="m-form__help">{{$isStudent ? 'You' : 'Students who'}} consider this teacher a role model</span>
                                                                    <span
                                                                        style="font-size: 1.5rem; font-weight: 600"
                                                                        class=" m--font-success">
                                                                            {{ number_format($roleModelPercentage, 1) }}%
                                                                        </span>
                                                                </div>
                                                                <div class="progress m-progress--sm">
                                                                    <div class="progress-bar m--bg-success"
                                                                         role="progressbar"
                                                                         style="width: {{ $roleModelPercentage }}%;"
                                                                         aria-valuenow="{{ $roleModelPercentage }}"
                                                                         aria-valuemin="0"
                                                                         aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle"></i> No evaluations yet. Be
                                                            the first to evaluate this teacher!
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- new design end-->
            </div>
        </div>
        <!--end::Form-->
    </div>
@endsection

