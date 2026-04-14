    <div class="m-portlet__body">
        <div class="m-section__content">
            <div class="col-md-12" style="position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%; height: 65rem;">
                <div class="text-center" style="box-sizing:border-box;text-align:center;">
                    {{--<img class="logo" src="{{asset('assets/global/img/nemc-logo.png')}}" alt="nemc logo" style="box-sizing:border-box;vertical-align:middle;border-style:none;width:5rem;margin-bottom:5px;">--}}
                    <img class="logo" src="assets/global/img/nemc-logo.png" alt="nemc logo" style="box-sizing:border-box;vertical-align:middle;border-style:none;width:8rem;margin-bottom:5px;">
                    <p class="college-title" style="box-sizing:border-box;margin-top:1rem;font-size:3rem;margin-bottom:0;">North East Medical College</p>
                    <h5 class="font-bold" style="font-size:3rem;margin-bottom:.5rem;line-height:1.2;margin-top:15rem;font-weight:bold;">Academic Calender</h5>
                    <h6 class="font-bold" style="box-sizing:border-box;font-size:2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">Session: {{$session}}, Course : {{$course}}</h6>
                    <h6 class="font-bold" style="box-sizing:border-box;font-size:2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">{{$subjectGroup}}</h6>
                    <p style="margin-top:0;font-size:1rem; margin-top: 22rem;">North East Medical College & Hospital. South Surma, Sylhet-3100, Bangladesh.</p>
                    <p style="margin-top:0;font-size:1rem;">Email : info@nemc.edu.bd, nemc1998@gmail.com</p>
                    <p style="margin-top:0;font-size:1rem;margin-bottom:5rem;">Cell : +880 1786511305, +880 1715944733.</p>
                </div>
            </div>
            <br>
            @if(isset($holidays))
                <div style="display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
                    <div  style="position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
                        <h5 style="font-size:1.25rem;margin-bottom:.5rem;font-weight:500;line-height:1.2;margin-top:0;text-align:center;">Holiday List</h5>
                        <div style="display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;">
                            <table style="border-collapse:collapse;width:100%;margin-bottom:1rem;color:#212529;border-width:0;">
                                <thead>
                                <tr>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Id</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Holiday Name</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">From</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">To</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($holidays as $holiday)
                                    <tr>
                                        <th  style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$holiday->id}}</th>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$holiday->title}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($holiday->from_date)? $holiday->from_date : 'N/A'}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($holiday->to_date)? $holiday->to_date : 'N/A'}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($classRoutines))
                <div style="display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
                    <div  style="position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
                        <h5 style="font-size:1.25rem;margin-bottom:.5rem;font-weight:500;line-height:1.2;margin-top:1rem;text-align:center;">Class Routine List</h5>
                        <div style="display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;">
                            <table style="border-collapse:collapse;width:100%;margin-bottom:1rem;color:#212529;border-width:0;">
                                <thead>
                                <tr>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Id</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Month</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Date</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Day</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Time</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Topic</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Teacher</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($classRoutines as $classRoutine)
                                    <tr>
                                        <th  style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$classRoutine->id}}</th>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{date("F , Y",strtotime($classRoutine->class_date))}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$classRoutine->class_date}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{date("l",strtotime($classRoutine->class_date))}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{date('g:i A', strtotime($classRoutine->start_from)) .' to '.date('g:i A', strtotime($classRoutine->end_at))}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($classRoutine->topic->title) ? $classRoutine->topic->title : 'n/a'}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$classRoutine->teacher->full_name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($exams))
                <div style="display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
                    <div  style="position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
                        <h5 style="font-size:1.25rem;margin-bottom:.5rem;font-weight:500;line-height:1.2;margin-top:1rem;text-align:center;">Exam List</h5>
                        <div style="display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;">
                            <table style="border-collapse:collapse;width:100%;margin-bottom:1rem;color:#212529;border-width:0;">
                                <thead>
                                <tr>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Id</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Title</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Session</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Course</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Phase</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Term</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Exam Category</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($exams as $exam)
                                    <tr>
                                        <th  style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$exam->id}}</th>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$exam->title}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$exam->session->title}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$exam->course->title}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$exam->phase->title}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$exam->term->title}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$exam->examCategory->title}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($books))
                <div style="display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
                    <div  style="position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
                        <h5 style="font-size:1.25rem;margin-bottom:.5rem;font-weight:500;line-height:1.2;margin-top:1rem;text-align:center;">Book List</h5>
                        <div style="display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;">
                            <table style="border-collapse:collapse;width:100%;margin-bottom:1rem;color:#212529;border-width:0;">
                                <thead>
                                <tr>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Id</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Name</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Subject</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Author</th>
                                    <th style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">Edition</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($books as $book)
                                    <tr>
                                        <th  style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$book->id}}</th>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$book->title}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$book->subject->title}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$book->author}}</td>
                                        <td style="border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($book->edition) ? $book->edition : 'n/a'}}</td>
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


