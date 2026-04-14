@php
    $disabled = Auth::user()->user_group_id === 1 ? '' : 'disabled';
@endphp
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Admission Session </label>
            <select class="form-control m-input" name="session_id" id="session_id" {{$disabled}}>
                <option value="">---- Select ----</option>
                {!! select($sessions, $student->session_id) !!}
            </select>
            @if ($errors->has('session_id'))
                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Present Session </label>
            <select class="form-control m-input" name="followed_by_session_id" id="followed_by_session_id">
                <option value="">---- Select ----</option>
                {!! select($sessions, $student->followed_by_session_id) !!}
            </select>
            @if ($errors->has('session_id'))
                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
            <select class="form-control m-input" name="course_id" id="course_id">
                <option value="">---- Select ----</option>
                {!! select($courses, $student->course_id) !!}
            </select>
            @if ($errors->has('course_id'))
                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('student_category_id') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Student category </label>
            <select class="form-control m-input" name="student_category_id" id="student-category">
                <option value="">---- Select ----</option>
                {!! select($studentCategories, $student->student_category_id) !!}
            </select>
            @if ($errors->has('student_category_id'))
                <div class="form-control-feedback">{{ $errors->first('student_category_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('admission_year') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Admission year </label>
            <input type="text" class="form-control m-input m_year_picker" name="admission_year"
                   value="{{ old('admission_year', $student->admission_year) }}" readonly/>
            @if ($errors->has('admission_year'))
                <div class="form-control-feedback">{{ $errors->first('admission_year') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('full_name_en') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Full name (english) </label>
            <input type="text" class="form-control m-input" name="full_name_en" value="{{$student->full_name_en}}"
                   placeholder="Full name"/>
            @if ($errors->has('full_name_en'))
                <div class="form-control-feedback">{{ $errors->first('full_name_en') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('full_name_bn') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Full name (বাংলা) </label>
            <input type="text" class="form-control m-input" name="full_name_bn" value="{{$student->full_name_bn}}"
                   placeholder="Full name"/>
            @if ($errors->has('full_name_bn'))
                <div class="form-control-feedback">{{ $errors->first('full_name_bn') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('form_fillup_date') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Form fillup date </label>
            <input type="text" class="form-control m-input m_datepicker_1" value="{{$student->form_fillup_date}}"
                   name="form_fillup_date" placeholder="Form Fillup Date"/>
            @if ($errors->has('form_fillup_date'))
                <div class="form-control-feedback">{{ $errors->first('form_fillup_date') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('commenced_year') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Commenced year </label>
            <input type="text" class="form-control m-input m_year_picker" name="commenced_year"
                   value="{{ old('commenced_year', $student->commenced_year) }}" readonly/>
            @if ($errors->has('commenced_year'))
                <div class="form-control-feedback">{{ $errors->first('commenced_year') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('test_score') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Test score </label>
            <input type="text" class="form-control m-input" name="test_score" value="{{$student->test_score}}"
                   placeholder="Test score"/>
            @if ($errors->has('test_score'))
                <div class="form-control-feedback">{{ $errors->first('test_score') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('merit_score') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Merit score </label>
            <input type="text" class="form-control m-input" name="merit_score" value="{{$student->merit_score}}"
                   placeholder="Merit score"/>
            @if ($errors->has('merit_score'))
                <div class="form-control-feedback">{{ $errors->first('merit_score') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('merit_position') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Merit position </label>
            <input type="text" class="form-control m-input" name="merit_position" value="{{$student->merit_position}}"
                   placeholder="Merit position"/>
            @if ($errors->has('merit_position'))
                <div class="form-control-feedback">{{ $errors->first('merit_position') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('admission_roll_no') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Admission roll no </label>
            <input type="text" class="form-control m-input" name="admission_roll_no"
                   value="{{$student->admission_roll_no}}" id="admission_roll_no" placeholder="Admission roll no"/>
            @if ($errors->has('admission_roll_no'))
                <div class="form-control-feedback">{{ $errors->first('admission_roll_no') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('reg_no') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Registration number </label>
            <input type="text" class="form-control m-input" value="{{$student->reg_no ?? ''}}" name="reg_no" id="reg_no"
                   placeholder="Registration number"/>
            @if ($errors->has('reg_no'))
                <div class="form-control-feedback text-danger">{{ $errors->first('reg_no') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('student_id') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Student ID </label>
            <input type="text" class="form-control m-input" name="student_id" id="student_id"
                   value="{{$student->student_id}}" placeholder="Student ID" readonly/>
            <span class="m-form__help text-danger">You cannot edit student id</span>
            @if ($errors->has('student_id'))
                <div class="form-control-feedback">{{ $errors->first('student_id') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('roll_no') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Roll No </label>
            <input type="text" class="form-control m-input" name="roll_no" value="{{$student->roll_no}}" id="roll_no"
                   placeholder="Roll number"/>
            @if ($errors->has('roll_no'))
                <div class="form-control-feedback">{{ $errors->first('roll_no') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('date_of_birth') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Date of birth </label>
            <input type="text" class="form-control m-input m_datepicker_1" name="date_of_birth"
                   value="{{$student->date_of_birth}}" placeholder="Date of birth"/>
            @if ($errors->has('date_of_birth'))
                <div class="form-control-feedback">{{ $errors->first('date_of_birth') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('gender') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Gender </label>
            <div class="m-radio-inline">
                <label class="m-radio">
                    <input type="radio" name="gender" value="male" {{($student->gender == 'male' ? 'checked' : '')}}>
                    Male
                    <span></span>
                </label>
                <label class="m-radio">
                    <input type="radio" name="gender"
                           value="female" {{($student->gender == 'female' ? 'checked' : '')}}> Female
                    <span></span>
                </label>
            </div>
            @if ($errors->has('gender'))
                <div class="form-control-feedback">{{ $errors->first('gender') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('blood_group') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Blood group </label>
            <input type="text" class="form-control m-input" name="blood_group" value="{{$student->blood_group}}"
                   placeholder="Blood group"/>
            @if ($errors->has('blood_group'))
                <div class="form-control-feedback">{{ $errors->first('blood_group') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('personal_remarks') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Remarks </label>
            <input type="text" class="form-control m-input" name="personal_remarks" value="{{$student->remarks}}"
                   placeholder="Remarks"/>
            @if ($errors->has('personal_remarks'))
                <div class="form-control-feedback">{{ $errors->first('personal_remarks') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('phone') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Phone </label>
            <input type="text" class="form-control m-input" name="phone" value="{{$student->phone}}"
                   placeholder="Phone"/>
            @if ($errors->has('phone'))
                <div class="form-control-feedback">{{ $errors->first('phone') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('mobile') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Mobile </label>
            <input type="text" class="form-control m-input" name="mobile" id="mobile" value="{{$student->mobile}}"
                   placeholder="Mobile"/>
            @if ($errors->has('mobile'))
                <div class="form-control-feedback">{{ $errors->first('mobile') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('email') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Email </label>
            <input type="text" class="form-control m-input" name="email" value="{{$student->email}}" id="email"
                   placeholder="Email"/>
            @if ($errors->has('email'))
                <div class="form-control-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('phase_id') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Phase </label>
            <select class="form-control m-input" name="phase_id" id="phase_id">
                <option value="">---- Select ----</option>
                {!! select($phases, $student->phase_id) !!}
            </select>

            @if ($errors->has('phase_id'))
                <div class="form-control-feedback">{{ $errors->first('phase_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('term_id') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Term </label>
            <select class="form-control m-input" name="term_id" id="term_id">
                <option value="">---- Select ----</option>
                {!! select($terms, $student->term_id) !!}
            </select>
            @if ($errors->has('term_id'))
                <div class="form-control-feedback">{{ $errors->first('term_id') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('batch_type_id') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Batch </label>
            <select class="form-control m-input" name="batch_type_id" id="batch_type_id">
                <option value="">---- Select ----</option>
                {!! select($batches, $student->batch_type_id) !!}
            </select>

            @if ($errors->has('batch_type_id'))
                <div class="form-control-feedback">{{ $errors->first('batch_type_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('status') ? 'has-danger' : '' }}">
            <label class="form-control-label"><span class="text-danger">*</span> Status </label>
            <select class="form-control m-input" name="status" id="status">
                <option value="">---- Select ----</option>
                {!! select($studentStatus, $student->status) !!}
            </select>

            @if ($errors->has('batch_type_id'))
                <div class="form-control-feedback">{{ $errors->first('batch_type_id') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4 foreign-row m--hide">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 foreign-row m--hide">
        <div class="form-group  m-form__group {{ $errors->has('embassy_contact_no') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Embassy Contact Number </label>
            <input type="text" class="form-control m-input" name="embassy_contact_no"
                   value="{{$student->embassy_contact_no}}" placeholder="Embassy Contact Number"/>
            @if ($errors->has('embassy_contact_no'))
                <div class="form-control-feedback">{{ $errors->first('embassy_contact_no') }}</div>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('passport_number') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Passport number </label>
            <input type="text" class="form-control m-input" name="passport_number" value="{{$student->passport_number}}"
                   placeholder="Passport number"/>
            @if ($errors->has('passport_number'))
                <div class="form-control-feedback">{{ $errors->first('passport_number') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row pl-4 pr-4 foreign-row m--hide">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group {{ $errors->has('visa_duration') ? 'has-danger' : '' }}">
            <label class="form-control-label"> Visa duration </label>
            <input type="text" class="form-control m-input" name="visa_duration" value="{{$student->visa_duration}}"
                   placeholder="Visa duration"/>
            @if ($errors->has('visa_duration'))
                <div class="form-control-feedback">{{ $errors->first('visa_duration') }}</div>
            @endif
        </div>
    </div>
</div>
