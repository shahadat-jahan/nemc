@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul pr-2"></i>Academic Calender List</h3>
                        </div>
                    </div>
                   {{-- <div class="m-portlet__head-tools">
                            <a href="{{ url('admin/topic/create') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-plus pr-2"></i>Create</a>
                    </div>--}}
                </div>

                <div class="m-portlet__body">
                    <form role="form" method="get" action="{{route('frontend.get.academic.calender.data')}}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group  m-form__group">
                                        <select class="form-control m-input" name="session_id" id="session_id">
                                            <option value="">-- Select Session --</option>
                                            {{--{!! select($sessions) !!}--}}
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group  m-form__group">
                                        <select class="form-control m-input" name="course_id" id="course_id">
                                            <option value="">-- Select Course --</option>
                                            {!! select($courses, app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-input" name="subject_group_id" id="subject_group_id">
                                            <option value="">---- Select Subject Group ----</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="clearfix"><hr/></div>

                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-plus"></i> Generate</button>
                                        @if(!empty($holidays) || !empty($classRoutines) || !empty($exams) || !empty($books))
                                        <a target="_blank" href="{{route('frontend.academic.calender.data.pdf', [
                                        'session_id' => app()->request->session_id, 'course_id' => app()->request->course_id, 'subject_group_id' => app()->request->subject_group_id
                                        ])}}" class="btn btn-info m-btn m-btn--icon"><i class="fas fa-file-download"></i> Download PDF</a>
                                        @endif
                                        {{--<button type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</button>--}}
                                    </div>
                                </div>
                            </div><br/>
                        </div>
                    </form>
                    <div class="m-section__content">
                        @if(isset($holidays))
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-center">Holiday List</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Holiday Name</th>
                                            <th scope="col">From</th>
                                            <th scope="col">To</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($holidays as $holiday)
                                        <tr>
                                            <th scope="row">{{$holiday->id}}</th>
                                            <td>{{$holiday->title}}</td>
                                            <td>{{!empty($holiday->from_date)? $holiday->from_date : 'N/A'}}</td>
                                            <td>{{!empty($holiday->to_date)? $holiday->to_date : 'N/A'}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(isset($classRoutines))
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-center mt-4">Class Routine List</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Month</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Day</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Topic</th>
                                            <th scope="col">Teacher</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($classRoutines as $classRoutine)
                                        <tr>
                                            <th scope="row">{{$classRoutine->id}}</th>
                                            <td>{{date("F , Y",strtotime($classRoutine->class_date))}}</td>
                                            <td>{{$classRoutine->class_date}}</td>
                                            <td>{{date("l",strtotime($classRoutine->class_date))}}</td>
                                            <td>{{date('g:i A', strtotime($classRoutine->start_from)) .' to '.date('g:i A', strtotime($classRoutine->end_at))}}</td>
                                            <td>{{!empty($classRoutine->topic->title) ? $classRoutine->topic->title : 'n/a'}}</td>
                                            <td>{{$classRoutine->teacher->full_name}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(isset($exams))
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-center mt-4">Exam List</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Session</th>
                                            <th scope="col">Course</th>
                                            <th scope="col">Phase</th>
                                            <th scope="col">Term</th>
                                            <th scope="col">Exam Category</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($exams as $exam)
                                        <tr>
                                            <th scope="row">{{$exam->id}}</th>
                                            <td>{{$exam->title}}</td>
                                            <td>{{$exam->session->title}}</td>
                                            <td>{{$exam->course->title}}</td>
                                            <td>{{$exam->phase->title}}</td>
                                            <td>{{$exam->term->title}}</td>
                                            <td>{{$exam->examCategory->title}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                         @if(isset($books))
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-center mt-4">Book List</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Author</th>
                                            <th scope="col">Edition</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($books as $book)
                                        <tr>
                                            <th scope="row">{{$book->id}}</th>
                                            <td>{{$book->title}}</td>
                                            <td>{{$book->subject->title}}</td>
                                            <td>{{$book->author}}</td>
                                            <td>{{!empty($book->edition) ? $book->edition : 'n/a'}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    var baseUrl = '{!! url('/') !!}/';
    var subject_group_id = '{{ app()->request->subject_group_id }}';
    console.log(subject_group_id);

    $('#session_id, #course_id').change(function (e) {
        sessionId = $('#session_id').val();
        courseId = $('#course_id').val();
        //console.log(sessionId, courseId);

        // load subject group
        if (sessionId > 0 && courseId > 0){
            $.get('{{route('frontend.subjects.session.course')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                if (response.data){
                    $('#subject_group_id').html('<option value="">---- Select ----</option>');
                    for (i in response.data){
                        subjectGroup = response.data[i];
                        console.log(subject_group_id);
                        //console.log(subjectGroup.id);
                        selected = (subject_group_id == subjectGroup.id) ? 'selected' : '';
                        $('#subject_group_id').append('<option value="'+subjectGroup.id+'" '+ selected +'>'+subjectGroup.title+'</option>')
                    }

                }
            })
        }

    });

    if (subject_group_id > 0){
        $('#session_id, #course_id').trigger('change');
    }
</script>
@endpush
