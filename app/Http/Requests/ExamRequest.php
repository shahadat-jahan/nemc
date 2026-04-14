<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
    public function rules()
    {
        return [
            'session_id'       => 'required|integer',
            'course_id'        => 'required|integer',
            'phase_id'         => 'required|integer',
            'term_id'          => 'required|integer',
            'exam_category_id' => 'required|integer',
            'title'            => 'required|string',
            'main_exam_id'     => 'nullable|required_if:exam_category_id,5|integer',
        ];
    }

    public function messages()
    {
        return [
            'main_exam_id.required_if' => 'The main exam field is required when exam category is Supplementary.',
        ];
    }
}
