<?php

use App\Services\UtilityServices;
use Carbon\Carbon;

/**
 * Make select box options
 */
function select($data = [], $value = ''): string
{
    if (empty($data)) {
        return '';
    }

    $html = '';
    foreach ($data as $key => $val) {
        $selected = is_array($value)
            ? (in_array($key, $value) ? 'selected' : '')
            : ($value == $key ? 'selected' : '');

        $html .= '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
    }

    return $html;
}

/**
 * Make checkbox group
 */
function checkbox($fieldName = '', $data = [], $values = [], $className = ''): string
{
    if (empty($data)) return '';

    $html = '<div class="mt-checkbox-list">';
    foreach ($data as $key => $val) {
        $checked = is_array($values) && in_array($key, $values) ? 'checked' : '';
        $html .= '<label class="mt-checkbox mt-checkbox-outline">
            <input type="checkbox" class="' . $className . '" name="' . $fieldName . '" value="' . $key . '" ' . $checked . '>' . $val . '
            <span></span>
        </label>';
    }
    $html .= '</div>';

    return $html;
}

/**
 * Make radio button group
 */
function radio($fieldName = '', $data = [], $value = '', $className = ''): string
{
    if (empty($data)) return '';

    $html = '<div class="mt-radio-list">';
    foreach ($data as $key => $val) {
        $checked = $key == $value ? 'checked' : '';
        $html .= '<label class="mt-radio mt-radio-outline">
            <input type="radio" class="' . $className . '" name="' . $fieldName . '" value="' . $key . '" ' . $checked . '>' . $val . '
            <span></span>
        </label>';
    }
    $html .= '</div>';

    return $html;
}

/**
 * Set operation messages
 */
function setMessage($type, $label = ''): string
{
    $label = ucfirst(strtolower($label));
    $type = strtolower($type);

    $messages = [
        'create' => "{$label} has been created successfully",
        'update' => "{$label} has been updated successfully",
        'delete' => "{$label} has been deleted successfully",
        'create.error' => "Error in saving {$label}",
        'update.error' => "Error in updating {$label}"
    ];

    return $messages[$type] ?? '';
}

/**
 * Format date with time
 */
function dateFormat($date): string
{
    return date('d M, Y g:i a', strtotime($date));
}

/**
 * Format full date
 */
function fullDateFormat($date): string
{
    return Carbon::createFromFormat('d/m/Y', $date)->format('F d, Y');
}

/**
 * Get status options
 */
function getStatus(): array
{
    return ['1' => 'Active', '0' => 'Inactive'];
}

/**
 * Status badge generator
 */
function setStatus($status_id = '', $type = ''): string
{
    $statusConfig = [
        'student' => [
            1 => ['class' => 'success', 'label' => 'Active'],
            2 => ['class' => 'danger', 'label' => 'Inactive'],
            3 => ['class' => 'primary', 'label' => 'In-leave'],
            4 => ['class' => 'warning', 'label' => 'Suspend'],
            5 => ['class' => 'accent', 'label' => 'Complete Degree'],
        ],
        'session' => [
            0 => ['class' => 'danger', 'label' => 'Inactive'],
            1 => ['class' => 'success', 'label' => 'Active'],
            2 => ['class' => 'warning', 'label' => 'Archived'],
        ],
        'class' => [
            0 => ['class' => 'danger', 'label' => 'Inactive'],
            1 => ['class' => 'success', 'label' => 'Active'],
            2 => ['class' => 'warning', 'label' => 'Suspend'],
        ],
        'default' => [
            0 => ['class' => 'danger', 'label' => 'Inactive'],
            1 => ['class' => 'success', 'label' => 'Active'],
        ]
    ];

    $config = $statusConfig[$type] ?? $statusConfig['default'];
    $status = $config[$status_id] ?? null;

    if (!$status) {
        return '';
    }

    $prefix = 'm-badge m-badge--';

    return '<span class="' . $prefix . $status['class'] . '">' . $status['label'] . '</span>';
}

/**
 * Notice board status badge
 */
function setNoticeBoardStatus($status_id = ''): string
{
    $statuses = [
        0 => ['class' => 'danger', 'label' => 'Inactive'],
        1 => ['class' => 'success', 'label' => 'Active'],
        2 => ['class' => 'info', 'label' => 'Publish']
    ];

    $status = $statuses[$status_id] ?? null;
    return $status
        ? '<span class="badge badge-' . $status['class'] . '">' . $status['label'] . '</span>'
        : '';
}

/**
 * Holiday status badge
 */
function setHolidayStatus($status_id = ''): string
{
    $statuses = [
        0 => ['class' => 'danger', 'label' => 'Canceled'],
        1 => ['class' => 'success', 'label' => 'Active']
    ];

    $status = $statuses[$status_id] ?? null;
    return $status
        ? '<span class="badge badge-' . $status['class'] . '">' . $status['label'] . '</span>'
        : '';
}

/**
 * Generate select dropdown
 */
function dropDown($name, $classes = [], $id, $data = [], $value = ''): string
{
    $class = is_array($classes) ? implode(' ', $classes) : $classes;

    $html = '<select id="' . $id . '" class="' . $class . '" name="' . $name . '">';
    $html .= '<option value="">--Please Select--</option>';
    $html .= select($data, $value);
    $html .= '</select>';

    return $html;
}

/**
 * Message status badge
 */
function messageStatus($status_id = 0): string
{
    $statuses = [
        0 => ['class' => 'info', 'label' => 'not yet seen'],
        1 => ['class' => 'success', 'label' => 'seen']
    ];

    $status = $statuses[$status_id] ?? null;
    return $status
        ? '<span class="badge badge-' . $status['class'] . '">' . $status['label'] . '</span>'
        : '';
}

/**
 * Message reply status badge
 */
function messageReplyStatus($status_id = 0): string
{
    $statuses = [
        0 => ['class' => 'info', 'label' => 'not replied'],
        1 => ['class' => 'success', 'label' => 'replied']
    ];

    $status = $statuses[$status_id] ?? null;
    return $status
        ? '<span class="badge badge-' . $status['class'] . '">' . $status['label'] . '</span>'
        : '';
}

/**
 * Admission applicant status badge
 */
function admissionApplicantStatus($status_id = 1): string
{
    if (!isset(UtilityServices::$admissionStatus[$status_id])) {
        return '';
    }

    $classMap = [
        2 => 'info',
        3 => 'warning',
        4 => 'focus',
        5 => 'danger',
        6 => 'success'
    ];

    $class = $classMap[$status_id] ?? 'metal';
    $label = UtilityServices::$admissionStatus[$status_id];

    return '<span class="m-badge m-badge--' . $class . '">' . $label . '</span>';
}

/**
 * Payment status badge
 */
function paymentStatus($status_id = 1): string
{
    $statuses = [
        0 => ['class' => 'danger', 'label' => 'Not Paid'],
        1 => ['class' => 'success', 'label' => 'Paid'],
        2 => ['class' => 'focus', 'label' => 'Partially Paid'],
    ];

    $status = $statuses[$status_id] ?? null;
    return $status
        ? '<span class="m-badge m-badge--' . $status['class'] . '">' . $status['label'] . '</span>'
        : '';
}

/**
 * Result publish status badge
 */
function resultPublishStatus($status_id = 0): string
{
    $statuses = [
        0 => ['class' => 'danger', 'label' => 'Not yet published'],
        1 => ['class' => 'success', 'label' => 'Published']
    ];

    $status = $statuses[$status_id] ?? null;
    return $status
        ? '<span class="badge badge-' . $status['class'] . '">' . $status['label'] . '</span>'
        : '';
}
