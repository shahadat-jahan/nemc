@extends('layouts.default')
@section('pageTitle', 'Edit Parent\'s Information')

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>Edit Parent's Information</h3>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/guardians/' .$parentInfo->id) }}" id="nemc-general-form" method="post">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">
                <input type="hidden" id="student-category" name="student_category_id" value="{{$parentInfo->students[0]->student_category_id}}"/>
                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('father_name') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span>Father's name </label>
                            <input type="text" class="form-control m-input" name="father_name" value="{{$parentInfo->father_name}}" placeholder="Father's name"/>
                            @if ($errors->has('father_name'))
                                <div class="form-control-feedback">{{ $errors->first('father_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('mother_name') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Mother's name </label>
                            <input type="text" class="form-control m-input" name="mother_name" value="{{$parentInfo->mother_name}}" placeholder="Mother's name"/>
                            @if ($errors->has('mother_name'))
                                <div class="form-control-feedback">{{ $errors->first('mother_name') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('father_phone') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span>Father's phone number </label>
                            <input type="text" class="form-control m-input" name="father_phone" value="{{$parentInfo->father_phone}}" placeholder="Father's phone number"/>
                            @if ($errors->has('father_phone'))
                                <div class="form-control-feedback">{{ $errors->first('father_phone') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('mother_phone') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> Mother's phone number </label>
                            <input type="text" class="form-control m-input" name="mother_phone" value="{{$parentInfo->mother_phone}}" placeholder="Mother's phone number"/>
                            @if ($errors->has('mother_phone'))
                                <div class="form-control-feedback">{{ $errors->first('mother_phone') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('father_email') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Father's email </label>
                            <input type="text" class="form-control m-input" name="father_email" value="{{$parentInfo->father_email}}" placeholder="Father's email"/>
                            @if ($errors->has('father_email'))
                                <div class="form-control-feedback">{{ $errors->first('father_email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('mother_email') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> Mother's email </label>
                            <input type="text" class="form-control m-input" name="mother_email" value="{{$parentInfo->mother_email}}" placeholder="Mother's email"/>
                            @if ($errors->has('mother_email'))
                                <div class="form-control-feedback">{{ $errors->first('mother_email') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('occupation') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Occupation </label>
                            <input type="text" class="form-control m-input" name="occupation" value="{{$parentInfo->occupation}}" placeholder="Occupation"/>
                            @if ($errors->has('occupation'))
                                <div class="form-control-feedback">{{ $errors->first('occupation') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('finance_during_study') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> <span class="text-danger">*</span>Who will finance during study </label>
                            <input type="text" class="form-control m-input" name="finance_during_study" value="{{$parentInfo->finance_during_study}}" placeholder="Finance during study"/>
                            @if ($errors->has('finance_during_study'))
                                <div class="form-control-feedback">{{ $errors->first('finance_during_study') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('annual_income') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span>Annual income </label>
                            <input type="text" class="form-control m-input" name="annual_income" value="{{abs($parentInfo->annual_income)}}" id="annual_income" placeholder="Annual income"/>
                            @if ($errors->has('annual_income'))
                                <div class="form-control-feedback">{{ $errors->first('annual_income') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('annual_income_grade') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> Insolvent grade </label>
                            <input type="text" class="form-control m-input" name="annual_income_grade" id="annual_income_grade" value="{{$parentInfo->annual_income_grade}}" placeholder="Insolvent grade for annual income"/>
                            @if ($errors->has('annual_income_grade'))
                                <div class="form-control-feedback">{{ $errors->first('annual_income_grade') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('movable_property') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Movable property </label>
                            <input type="text" class="form-control m-input" name="movable_property" id="movable_property" value="{{($parentInfo->movable_property)}}" placeholder="Movable property"/>
                            @if ($errors->has('movable_property'))
                                <div class="form-control-feedback">{{ $errors->first('movable_property') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('movable_property_grade') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> Insolvent grade </label>
                            <input type="text" class="form-control m-input" name="movable_property_grade" id="movable_property_grade" value="{{$parentInfo->movable_property_grade}}" placeholder="Insolvent grade for movable property"/>
                            @if ($errors->has('movable_property_grade'))
                                <div class="form-control-feedback">{{ $errors->first('movable_property_grade') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('immovable_property') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Immovable property </label>
                            <input type="text" class="form-control m-input" name="immovable_property" id="immovable_property" value="{{($parentInfo->immovable_property)}}" placeholder="Immovable property"/>
                            @if ($errors->has('immovable_property'))
                                <div class="form-control-feedback">{{ $errors->first('immovable_property') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('immovable_property_grade') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> Insolvent grade </label>
                            <input type="text" class="form-control m-input" name="immovable_property_grade" id="immovable_property_grade" value="{{$parentInfo->immovable_property_grade}}" placeholder="Insolvent grade for immovable property"/>
                            @if ($errors->has('immovable_property_grade'))
                                <div class="form-control-feedback">{{ $errors->first('immovable_property_grade') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('total_asset') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Total assets </label>
                            <input type="text" class="form-control m-input" name="total_asset" id="total_asset" value="{{abs($parentInfo->total_asset)}}" placeholder="Total assets" readonly/>
                            @if ($errors->has('total_asset'))
                                <div class="form-control-feedback">{{ $errors->first('total_asset') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('total_asset_grade') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> Total insolvent grade </label>
                            <input type="text" class="form-control m-input" name="total_asset_grade" id="total_asset_grade" value="{{$parentInfo->total_asset_grade}}" placeholder="Total insolvent grade"/>
                            @if ($errors->has('total_asset_grade'))
                                <div class="form-control-feedback">{{ $errors->first('total_asset_grade') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group {{ $errors->has('parent_address') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Address </label>
                            <textarea class="form-control m-input" name="parent_address" rows="3" placeholder="Address">{{$parentInfo->address}}</textarea>
                            @if ($errors->has('parent_address'))
                                <div class="form-control-feedback">{{ $errors->first('parent_address') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/payment_type') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')

    <script>


        $(document).ready(function() {
            // Add custom validation method for father mobile number
            $.validator.addMethod("validFatherMobile", function(value, element) {
                // Check for at least one non-zero digit and a minimum length of 11 digits
                // Check the student category (you need to replace 'isStudentNormal' with your actual check)
                var isStudentNormal = $('#student-category').val();  // Replace this with your actual logic to determine the category


                // Define regular expressions based on the student category
                var normalCategoryRegex = /^(?=.*[1-9])[0-9]{11}$/;
                var otherCategoryRegex = /^\+(?:\d{1,3}[-.\s])?\(?\d{1,4}\)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/;  // Replace this with your other regex
                // Use the appropriate regex based on the student category
                var regexToUse = isStudentNormal != 2 ? normalCategoryRegex : otherCategoryRegex;
                // Test the value against the selected regex
                return regexToUse.test(value);
            }, "Please enter a valid mobile number.");
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
                        validFatherMobile: true,
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
