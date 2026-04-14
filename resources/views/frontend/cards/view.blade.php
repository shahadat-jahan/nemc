@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul pr-2"></i>Card Name : Card</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('cards.index') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-lg fa-info-circle pr-2"></i>Cards</a>
                    </div>
                </div>

                <div class="m-portlet__body">

                    <div class="m-section__content">

                        <div class="card">
                            <div class="card-header">
                                Card Title : {{$card->title}}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Subject :</div>
                                                        <div class="col-md-8">{{$card->subject->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Phase :</div>
                                                        <div class="col-md-8">{{$card->phase->title}}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Term :</div>
                                                        <div class="col-md-8">{{$card->term->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Status :</div>
                                                        <div class="col-md-8">{{$card->status == 1 ? 'Active' : 'Inactive' }}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="text-center">All Items of Card : {{$card->title}}</h4>
                                    </div>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Item Title</th>
                                                    <th scope="col">Serial Number</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($card->cardItems)
                                                    @foreach($card->cardItems as $item)
                                                        <tr>
                                                            <th>{{$item->title}}</th>
                                                            <td>{{$item->serial_number}}</td>
                                                            <td>{{!empty($item->description) ? $item->description : '--'}}</td>
                                                            <td>{{$item->status == 1 ? "Active" : "InActive"}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
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

@endsection
