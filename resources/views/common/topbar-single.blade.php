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
                </div>
            </div>

            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                <!-- END: Horizontal Menu -->

                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">

                            <li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<img src="{{asset('assets/global/img/male_avater.png')}}" class="m--img-rounded m--marginless m--img-centered" alt="">
												</span>
                                    <span class="m-nav__link-icon m-topbar__usericon  m--hide">
													<span class="m-nav__link-icon-wrapper"><i class="flaticon-user-ok"></i></span>
												</span>
                                    <span class="m-topbar__username m--hide">Nick</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center">
                                            <div class="m-card-user m-card-user--skin-light">
                                                <div class="m-card-user__pic">
                                                    <img src="{{asset('assets/global/img/male_avater.png')}}" class="m--img-rounded m--marginless" alt="">
                                                </div>
                                                @if(Auth::guard('web')->check())
                                                <div class="m-card-user__details">
                                                        @if(Auth::guard('web')->user()->teacher)
                                                            <span class="m-card-user__name m--font-weight-500">
                                                            {{Auth::guard('web')->user()->teacher->first_name.' '.Auth::guard('web')->user()->teacher->last_name}}
                                                            </span>
                                                        @else
                                                            <span class="m-card-user__name m--font-weight-500">
                                                            {{Auth::guard('web')->user()->first_name.' '.Auth::guard('web')->user()->last_name}}
                                                            </span>
                                                        @endif

                                                        @if(Auth::guard('web')->user()->teacher)
                                                            <a class="m-card-user__email m--font-weight-300 m-link">
                                                                {{Auth::guard('web')->user()->teacher->email}}
                                                            </a>
                                                        @else
                                                         <a class="m-card-user__email m--font-weight-300 m-link">
                                                            {{Auth::guard('web')->user()->email}}
                                                        </a>
                                                        @endif
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                @if(Auth::guard('web')->check())
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__item">
                                                        <a href="{{url('admin/logout')}}" class="btn m-btn--pill btn-block    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
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
