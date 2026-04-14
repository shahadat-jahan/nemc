<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectGroupRequest extends FormRequest {
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
    public function rules()
    {
        return [
            'course_id' => 'required',
            'title' => [
                'required',
                'unique:subject_groups,title,' . $this->subject_group
            ],
        ];
    }
    public function messages()
    {
        return [
            'course_id.required' => 'Course title is required',
        ];
    }
}
