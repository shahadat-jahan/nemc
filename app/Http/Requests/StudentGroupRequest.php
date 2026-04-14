<?php

namespace App\Http\Requests;

use App\Rules\StudentGroupRule;
use App\Services\Admin\Admission\StudentGroupService;
use App\Services\Admin\StudentService;
use Illuminate\Foundation\Http\FormRequest;

class StudentGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(StudentService $studentService, StudentGroupService $studentGroupService)
    {
        return [
//            'course_id' => 'required',
//            'title' => 'required',
//            'type' => 'required',
            'session_id' =>new StudentGroupRule($this, $studentGroupService, $studentService)
        ];
    }
}
