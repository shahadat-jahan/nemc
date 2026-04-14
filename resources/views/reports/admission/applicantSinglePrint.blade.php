@extends('layouts.print')
@push('style')

    <style type="text/css" media="print">
        @page {
            size: A3 portrait;
        }
    </style>
@endpush

@section('content')
    @isset($student)
        <h3 style="text-align: center; font-size: 20px;">Student details</h3>
        <div class="m-portlet__body border m-5" style="box-sizing:border-box;padding-top:0 !important;padding-bottom:0 !important;padding-right:0 !important;padding-left:0 !important;margin-top:3rem !important;margin-bottom:3rem !important;margin-right:3rem !important;margin-left:3rem !important;border-width:1px !important;border-style:solid !important;border-color:#dee2e6 !important;" >
            <div class="row" style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;" >
                <div class="col-sm-6" style="box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px;" >
                    <div class="border-right h-100" style="box-sizing:border-box;height:100% !important;border-right-width:1px !important;border-right-style:solid !important;border-right-color:#dee2e6 !important;" >
                        <div class="p-3" style="box-sizing:border-box;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;" >
                            <table class="table table-bordered mb-0" style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);" >
                                <tbody style="box-sizing:border-box;" >
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;width:40%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Course</td>
                                    <td style="box-sizing:border-box;width:60%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->course->title}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Session</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->session->title}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Student Name</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->full_name_en}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Blood group</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->blood_group) ? $student->blood_group : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Student Category</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->studentCategory->title}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Registration Date</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{date('d/m/Y', strtotime($student->created_at))}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Test score</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->test_score) ? $student->test_score : '--'}}</td>
                                </tr>

                                @if($student->student_category_id == 2)
                                    <tr style="box-sizing:border-box;" >
                                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Visa Duration</td>
                                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->visa_duration) ? $student->visa_duration : '--'}}</td>
                                    </tr>
                                    <tr style="box-sizing:border-box;" >
                                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Embassy Contact No</td>
                                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->embassy_contact_no) ? $student->embassy_contact_no : '--'}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px;" >
                    <div class="border-left h-100" style="box-sizing:border-box;height:100% !important;border-left-width:1px !important;border-left-style:solid !important;border-left-color:#dee2e6 !important;" >
                        <div class="p-3" style="box-sizing:border-box;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;" >
                            <table class="table table-bordered mb-0" style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);" >
                                <tbody style="box-sizing:border-box;" >
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;width:40%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Status</td>
                                    <td style="box-sizing:border-box;width:60%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$studentStatus[$student->status]}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Nationality</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->country->name}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Gender</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->gender}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Date Of Birth</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->date_of_birth}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Who will finance during study</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->admissionParent->finance_during_study}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >College</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: North East Medical College</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <hr class="m-0" style="border-width:0;border-top-width:1px;border-top-style:solid;border-top-color:rgba(0,0,0,.1);box-sizing:content-box;height:0;overflow:visible;margin-top:0 !important;margin-bottom:0 !important;margin-right:0 !important;margin-left:0 !important;" >

            <div class="row" style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;" >
                <div class="col-sm-6" style="box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px;" >
                    <div class="border-right h-100" style="box-sizing:border-box;height:100% !important;border-right-width:1px !important;border-right-style:solid !important;border-right-color:#dee2e6 !important;" >
                        <div class="p-3" style="box-sizing:border-box;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;" >
                            <table class="table table-bordered mb-0" style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);" >
                                <tbody style="box-sizing:border-box;" >
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;width:40%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Father's Name</td>
                                    <td style="box-sizing:border-box;width:60%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->admissionParent->father_name}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Father's phone number</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->father_phone) ? $student->admissionParent->father_phone : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Father's Email</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->father_email) ? $student->admissionParent->father_email : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Mother' Name</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->mother_name) ? $student->admissionParent->mother_name : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Mother's phone number</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->mother_phone) ? $student->admissionParent->mother_phone : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Mother's Email</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->mother_email) ? $student->admissionParent->mother_email : '--'}}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px;" >
                    <div class="border-left h-100" style="box-sizing:border-box;height:100% !important;border-left-width:1px !important;border-left-style:solid !important;border-left-color:#dee2e6 !important;" >
                        <div class="p-3" style="box-sizing:border-box;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;" >
                            <table class="table table-bordered mb-0" style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);" >
                                <tbody style="box-sizing:border-box;" >
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;width:40%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Admission Year</td>
                                    <td style="box-sizing:border-box;width:60%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->admission_year}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Admission roll no</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admission_roll_no) ? $student->admission_roll_no : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Commence Year</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->commenced_year}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Form Fill-up date</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->form_fillup_date) ? $student->form_fillup_date : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Merit Score</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->merit_score) ? $student->merit_score : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Merit Position</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->merit_position) ? $student->merit_position : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Place of Birth</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{$student->place_of_birth}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <hr class="m-0" style="border-width:0;border-top-width:1px;border-top-style:solid;border-top-color:rgba(0,0,0,.1);box-sizing:content-box;height:0;overflow:visible;margin-top:0 !important;margin-bottom:0 !important;margin-right:0 !important;margin-left:0 !important;" >

            <div class="row" style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;" >
                <div class="col-sm-6" style="box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px;" >
                    <div class="border-right h-100" style="box-sizing:border-box;height:100% !important;border-right-width:1px !important;border-right-style:solid !important;border-right-color:#dee2e6 !important;" >
                        <div class="p-3" style="box-sizing:border-box;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;" >
                            <table class="table table-bordered mb-0" style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);" >
                                <tbody style="box-sizing:border-box;" >
                                <tr style="box-sizing:border-box;" >
                                    <td colspan="2" class="text-center" style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Permanent Address</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >{{!empty($student->permanent_address) ? $student->permanent_address : '--'}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px;" >
                    <div class="border-left h-100" style="box-sizing:border-box;height:100% !important;border-left-width:1px !important;border-left-style:solid !important;border-left-color:#dee2e6 !important;" >
                        <div class="p-3" style="box-sizing:border-box;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;" >
                            <table class="table table-bordered mb-0" style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);" >
                                <tbody style="box-sizing:border-box;" >
                                <tr style="box-sizing:border-box;" >
                                    <td colspan="2" class="text-center" style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Present Address</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >{{!empty($student->permanent_address) ? $student->permanent_address : '--'}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <hr class="m-0" style="border-width:0;border-top-width:1px;border-top-style:solid;border-top-color:rgba(0,0,0,.1);box-sizing:content-box;height:0;overflow:visible;margin-top:0 !important;margin-bottom:0 !important;margin-right:0 !important;margin-left:0 !important;" >


            @php
                $studentSscEducationInfo = $student->admissionEducationHistories()->where('education_level', 1)->first();
                $studentHscEducationInfo = $student->admissionEducationHistories()->where('education_level', 2)->first();
            @endphp

            <div class="row" style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;" >
                <div class="col-sm-6" style="box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px;" >
                    <div class="border-right h-100" style="box-sizing:border-box;height:100% !important;border-right-width:1px !important;border-right-style:solid !important;border-right-color:#dee2e6 !important;" >
                        <div class="p-3" style="box-sizing:border-box;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;" >
                            <table class="table table-bordered mb-0" style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);" >
                                <tbody style="box-sizing:border-box;" >
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;width:40%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >SSC Passing Year</td>
                                            <td style="box-sizing:border-box;width:60%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentSscEducationInfo->pass_year) ? $studentSscEducationInfo->pass_year : '--'}}</td>
                                        </tr>
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Education Board</td>
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentSscEducationInfo->educationBoard) ? $studentSscEducationInfo->educationBoard->title : '--'}}</td>
                                        </tr>
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >SSC Marks/GPA</td>
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentSscEducationInfo->gpa) ? $studentSscEducationInfo->gpa : '--'}}</td>
                                        </tr>
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >GPA in Biology</td>
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentSscEducationInfo->gpa_biology) ? $studentSscEducationInfo->gpa_biology : '--'}}</td>
                                        </tr>
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Institution</td>
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentSscEducationInfo->institution) ? $studentSscEducationInfo->institution : '--'}}</td>
                                        </tr>
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Extra Curriculum Activity</td>
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentSscEducationInfo->extra_activity) ? $studentSscEducationInfo->extra_activity : '--'}}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px;" >
                    <div class="border-left h-100" style="box-sizing:border-box;height:100% !important;border-left-width:1px !important;border-left-style:solid !important;border-left-color:#dee2e6 !important;" >
                        <div class="p-3" style="box-sizing:border-box;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;" >
                            <table class="table table-bordered mb-0" style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);" >
                                <tbody style="box-sizing:border-box;" >
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;width:40%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >HSC Passing Year</td>
                                            <td style="box-sizing:border-box;width:60%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentHscEducationInfo->pass_year) ? $studentHscEducationInfo->pass_year : '--'}}</td>
                                        </tr>
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Education Board</td>
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentHscEducationInfo->educationBoard) ? $studentHscEducationInfo->educationBoard->title : '--'}}</td>
                                        </tr>
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >HSC Marks/GPA</td>
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentHscEducationInfo->gpa) ? $studentHscEducationInfo->gpa : '--'}}</td>
                                        </tr>
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >GPA in Biology</td>
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentHscEducationInfo->gpa_biology) ? $studentHscEducationInfo->gpa_biology : '--'}}</td>
                                        </tr>
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Institution</td>
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentHscEducationInfo->institution) ? $studentHscEducationInfo->institution : '--'}}</td>
                                        </tr>
                                        <tr style="box-sizing:border-box;" >
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Extra Curriculum Activity</td>
                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($studentHscEducationInfo->extra_activity) ? $studentHscEducationInfo->extra_activity : '--'}}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <hr class="m-0" style="border-width:0;border-top-width:1px;border-top-style:solid;border-top-color:rgba(0,0,0,.1);box-sizing:content-box;height:0;overflow:visible;margin-top:0 !important;margin-bottom:0 !important;margin-right:0 !important;margin-left:0 !important;" >

            <div class="row" style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;" >
                <div class="col-sm-6" style="box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px;" >
                    <div class="border-right h-100" style="box-sizing:border-box;height:100% !important;border-right-width:1px !important;border-right-style:solid !important;border-right-color:#dee2e6 !important;" >
                        <div class="p-3" style="box-sizing:border-box;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;" >
                            <table class="table table-bordered mb-0" style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);" >
                                <tbody style="box-sizing:border-box;" >
                                <tr style="box-sizing:border-box;" >
                                    <td colspan="2" class="text-center" style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Asset Grade</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;width:40%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Annual income</td>
                                    <td style="box-sizing:border-box;width:60%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->annual_income) ? $student->admissionParent->annual_income : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Movable property</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->movable_property) ? $student->admissionParent->movable_property : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Immovable property</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->immovable_property) ? $student->admissionParent->immovable_property : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Total assets</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->total_asset) ? $student->admissionParent->total_asset : '--'}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="box-sizing:border-box;-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%;position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px;" >
                    <div class="border-left h-100" style="box-sizing:border-box;height:100% !important;border-left-width:1px !important;border-left-style:solid !important;border-left-color:#dee2e6 !important;" >
                        <div class="p-3" style="box-sizing:border-box;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;" >
                            <table class="table table-bordered mb-0" style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);" >
                                <tbody style="box-sizing:border-box;" >
                                <tr style="box-sizing:border-box;" >
                                    <td colspan="2" class="text-center" style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Asset Grade</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;width:70%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Insolvent grade(Annual income)</td>
                                    <td style="box-sizing:border-box;width:30%;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->annual_income_grade) ? $student->admissionParent->annual_income_grade : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Insolvent grade(Movable property)</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->movable_property_grade) ? $student->admissionParent->movable_property_grade : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Insolvent grade(Immovable property)</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->immovable_property_grade) ? $student->admissionParent->immovable_property_grade : '--'}}</td>
                                </tr>
                                <tr style="box-sizing:border-box;" >
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >Insolvent grade(Total assets)</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;" >: {{!empty($student->admissionParent->total_asset_grade) ? $student->admissionParent->total_asset_grade : '--'}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endisset
@endsection
