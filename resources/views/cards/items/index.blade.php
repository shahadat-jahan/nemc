@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <link href="{{asset('assets/global/plugins/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
@endpush
<?php
$cardId = !empty($cardInfo) ? $cardInfo->id : '';
$subjectId = !empty($cardInfo) ? $cardInfo->subject->id : '';
$subjectGroupId = !empty($cardInfo) ? $cardInfo->subject->subject_group_id : '';
$courseId = !empty($cardInfo) ? $cardInfo->subject->subjectGroup->course_id : '';
?>
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul pr-2"></i>Card Items</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('card_items/create'))
                            <a href="{{ route('cardItems.create') }}" class="btn btn-primary m-btn m-btn--icon" title="Create New"><i class="fa fa-plus pr-2"></i>Create</a>
                        @endif
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value=" ">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="subject_group_id" id="subject_group_id">
                                            <option value=" ">---- Select Subject Group ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="subject_id" id="subject_id">
                                            <option value=" ">---- Select Subject ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="card_id" id="card_id">
                                            <option value=" ">---- Select Card ----</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="clearfix"><hr/></div>

                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i> Search</button>
                                        <button type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</button>
                                    </div>
                                </div>
                            </div><br/>
                        </div>
                    </form>
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="table m-table table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTable">
                                            <thead>
                                            <tr>
                                                @foreach ($tableHeads as $key => $title)
                                                    <th class="uppercase"><?=$title;?></th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{asset('assets/global/plugins/datatables/datatables.bundle.js')}}" type="text/javascript"></script>

<script>
    //get subject group by course id
    var cardId = '{{$cardId}}';
    var subjectId = '{{$subjectId}}';
    var courseId = $('#course_id').val();
    var subjectGroupId = '{{$subjectGroupId}}';

    $('#course_id').change(function (e) {
        courseId = $(this).val();

        // load subject group
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get('{{route('SubjectGroup.course')}}', {courseId: courseId}, function (response) {
                $('#subject_group_id').html('<option value="">---- Select Subject Group ----</option>');
                if (response.data){
                    for (i in response.data){
                        subjectGroup = response.data[i];
                        selected = (subjectGroupId == subjectGroup.id) ? 'selected' : '';
                        $('#subject_group_id').append('<option value="'+subjectGroup.id+'" '+selected+'>'+subjectGroup.title+'</option>')
                    }
                }
                mApp.unblockPage()
            })
    });

    if (courseId > 0) {
        mApp.blockPage({
            overlayColor: "#000000",
            type: "loader",
            state: "primary",
            message: "Please wait..."
        });

        $.get('{{route('SubjectGroup.course')}}', {courseId: courseId}, function (response) {
            $('#subject_group_id').html('<option value="">---- Select Subject Group ----</option>');
            if (response.data) {
                for (i in response.data) {
                    subjectGroup = response.data[i];
                    selected = (subjectGroupId == subjectGroup.id) ? 'selected' : '';
                    $('#subject_group_id').append('<option value="' + subjectGroup.id + '" ' + selected + '>' + subjectGroup.title + '</option>')
                }
            }
            mApp.unblockPage()
        })
    }

    //get subject by course id and subject group id
    $('#course_id, #subject_group_id').change(function (e) {
        courseId = $('#course_id').val();
        subjectGroupId = $('#subject_group_id').val();

        // load subject
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get('{{route('subjects.course.group')}}', {courseId: courseId, subjectGroupId: subjectGroupId}, function (response) {
                $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                if (response.data){
                    for (i in response.data){
                        subject = response.data[i];
                        $('#subject_id').append('<option value="'+subject.id+'">'+subject.title+'</option>')
                    }
                }
                mApp.unblockPage()
            })
    });

    //get item by subject id
    var columns = eval('{!! json_encode($columns) !!}');


    $('#subject_id').change(function (e) {
        e.preventDefault();

        subjectChoiseId = $(this).val();

        $.get(baseUrl+'admin/cards/subjects/'+subjectChoiseId,{},function (response) {
            $("#card_id").html('<option value="">---- Select Card ----</option>');
            if (response.data.length > 0){
                for (i in response.data){
                    item = response.data[i];
                    selected = (cardId == item.id) ? 'selected' : '';
                    $("#card_id").append('<option value="' + item.id + '" '+selected+'>' + item.title + '</option>');
                }
            }
        })
    });

    var dataTable = $('#dataTable').DataTable({
         dom: 'rt<"row"<"col-md-2 col-sm-12"l><"col-md-5 col-sm-12 text-center"i><"col-md-5 col-sm-12"p>>',
        language: {
            search: "",
            searchPlaceholder: "Search",
        },
        lengthMenu: [
            [10, 20, 50, 100, 150, 200, -1],
            [10, 20, 50, 100, 150, 200, "All"]
        ],
        pageLength: 10,
        pagingType: "full_numbers",
        order: [
            [0, "desc"]
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url($dataUrl) }}',
            data: function (e) {
                var fields = $('#searchForm').serializeArray();
                $.each( fields, function( i, field ) {
                    e[field.name] = field.value;
                });
            }
        },
        columns: columns
    });

    $('#searchForm').submit(function (e) {
        e.preventDefault();
        dataTable.draw();
    });

    $('.reset').click(function (e) {
        e.preventDefault();
        $('#searchForm').trigger("reset");
        $('#subject_id').val('');
        $('#subject_id').selectpicker('refresh');
        dataTable.draw();
    });

    if (subjectId > 0){
        $('#subject_id').trigger('change');
        dataTable.draw();
    }


    if (cardId > 0 && subjectId > 0 && courseId > 0 && subjectGroupId > 0){
        var ajax1 = $.get('{{route('SubjectGroup.course')}}', {courseId: courseId}, function (response) {
                if (response.data){
                    $('#subject_group_id').html('<option value="">---- Select ----</option>');
                    for (i in response.data){
                        subjectGroup = response.data[i];
                        selected = (subjectGroupId == subjectGroup.id) ? 'selected' : '';
                        $('#subject_group_id').append('<option value="'+subjectGroup.id+'" '+selected+'>'+subjectGroup.title+'</option>')
                    }

                }
            }),
            ajax2 = $.get('{{route('subjects.course.group')}}', {courseId: courseId, subjectGroupId: subjectGroupId}, function (response) {
                if (response.data){
                    $('#subject_id').html('<option value="">---- Select ----</option>');
                    for (i in response.data){
                        subject = response.data[i];
                        console.log(subjectId+'......1');
                        console.log(subject.id+'......2');
                        selected = (subjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="'+subject.id+'" '+selected+'>'+subject.title+'</option>')
                    }

                }
            }),
            ajax3 = $.get(baseUrl+'admin/cards/subjects/'+subjectId,{},function (response) {
                $("#card_id").html('<option value="">--Select Card--</option>');
                if (response.data.length > 0){
                    for (i in response.data){
                        item = response.data[i];
                        selected = (cardId == item.id) ? 'selected' : '';
                        $("#card_id").append('<option value="' + item.id + '" '+selected+'>' + item.title + '</option>');
                    }
                }
            });

        $.when(ajax1, ajax2, ajax3).done(function(req1, req2, req3) {
            dataTable.draw();
        });
    }

</script>
@endpush
