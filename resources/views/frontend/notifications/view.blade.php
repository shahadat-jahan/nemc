@extends('frontend.layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-table font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp sbold uppercase">Notification details</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Notification details</h4>
                        </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul class="list-group">
                                            <li class="list-group-item">ID: {{ $notification->id }}</li>
                                            <li class="list-group-item">Resource type: {{ $notification->resource_type }}</li>
                                            <li class="list-group-item">Resource Name:{{ $notification->resource_id }}</li>
                                            <li class="list-group-item">Message: {!! $notification->message  !!}</li>
                                            <li class="list-group-item">Status: {{ ($notification->is_seen == 0) ? 'Unseen' : 'Seen' }}</li>
                                            <li class="list-group-item">Date: {{ $notification->created_at->diffForHumans() }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
