@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .table td {
            padding-top: 0.6rem !important;
            padding-bottom: .6rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
        }
    </style>
@endpush
@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Add Card Items</h3>
                </div>
            </div>
        </div>

        <?php

        if (!empty($card)){
            $selectedCard = $card->id;
            $subjectId = $card->subject->id;
        }else{
            $selectedCard = '';
            $subjectId = '';
        }
        ?>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('cardItems.store') }}" id="nemc-general-form" method="post">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                            <select class="form-control" name="course_id" id="course_id">
                                <option value=" ">---- Select Course ----</option>
                                {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_group_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject Group </label>
                            <select class="form-control m-input" name="subject_group_id" id="subject_group_id">
                                <option value=" ">---- Select Subject Group ----</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject </label>
                            <select class="form-control m-input" name="subject_id" id="subject_id">
                                <option value=" ">---- Select Subject ----</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('card_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Card </label>
                            <select class="form-control" name="card_id" id="card_id">
                                <option value="">---- Select Card ----</option>
                            </select>
                            @if ($errors->has('card_id'))
                                <div class="form-control-feedback">{{ $errors->first('card_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row item-row card-items">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Item Serial Number </label>
                            <input type="number" class="form-control m-input item-serial-no" name="serial_number[]"  id="item-serial-no" placeholder="Item Serial Number" readonly/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Item Title </label>
                            <input type="text" class="form-control m-input item-title" name="title[]" placeholder="Item Title"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 col-xl-1 mt-5">
                        <button type="button" class="btn btn-success btn-sm add-row btn btn-primary m-btn m-btn--icon" title="Add"><i class="fa fa-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-sm remove-row m--hide"><i class="fa fa-times" title="Remove"></i></button>
                    </div>

                </div>

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ route('cardItems.index') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
        <!--end::Form-->

        <!-- show item list for card selected from dropdown start -->
        <div id="item-list-container" class="row pb-5 m--hide">
            <div class="col-12">
                <div class="m-separator m-separator--dashed"></div>
                <h5 class="text-center">Selected Card's item list</h5>
            </div>
            <div class="col-12 px-5">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="uppercase">Serial No.</th>
                        <th class="uppercase">Item Title</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- show item list for card selected from dropdown start -->
    </div>
@endsection

@push('scripts')
    <script>
        var baseUrl = '{!! url('/') !!}/';

        //get subject group by course id
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
                            $('#subject_group_id').append('<option value="'+subjectGroup.id+'">'+subjectGroup.title+'</option>')
                        }
                    }
                    mApp.unblockPage()
                })
        });

        let courseId = $('#course_id').val();

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
            if (courseId > 0 && subjectGroupId > 0){
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
            }

        });

        //get card by subject id

        var selectedSubject = '{{$subjectId}}';
        var selectedCard = '{{$selectedCard}}';

        $('#subject_id').change(function (e) {
            e.preventDefault();

            subjectId = $(this).val();

            $.get(baseUrl+'admin/cards/subjects/'+subjectId,{},function (response) {
                $("#card_id").html('<option value="">---- Select Card ----</option>');
                if (response.data.length > 0){
                    for (i in response.data){
                        item = response.data[i];
                        selected = (selectedCard == item.id) ? 'selected' : '';
                        $("#card_id").append('<option value="' + item.id + '" '+selected+'>' + item.title + '</option>');
                    }
                }
                $('.m_selectpicker').selectpicker('refresh');
            })
        });

        //get item names by cardId
        $('#card_id').change(function (e) {
            $("#item-list-container table tbody").html('');
            cardId = $(this).val();
            if (cardId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('item.list.cardId')}}', {cardId: cardId}, function (response) {
                    if (response.status){
                        for (i in response.data){
                            itemName = response.data[i];
                            var serialNo= ++i;
                            $("#item-list-container table tbody").append('<tr> ' +
                                '<td>'+serialNo+'</td> ' +
                                '<td>'+itemName+'</td> ' +
                                '</td>');
                        }
                        $('#item-list-container').removeClass('m--hide')
                    }
                    mApp.unblockPage()
                })
            }

        });


        if (selectedSubject > 0){
            $('#subject_id').trigger('change');
        }

        //get max item serial number by cardId
        $('#card_id').change(function (e) {
            cardId = $(this).val();
            if (cardId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('item.serial.cardId')}}', {cardId: cardId}, function (response) {
                    if (response.status){
                        itemSerialNumber = response.data;
                         passItemSerialNo(itemSerialNumber);
                    }
                    mApp.unblockPage()
                })
            }

        });

        var plusButton = $('.hide');

       function passItemSerialNo(itemSerialNumber){
            serialNo = itemSerialNumber+1;

           $('#item-serial-no').val(serialNo);

           $('.add-row').on('click',function(){
               var copyRow = $('.item-row');
               var copydata = copyRow.clone(true);
               copydata.find('.item-title').val('');
               serialNo++;
               copydata.find('.item-serial-no').val(serialNo);
               copyRow.removeClass('item-row');
               $(this).parents('.row').after(copydata);
               $(this).parents('.card-items').find('.remove-row').removeClass('m--hide');
               $(this).parents('.row').find('.add-row').detach();
           });

           // code for remove
           $('.remove-row').on('click',function(){
               Swal.fire({
                   title: 'Are you sure?',
                   text: "Do you want to remove this",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonText: 'Yes'
               }).then((result) => {
                   if (result.value) {
                       // if($('.payment-detail-row').length > 2){
                       $(this).parents('.card-items').prev('.row').addClass('copy-data')
                       $(this).parents('.card-items').prev('.row').find('.col-md-1:last').prepend(plusButton.removeClass('hide'));
                       $(this).parents('.card-items').detach();
                       // }

                   }else if (result.dismiss === Swal.DismissReason.cancel){
                       return false;
                   }
               });
           });
        }

        // code for add

        $.validator.addMethod("item_title", function (value, element) {
            var flag = true;
            $(".item-title").each(function (i, j) {
                if ($.trim($(this).val()) == '') {
                    flag = false;
                    $(this).parents('.form-group').addClass('has-danger');
                }else{
                    $(this).parents('.form-group').removeClass('has-danger');
                }
            });
            return flag;

        }, "");

        //check item title is unique
        $.validator.addMethod("item_title_unique", function (value, element) {
                var flag = true;
                //store all item title
                var ar = $('.item-title').map(function() {
                    if ($(this).val() != '') return $(this).val()
                }).get();

                //check item title unique
                var uniqueTitle = ar.filter(function(item, pos) {
                    return ar.indexOf(item) != pos;
                });

                if (uniqueTitle.length != 0){
                    flag = false;
                    Swal.fire({
                        title: 'Item Title need to be Unique',
                        type: 'warning',
                        //showCancelButton: true,
                        confirmButtonText: 'Ok'
                    })
                }else {
                     flag = true;
                }
            return flag;

        }, "");


        $('#nemc-general-form').validate({
            rules:{
                course_id: {
                    required: true,
                    min: 1
                },
                subject_group_id: {
                    required: true,
                    min: 1
                },
                subject_id: {
                    required: true,
                    min: 1
                },
                card_id: {
                    required: true,
                    min: 1
                },
                'title[]': {
                    item_title: true,
                    item_title_unique: true,
                },
                'serial_number[]': {
                    item_title: true,
                }
            }
        });

    </script>
@endpush
