@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item, .m-stack--demo.m-stack--hor .m-stack__demo-item{
            padding: 29px;
        }
        .exam-delete {
            color: red;
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
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('exams/create'))
                            <a href="{{ route('exams.create') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-plus pr-2"></i>Create</a>
                        @endif
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <form id="searchForm" role="form" method="post">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases) !!}
                                        </select>
                                    </div>
                                </div>
<!--                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="term_id" id="term_id">
                                            <option value="">---- Select Term ----</option>
                                            {!! select($terms) !!}
                                        </select>
                                    </div>
                                </div>-->

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="term_id" id="term_id">
                                           <option value="">---- Select ----</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control" name="exam_category_id" id="exam_category_id">
                                        <option value="">---- Select Exam Category ----</option>
                                        {!! select($examCategories, app()->request->exam_category_id) !!}
                                    </select>
                                </div>

<!--                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="subject_id" id="subject_id">
                                            <option value="">---- Select Subject ----</option>
                                            {!! select($subjects, app()->request->subject_id) !!}
                                        </select>
                                    </div>
                                </div>-->

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                   <div class="form-group  m-form__group">
                                       <input type="text" class="form-control m-input m_datepicker" name="from_date" value="{{app()->request->from_date}}" id="from_date" placeholder="Date From" autocomplete="off"/>
                                   </div>
                               </div>
                               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                   <div class="form-group  m-form__group">
                                       <input type="text" class="form-control m-input m_datepicker" name="to_date" value="{{app()->request->to_date}}" id="to_date" placeholder="Date To" autocomplete="off"/>
                                   </div>
                               </div>


                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i> Search</button>
                                        <button type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="table m-table table-responsive">
                                        @include('common/datatable')
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

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>

    <script>
        $('body').on('click', '.exam-delete', function (e) {
            e.preventDefault();
            var id = $(this).data('exam-id');
            var url = baseUrl + 'admin/exams/' + id;

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this exam?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                toastr.success(response.message, "Success");
                                $('#dataTable').DataTable().ajax.reload();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message, "Error");
                        }
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    return false;
                }
            });
        });

        $(document).on('click', '.toggle-status', function () {
            const examId = $(this).data('id');

            $.ajax({
                url: 'exams/toggle-status',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: examId
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#dataTable').DataTable().ajax.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function () {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });

        var phaseInfo = [];
        var total_terms='';
        var selectedPhase='';
        $('#course_id, #session_id').change(function () {
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            $.get('{{route('phase.term.list')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                 if (response.data){
                     phaseInfo = response.data;
                     console.log(phaseInfo);
                 }
            })
        });

        $('#phase_id').change(function () {
            phaseId = $(this).val();
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            //console.log(phaseInfo);
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

           selectedPhase = _.find(phaseInfo, function(o) { return o.phase.id  == phaseId; });

            console.log(selectedPhase);
            if (selectedPhase) {
              console.log(`x === undefined`)
              totalTerms=selectedPhase.total_terms;
            } else {
              console.log(`x !== undefined`)
              totalTerms=''
            }
            //total_terms=selectedPhase.total_terms ? selectedPhase.total_terms :'';
            //console.log(selectedPhase);
            $('#term_id').html('<option value="">---- Select ----</option>');
            for (var i = 1; i <= totalTerms; i++){
                $('#term_id').append('<option value="'+i+'"> Term '+i+'</option>')
            }
            mApp.unblockPage();
        });

        $(".m_datepicker").datepicker( {
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
        });

    </script>
@endpush
