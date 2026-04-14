@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fa fa-eye pr-2"></i> View Student Group Type</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                @if(hasPermission('student_group_type/index'))
                    <a href="{{ route('student_group_type.index') }}" class="btn btn-primary m-btn m-btn--icon mr-2">
                        <i class="fa fa-arrow-left pr-2"></i>Back to List
                    </a>
                @endif
                @if (hasPermission('student_group_type/edit'))
                    <a href="{{ route('student_group_type.edit', [$studentGroupType->id]) }}"
                       class="btn btn-primary m-btn m-btn--icon">
                        <i class="fa fa-edit pr-2"></i>Edit
                    </a>
                @endif
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <h5><strong>Title:</strong></h5>
                    <p>{{ $studentGroupType->title }}</p>
                </div>
                <div class="col-md-4">
                    <h5><strong>Status:</strong></h5>
                    <p>
                        @if($studentGroupType->status)
                            <span class="m-badge m-badge--success">Active</span>
                        @else
                            <span class="m-badge m-badge--danger">Inactive</span>
                        @endif
                    </p>
                </div>
                <div class="col-4">
                    <h5><strong>Description:</strong></h5>
                    <p>{{ $studentGroupType->description ?: 'No Description Available'}}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <h5><strong>Class Types:</strong></h5>
                    <ul>
                        @if(optional($studentGroupType->classTypes)->count())
                            @foreach($studentGroupType->classTypes as $classType)
                                <li>{{ $classType->title }}</li>
                            @endforeach
                        @else
                            <li><em>None assigned</em></li>
                        @endif
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5><strong>Exam Categories:</strong></h5>
                    <ul>
                        @if(optional($studentGroupType->examCategories)->count())
                            @foreach($studentGroupType->examCategories as $examCategory)
                                <li>{{ $examCategory->title }}</li>
                            @endforeach
                        @else
                            <li><em>None assigned</em></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
