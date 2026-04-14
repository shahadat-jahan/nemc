@extends('layouts.default')
@push('style')
    <style>
        li .list-unstyled {
            padding-left: 30px;
        }

        .permissions-card {
            background: #f9f9fb;
            border: 1px solid #e2e5ec;
            border-radius: 8px;
            padding: 24px 18px 18px 18px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .custom-checkbox {
            position: relative;
            padding-left: 28px;
            cursor: pointer;
            user-select: none;
            display: inline-flex;
            align-items: center;
        }

        .custom-checkbox input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .custom-checkbox .checkmark {
            position: absolute;
            left: 0;
            top: 2px;
            height: 18px;
            width: 18px;
            background-color: #fff;
            border: 1.5px solid #b5b5c3;
            border-radius: 4px;
            transition: background 0.2s, border 0.2s;
        }

        .custom-checkbox input:checked~.checkmark {
            background-color: #34bfa3;
            border-color: #34bfa3;
        }

        .custom-checkbox input:disabled~.checkmark {
            background-color: #f5f5f5;
            border-color: #d1d3e0;
            cursor: not-allowed;
        }

        .custom-checkbox input:disabled:checked~.checkmark {
            background-color: #a0a0a0;
            border-color: #a0a0a0;
        }

        .custom-checkbox .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .custom-checkbox input:checked~.checkmark:after {
            display: block;
        }

        .custom-checkbox .checkmark:after {
            left: 6px;
            top: 2px;
            width: 4px;
            height: 9px;
            border: solid white;
            border-width: 0 2.5px 2.5px 0;
            transform: rotate(45deg);
        }

        .disabled-label {
            color: #6c757d;
            opacity: 0.7;
        }

        @media (max-width: 600px) {
            .permissions-card {
                padding: 10px 4px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Update Teacher Permissions</h3>
                <a href="{{ route('teacher.index') }}" class="btn btn-primary"><i class="fa fa-users pr-2"></i>Teachers</a>
            </div>
            <form action="{{ route('teacher.extra.permission') }}" method="post">
                @csrf
                <div class="card-body">
                    <input type="hidden" name="group_id" value="{{ $userGroup->id }}">
                    <input type="hidden" name="teacher_id" value="{{ $teacherId }}">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><span class="text-danger">*</span> Group Name </label>
                            <input type="text" class="form-control" name="group_name"
                                   value="{{ $userGroup->group_name }}" disabled />
                        </div>
                    </div>

                    <label class="form-label">Modules</label>
                    <div class="mb-2">
                        <button type="button" class="btn btn-sm btn-primary" id="selectAllBtn"><i
                                class="fa fa-check-square-o"></i> Select All</button>
                        <button type="button" class="btn btn-sm btn-warning" id="deselectAllBtn"><i
                                class="fa fa-square-o"></i> Deselect All</button>
                    </div>

                    <div class="row">
                        @foreach (Config::get('menu') as $key => $val)
                            @php
                                $checked =
                                    (array_key_exists($key, $userGroupPermissions) and
                                    $userGroupPermissions[$key] > 0)
                                        ? 'checked'
                                        : '';
                                $readOnly =
                                    (array_key_exists($key, $userGroupPermissions) and
                                    $userGroupPermissions[$key] > 0 and
                                    array_key_exists($key, $onlyTeacherGroupPermissions))
                                        ? 'disabled'
                                        : '';
                            @endphp
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 border-info">
                                    <div class="card-header bg-info text-white py-2">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   style="transform:scale(1.3);margin-right:10px;" type="checkbox"
                                                   name="action[]" value="{{ $key }}"
                                                   id="perm-{{ $key }}" {{ $checked }} {{ $readOnly }}>
                                            <label class="form-check-label font-weight-bold pl-1"
                                                   for="perm-{{ $key }}">{{ $val['title'] }}</label>
                                            @if ($readOnly == 'disabled')
                                                <input type="hidden" name="action[]" value="{{ $key }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @if (sizeof($val['children']) > 0)
                                                @foreach ($val['children'] as $cKey => $cVal)
                                                    @php
                                                        $cChecked =
                                                            (array_key_exists($cKey, $userGroupPermissions) and
                                                            $userGroupPermissions[$cKey] > 0)
                                                                ? 'checked'
                                                                : '';
                                                        $cReadOnly =
                                                            (array_key_exists($cKey, $userGroupPermissions) and
                                                            $userGroupPermissions[$cKey] > 0 and
                                                            array_key_exists($cKey, $onlyTeacherGroupPermissions))
                                                                ? 'disabled'
                                                                : '';
                                                    @endphp
                                                    <div class="col-12 mb-2">
                                                        <div class="bg-light rounded p-2 mb-2">
                                                            <div class="form-check mb-1">
                                                                <input class="form-check-input"
                                                                       style="transform:scale(1.3);margin-right:10px;"
                                                                       type="checkbox" name="action[]"
                                                                       value="{{ $cKey }} "
                                                                       id="perm-{{ $cKey }}" {{ $cChecked }}
                                                                    {{ $cReadOnly }}>
                                                                <label class="form-check-label font-weight-bold pl-1"
                                                                       for="perm-{{ $cKey }}">{{ $cVal['title'] }}</label>
                                                                @if ($cReadOnly == 'disabled')
                                                                    <input type="hidden" name="action[]"
                                                                           value="{{ $cKey }} ">
                                                                @endif
                                                            </div>
                                                            <div class="row ms-3">
                                                                @foreach ($cVal['actions'] as $aKey => $aVal)
                                                                    @php
                                                                        $cAChecked =
                                                                            (array_key_exists(
                                                                                $cKey . '/' . $aVal,
                                                                                $userGroupPermissions,
                                                                            ) and
                                                                            $userGroupPermissions[
                                                                                $cKey . '/' . $aVal
                                                                            ] >
                                                                                0)
                                                                                ? 'checked'
                                                                                : '';
                                                                        $cAReadOnly =
                                                                            (array_key_exists(
                                                                                $cKey . '/' . $aVal,
                                                                                $userGroupPermissions,
                                                                            ) and
                                                                            $userGroupPermissions[
                                                                                $cKey . '/' . $aVal
                                                                            ] >
                                                                                0 and
                                                                            array_key_exists(
                                                                                $cKey . '/' . $aVal,
                                                                                $onlyTeacherGroupPermissions,
                                                                            ))
                                                                                ? 'disabled'
                                                                                : '';
                                                                    @endphp
                                                                    <div class="col-6 col-md-6 mb-1">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                   style="transform:scale(1.3);margin-right:10px;"
                                                                                   type="checkbox" name="action[]"
                                                                                   value="{{ $cKey . '/' . $aVal }}"
                                                                                   id="perm-{{ $cKey }}-{{ $aVal }}"
                                                                                {{ $cAChecked }}
                                                                                {{ $cAReadOnly }}>
                                                                            <label class="form-check-label pl-1"
                                                                                   for="perm-{{ $cKey }}-{{ $aVal }}">{{ str_replace('_', ' ', $aVal) }}</label>
                                                                            @if ($cAReadOnly == 'disabled')
                                                                                <input type="hidden" name="action[]"
                                                                                       value="{{ $cKey . '/' . $aVal }}">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                @foreach ($val['actions'] as $aKey => $aVal)
                                                    @php
                                                        $aChecked =
                                                            (array_key_exists(
                                                                $key . '/' . $aVal,
                                                                $userGroupPermissions,
                                                            ) and
                                                            $userGroupPermissions[$key . '/' . $aVal] > 0)
                                                                ? 'checked'
                                                                : '';
                                                        $aReadOnly =
                                                            (array_key_exists(
                                                                $key . '/' . $aVal,
                                                                $userGroupPermissions,
                                                            ) and
                                                            $userGroupPermissions[$key . '/' . $aVal] > 0 and
                                                            array_key_exists(
                                                                $key . '/' . $aVal,
                                                                $onlyTeacherGroupPermissions,
                                                            ))
                                                                ? 'disabled'
                                                                : '';
                                                    @endphp
                                                    <div class="col-6 col-md-6">
                                                        <div class="form-check ms-2">
                                                            <input class="form-check-input"
                                                                   style="transform:scale(1.3);margin-right:10px;"
                                                                   type="checkbox" name="action[]"
                                                                   value="{{ $key . '/' . $aVal }}"
                                                                   id="perm-{{ $key }}-{{ $aVal }}"
                                                                {{ $aChecked }} {{ $aReadOnly }}>
                                                            <label class="form-check-label pl-1"
                                                                   for="perm-{{ $key }}-{{ $aVal }}">{{ str_replace('_', ' ', $aVal) }}</label>
                                                            @if ($aReadOnly == 'disabled')
                                                                <input type="hidden" name="action[]"
                                                                       value="{{ $key . '/' . $aVal }}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="{{ url('admin/user_groups') }}" class="btn btn-secondary mr-2"><i class="fa fa-times"></i>
                            Cancel</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Select All / Deselect All
        $('#selectAllBtn').click(function() {
            $('input[type="checkbox"]').not(':disabled').prop('checked', true).trigger('change');
        });
        $('#deselectAllBtn').click(function() {
            $('input[type="checkbox"]').not(':disabled').prop('checked', false).trigger('change');
        });
        // Parent-child checkbox logic
        $('input[type="checkbox"]').change(function() {
            var $this = $(this);
            var val = $this.val();
            if ($this.closest('.card-header').length) {
                // Module checkbox
                $this.closest('.card').find('input[type="checkbox"]').not(':disabled').prop('checked', this
                    .checked);
            } else if ($this.closest('.bg-light').length && !$this.closest('.row').is('.ms-3')) {
                // Child checkbox
                var childBlock = $this.closest('.bg-light');
                childBlock.find('.row.ms-3 input[type="checkbox"]').not(':disabled').prop('checked', this.checked);
            } else if ($this.closest('.ms-2').length) {
                // (Optional) If you want to update module checkbox based on all children
                var card = $this.closest('.card');
                var allChecked = card.find('.ms-2 input[type="checkbox"]').not(':disabled').length === card.find(
                    '.ms-2 input[type="checkbox"]:checked').not(':disabled').length;
                card.find('.card-header input[type="checkbox"]').not(':disabled').prop('checked', allChecked);
            }

            // ACTION: If any action under a child is checked, check the child; if none, uncheck the child
            if ($this.closest('.row.ms-3').length) {
                var childBlock = $this.closest('.bg-light');
                var actions = childBlock.find('.row.ms-3 input[type="checkbox"]').not(':disabled');
                var checkedActions = actions.filter(':checked').length;
                var childCheckbox = childBlock.find('> .form-check input[type="checkbox"]').not(':disabled');
                childCheckbox.prop('checked', checkedActions > 0);
            }

            // MODULE: If any child or action in a module is checked, check the module; if none, uncheck the module
            var card = $this.closest('.card');
            if (card.length) {
                var allModuleChecks = card.find('.bg-light input[type="checkbox"], .ms-2 input[type="checkbox"]')
                    .not(':disabled');
                var checkedModuleChecks = allModuleChecks.filter(':checked').length;
                var moduleCheckbox = card.find('.card-header input[type="checkbox"]').not(':disabled');
                moduleCheckbox.prop('checked', checkedModuleChecks > 0);
            }
        });
    </script>
@endpush
