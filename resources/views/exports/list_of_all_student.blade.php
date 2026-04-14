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
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Session: {{$session}}, Course: {{$course}}</h6>
            </div>
        </div>
        <br/>
        @isset($students)
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;" >

                <div class="table-responsive">
                    <h5 class="text-center">Student List</h5>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Roll No.</th>
                            <th scope="col">User Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Session</th>
                            <th scope="col">Course</th>
                            <th scope="col">Category</th>
                            <th scope="col">Phase</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td>{{$student->roll_no}}</td>
                            <td>{{$student->user->user_id}}</td>
                            <td>{{$student->full_name_en}}</td>
                            <td>{{!empty($student->mobile) ? $student->mobile : "--"}}</td>
                            <td>{{!empty($student->email) ? $student->email : "--"}}</td>
                            <td>{{$student->session->title}}</td>
                            <td>{{$student->course->title}}</td>
                            <td>{{$student->studentCategory->title}}</td>
                            <td>{{$student->phase->title}}</td>
                            <td>{{$studentStatus[$student->status]}}</td>
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