@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        .sortable-list {
            width: 700px;
            padding: 25px;
            background: #fff;
            border-radius: 7px;
            padding: 30px 25px 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .sortable-list .item {
            list-style: none;
            display: flex;
            cursor: move;
            background: #fff;
            align-items: center;
            border-radius: 5px;
            padding: 10px 13px;
            margin-bottom: 11px;
            /* box-shadow: 0 2px 4px rgba(0,0,0,0.06); */
            border: 1px solid #ccc;
            justify-content: space-between;
        }

        .item .details {
            display: flex;
            align-items: center;
        }

        .item .details img {
            height: 43px;
            width: 43px;
            pointer-events: none;
            margin-right: 12px;
            object-fit: cover;
            border-radius: 50%;
        }

        .item .details span {
            font-size: 1.13rem;
        }

        .item i {
            color: #474747;
            font-size: 1.13rem;
        }

        .item.dragging {
            opacity: 0.6;
        }

        .item.dragging :where(.details, i) {
            opacity: 0;
        }
        .text-align-center{
            text-align: -webkit-center;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="get">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i>
                                            Search
                                        </button>
                                        <button type="reset" class="btn btn-default reset"><i
                                                class="fas fa-sync-alt search-reset"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                @if(!empty($students) && !$students->isEmpty())
                                    <form class="text-align-center" id="sortableForm" action="{{ route('students.roll.update')}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="font-weight-bold m--icon-font-size-lg1">Total Student: {{$totalStudents}}</label>
                                                <!-- Hidden input fields for id and roll pairs -->
                                                <input type="hidden" name="students" id="students" value="">
                                                <ul ondragover="allowDrop(event)" class="sortable-list mt-3">
                                                    @foreach($students as $index => $student)
                                                        @php
                                                            $imageSrc = !empty($student->photo) ? $student->photo : getAvatar($student->gender);
                                                        @endphp
                                                        <li class="item draggable" draggable="true" ondragend="dragEnd()"
                                                            ondragover="dragOver(event)"
                                                            ondragstart="dragStart(event)"
                                                            data-id="{{$student->id}}"
                                                            data-fullName="{{$student->full_name_en}}"
                                                            data-roll="{{$student->roll_no}}"
                                                            data-courseId="{{$student->course_id}}"
                                                            data-phaseId="{{$student->phase_id}}"
                                                            data-batchTypeId="{{$student->batch_type_id}}">
                                                            <div class="details">
                                                                <img src=" {{asset($imageSrc)}}" alt="Photo"/>
                                                                <span>{{$student->full_name_en}} - <strong>Batch:</strong> {{$student->batch_type_id === 1 ? 'Regular' : 'Irregular'}} - <strong>Roll:</strong> {{ $student->roll_no }}</span>
                                                            </div>
                                                            <i class="uil uil-draggabledots"></i>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button id="update-btn" type="submit" class="btn btn-primary not-allowed mt-3">Update
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        //window scroll up-down code start
        var stop = true;
        $(".draggable").on("drag", function (e) {

            stop = true;

            if (e.originalEvent.clientY < 150) {
                stop = false;
                scroll(-1)
            }

            if (e.originalEvent.clientY > ($(window).height() - 150)) {
                stop = false;
                scroll(1)
            }

        });

        $(".draggable").on("dragend", function (e) {
            stop = true;
        });

        var scroll = function (step) {
            var scrollY = $(window).scrollTop();
            $(window).scrollTop(scrollY + step);
            if (!stop) {
                setTimeout(function () { scroll(step) }, 20);
            }
        }
        //window scroll up-down code end

        //element drag code start
        document.getElementById('update-btn').disabled = true;
        var el;

        function allowDrop(e) {
            e.preventDefault();
        }

        function dragOver(e) {
            e.preventDefault();
            el.classList.add('hidden');
            if (isBefore(el, e.target)) {
                e.target.parentNode.insertBefore(el, e.target);
            } else {
                e.target.parentNode.insertBefore(el, e.target.nextSibling);
            }
            updateIndexes(); // Call a function to update indexes after reordering
            updateHiddenInput() // Call a function to update hidden input after reordering
        }

        function dragEnd() {
            el.classList.remove('hidden');
            el = null;
        }

        function dragStart(e) {
            e.dataTransfer.effectAllowed = "move";
            e.dataTransfer.setData("text/plain", null);
            el = e.target;
        }

        function isBefore(el1, el2) {
            if (el1.parentNode === el2.parentNode) {
                for (var cur = el1.previousSibling; cur; cur = cur.previousSibling) {
                    if (cur === el2) {
                        return true;
                    }
                }
            }
            return false;
        }

        function updateIndexes() {
            var items = document.querySelectorAll('.sortable-list .item');
            items.forEach(function (item, index) {
                var fullName = item.getAttribute('data-fullName');
                var roll = item.getAttribute('data-roll');
                if(item.getAttribute('data-batchTypeId') == 1){
                    var batch = 'Regular';
                }else {
                    var batch = 'Irregular';
                }
                item.querySelector('span').innerHTML = fullName + ' - <strong>Batch:</strong> ' + batch + ' - <strong>Roll:</strong> ' + roll + '=>' + (index + 1);

            });
        }

        function updateHiddenInput() {
            var items = document.querySelectorAll('.sortable-list .item');
            var studentsId = [];
            var studentsRoll = [];
            items.forEach(function (item, index) {
                var studentId = item.getAttribute('data-id');
                studentsId.push(studentId);
            });
            //Convert the array to a JSON string & Set the JSON string as the value of the hidden input field
            document.getElementById('students').value = JSON.stringify(studentsId);
            document.getElementById('update-btn').disabled = false;
            document.getElementById('update-btn').removeClass('not-allowed');
            // document.getElementById('students_id').value = studentsId.join(', ');
        }
        //element drag code end
    </script>
@endpush
