<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('nationality') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Nationality </label>
            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="nationality" data-live-search="true">
                <option value="">---- Select ----</option>
                {!! select($countries, $student->nationality) !!}
            </select>
            @if ($errors->has('nationality'))
                <div class="form-control-feedback">{{ $errors->first('nationality') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('place_of_birth') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Place of birth </label>
            <input type="text" class="form-control m-input" name="place_of_birth" value="{{$student->place_of_birth}}" placeholder="Place of birth"/>
            @if ($errors->has('place_of_birth'))
                <div class="form-control-feedback">{{ $errors->first('place_of_birth') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('mother_tongue') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Mother tongue </label>
            <input type="text" class="form-control m-input" name="mother_tongue" value="{{$student->mother_tongue}}" placeholder="Mother tongue"/>
            @if ($errors->has('mother_tongue'))
                <div class="form-control-feedback">{{ $errors->first('mother_tongue') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('knowledge_english') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Knowledge of English </label>
            <input type="text" class="form-control m-input" name="knowledge_english" value="{{$student->knowledge_english}}" placeholder="Knowledge of English"/>
            @if ($errors->has('knowledge_english'))
                <div class="form-control-feedback">{{ $errors->first('knowledge_english') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="form-group  m-form__group {{ $errors->has('permanent_address') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Permanent address </label>
            <textarea class="form-control m-input" name="permanent_address" id="st-permanent-addr" rows="3" placeholder="Permanent address">{{$student->permanent_address}}</textarea>
            @if ($errors->has('permanent_address'))
                <div class="form-control-feedback">{{ $errors->first('permanent_address') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="form-group  m-form__group {{ $errors->has('present_address') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Present address </label>
            <div class="m-checkbox-list">
                <label class="m-checkbox">
                    <input type="checkbox" name="same_as_present" id="same_as_present" value="1" {{($student->same_as_permanent) ? 'checked' : ''}}> Same as permanent address
                    <span></span>
                </label>
            </div>
            <textarea class="form-control m-input" name="present_address" id="st-present-addr" rows="3" placeholder="Present address" {{($student->same_as_permanent) ? 'readonly' : ''}}>{{$student->present_address}}</textarea>
            @if ($errors->has('present_address'))
                <div class="form-control-feedback">{{ $errors->first('present_address') }}</div>
            @endif
        </div>
    </div>
</div>
