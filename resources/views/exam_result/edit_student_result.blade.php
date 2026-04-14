<?php
$student = $examResult->first()->student;
?>
    <div class="row no-gutters">
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group  m-form__group">
                <label class="form-control-label"><b>Roll No</b> </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
            <div class="form-group  m-form__group"><b>{{$student->roll_no}}</b></div>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group  m-form__group">
                <label class="form-control-label"><b>Name</b> </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
            <div class="form-group  m-form__group"><b>{{$student->full_name_en}}</b></div>
        </div>
    </div>
@php
    $fail = $examResult->where('result_status', 'Fail')->count();
    $absent = $examResult->where('pass_status', 4)->count();
    $grace = $examResult->where('pass_status', 3)->count();
    $specialPass = $examResult->where('special_status', 1)->count();
    $specialFail = $examResult->where('special_status', 2)->count();
    if ($fail > 0){
        $absent > 0 ? $resultStatus = 'Absent' : $resultStatus = 'Fail';
    }else{
        $grace > 0 ? $resultStatus = 'Pass(Grace)' : $resultStatus = 'Pass';
    }
$comment = $examResult->first()->remarks;
@endphp
    @foreach($examResult as $result)
        <div class="row no-gutters">
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                <div class="form-group  m-form__group">
                    <label class="form-control-label">{{$result->examSubjectMark->examSubType->examType->title}}</label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <div class="form-group  m-form__group">
                    {{$result->examSubjectMark->examSubType->title}}({{$result->examSubjectMark->total_marks}})
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <div class="form-group  m-form__group">
                    <input type="number" class="form-control m-input sub_type_mark" min="0" max="{{$result->examSubjectMark->total_marks}}" name="sub_type_mark[{{$result->id}}]"
                           value="{{$result->marks}}" autocomplete="off"/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <div class="form-group  m-form__group">
                    <div class="input-group parent-wrapper">
                        <div class="input-group-prepend" title="Check the checkbox to enter mark">
                            <div class="input-group-text">
                                <input type="checkbox" class="grace-remark-status" name="grace-remark-status[{{$result->id}}]"
                                       aria-label="Checkbox for following text input" {{$result->grace_marks > 0 ? 'checked' : ''}}>
                            </div>
                        </div>
                        <input type="number" name="grace_marks[{{$result->id}}]" class="form-control grace-remark-mark"
                               min="0" max="{{$result->examSubjectMark->total_marks}}"
                               placeholder="Grace Mark" aria-label="Text input with checkbox"
                               value="{{$result->grace_marks}}" style="width: auto; height: calc(2.50rem + 4px) !important;" {{$result->grace_marks > 0 ? '' : 'readonly'}}>
                    </div>
                    <small id="emailHelp" class="form-text text-muted">Check the checkbox to provide grace marks</small>
                </div>
            </div>
        </div>
    @endforeach
<div class="row no-gutters">
    <div class="m-checkbox-inline">
        <label class="form-check-label pl-4 pb-3">
            <input class="form-check-input special-consideration" type="checkbox" name="special_consideration" value="1" {{($specialPass != 0 || $specialFail != 0) ? 'checked' : ''}}> Special consideration
            <span></span>
        </label>
    </div>
</div>

{{--    <div class="manual_pass_fail">--}}
{{--        <input type="checkbox" class="manual_pass_fail_approve" name="manual_pass_fail" aria-label="Checkbox for following text input">--}}
{{--        <label for="manual_pass_fail_approve">Manually Pass / Fail</label>--}}
{{--    </div>--}}


    <div class="row no-gutters">
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group  m-form__group">
                <label class="form-control-label">Result Status </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
            <div class="form-group  m-form__group">
                <select name="result_status" id="special-consideration-status" class="form-control m-input {{($specialPass != 0 || $specialFail != 0) ? '' : 'm--hide'}}">
                    <option value="1" @if($specialPass != 0) {{ 'selected' }} @endif> Pass  </option>
                    <option value="2" @if($specialFail != 0) {{ 'selected' }} @endif> Fail  </option>
                </select>
                <input type="text" class="form-control {{($specialPass != 0 || $specialFail != 0) ? 'm--hide' : ''}}"
                       id="result-status" value="" autocomplete="off" readonly/>
            </div>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group  m-form__group">
                <label class="form-control-label">Comment </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
            <div class="form-group  m-form__group">
                <input type="text" class="form-control m-input comment" name="comment" value="{{$comment}}" autocomplete="off"/>
            </div>
        </div>
    </div>

<script>
    $('.grace-remark-status').change(function() {
        if (this.checked) {
            $(this).parents().eq(2).find('.grace-remark-mark').removeAttr('readonly');
        }
        else {
            $(this).parents().eq(2).find('.grace-remark-mark').attr('readonly', true);
        }
    });

    $(document).on('click', '.special-consideration', function () {
        console.log(this.checked);
        if (this.checked) {
            $('.grace-remark-status').attr('readonly', true);
            $('.sub_type_mark').attr('readonly', true);
            $('#special-consideration-status').removeClass('m--hide');
            $('#result-status').addClass('m--hide');
        }
        else {
            $('.grace-remark-status').removeAttr('readonly');
            $('.sub_type_mark').removeAttr('readonly');
            $('#special-consideration-status').addClass('m--hide');
            $('#result-status').removeClass('m--hide');
        }
    })
</script>
