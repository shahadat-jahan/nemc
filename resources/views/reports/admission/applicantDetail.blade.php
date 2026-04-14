@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        .table td {
            padding-top: 0.6rem !important;
            padding-bottom: .6rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Student's Detail: {{$student->full_name_en}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{url()->previous()}}" class="btn btn-primary m-btn m-btn--icon mr-2" title="Applicants"><i class="fa fa-undo-alt"></i> Back</a>
                        <a target="_blank" href="{{route('applicant.single.print', $student->id)}}" class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fas fa-print"></i> Print</a>
                    </div>
                </div>

                <div class="m-portlet__body border m-3" style="padding: 0 !important">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="border-right h-100">
                                <div class="p-3">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                        <tr>
                                            <td style="width: 40%;">Course</td>
                                            <td style="width: 60%;">: {{$student->course->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>Session</td>
                                            <td>: {{$student->session->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>Student Name</td>
                                            <td>: {{$student->full_name_en}}</td>
                                        </tr>
                                        <tr>
                                            <td>Blood group</td>
                                            <td>: {{!empty($student->blood_group) ? $student->blood_group : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Student Category</td>
                                            <td>: {{$student->studentCategory->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>Registration Date</td>
                                            <td>: {{date('d/m/Y', strtotime($student->created_at))}}</td>
                                        </tr>
                                        <tr>
                                            <td>Test score</td>
                                            <td>: {{!empty($student->test_score) ? $student->test_score : '--'}}</td>
                                        </tr>
                                        @if($student->student_category_id == 2)
                                        <tr>
                                            <td>Visa Duration</td>
                                            <td>: {{!empty($student->visa_duration) ? $student->visa_duration : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Embassy Contact No</td>
                                            <td>: {{!empty($student->embassy_contact_no) ? $student->embassy_contact_no : '--'}}</td>
                                        </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border-left h-100">
                                <div class="p-3">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                   {{-- <tr>
                                        <td style="width: 40%;">College Roll No.</td>
                                        <td style="width: 60%;">: {{$student->roll_no}}</td>
                                    </tr>--}}
                                    <tr>
                                        <td style="width: 40%;">Status</td>
                                        <td style="width: 60%;">: {{$studentStatus[$student->status]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nationality</td>
                                        <td>: {{$student->country->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>: {{$student->gender}}</td>
                                    </tr>
                                    <tr>
                                        <td>Date Of Birth</td>
                                        <td>: {{$student->date_of_birth}}</td>
                                    </tr>
                                    <tr>
                                        <td>Who will finance during study</td>
                                        <td>: {{$student->admissionParent->finance_during_study}}</td>
                                    </tr>
                                   <tr>
                                       <td>College</td>
                                       <td>: North East Medical College</td>
                                   </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr class="m-0">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="border-right h-100">
                                <div class="p-3">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                        <tr>
                                            <td style="width: 40%;">Father's Name</td>
                                            <td style="width: 60%;">: {{$student->admissionParent->father_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Father's phone number</td>
                                            <td>: {{!empty($student->parent->father_phone) ? $student->parent->father_phone : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Father's Email</td>
                                            <td>: {{!empty($student->parent->father_email) ? $student->parent->father_email : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mother' Name</td>
                                            <td>: {{!empty($student->parent->mother_name) ? $student->parent->mother_name : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mother's phone number</td>
                                            <td>: {{!empty($student->parent->mother_phone) ? $student->parent->mother_phone : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Mother's Email</td>
                                            <td>: {{!empty($student->parent->mother_email) ? $student->parent->mother_email : '--'}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border-left h-100">
                                <div class="p-3">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                    <tr>
                                        <td style="width: 40%;">Admission Year</td>
                                        <td style="width: 60%;">: {{$student->admission_year}}</td>
                                    </tr>
                                    <tr>
                                        <td>Admission roll no</td>
                                        <td>: {{!empty($student->admission_roll_no) ? $student->admission_roll_no : '--'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Commence Year</td>
                                        <td>: {{$student->commenced_year}}</td>
                                    </tr>
                                    <tr>
                                        <td>Form Fill-up date</td>
                                        <td>: {{!empty($student->form_fillup_date) ? $student->form_fillup_date : '--'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Merit Score</td>
                                        <td>: {{!empty($student->merit_score) ? $student->merit_score : '--'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Merit Position</td>
                                        <td>: {{!empty($student->merit_position) ? $student->merit_position : '--'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Place of Birth</td>
                                        <td>: {{$student->place_of_birth}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr class="m-0">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="border-right h-100">
                                <div class="p-3">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                        <tr>
                                            <td colspan="2" class="text-center">Permanent Address</td>
                                        </tr>
                                        <tr>
                                            <td>{{!empty($student->permanent_address) ? $student->permanent_address : '--'}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border-left h-100">
                                <div class="p-3">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                        <tr>
                                            <td colspan="2" class="text-center">Present Address</td>
                                        </tr>
                                        <tr>
                                            <td>{{!empty($student->permanent_address) ? $student->permanent_address : '--'}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr class="m-0">
                    @php
                        $studentSscEducationInfo = $student->admissionEducationHistories()->where('education_level', 1)->first();
                        $studentHscEducationInfo = $student->admissionEducationHistories()->where('education_level', 2)->first();
                    @endphp
                    <div class="row">
                        @isset($studentSscEducationInfo)
                        <div class="col-sm-6">
                            <div class="border-right h-100">
                                <div class="p-3">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                                <tr>
                                                    <td style="width: 40%;">SSC Passing Year</td>
                                                    <td style="width: 60%;">: {{$studentSscEducationInfo->pass_year}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Education Board</td>
                                                    <td>: {{$studentSscEducationInfo->educationBoard->title}}</td>
                                                </tr>
                                                <tr>
                                                    <td>SSC Marks/GPA</td>
                                                    <td>: {{$studentSscEducationInfo->gpa}}</td>
                                                </tr>
                                                <tr>
                                                    <td>GPA in Biology</td>
                                                    <td>: {{$studentSscEducationInfo->gpa_biology}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Institution</td>
                                                    <td>: {{$studentSscEducationInfo->institution}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Extra Curriculum Activity</td>
                                                    <td>: {{!empty($studentSscEducationInfo->extra_activity) ? $studentSscEducationInfo->extra_activity : '--'}}</td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endisset

                        @isset($studentHscEducationInfo)
                        <div class="col-sm-6">
                            <div class="border-left h-100">
                                <div class="p-3">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                                <tr>
                                                    <td style="width: 40%;">HSC Passing Year</td>
                                                    <td style="width: 60%;">: {{$studentHscEducationInfo->pass_year}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Education Board</td>
                                                    <td>: {{$studentHscEducationInfo->educationBoard->title}}</td>
                                                </tr>
                                                <tr>
                                                    <td>HSC Marks/GPA</td>
                                                    <td>: {{$studentHscEducationInfo->gpa}}</td>
                                                </tr>
                                                <tr>
                                                    <td>GPA in Biology</td>
                                                    <td>: {{$studentHscEducationInfo->gpa_biology}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Institution</td>
                                                    <td>: {{$studentHscEducationInfo->institution}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Extra Curriculum Activity</td>
                                                    <td>: {{!empty($studentHscEducationInfo->extra_activity) ? $studentHscEducationInfo->extra_activity : '--'}}</td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endisset
                    </div>
                    <hr class="m-0">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="border-right h-100">
                                <div class="p-3">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                        <tr>
                                            <td colspan="2" class="text-center">Asset Grade</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;">Annual income</td>
                                            <td style="width: 60%;">: {{!empty($student->admissionParent->annual_income) ? $student->admissionParent->annual_income : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Movable property</td>
                                            <td>: {{!empty($student->admissionParent->movable_property) ? $student->admissionParent->movable_property : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Immovable property</td>
                                            <td>: {{!empty($student->admissionParent->immovable_property) ? $student->admissionParent->immovable_property : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total assets</td>
                                            <td>: {{!empty($student->admissionParent->total_asset) ? $student->admissionParent->total_asset : '--'}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border-left h-100">
                                <div class="p-3">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                        <tr>
                                            <td colspan="2" class="text-center">Asset Grade</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 70%;">Insolvent grade(Annual income)</td>
                                            <td style="width: 30%;">: {{!empty($student->admissionParent->annual_income_grade) ? $student->admissionParent->annual_income_grade : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Insolvent grade(Movable property)</td>
                                            <td>: {{!empty($student->admissionParent->movable_property_grade) ? $student->admissionParent->movable_property_grade : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Insolvent grade(Immovable property)</td>
                                            <td>: {{!empty($student->admissionParent->immovable_property_grade) ? $student->admissionParent->immovable_property_grade : '--'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Insolvent grade(Total assets)</td>
                                            <td>: {{!empty($student->admissionParent->total_asset_grade) ? $student->admissionParent->total_asset_grade : '--'}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>

@endsection
