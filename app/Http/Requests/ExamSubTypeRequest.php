<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExamSubTypeRequest extends FormRequest {
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

        if ($this->request->has('exam_type_id')){
            $examTypeId = $this->exam_type_id;
            $examSubTypeId = isset($this->exam_sub_type) ? $this->exam_sub_type : '';
        }
        if ($this->isMethod('post')){
            return [
                'exam_type_id' => 'required',
                'title' => [
                    'required',
                    Rule::unique('exam_sub_types')->where(function ($query) use($examTypeId) {
                        return $query->where('exam_type_id', $examTypeId);
                    }),
                ],
            ];
        }

        return [
            'exam_type_id' => 'required',
            'title'        => [
                'required',
                Rule::unique('exam_sub_types')->where(function ($query) use ($examTypeId, $examSubTypeId) {
                    return $query->where('exam_type_id', $examTypeId)->where('id', '<>', $examSubTypeId);
                }),
            ],
        ];
    }
    public function messages()
    {
        return [
            'exam_type_id.required' => 'Exam type is required',
            'title.unique' => 'Exam sub type is unique for current Exam type',
        ];
    }
}
