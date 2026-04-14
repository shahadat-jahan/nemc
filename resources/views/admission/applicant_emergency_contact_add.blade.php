<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('emergency_contact_name') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Name </label>
            <input type="text" class="form-control m-input" name="emergency_contact_name" placeholder="Name"/>
            @if ($errors->has('emergency_contact_name'))
                <div class="form-control-feedback">{{ $errors->first('emergency_contact_name') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('emergency_contact_relation') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Relation </label>
            <input type="text" class="form-control m-input" name="emergency_contact_relation" placeholder="Relation"/>
            @if ($errors->has('emergency_contact_relation'))
                <div class="form-control-feedback">{{ $errors->first('emergency_contact_relation') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('emergency_phone') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Phone </label>
            <input type="text" class="form-control m-input" name="emergency_phone" placeholder="Phone"/>
            @if ($errors->has('emergency_phone'))
                <div class="form-control-feedback">{{ $errors->first('emergency_phone') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('emergency_email') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Email </label>
            <input type="text" class="form-control m-input" name="emergency_email" placeholder="Email"/>
            @if ($errors->has('emergency_email'))
                <div class="form-control-feedback">{{ $errors->first('emergency_email') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="form-group  m-form__group {{ $errors->has('emergency_address') ? 'has-danger' : '' }}">
            <label class="form-control-label">Address </label>
            <textarea class="form-control m-input" name="emergency_address" rows="3" placeholder="Address"></textarea>
            @if ($errors->has('emergency_address'))
                <div class="form-control-feedback">{{ $errors->first('emergency_address') }}</div>
            @endif
        </div>
    </div>
</div>
