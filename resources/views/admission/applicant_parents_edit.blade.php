<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('father_name') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span>Father's name </label>
            <input type="text" class="form-control m-input" name="father_name" value="{{$applicant->admissionParent->father_name}}" placeholder="Father's name"/>
            @if ($errors->has('father_name'))
                <div class="form-control-feedback">{{ $errors->first('father_name') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('mother_name') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Mother's name </label>
            <input type="text" class="form-control m-input" name="mother_name" value="{{$applicant->admissionParent->mother_name}}" placeholder="Mother's name"/>
            @if ($errors->has('mother_name'))
                <div class="form-control-feedback">{{ $errors->first('mother_name') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('father_phone') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span>Father's phone number </label>
            <input type="text" class="form-control m-input" name="father_phone" value="{{$applicant->admissionParent->father_phone}}" placeholder="Father's phone number"/>
            @if ($errors->has('father_phone'))
                <div class="form-control-feedback">{{ $errors->first('father_phone') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('mother_phone') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Mother's phone number </label>
            <input type="text" class="form-control m-input" name="mother_phone" value="{{$applicant->admissionParent->mother_phone}}" placeholder="Mother's phone number"/>
            @if ($errors->has('mother_phone'))
                <div class="form-control-feedback">{{ $errors->first('mother_phone') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('father_email') ? 'has-danger' : '' }}">
            <label class="form-control-label">Father's email </label>
            <input type="text" class="form-control m-input" name="father_email" value="{{$applicant->admissionParent->father_email}}" placeholder="Father's email"/>
            @if ($errors->has('father_email'))
                <div class="form-control-feedback">{{ $errors->first('father_email') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('mother_email') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Mother's email </label>
            <input type="text" class="form-control m-input" name="mother_email" value="{{$applicant->admissionParent->mother_email}}" placeholder="Mother's email"/>
            @if ($errors->has('mother_email'))
                <div class="form-control-feedback">{{ $errors->first('mother_email') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('occupation') ? 'has-danger' : '' }}">
            <label class="form-control-label">Occupation </label>
            <input type="text" class="form-control m-input" name="occupation" value="{{$applicant->admissionParent->occupation}}" placeholder="Occupation"/>
            @if ($errors->has('occupation'))
                <div class="form-control-feedback">{{ $errors->first('occupation') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('finance_during_study') ? 'has-danger' : '' }}">
            <label class="form-control-label"> <span class="text-danger">*</span>Who will finance during study </label>
            <input type="text" class="form-control m-input" name="finance_during_study" value="{{$applicant->admissionParent->finance_during_study}}" placeholder="Finance during study"/>
            @if ($errors->has('finance_during_study'))
                <div class="form-control-feedback">{{ $errors->first('finance_during_study') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('annual_income') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span>Annual income </label>
            <input type="text" class="form-control m-input" name="annual_income" value="{{abs($applicant->admissionParent->annual_income)}}" id="annual_income" placeholder="Annual income"/>
            @if ($errors->has('annual_income'))
                <div class="form-control-feedback">{{ $errors->first('annual_income') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('annual_income_grade') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Insolvent grade </label>
            <input type="text" class="form-control m-input" name="annual_income_grade" id="annual_income_grade" value="{{$applicant->admissionParent->annual_income_grade}}" placeholder="Insolvent grade for annual income"/>
            @if ($errors->has('annual_income_grade'))
                <div class="form-control-feedback">{{ $errors->first('annual_income_grade') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('movable_property') ? 'has-danger' : '' }}">
            <label class="form-control-label">Movable property </label>
            <input type="text" class="form-control m-input" name="movable_property" id="movable_property" value="{{abs($applicant->admissionParent->movable_property)}}" placeholder="Movable property"/>
            @if ($errors->has('movable_property'))
                <div class="form-control-feedback">{{ $errors->first('movable_property') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('movable_property_grade') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Insolvent grade </label>
            <input type="text" class="form-control m-input" name="movable_property_grade" id="movable_property_grade" value="{{$applicant->admissionParent->movable_property_grade}}" placeholder="Insolvent grade for movable property"/>
            @if ($errors->has('movable_property_grade'))
                <div class="form-control-feedback">{{ $errors->first('movable_property_grade') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('immovable_property') ? 'has-danger' : '' }}">
            <label class="form-control-label">Immovable property </label>
            <input type="text" class="form-control m-input" name="immovable_property" id="immovable_property" value="{{abs($applicant->admissionParent->immovable_property)}}" placeholder="Immovable property"/>
            @if ($errors->has('immovable_property'))
                <div class="form-control-feedback">{{ $errors->first('immovable_property') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('immovable_property_grade') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Insolvent grade </label>
            <input type="text" class="form-control m-input" name="immovable_property_grade" id="immovable_property_grade" value="{{$applicant->admissionParent->immovable_property_grade}}" placeholder="Insolvent grade for immovable property"/>
            @if ($errors->has('immovable_property_grade'))
                <div class="form-control-feedback">{{ $errors->first('immovable_property_grade') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('total_asset') ? 'has-danger' : '' }}">
            <label class="form-control-label">Total assets </label>
            <input type="text" class="form-control m-input" name="total_asset" id="total_asset" value="{{abs($applicant->admissionParent->total_asset)}}" placeholder="Total assets" readonly/>
            @if ($errors->has('total_asset'))
                <div class="form-control-feedback">{{ $errors->first('total_asset') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('total_asset_grade') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Total insolvent grade </label>
            <input type="text" class="form-control m-input" name="total_asset_grade" id="total_asset_grade" value="{{$applicant->admissionParent->total_asset_grade}}" placeholder="Total insolvent grade" readonly/>
            @if ($errors->has('total_asset_grade'))
                <div class="form-control-feedback">{{ $errors->first('total_asset_grade') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="form-group  m-form__group {{ $errors->has('parent_address') ? 'has-danger' : '' }}">
            <label class="form-control-label">Address </label>
            <textarea class="form-control m-input" name="parent_address" rows="3" placeholder="Address">{{$applicant->admissionParent->address}}</textarea>
            @if ($errors->has('parent_address'))
                <div class="form-control-feedback">{{ $errors->first('parent_address') }}</div>
            @endif
        </div>
    </div>
</div>
