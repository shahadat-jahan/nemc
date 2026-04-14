<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parents List</title>
    <style type="text/css">
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .brand-section {
            background-color: #fff;
            /* padding: 10px 40px; */
        }

        .logo {
            width: 150px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            width: 50%;
            flex: 0 0 auto;
        }

        .text-black {
            color: #000 !important;
        }

        table {
            border-collapse: collapse;
            margin: 10px auto;
        }

        table thead tr {
            border: 1px solid #dee2e6;
            font-size: 15px;
        }

        table td {
            font-size: 13px;
            /*vertical-align: middle !important;*/
            /*text-align: center;*/
        }

        table th,
        table td {
            padding: 5px;
        }

        .table-bordered {
            box-shadow: 0 0 5px 0.5px gray;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: end !important;
        }

        .w-30 {
            width: 30%;
        }

        .w-70 {
            width: 70%;
        }

        .float-right {
            float: right;
        }


        .green-text {
            color: green;
        }

        .red-text {
            color: red;
        }

        /* Wrapper for summary and signature sections */
        .bottom-section {
            display: flex;
            /* Flexbox layout */
            justify-content: space-between;
            /* Place items at opposite ends */
            align-items: flex-end;
            /* Align items at the top */
            /*gap: 20px; !* Add spacing between items *!*/
            margin-top: 20px;
        }

        /* Styling for the summary section */
        .summary-section {
            padding-left: 50px !important;
            /*min-width: 10%; !* Ensure it has some minimum width *!*/
        }

        /* Styling for the signature section */
        .signature-section {
            min-width: 15%;
            /* Ensure it has some minimum width */
            /*margin-right: 30px;*/
        }

        @page {
            footer: page-footer;
            margin-footer: 10px;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="brand-section">
            <span>
                <img class="logo" src="{{ asset('assets/global/img/logo.jpg') }}"/>
            </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>
                North East Medical College, Sylhet
            </h2>
            <h3>Parents List Report</h3>

        </div>
    </div>
    @if (isset($parents) && !empty($parents))
        <div class="attendance-details">
            <table class="table table-bordered table-hover">
                <thead>
                <tr style="box-sizing:border-box;">
                    <th scope="col"
                        style="vertical-align: middle;border: 1px solid #f4f5f8;padding: .75rem; text-align: left;">
                        User ID.
                    </th>
                    <th scope="col"
                        style="vertical-align: middle;border: 1px solid #f4f5f8;padding: .75rem; text-align: left;">
                        Student Name
                    </th>
                    <th scope="col"
                        style="vertical-align: middle;border: 1px solid #f4f5f8;padding: .75rem; text-align: left;">
                        Father Name
                    </th>
                    <th scope="col"
                        style="vertical-align: middle;border: 1px solid #f4f5f8;padding: .75rem; text-align: left;">
                        Mother Name
                    </th>
                    <th scope="col"
                        style="vertical-align: middle;border: 1px solid #f4f5f8;padding: .75rem; text-align: left;">
                        Father Phone & Email
                    </th>
                    <th scope="col"
                        style="vertical-align: middle;border: 1px solid #f4f5f8;padding: .75rem; text-align: left;">
                        Student Session
                    </th>
                    <th scope="col"
                        style="vertical-align: middle;border: 1px solid #f4f5f8;padding: .75rem; text-align: left;">
                        Student Course
                    </th>
                    <th scope="col"
                        style="vertical-align: middle;border: 1px solid #f4f5f8;padding: .75rem; text-align: left;">
                        Student Category
                    </th>
                    <th scope="col"
                        style="vertical-align: middle;border: 1px solid #f4f5f8;padding: .75rem; text-align: left;">
                        Student Phase
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($parents as $parent)
                    <tr style="box-sizing:border-box;">
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;
                        padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;
                        padding-left:.75rem;vertical-align:middle;">{{$parent->user->user_id}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;
                        padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;
                        padding-left:.75rem;vertical-align:middle;">
                            @php $count = $parent->students->count();@endphp
                            @foreach($parent->students as $student)
                                @if($student->followed_by_session_id ==  app()->request->session_id and $student->course_id ==  app()->request->course_id)
                                    {{$student->full_name_en .'(Roll no-' .$student->roll_no. ')'}} {{$count > 1 ? ',' : ''}}
                                @endif
                            @endforeach
                        </td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:middle;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$parent->father_name}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:middle;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$parent->mother_name}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:middle;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">
                            {{$parent->father_phone}}
                            @if(!empty($parent->father_email))
                                <br>{{$parent->father_email}}
                            @endif
                        </td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:middle;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$parent->students->where('followed_by_session_id', app()->request->session_id)->where('course_id', app()->request->course_id)->first()->session->title}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:middle;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$parent->students->where('followed_by_session_id', app()->request->session_id)->where('course_id', app()->request->course_id)->first()->course->title}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:middle;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$parent->students->where('followed_by_session_id', app()->request->session_id)->where('course_id', app()->request->course_id)->first()->studentCategory->title}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;
                        padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;
                        padding-left:.75rem;vertical-align:middle;">{{$parent->students->where('followed_by_session_id', app()->request->session_id)->where('course_id', app()->request->course_id)->first()->phase->title}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No attendance records found for this teacher.</p>
    @endif
</div>
<htmlpagefooter name="page-footer">
    <div style="text-align: center; font-size: 12px; vertical-align: bottom;">Page {PAGENO} of {nbpg}</div>
</htmlpagefooter>
</body>

</html>
