<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
    <div style="box-sizing:border-box;text-align:center;" >
        <p style="font-size:2rem;margin-bottom:0; text-align:center;">North East Medical College, Sylhet</p>
        <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Session: {{$session}}, Course: {{$course}}</h6>
    </div>
</div>
<br/>
<h4 class="text-center">Parent List</h4>
<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">User ID.</th>
        <th scope="col">Student Name</th>
        <th scope="col">Father Name</th>
        <th scope="col">Mother Name</th>
        <th scope="col">Father Phone</th>
        <th scope="col">Student Session</th>
        <th scope="col">Student Course</th>
        <th scope="col">Student Category</th>
        <th scope="col">Student Phase</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($parents as $parent)
        <tr>
            <td>{{$parent->user->user_id}}</td>
            <td>
                @php $count = $parent->students->count();@endphp
                @foreach($parent->students as $student)
                    @if($student->session_id ==  app()->request->session_id and $student->course_id ==  app()->request->course_id)
                        {{$student->full_name_en .'(Roll no-' .$student->roll_no. ')'}} {{$count > 1 ? ',' : ''}}
                    @endif
                @endforeach
            </td>
            <td>{{$parent->father_name}}</td>
            <td>{{$parent->mother_name}}</td>
            <td>{{$parent->father_phone}}</td>
            <td>{{$parent->students->where('session_id', app()->request->session_id)->where('course_id', app()->request->course_id)->first()->session->title}}</td>
            <td>{{$parent->students->where('session_id', app()->request->session_id)->where('course_id', app()->request->course_id)->first()->course->title}}</td>
            <td>{{$parent->students->where('session_id', app()->request->session_id)->where('course_id', app()->request->course_id)->first()->studentCategory->title}}</td>
            <td>{{$parent->students->where('session_id', app()->request->session_id)->where('course_id', app()->request->course_id)->first()->phase->title}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
