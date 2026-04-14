@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        .hide{
            display: none;
        }
    </style>
    @endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul pr-2"></i>Application Settings</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        {{--<a href="" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-edit pr-2"></i>Application Setting</a>--}}
                        <button type="button" class="btn btn-primary m-btn m-btn--icon appSettingBtn" data-setting-id="{{$applicationInfo->id}}" title="Edit Application Setting">
                            <i class="fas fa-edit pr-2" aria-hidden="true"></i>Application Settings
                        </button>
                    </div>

                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <div class="card customer-info-details user-info-text-container">
                            <h5 class="card-header">Featured</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="media">
                                            {{--<img src="..." class="mr-3" alt="...">--}}
                                            <i class="fas fa-tags fa-2x"></i>
                                            <div class="media-body pl-3">
                                                <h5 class="mb-0">Name</h5>
                                                <p class="text-muted">{{$applicationInfo->title}}</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="media">
                                            <i class="fas fa-mobile-alt fa-2x"></i>
                                            <div class="media-body pl-3">
                                                <h5 class="mb-0">Phone</h5>
                                                <p class="text-muted">{{$applicationInfo->phone}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="media">
                                            <i class="far fa-envelope fa-2x"></i>
                                            <div class="media-body pl-3">
                                                <h5 class="mb-0">Email</h5>
                                                <p class="text-muted">{{$applicationInfo->email}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-5">
                                        <div class="media">
                                            <i class="fas fa-map-marker-alt fa-2x"></i>
                                            <div class="media-body pl-3">
                                                <h5 class="mb-0">Address</h5>
                                                <p class="text-muted">{{$applicationInfo->address}}</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="media">
                                            <i class="fas fa-graduation-cap fa-2x"></i>
                                            <div class="media-body pl-3">
                                                <h5 class="mb-0">Pass Marks</h5>
                                                <p class="pt-1">{{$applicationInfo->pass_mark}} %</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="media">
                                            <i class="fas fa-address-book fa-2x"></i>
                                            <div class="media-body pl-3">
                                                <h5 class="mb-0">Item Exam Marks</h5>
                                                <p class="pt-1">{{$applicationInfo->item_exam_mark}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <div class="media">
                                            <i class="fas fa-check fa-2x"></i>
                                            <div class="media-body pl-3">
                                                <h5 class="mb-0">Status</h5>
                                                <p class="pt-1">@if($applicationInfo->status == 1) Active @else Inactive @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card application-setting hide">
                            <h5 class="card-header">Featured</h5>
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <form action="{{ route('application.setting.update', [$applicationInfo->id])  }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                                                            <label class="form-control-label"><span class="text-danger">*</span> Name</label>
                                                            <input type="text" class="form-control m-input" name="title" value="{{ old('title', $applicationInfo->title) }}" placeholder="Name"/>
                                                            <span>
                                                            @if ($errors->has('title'))
                                                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                                                             @endif
                                                    </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label>Phone</label>
                                                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $applicationInfo->phone) }}" placeholder="phone"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="text" class="form-control" name="email" value="{{ old('email', $applicationInfo->email) }}" placeholder="email"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <input type="text" class="form-control" name="address" value="{{ old('address', $applicationInfo->address) }}" placeholder="address"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label> Pass Marks in Percentage (%) :</label>
                                                            <input type="text" class="form-control" name="pass_mark" value="{{ old('pass_mark', $applicationInfo->pass_mark) }}" placeholder="Pass Marks"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label> Item Exam Marks :</label>
                                                            <input type="text" class="form-control" name="item_exam_mark" value="{{ old('item_exam_mark', $applicationInfo->item_exam_mark) }}" placeholder="Item Exam Marks"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label> Status</label>
                                                            <select class="form-control m-input " name="status">
                                                                <option value="1" {{ $applicationInfo->status == 1  ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ $applicationInfo->status == 0  ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-actions">
                                                    <div class="m-portlet__foot m-portlet__foot--fit">
                                                        <div class="m-form__actions text-center  mt-4">
                                                            <button class="btn btn btn-outline-brand form-cancel-btn"><i class="fa fa-times"></i> Cancel</button>
                                                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

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
@push('scripts')
    <script>
        $(".appSettingBtn").click(function(){
            $(".user-info-text-container").addClass("hide");
            $(".application-setting").removeClass("hide");
        });

        $(".form-cancel-btn").click(function(e){
            e.preventDefault();
            $(".user-info-text-container").removeClass("hide");
            $(".application-setting").addClass("hide");
        });
    </script>
@endpush
