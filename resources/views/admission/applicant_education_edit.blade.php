<?php
$sscInfo = $applicant->admissionEducationHistories->first();
$hscInfo = $applicant->admissionEducationHistories->last();
?>
<div class="m-form__heading">
    <h3 class="m-form__heading-title">SSS/Similar</h3>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('education_level') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Examination </label>
            <select class="form-control m-input" name="education_level_ssc" id="education-level-ssc">
                <option value="">---- Select ----</option>
                {!! select($certifications, $sscInfo->education_level) !!}
            </select>
            @if ($errors->has('education_level'))
                <div class="form-control-feedback">{{ $errors->first('education_level') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('education_board_id') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Education Board </label>
            <select class="form-control m-input" name="education_board_id_ssc">
                <option value="">---- Select ----</option>
                {!! select($educationBoards, $sscInfo->education_board_id) !!}
            </select>
            @if ($errors->has('education_board_id'))
                <div class="form-control-feedback">{{ $errors->first('education_board_id') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('institution') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Institution </label>
            <input type="text" class="form-control m-input" name="institution_ssc" value="{{$sscInfo->institution}}" placeholder="Institution"/>
            @if ($errors->has('institution'))
                <div class="form-control-feedback">{{ $errors->first('institution') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('pass_year_ssc') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Year of passing </label>
            <input type="text" class="form-control m-input m_year_picker" name="pass_year_ssc"
                   value="{{$sscInfo->pass_year}}">
            @if ($errors->has('pass_year_ssc'))
                <div class="form-control-feedback">{{ $errors->first('pass_year_ssc') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('gpa') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> GPA </label>
            <input type="number" min="1" max="5" class="form-control m-input" name="gpa_ssc" value="{{$sscInfo->gpa}}" placeholder="GPA"/>
            @if ($errors->has('gpa'))
                <div class="form-control-feedback">{{ $errors->first('gpa') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('gpa_biology') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> GPA in Biology </label>
            <input type="number" min="1" max="5" class="form-control m-input" name="gpa_biology_ssc" value="{{$sscInfo->gpa_biology}}" placeholder="GPA in Biology"/>
            @if ($errors->has('gpa_biology'))
                <div class="form-control-feedback">{{ $errors->first('gpa_biology') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="form-group m-form__group {{ $errors->has('extra_activity') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Extra Curriculam Activity </label>
            <input type="text" class="form-control m-input" name="extra_activity_ssc" value="{{$sscInfo->extra_activity}}" placeholder="Extra Curriculam Activity"/>
            @if ($errors->has('extra_activity'))
                <div class="form-control-feedback">{{ $errors->first('extra_activity') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="m-separator m-separator--dashed m-separator--lg"></div>
<div class="m-form__heading">
    <h3 class="m-form__heading-title">HSC/Similar</h3>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('education_level') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Examination </label>
            <select class="form-control m-input" name="education_level_hsc" id="education-level-hsc">
                <option value="">---- Select ----</option>
                {!! select($certifications, $hscInfo->education_level) !!}
            </select>
            @if ($errors->has('education_level'))
                <div class="form-control-feedback">{{ $errors->first('education_level') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('education_board_id') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Education Board </label>
            <select class="form-control m-input" name="education_board_id_hsc">
                <option value="">---- Select ----</option>
                {!! select($educationBoards, $hscInfo->education_board_id) !!}
            </select>
            @if ($errors->has('education_board_id'))
                <div class="form-control-feedback">{{ $errors->first('education_board_id') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('institution') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Institution </label>
            <input type="text" class="form-control m-input" name="institution_hsc" value="{{$hscInfo->institution}}" placeholder="Institution"/>
            @if ($errors->has('institution'))
                <div class="form-control-feedback">{{ $errors->first('institution') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('pass_year_hsc') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Year of passing </label>
            <input type="text" class="form-control m-input m_year_picker" name="pass_year_hsc"
                   value="{{$hscInfo->pass_year}}">
            @if ($errors->has('pass_year_hsc'))
                <div class="form-control-feedback">{{ $errors->first('pass_year_hsc') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('gpa') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> GPA </label>
            <input type="number" min="1" max="5" class="form-control m-input" name="gpa_hsc" value="{{$hscInfo->gpa}}" placeholder="GPA"/>
            @if ($errors->has('gpa'))
                <div class="form-control-feedback">{{ $errors->first('gpa') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group m-form__group {{ $errors->has('gpa_biology') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> GPA in Biology </label>
            <input type="number" min="1" max="5" class="form-control m-input" name="gpa_biology_hsc" value="{{$hscInfo->gpa_biology}}" placeholder="GPA in Biology"/>
            @if ($errors->has('gpa_biology'))
                <div class="form-control-feedback">{{ $errors->first('gpa_biology') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="form-group m-form__group {{ $errors->has('extra_activity') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Extra Curriculam Activity </label>
            <input type="text" class="form-control m-input" name="extra_activity_hsc" value="{{$hscInfo->extra_activity}}" placeholder="Extra Curriculam Activity"/>
            @if ($errors->has('extra_activity'))
                <div class="form-control-feedback">{{ $errors->first('extra_activity') }}</div>
            @endif
        </div>
    </div>
</div>
