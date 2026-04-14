<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NoticeBoardRequest extends FormRequest {
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
            'title' => [
                'required',
                Rule::unique('notice_boards', 'title')->ignore($this->notice_board),
            ],
            'notice_file' => ['nullable', 'mimes:pdf', 'max:2048'],
            'batch_type_id' => [],
            'session_id' => [
                'required_with:batch_type_id',
                'required_with:course_id',
                'required_with:phase_id',
            ],
            'course_id' => [
                'required_with:phase_id',
            ],
            'phase_id' => [
                'required_with:course_id',
            ],
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Notice title is required.',
            'title.unique' => 'This title has already been taken.',
            'notice_file.mimes' => 'The notice file must be a PDF.',
            'notice_file.max' => 'The notice file size cannot exceed 2MB.',
            'session_id.required_with' => 'The session field is required when :values is selected.',
            'course_id.required_with' => 'The course field is required when :values is selected.',
            'phase_id.required_with' => 'The phase field is required when :values is selected.',
        ];
    }
}
