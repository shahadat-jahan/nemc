@extends('frontend.layouts.default')
@section('pageTitle', 'View Parent\'s Information')

@push('style')
    <style>
        .form-control[disabled] {
            border-color: #f4f5f8 !important;
            color: #6f727d;
            background-color: #f4f5f8 !important;
        }
        .m-checkbox>input:disabled ~ span {
            opacity: 1 !important;
            filter: alpha(opacity=60);
        }
        .m-checkbox>input:checked ~ span {
            border: 1px solid #bdc3d4;
            background: #f4f5f8 !important;
        }
    </style>
@endpush

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="flaticon-eye pr-2"></i>View Parent's Information</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            @section('content')
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text"><i class="flaticon-eye pr-2"></i>View Parent's Information</h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <a href="{{ URL::previous() }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-undo pr-2"></i>Back</a>
                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <div class="m-portlet">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">Parent Details with Student</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#parent_info" role="tab">Parent Info</a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#student_into" role="tab">Students</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="parent_info" role="tabpanel">
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
                                                                    <img src="{{asset('assets/global/img/male_avater.png')}}" class="card-img" alt="Teacher image">
                                                                </div>
                                                            </div>
                                                            <div class="m-card-profile__details">
                                                                <span class="m-card-profile__name"> </span>

                                                                <span class="m-card-profile__name">{{$parentInfo->father_name}}</span>
                                                                <a href="" class="m-card-profile__email m-link" style="word-break: break-all;">{{$parentInfo->father_email}}</a>
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
                                                        <span class="m-nav__link-text">ID : {{$parentInfo->user->user_id}}</span>
                                                    </span>
                                                </span>
                                                                </div>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <div class="m-nav__link">
                                                                    <i class="m-nav__link-icon far fa-check-square"></i>
                                                                    <span class="m-nav__link-text">Total Student: {{count(getStudentsIdByParentId($parentInfo->id))}} </span>
                                                                </div>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <div class="m-nav__link">
                                                                    <i class="m-nav__link-icon far fa-check-square"></i>
                                                                    <span class="m-nav__link-text">Status: @if($parentInfo->status == 1) Active @else Inactive @endif </span>
                                                                </div>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8 col-lg-7">
                                                <div class="m-portlet m-portlet--full-height">
                                                    <div class="p-3">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title">Father info</h5>
                                                                        <p class="card-text mb-1">Name : {{!empty($parentInfo->father_name)? $parentInfo->father_name: 'n/a'}}</p>
                                                                        <p class="card-text mb-1">Email Address : {{!empty($parentInfo->father_email)? $parentInfo->father_email: 'n/a'}}</p>
                                                                        <p class="card-text mb-1">Phone Number : {{!empty($parentInfo->father_phone)? $parentInfo->father_phone: 'n/a'}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 mt-3">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title">Mother Info</h5>
                                                                        <p class="card-text mb-1">Name : {{!empty($parentInfo->mother_name)? $parentInfo->mother_name: 'n/a'}}</p>
                                                                        <p class="card-text mb-1">Email Address : {{!empty($parentInfo->mother_email)? $parentInfo->mother_email: 'n/a'}}</p>
                                                                        <p class="card-text mb-1">Phone Number : {{!empty($parentInfo->mother_phone)? $parentInfo->mother_phone: 'n/a'}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 mt-3">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title">Property Info</h5>
                                                                        <p class="card-text mb-1">Who will finance during study : {{!empty($parentInfo->finance_during_study)? $parentInfo->finance_during_study: 'n/a'}}</p>
                                                                        <p class="card-text mb-1">Occupation : {{!empty($parentInfo->occupation)? $parentInfo->occupation: 'n/a'}}</p>
                                                                        <p class="card-text mb-1">Annual income : {{!empty($parentInfo->annual_income)? $parentInfo->annual_income: 'n/a'}} and  Insolvent grade : {{!empty($parentInfo->annual_income_grade)? $parentInfo->annual_income_grade: 'n/a'}}</p>
                                                                        <p class="card-text mb-1">Movable property : {{!empty($parentInfo->movable_property)? $parentInfo->movable_property: 'n/a'}} and Insolvent grade : {{!empty($parentInfo->movable_property_grade)? $parentInfo->movable_property_grade: 'n/a'}}</p>
                                                                        <p class="card-text mb-1">Immovable property : {{!empty($parentInfo->immovable_property)? $parentInfo->immovable_property: 'n/a'}} and Insolvent grade : {{!empty($parentInfo->immovable_property_grade)? $parentInfo->immovable_property_grade: 'n/a'}}</p>

                                                                        <p class="card-text mb-1">Total assets : {{!empty($parentInfo->total_asset)? $parentInfo->total_asset: 'n/a'}} and Insolvent grade : {{!empty($parentInfo->total_asset_grade)? $parentInfo->total_asset_grade: 'n/a'}}</p>
                                                                        <p class="card-text mb-1">Address : {{!empty($parentInfo->parent_address)? $parentInfo->parent_address: 'n/a'}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="student_into" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Student Name</th>
                                                            <th scope="col">Roll</th>
                                                            <th scope="col">Session</th>
                                                            <th scope="col">Course</th>
                                                            <th scope="col">Category</th>
                                                            <th scope="col">Phase</th>
                                                            <th scope="col">Status</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($parentInfo->students as $student)
                                                            <tr>
                                                                <th><a href="{{route('frontend.students.show', $student->id)}}" target="_blank">{{$student->full_name_en}}</a></th>
                                                                <td>{{$student->roll_no}}</td>
                                                                <td>{{$student->session->title}}</td>
                                                                <td>{{$student->course->title}}</td>
                                                                <td>{{$student->studentCategory->title}}</td>
                                                                <td>{{$student->phase->title}}</td>
                                                                <td>@if($student->status == 1) Active @else Inactive @endif</td>
                                                            </tr>
                                                        @endforeach
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

                    <!--end::Form-->
                </div>
            @endsection

            @push('scripts')

                <script>


                    $(document).ready(function() {

                        $('#nemc-general-form').validate({
                            rules:{
                                father_name: {
                                    required: true,
                                },
                                mother_name: {
                                    required: true,
                                },
                                father_phone: {
                                    required: true,
                                },
                                finance_during_study: {
                                    required: true,
                                },
                                annual_income: {
                                    required: true,
                                },
                            }
                        });

                        function getTotalAssets(){
                            annualIncome = ($('#annual_income').val().length > 0 )? $('#annual_income').val() : 0;
                            movableProperty = ($('#movable_property').val().length > 0 )? $('#movable_property').val() : 0;
                            immovableProperty = ($('#immovable_property').val().length > 0 )? $('#immovable_property').val() : 0;
                            totalAsset = parseInt(annualIncome) + parseInt(movableProperty) + parseInt(immovableProperty);

                            $('#total_asset').val(totalAsset.toFixed(2));
                        }

                        function getTotalAssetsPoints(){
                            annualIncomePoint = ($('#annual_income_grade').val().length > 0 )? $('#annual_income_grade').val() : 0;
                            movablePropertyPoint = ($('#movable_property_grade').val().length > 0 )? $('#movable_property_grade').val() : 0;
                            immovablePropertyPoint = ($('#immovable_property_grade').val().length > 0 )? $('#immovable_property_grade').val() : 0;
                            totalAssetPoint = parseInt(annualIncomePoint) + parseInt(movablePropertyPoint) + parseInt(immovablePropertyPoint);

                            $('#total_asset_grade').val(totalAssetPoint.toFixed(2));
                        }

                        $('#annual_income, #movable_property, #immovable_property').keyup(function (e) {
                            e.preventDefault();
                            getTotalAssets();
                        })

                        $('#annual_income_grade, #movable_property_grade, #immovable_property_grade').keyup(function (e) {
                            e.preventDefault();
                            getTotalAssetsPoints();
                        })




                    });
                </script>
            @endpush

        </div>
    </div>
@endsection

@push('scripts')

    <script>


        $(document).ready(function() {

            $('#nemc-general-form').validate({
                rules:{
                    father_name: {
                        required: true,
                    },
                    mother_name: {
                        required: true,
                    },
                    father_phone: {
                        required: true,
                    },
                    finance_during_study: {
                        required: true,
                    },
                    annual_income: {
                        required: true,
                    },
                }
            });

            function getTotalAssets(){
                annualIncome = ($('#annual_income').val().length > 0 )? $('#annual_income').val() : 0;
                movableProperty = ($('#movable_property').val().length > 0 )? $('#movable_property').val() : 0;
                immovableProperty = ($('#immovable_property').val().length > 0 )? $('#immovable_property').val() : 0;
                totalAsset = parseInt(annualIncome) + parseInt(movableProperty) + parseInt(immovableProperty);

                $('#total_asset').val(totalAsset.toFixed(2));
            }

            function getTotalAssetsPoints(){
                annualIncomePoint = ($('#annual_income_grade').val().length > 0 )? $('#annual_income_grade').val() : 0;
                movablePropertyPoint = ($('#movable_property_grade').val().length > 0 )? $('#movable_property_grade').val() : 0;
                immovablePropertyPoint = ($('#immovable_property_grade').val().length > 0 )? $('#immovable_property_grade').val() : 0;
                totalAssetPoint = parseInt(annualIncomePoint) + parseInt(movablePropertyPoint) + parseInt(immovablePropertyPoint);

                $('#total_asset_grade').val(totalAssetPoint.toFixed(2));
            }

            $('#annual_income, #movable_property, #immovable_property').keyup(function (e) {
                e.preventDefault();
                getTotalAssets();
            })

            $('#annual_income_grade, #movable_property_grade, #immovable_property_grade').keyup(function (e) {
                e.preventDefault();
                getTotalAssetsPoints();
            })




        });
    </script>
@endpush
