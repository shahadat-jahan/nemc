@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        #dataTable_wrapper tbody tr td:last-child {
            width: 7rem !important;
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
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('students/create'))
                            <a href="{{ route('students.create') }}" class="btn btn-primary m-btn m-btn--icon"
                               title="Add New Applicant"><i class="fa fa-plus"></i> Add Student</a>
                        @endif
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="student_category_id">
                                            <option value="">---- Select Category ----</option>
                                            {!! select($studentCategories) !!}

                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases) !!}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="user_id"
                                               placeholder="User ID"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="roll_no"
                                               placeholder="Roll No"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="full_name_en"
                                               placeholder="Student Name"/>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="email"
                                               placeholder="Email"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="phone_mobile"
                                               placeholder="Phone"/>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control student_id select2" name="student_id">
                                            <option value="">---- Fuzzy Search ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="reg_no"
                                               placeholder="Registration No"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select type="text" class="form-control m-input" name="status">
                                            <option value="">---- Select Status ----</option>
                                            {!! select($studentStatus) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
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

    @include('common.messageModal')

    @push('scripts')
        <script>

            $(document).ready(function () {
                $(document).on('click', '.copy-id', function () {
                    let studentId = $(this).data('id');
                    let tempInput = $("<input>");
                    $("body").append(tempInput);
                    tempInput.val(studentId).select();
                    document.execCommand("copy");
                    tempInput.remove();
                    toastr.info("Copied ID: " + studentId);
                });

                $(".student_id").select2({
                    allowClear: true,
                    minimumInputLength: 2,
                    dropdownAutoWidth: true,
                    placeholder: '-- Name/Phone/Reg Number/Email --',
                    ajax: {
                        url: '/admin/fuzzy-search-student',
                        dataType: 'json',
                        type: "GET",
                        quietMillis: 50,
                        data: function (params) {
                            return {
                                search_term: params.term,
                                data_for: 'select',
                                search_column: 'full_name_en'
                            }
                        },
                        processResults: function (data) {
                            var arr = []
                            console.log(data);
                            $.each(data, function (index, value) {
                                arr.push({
                                    id: index,
                                    text: value
                                })
                            })
                            return {
                                results: arr
                            };
                        },
                        // cache: true
                    },

                });
                $('.student_id').trigger('change');
            });
        </script>
    @endpush

@endsection
