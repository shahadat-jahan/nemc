<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<div style="box-sizing:border-box;width:90%;max-width:1140px;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;" >
    <div style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;" >
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;text-align:center;" >
                <p style="font-size:2rem;margin-bottom:0; text-align:center;">North East Medical College</p>
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Department: {{$department}}, Course: {{$course}}</h6>
            </div>
        </div>
        <br/>
        @isset($teachers)
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;" >

                <div class="table-responsive">
                    <h5 class="text-center">Teachers List</h5>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Sl.</th>
{{--                            <th scope="col">Image</th>--}}
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
{{--                            <td>--}}
{{--                                @if($teacher->photo)--}}
{{--                                    <img src="{{asset($teacher->photo)}}" class="card-img" alt="Teacher image" style="width: 50px;">--}}
{{--                                @else--}}
{{--                                    <img src="{{ $teacher->gender == 'male' ? asset('assets/global/img/male_avater.png') : asset('assets/global/img/female_avater.png')}}" class="card-img" alt="Teacher image" style="width: 50px;">--}}
{{--                                @endif--}}
{{--                            </td>--}}
                            <td>{{$teacher->first_name}} {{$teacher->last_name}}</td>
                            <td>{{$teacher->department->title}}</td>
                            <td>{{$teacher->designation->title}}</td>
                            <td>{{!empty($teacher->phone)? $teacher->phone : '--'}}</td>
                            <td>{{!empty($teacher->email)? $teacher->email : '--'}}</td>
                            <td>{{$teacher->course->title}}</td>
                            <td> @if($teacher->status == 1) Active @else Inactive @endif</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endisset
    </div>
</div>
</body>
</html>
