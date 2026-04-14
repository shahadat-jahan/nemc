<!doctype html>
<html lang="en">
<body style="box-sizing:border-box;font-size:14px;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff;" >
<div style="box-sizing:border-box;width:90%;max-width:1140px;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;" >
    <div style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;" >
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;text-align:center!important;" >
                <img src="{{asset('assets/global/img/nemc-logo.png')}}" alt="nemc logo" style="box-sizing:border-box;vertical-align:middle;border-style:none;width:5rem;margin-bottom:5px;" >
                <p style="box-sizing:border-box;margin-top:0;font-size:1.4rem;margin-bottom:0;" >{{Setting::getSiteSetting()->title}}</p>
                <h5 style="box-sizing:border-box;font-size:1.25rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Department Of {{$subjectInfo->department->title}}</h5>
                <p style="box-sizing:border-box;margin-top:0;font-size:1.4rem;margin-bottom:0;" >Result: {{$examInfo->title}} Examination, {{date('F Y')}}</p>
                <?php
                $batch = $examInfo->session->sessionDetails->where('course_id', $examInfo->course_id)->first()->batch_number;
                ?>
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Session: {{$examInfo->session->title}} ({{$examInfo->course->title}} {{ordinalNumber($batch)}} Batch)</h6>
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Name: {{$examResult->first()->student->full_name_en}}, Roll: {{$examResult->first()->student->roll_no}}</h6>
            </div>
        </div>
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;" >
                <table style="box-sizing:border-box;border-collapse:collapse;width:100%;margin-bottom:1rem;color:#212529;border-width:0;" >
                    <thead style="box-sizing:border-box;" >
                    <tr style="box-sizing:border-box;">
                        @foreach($examTypeSubType as $type)
                            <?php
                            $examTypeMarks = 0;
                            $colspan = count($type->examSubTypes);
                            ?>
                            @foreach($type->examSubTypes as $subType)
                                @foreach($subType->examSubjectMark as $mark)
                                    <?php $examTypeMarks += $mark->total_marks ?>
                                @endforeach

                            @endforeach
                            <th colspan="{{$colspan}}" style="box-sizing:border-box;text-align:center!important;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">{{$type->title}} ({{$examTypeMarks}})</th>
                        @endforeach
                        <th rowspan="2" style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;" >Remarks</th>
                        <th rowspan="2" style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;" >Comment</th>
                    </tr>
                    <tr tyle="box-sizing:border-box;">
                        @foreach($examTypeSubType as $type)
                            @foreach($type->examSubTypes as $subType)
                                @foreach($subType->examSubjectMark as $mark)
                                    <th style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;" >{{$subType->title}} ({{$mark->total_marks}})</th>
                                @endforeach
                            @endforeach
                                {{--<th style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:top;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;" >Total</th>--}}
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="box-sizing:border-box;" >
                        <?php
                        $resultStatus = $examResult->first()->pass_status;
                        $comment = $examResult->first()->comment;
                        ?>
                        @foreach($examResult as $result)
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$result->marks}}</td>
                        @endforeach
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{\App\Services\UtilityServices::$passStatus[$resultStatus]}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{$comment}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
