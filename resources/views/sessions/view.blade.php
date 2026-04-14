@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.default')
@section('pageTitle', $pageTitle)
@section('content')
    <div class="row">
        <div class="col-md-12">
            {{--<div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Session : {{$sessionData->title}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('sessions/create'))
                            <a href="{{ route('sessions.index') }}" class="btn btn-primary m-btn m-btn--icon" title="Create New Session"><i class="flaticon-calendar-2 pr-2"></i>Sessions</a>
                        @endif
                    </div>
                </div>
            </div>--}}
            <?php
/*            $mbbs = $sessionData->sessionDetails->firstWhere('course_id', 1);
            $dental = $sessionData->sessionDetails->firstWhere('course_id', 2);
            */?>

            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-lg fa-info-circle pr-2"></i>Session : {{$sessionData->title}}, Start Year : {{$sessionData->start_year}} </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('sessions/create'))
                            <a href="{{ route('sessions.index') }}" class="btn btn-primary m-btn m-btn--icon" title="Create New Session"><i class="flaticon-calendar-2 pr-2"></i>Sessions</a>
                        @endif
                    </div>
                </div>
                <?php
                $mbbs = $sessionData->sessionDetails->firstWhere('course_id', 1);
                $dental = $sessionData->sessionDetails->firstWhere('course_id', 2);
                ?>

                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="flaticon-calendar-2 fa-md pr-2"></i>MBBS</h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="m-list-search">
                                    <div class="m-list-search__results">

                                        <div class="m-list-search__result-category m-list-search__result-category--first"> <i class="fa fa-dollar-sign"></i> Costs</div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Development Fee (Local): {{!empty($mbbs->development_fee_local) ? formatAmount($mbbs->development_fee_local) : 'n/a'}} TK</span>
                                                </div>
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Tuition Fee (Local): {{!empty($mbbs->tuition_fee_local) ? formatAmount($mbbs->tuition_fee_local) : 'n/a'}} TK</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Development Fee (Foreign): {{!empty($mbbs->development_fee_foreign) ? formatAmount($mbbs->development_fee_foreign) : 'n/a'}} USD</span>
                                                </div>
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Tuition Fee (Foreign): {{!empty($mbbs->tuition_fee_foreign) ? formatAmount($mbbs->tuition_fee_foreign) : 'n/a'}} USD</span>
                                                </div>
                                            </div>
                                        </div>

                                        <br/>

                                        <div class="m-list-search__result-category m-list-search__result-category--first">Subjects</div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Phase</th>
                                                            <th>Terms</th>
                                                            <th>Duration</th>
                                                            <th>Exam Title</th>
                                                            <th>Subjects</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!empty($mbbs->sessionPhaseDetails))
                                                            @foreach($mbbs->sessionPhaseDetails as $phase)
                                                        <tr>
                                                            <td>{{$phase->phase->title}}</td>
                                                            <td>{{$phase->total_terms}}</td>
                                                            <td>
                                                                @if(!empty($phase->duration))
                                                                {{$phase->duration}} {{Str::plural('year', $phase->duration)}}
                                                                @endif
                                                            </td>
                                                            <td>{{$phase->exam_title}}</td>
                                                            <td>
                                                                @if($phase->subjects)
                                                                    @foreach($phase->subjects as $subject)
                                                                        - {{$subject->title}}<br>
                                                                        @endforeach
                                                                    @endif
                                                            </td>
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

            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="flaticon-calendar-2 fa-md pr-2"></i>BDS</h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="m-list-search">
                                    <div class="m-list-search__results">

                                        <div class="m-list-search__result-category m-list-search__result-category--first"> <i class="fa fa-dollar-sign"></i> Costs</div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Development Fee (Local): {{!empty($dental->development_fee_local) ? formatAmount($dental->development_fee_local) : 'n/a'}} TK</span>
                                                </div>
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Tuition Fee (Local): {{!empty($dental->tuition_fee_local) ? formatAmount($dental->tuition_fee_local) : 'n/a'}} TK</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Development Fee (Foreign): {{!empty($dental->development_fee_foreign) ? formatAmount($dental->development_fee_foreign).' USD' : ' n/a'}} </span>
                                                </div>
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Tuition Fee (Foreign): {{!empty($dental->tuition_fee_foreign) ? formatAmount($dental->tuition_fee_foreign).' USD' : ' n/a'}} </span>
                                                </div>
                                            </div>
                                        </div>

                                        <br/>

                                        <div class="m-list-search__result-category m-list-search__result-category--first">Subjects</div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Phase</th>
                                                            <th>Terms</th>
                                                            <th>Duration</th>
                                                            <th>Exam Title</th>
                                                            <th>Subjects</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!empty($dental->sessionPhaseDetails))
                                                            @foreach($dental->sessionPhaseDetails as $phase2)
                                                                <tr>
                                                                    <td>{{$phase2->phase->title}}</td>
                                                                    <td>{{$phase2->total_terms}}</td>
                                                                    <td>
                                                                        @if(!empty($phase2->duration))
                                                                            {{$phase2->duration}} {{Str::plural('year', $phase2->duration)}}
                                                                        @endif
                                                                    </td>
                                                                    <td>{{$phase2->exam_title}}</td>
                                                                    <td>
                                                                        @if($phase2->subjects)
                                                                            @foreach($phase2->subjects as $subjects)
                                                                                - {{$subjects->title}}<br>
                                                                            @endforeach
                                                                        @endif
                                                                    </td>
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

        </div>
    </div>

@endsection
