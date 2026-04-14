@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="fa fa-bell-o font-red-haze"></i>
                        <span class="caption-subject font-green-sharp sbold uppercase">{{__('booking.notifications')}}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!--BEGIN TABS-->
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">
                                    @foreach($notifications as $notification)
                                    <li class="{{ ($notification->is_seen == 0) ? 'bold' : '' }}">
                                        <a href="{{ url('admin/notifications/'.$notification->id) }}">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-{{ ($notification->is_seen == 0) ? 'success' : 'default' }}">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">{!! $notification->message  !!}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2" style="width: 100px; margin-left: -100px;">
                                                <div class="date"> {{ $notification->created_at->diffForHumans() }} </div>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--END TABS-->
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>

@endsection
