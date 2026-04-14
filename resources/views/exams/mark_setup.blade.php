@extends('layouts.default')
@section('pageTitle', $pageTitle)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fa fa-clock fa-md pr-2"></i>Exam
                                Detail: {{$examInfo->title}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('exams.list') }}" class="btn btn-primary m-btn m-btn--icon"
                           title="Applicants"><i class="fas fa-archway"></i> Exams</a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">

                        <div class="card">
                            <div class="card-header">
                                Common Information
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Session :</div>
                                                        <div class="col-md-8">{{$examInfo->session->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Phase :</div>
                                                        <div class="col-md-8">{{$examInfo->phase->title}}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Course :</div>
                                                        <div class="col-md-8">{{$examInfo->course->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Term :</div>
                                                        <div class="col-md-8">{{$examInfo->term->title}}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="all-errors"></div>

                        @if(!empty($examSubjects))
                            <form class="m-form m-form--fit m-form--label-align-right"
                                  action="{{ route('exams.mark.save', [$examInfo->id]) }}" method="post"
                                  id="nemc-general-form">
                                @csrf
                                @foreach($examSubjects as $key => $subject)
                                    @php
                                        $hideClass = '';
                                        if (Auth::guard('web')->check()){
                                            $user = Auth::guard('web')->user();
                                            if ($user->teacher){
                                                if (!in_array($subject[0]->subject_id, getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id))){
                                                    $hideClass = 'm--hide';
                                                }
                                            }
                                        }
                                    @endphp
                                    <div class="card mt-3 {{$hideClass}}">
                                        <div class="card-header">
                                            {{$subject[0]->subject->title}}
                                            <input type="hidden" name="subject_id[]"
                                                   value="{{$subject[0]->subject_id}}">
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                    <div class="">
                                                        <div class="table m-table table-responsive">
                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th>
                                                                            <?php
                                                                            $check = $examInfo->examMarks->where('subject_id', $subject[0]->subject_id)->first()
                                                                            ?>
                                                                        <label class="m-checkbox">
                                                                            <input type="checkbox" name="all_types"
                                                                                   class="all-types"
                                                                                   value="1" {{!empty($check) ? 'checked' : ''}}>
                                                                            <span></span>
                                                                        </label>
                                                                    </th>
                                                                    <th>Exam Type</th>
                                                                    <th>Exam Sub Type</th>
                                                                    <th>Marks</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $totalMarks = 0; ?>
                                                                @foreach($examSubTypes[$key] as $sKey => $subType)
                                                                    @php
                                                                        $examSubjectMarks = $examInfo->examMarks->where('subject_id', $subject[0]->subject_id)->where('exam_sub_type_id', $subType->id)->first();
                                                                        $totalMarks = $totalMarks + (!empty($examSubjectMarks) ? $examSubjectMarks->total_marks : 0);
                                                                    @endphp
                                                                    <tr>
                                                                        <td>
                                                                            <label class="m-checkbox">
                                                                                <input type="checkbox"
                                                                                       class="exam-sub-type"
                                                                                       name="sub_type_id[{{$subject[0]->subject_id}}][{{$subType->id}}]"
                                                                                       value="{{$subType->id}}" {{!empty($examSubjectMarks) ? 'checked' : ''}}>
                                                                                <span></span>
                                                                            </label>
                                                                        </td>
                                                                        <td>{{$subType->examType->title}}</td>
                                                                        <td>{{$subType->title}}</td>
                                                                        <td width="100px">
                                                                            <input type="number"
                                                                                   class="form-control m-input exam-mark"
                                                                                   name="marks[{{$subject[0]->subject_id}}][{{$subType->id}}]"
                                                                                   min="1" maxlength="3"
                                                                                   value="{{!empty($examSubjectMarks) ? $examSubjectMarks->total_marks : ''}}"
                                                                                   placeholder="Mark"
                                                                                   autocomplete="off" {{empty($examSubjectMarks) ? 'readonly' : ''}}/>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                <tr>
                                                                    {{--<td colspan="2"></td>--}}
                                                                    <td colspan="3" align="right">Total</td>
                                                                    <td width="100px"
                                                                        class="subject-total">{{$totalMarks}}</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="m-portlet__foot m-portlet__foot--fit">
                                    <div class="m-form__actions text-center">
                                        <a href="{{ route('exams.list') }}" class="btn btn-outline-brand"><i
                                                class="fa fa-times"></i> Cancel</a>
                                        @if(!$is_marks_entered)
                                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                                Save
                                            </button>
                                        @else
                                            <h5 class="text-danger pt-4">Some marks already entered you are not eligible
                                                to
                                                edit</h5>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.all-types').change(function () {

                if (this.checked) {
                    $(this).parents('.table').find('tbody').find('input:checkbox').prop('checked', true);
                    $(this).parents('.table').find('tbody').find('.exam-mark').removeAttr('readonly');
                } else {
                    $(this).parents('.table').find('tbody').find('input:checkbox').prop('checked', false);
                    $(this).parents('.table').find('tbody').find('.exam-mark').val('').attr('readonly', true);
                }
            });

            $('.exam-sub-type').change(function () {
                if (this.checked) {
                    $(this).parents('.table').find('.all-types').prop('checked', true);
                    $(this).parents('tr').find('.exam-mark').removeAttr('readonly');
                } else {
                    $(this).parents('.table').find('.all-types').prop('checked', false);
                    $(this).parents('tr').find('.exam-mark').val('').attr('readonly', true);
                }
            });

            $('.exam-mark').bind('keyup change', function () {
                totalRow = $(this).parents('.table').find('.subject-total');
                markTotal = 0;
                $(this).parents('.table').find('.exam-mark').each(function () {
                    mark = ($(this).val() == '') ? 0 : $(this).val();

                    markTotal = parseInt(markTotal) + parseInt(mark);
                });
                totalRow.text(markTotal);
            });

            $.validator.addMethod("check_marks", function (value, element) {
                var flag = true;
                markStatus = true;

                $('.exam-sub-type:checked').each(function () {
                    if ($(this).parents('tr').find('.exam-mark').val() == '') {
                        markStatus = false;
                    }
                });
                if (markStatus == false) {
                    flag = false;
                }
                return flag;

            }, "Selected exam sub types mark should not be empty");

            $.validator.addMethod("total_check_marks", function (value, element) {
                var flag = true;
                subTypeStatus = true;

                if ($('.exam-sub-type:checked').length == 0) {
                    subTypeStatus = false;
                }

                if (subTypeStatus == false) {
                    flag = false;
                }
                return flag;

            }, "All subjects marks required");

            $.validator.addClassRules('exam-mark', {check_marks: true});
            $.validator.addClassRules('exam-sub-type', {total_check_marks: true});

            $('#nemc-general-form').validate({
                errorLabelContainer: "#all-errors",
                errorElement: "span",
            });

            $('.btn-success').click(function () {
                setTimeout(
                    function () {
                        $('#all-errors').hide();
                        // $('#all-errors div').not(':first').remove();
                        if ($('#all-errors span:last').text().length > 0) {
                            sweetAlert($('#all-errors span:last').text(), 'error');
                        } else if ($('#all-errors span:first').text().length > 0) {
                            sweetAlert($('#all-errors span:first').text(), 'error');
                        }

                    }, 200
                )

            });
        });
    </script>
@endpush
