<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher List of {{$department}}</title>
    <style>
        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .brand-section {
            padding: 10px 40px;
        }

        .logo {
            width: 150px;
            margin-left: -30px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            width: 50%;
            flex: 0 0 auto;
        }

        table {
            border-collapse: collapse;
        }

        table thead tr {
            border: 1px solid #dee2e6;
        }

        table td {
            vertical-align: middle !important;
            text-align: center;
        }

        table th, table td {
            padding: 5px;
        }

        .table-bordered {
            box-shadow: 0 0 5px 0.5px gray;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
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

        .info {
            width: 100%;
        }

        .info_one {
            width: 50%;
            float: left;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="brand-section">
        <span>
            <img class="logo" src="{{asset('assets/global/img/logo.jpg')}}"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <br>
            <h3>
                <span> Department of {{$department}} </span>
            </h3>
            <br>
            <h4 class="text-center text-uppercase">Teacher List</h4>
            <br>
            @if(!empty($course))
                <span>Course : {{$course}}</span>
            @endif
        </div>
    </div>
    <br/>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Sl.</th>
            <th scope="col">Image</th>
            <th scope="col">Full Name</th>
            <th scope="col">Department</th>
            <th scope="col">Designation</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Course</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($teachers as $key => $teacher)
            <tr>
                <td>{{$key + 1}}</td>
                <td>
                    @if($teacher->photo)
                        <img src="{{asset($teacher->photo)}}" class="card-img" alt="Teacher image" style="width: 40px;">
                    @else
                        <img src="{{$teacher->gender == 'male' ? asset('assets/global/img/male_avater.png') : asset('assets/global/img/female_avater.png')}}" class="card-img" alt="Teacher image" style="width: 40px;">
                    @endif
                </td>
                <td>{{$teacher->first_name}} {{$teacher->last_name}}</td>
                <td>{{$teacher->department->title}}</td>
                <td>{{$teacher->designation->title}}</td>
                <td>{{!empty($teacher->phone)? $teacher->phone : '--'}}</td>
                <td>{{!empty($teacher->email)? $teacher->email : '--'}}</td>
                <td>{{$teacher->course->title}}</td>
                <td> @if($teacher->status == 1)
                        Active
                    @else
                        Inactive
                    @endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
