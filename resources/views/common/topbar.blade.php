<style>
    .notification-detail a:hover {
        text-decoration: none;
    }
</style>

<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">

            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{url('admin')}}" class="m-brand__logo-wrapper">
                            <img alt="" src="{{asset('assets/global/img/logo.jpg')}}" style="width: 12rem;">
                            {{-- <h3>NEMC</h3>--}}
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">

                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        {{--                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">--}}
                        {{--                            <span></span>--}}
                        {{--                        </a>--}}

                        <!-- END -->

                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>

                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>

            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark "
                        id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                <!-- END: Horizontal Menu -->

                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__notifications m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width"
                                m-dropdown-toggle="click" m-dropdown-persistent="1">
                                <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                    <span class="m-nav__link-icon">
                                        <span class="m-nav__link-icon-wrapper"><i class="flaticon-alarm"></i></span>
                                         @if( $unseenNotifications != 0 )
                                            <span
                                                class="m-nav__link-badge m-badge m-badge--danger"> {{ $unseenNotifications }} </span>
                                        @endif
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper" style="left: -5rem !important;">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background-color: #56bfa399;">
                                            <span class="m-dropdown__header-title">{{$unseenNotifications}} New Notification</span>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <div class="tab-content mt-3">
                                                    <div class="tab-pane active" id="topbar_notifications_notifications"
                                                         role="tabpanel">
                                                        <div class="m-scrollable m-scroller ps" data-scrollable="true"
                                                             data-height="250" data-mobile-height="200"
                                                             style="height: 250px; overflow: hidden;">
                                                            <div class="m-list-timeline m-list-timeline--skin-light">
                                                                <div class="m-list-timeline__items notification-detail">
                                                                    @foreach($notifications as $notification)
                                                                        <a
                                                                            href="{{ url('admin/notifications/'.$notification->id) }}">
                                                                            <div class="m-list-timeline__item py-2">
                                                                                <span
                                                                                    class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
                                                                                <span
                                                                                    class="m-list-timeline__text">{!! $notification->message  !!}</span>
                                                                                <span
                                                                                    class="m-list-timeline__time">{{ $notification->created_at->diffForHumans() }}</span>
                                                                            </div>
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    @if(Auth::guard('web')->check())
                                        @php $authUser = Auth::guard('web')->user(); @endphp
                                        @if($authUser->adminUser)
                                            <span class="m-topbar__userpic">
                                                    <img class="m--img-rounded m--marginless m--img-centered"
                                                         src="{{$authUser->adminUser->photo ? asset($authUser->adminUser->photo) : asset(getAvatar())}}"
                                                         alt="User image">
                                                </span>
                                        @elseif($authUser->teacher)
                                            <span class="m-topbar__userpic">
                                                    <img class="m--img-rounded m--marginless m--img-centered"
                                                         src="{{$authUser->teacher->photo ? asset($authUser->teacher->photo) : asset(getAvatar())}}"
                                                         alt="User image">
                                                </span>
                                        @else
                                            <span class="m-topbar__userpic">
                                                    <img class="m--img-rounded m--marginless m--img-centered"
                                                         src="{{asset('assets/global/img/male_avater.png')}}}"
                                                         alt="User image">
                                                </span>
                                        @endif
                                    @endif

                                    <span class="m-nav__link-icon m-topbar__usericon  m--hide">
													<span class="m-nav__link-icon-wrapper"><i
                                                            class="flaticon-user-ok"></i></span>
												</span>
                                    <span class="m-topbar__username m--hide">Nick</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span
                                        class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center">
                                            @if(Auth::guard('web')->check())
                                                @php $authUser = Auth::guard('web')->user(); @endphp
                                                <div class="m-card-user m-card-user--skin-light">
                                                    <div class="m-card-user__pic">
                                                        @if($authUser->adminUser)
                                                            <img class="m--img-rounded m--marginless"
                                                                 src="{{$authUser->adminUser->photo ? asset($authUser->adminUser->photo) : asset(getAvatar())}}"
                                                                 alt="User image">
                                                        @elseif($authUser->teacher)
                                                            <img class="m--img-rounded m--marginless"
                                                                 src="{{$authUser->teacher->photo ? asset($authUser->teacher->photo) : asset(getAvatar())}}"
                                                                 alt="User image">
                                                        @else
                                                            <img src="{{asset('assets/global/img/male_avater.png')}}"
                                                                 class="m--img-rounded m--marginless" alt="">
                                                        @endif
                                                    </div>

                                                    <div class="m-card-user__details">

                                                        @if($authUser->teacher)
                                                            <span class="m-card-user__name m--font-weight-500">
                                                            {{$authUser->teacher->first_name.' '.$authUser->teacher->last_name}}
                                                            </span>
                                                        @else
                                                            <span class="m-card-user__name m--font-weight-500">
                                                            {{$authUser->first_name.' '.$authUser->last_name}}
                                                            </span>
                                                        @endif

                                                        @if($authUser->teacher)
                                                            <a class="m-card-user__email m--font-weight-300 m-link">
                                                                {{$authUser->teacher->email ? $authUser->teacher->email : $authUser->user_id}}
                                                            </a>
                                                        @else
                                                            <a class="m-card-user__email m--font-weight-300 m-link">
                                                                {{$authUser->email ? $authUser->email : $authUser->user_id}}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                @if(Auth::guard('web')->check())
                                                    <ul class="m-nav m-nav--skin-light">
                                                        <li class="m-nav__section m--hide">
                                                            <span class="m-nav__section-text">Section</span>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            @if(Auth::guard('web')->user()->teacher)
                                                                <a href="{{route('teacher.show',Auth::guard('web')->user()->teacher->id)}}"
                                                                   class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                    <span class="m-nav__link-title">
                                                                        <span class="m-nav__link-wrap">
                                                                            <span
                                                                                class="m-nav__link-text">My Profile</span>
                                                                        </span>
                                                                    </span>
                                                                </a>
                                                            @else
                                                                <a href="{{route('users.show', Auth::guard('web')->user()->id)}}"
                                                                   class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                    <span class="m-nav__link-title">
                                                                        <span class="m-nav__link-wrap">
                                                                            <span
                                                                                class="m-nav__link-text">My Profile</span>
                                                                        </span>
                                                                    </span>
                                                                </a>
                                                            @endif
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="{{route('message.index')}}" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                <span class="m-nav__link-text">Messages</span>
                                                            </a>
                                                        </li>
                                                        {{-- {{Auth::guard('web')->user()->teacher->id}}--}}
                                                        <li class="m-nav__item">
                                                            @if(Auth::guard('web')->user()->teacher)
                                                                <a href="{{route('teacher.password-change.form', Auth::guard('web')->user()->teacher->id)}}"
                                                                   class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-lock"></i>
                                                                    <span
                                                                        class="m-nav__link-text">Change Password</span>
                                                                </a>
                                                            @else
                                                                <a href="{{route('user.password-change.form', Auth::guard('web')->user()->id)}}"
                                                                   class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-lock"></i>
                                                                    <span
                                                                        class="m-nav__link-text">Change Password</span>
                                                                </a>
                                                            @endif
                                                        </li>
                                                        <li class="m-nav__separator m-nav__separator--fit">
                                                        </li>
                                                        <li class="m-nav__item">
                                                            {{--                                                        <a href="{{url('admin/logout')}}" class="btn m-btn--pill btn-block    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>--}}
                                                            <a class="btn m-btn--pill btn-block btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder"
                                                               href="{{ url('admin/logout') }}"
                                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                                Logout
                                                            </a>

                                                            <form id="logout-form" action="{{ url('admin/logout') }}"
                                                                  method="GET" style="display: none;">
                                                                {{ csrf_field() }}
                                                            </form>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>
