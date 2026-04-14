@extends('layouts.print')
@push('style')
    <style type="text/css" media="print">
        @page {
            /*size: landscape;*/
            size: A4 landscape;
        }
    </style>
@endpush

@section('content')
    @isset($teacher)
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center" style="text-align: center; font-size: 15px;">Detail Information of {{$teacher->first_name .' '.$teacher->last_name}}</h3>
                <div class="row pt-4 pl-2 pr-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered"  style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);">
                                <thead>
                                <tr style="box-sizing:border-box;">
                                    <th scope="col"  style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Image</th>
                                    <th scope="col"  style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">First Name</th>
                                    <th scope="col"  style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Last Name</th>
                                    <th scope="col"  style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">birth Date</th>
                                    <th scope="col"  style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Department</th>
                                    <th scope="col"  style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Designation</th>
                                    <th scope="col"  style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Phone</th>
                                    <th scope="col"  style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Email</th>
                                    <th scope="col"  style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Course</th>
                                    <th scope="col"  style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr style="box-sizing:border-box;">
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">
                                        @if($teacher->photo)
                                            <img src="{{asset($teacher->photo)}}" class="card-img" alt="Teacher image" style="width: 40%;">
                                        @else
                                            <img src="{{asset('assets/global/img/male_avater.png')}}" class="card-img" alt="Teacher image" style="width: 40%;">
                                        @endif
                                    </td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$teacher->first_name}}</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$teacher->last_name}}</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$teacher->dob}}</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$teacher->department->title}}</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$teacher->designation->title}}</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{!empty($teacher->phone)? $teacher->phone : '--'}}</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{!empty($teacher->email)? $teacher->email : '--'}}</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$teacher->course->title}}</td>
                                    <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;"> @if($teacher->status == 1) Active @else Inactive @endif</td>
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
