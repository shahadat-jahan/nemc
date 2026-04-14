@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>User Detail</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                @if($user->id == Auth::user()->id)
                    <a href="{{ url('admin/users/'.$user->id.'/edit') }}"
                       class="btn btn-primary m-btn m-btn--icon mr-3"><i
                            class="fas fa-edit pr-2"></i>Edit User</a>
                @endif
                <a href="{{ url()->previous() }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="fas fa-history pr-2"></i>Back</a>
            </div>
        </div>

        <!--begin::Form-->
        <div class="m-portlet__body">

            <div class="m-section__content">

                <!--Student detail new start-->
                <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    <div class="m-content p-0">
                        <div class="row">
                            <div class="col-xl-4 col-lg-5">
                                <div class="m-portlet m-portlet--full-height  ">
                                    <div class="m-portlet__body">
                                        <div class="m-card-profile">
                                            <div class="m-card-profile__title m--hide">
                                                Your Profile
                                            </div>
                                            <div class="m-card-profile__pic">
                                                <div class="m-card-profile__pic-wrapper">
                                                    @if($user->adminUser)
                                                        <img
                                                            src="{{asset($user->adminUser->photo) ? asset($user->adminUser->photo) : asset(getAvatar())}}"
                                                            alt="Applicant image">
                                                    @elseif($user->teacher)
                                                        <img src="{{asset($user->teacher->photo)}}" alt="Teacher image">
                                                    @else
                                                        <img
                                                            src="{{asset($user->adminUser->photo) ? asset($user->adminUser->photo) : asset(getAvatar())}}"
                                                            alt="Accounts image">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="m-card-profile__details">
                                                @if($user->adminUser)
                                                    <span
                                                        class="m-card-profile__name">{{$user->first_name.' '.$user->last_name}}</span>
                                                    <a href="" class="m-card-profile__email m-link"
                                                       style="word-break: break-all;">{{$user->email}}</a>
                                                @elseif($user->teacher)
                                                    <span
                                                        class="m-card-profile__name">{{$user->teacher->first_name.' '.$user->teacher->last_name}}</span>
                                                    <a href="" class="m-card-profile__email m-link"
                                                       style="word-break: break-all;">{{$user->email ? $user->email : ''}}</a>
                                                @else
                                                    <span
                                                        class="m-card-profile__name">{{$user->adminUser->first_name.' '.$user->adminUser->last_name}}</span>
                                                    <a href="" class="m-card-profile__email m-link"
                                                       style="word-break: break-all;">{{$user->email ? $user->email : ''}}</a>
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
                                                    <i class="m-nav__link-icon fas fa-id-card-alt"></i>
                                                    <span class="m-nav__link-title">
														<span class="m-nav__link-wrap">
															<span
                                                                class="m-nav__link-text">ID : {{$user->user_id}}</span>
														</span>
													</span>
                                                </div>
                                            </li>
                                            <li class="m-nav__item">
                                                <div class="m-nav__link">
                                                    <i class="m-nav__link-icon far fa-check-square"></i>
                                                    <span
                                                        class="m-nav__link-text">Status:{{$user->status == 1 ? 'Active' : 'Inactive'}}</span>
                                                </div>
                                            </li>
                                            {{--<li class="m-nav__item">
                                                <div class="m-nav__link">
                                                    <i class="m-nav__link-icon fas fa-mobile-alt"></i>
                                                    <span class="m-nav__link-text">{{$user->adminUser->phone}}</span>
                                                </div>
                                            </li>--}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7">
                                <div class="m-portlet m-portlet--full-height">
                                    <div class="p-4">
                                        <p>Group Name
                                            : {{!empty($user->userGroup->group_name) ? $user->userGroup->group_name: 'n/a'}}</p>
                                        <hr>
                                        <p>Email Address : {{!empty($user->email) ? $user->email: 'n/a'}}</p>
                                        <hr>
                                        <p>Phone Number
                                            : {{!empty($user->adminUser->phone) ? $user->adminUser->phone: 'n/a'}}</p>
                                        <hr>
                                        <p>Department
                                            : {{!empty($user->adminUser->department->title) ? $user->adminUser->department->title: 'n/a'}}</p>
                                        <hr>
                                        <p>Designation
                                            : {{!empty($user->adminUser->designation->title) ? $user->adminUser->designation->title: 'n/a'}}</p>
                                        <hr>
                                        <p>Email Notification : @if($user->email_notification == 1)
                                                Active
                                            @else
                                                Inactive
                                            @endif </p>
                                        <hr>
                                        <p>System Notification : @if($user->system_notification == 1)
                                                Active
                                            @else
                                                Inactive
                                            @endif </p>
                                        <hr>
                                        <p>Address
                                            : {{!empty($user->adminUser->address) ? $user->adminUser->address: 'n/a'}}</p>
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
@endsection

