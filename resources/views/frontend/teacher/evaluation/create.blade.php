@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .table th {
            vertical-align: middle !important;
            background-color: #f4f5f8;
            font-weight: 600;
        }

        .table td {
            vertical-align: middle;
        }

        .statement-rating {
            cursor: pointer;
        }

        .select-all-btn {
            font-size: 11px;
            padding: 4px 8px;
            white-space: nowrap;
        }

        .bg-light {
            background-color: #fdfdfd !important;
        }
    </style>
@endpush

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-clipboard-check pr-2"></i>Teacher Evaluation</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ route('frontend.teacher.show', $teacher->id) }}"
                   class="btn btn-primary m-btn m-btn--icon"><i
                        class="fas fa-user-tie pr-2"></i>Back to Teacher</a>
            </div>
        </div>

        <form action="{{ route('frontend.teacher.evaluation.store', $teacher->id) }}" method="POST" id="evaluationForm">
            @csrf

            <div class="m-portlet__body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <strong>Teacher:</strong> {{ $teacher->full_name }}<br>
                            <strong>Department:</strong> {{ !empty($teacher->department->title) ? $teacher->department->title : 'N/A' }}
                            <br>
                            <strong>Course:</strong> {{ !empty($teacher->course->title) ? $teacher->course->title : 'N/A' }}
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width: 50%;">Statement</th>
                            <th style="width: 10%; text-align: center;">1 (Never)</th>
                            <th style="width: 10%; text-align: center;">2 (Once in a while)</th>
                            <th style="width: 10%; text-align: center;">3 (Sometimes)</th>
                            <th style="width: 10%; text-align: center;">4 (Most of the time)</th>
                            <th style="width: 10%; text-align: center;">5 (Almost Always)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="bg-light">
                            <td>
                                <button type="button" class="btn btn-warning" id="clearAll">
                                    <i class="fas fa-eraser"></i> Clear All
                                </button>
                            </td>
                            @for($rating = 1; $rating <= 5; $rating++)
                                <td style="text-align: center;">
                                    <button type="button" class="btn btn-sm btn-info select-all-btn"
                                            data-rating="{{ $rating }}">
                                        <i class="fas fa-check-double"></i> Select All
                                    </button>
                                </td>
                            @endfor
                        </tr>
                        @forelse($evaluationStatements as $id => $statement)
                            <tr>
                                <td>{{$id}}. {{ $statement }}</td>
                                @for($rating = 1; $rating <= 5; $rating++)
                                    <td style="text-align: center;">
                                        <label class="m-radio">
                                            <input type="radio" name="statement_{{ $id }}_rating"
                                                   value="{{ $rating }}" class="statement-rating rating-{{ $rating }}">
                                            <span></span>
                                        </label>
                                    </td>
                                @endfor
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No evaluation statements found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label"><strong>I consider this teacher a role
                                    model</strong></label>
                            <div class="m-radio-inline">
                                <label class="m-radio">
                                    <input type="radio" name="is_role_model" value="1">
                                    Yes
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="is_role_model" value="0">
                                    No
                                    <span></span>
                                </label>
                            </div>
                            @error('is_role_model')
                            <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-portlet__foot">
                <div class="m-form__actions text-center">
                    <a href="{{ route('frontend.teacher.show', $teacher->id) }}" class="btn btn-outline-brand"><i
                            class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Select all buttons functionality
            $('.select-all-btn').on('click', function () {
                const rating = $(this).data('rating');
                $('.rating-' + rating).prop('checked', true);
                toastr.success('All statements set to rating ' + rating);
            });

            // Clear all button functionality
            $('#clearAll').on('click', function () {
                $('.statement-rating').prop('checked', false);
                toastr.info('All selections cleared');
            });

            // Form validation
            $('#evaluationForm').on('submit', function (e) {
                let allRated = true;

                // Check if all statements are rated
                for (let i = 1; i <= 15; i++) {
                    const checked = $('input[name="statement_' + i + '_rating"]:checked').length > 0;
                    if (!checked) {
                        allRated = false;
                        break;
                    }
                }

                if (!allRated) {
                    e.preventDefault();
                    toastr.error('Please rate all statements before submitting.');
                    return false;
                }

                const roleModel = $('input[name="is_role_model"]:checked').length > 0;
                if (!roleModel) {
                    e.preventDefault();
                    toastr.error('Please answer the role model question.');
                    return false;
                }
            });
        });
    </script>
@endpush
