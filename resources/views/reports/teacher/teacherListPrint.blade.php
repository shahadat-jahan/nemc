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
    @isset($teachers)
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Teacher List</h3>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered"  style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);">
                        <thead>
                        <tr style="box-sizing:border-box;">
                            <th scope="col" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Image</th>
                            <th scope="col" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Full Name</th>
                            <th scope="col" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Department</th>
                            <th scope="col" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Designation</th>
                            <th scope="col" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Phone</th>
                            <th scope="col" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Email</th>
                            <th scope="col" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Course</th>
                            <th scope="col" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($teachers as $teacher)
                            <tr style="box-sizing:border-box;">
                                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">
                                    @if($teacher->photo)
                                        <img src="{{asset($teacher->photo)}}" class="card-img" alt="Teacher image" style="width: 50px;">
                                    @else
                                        <img src="{{asset('assets/global/img/male_avater.png')}}" class="card-img" alt="Teacher image" style="width: 50px;">
                                    @endif
                                </td>
                                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$teacher->first_name}} {{$teacher->last_name}}</td>
                                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$teacher->department->title}}</td>
                                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$teacher->designation->title}}</td>
                                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{!empty($teacher->phone)? $teacher->phone : '--'}}</td>
                                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{!empty($teacher->email)? $teacher->email : '--'}}</td>
                                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$teacher->course->title}}</td>
                                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;"> @if($teacher->status == 1) Active @else Inactive @endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endisset
@endsection
