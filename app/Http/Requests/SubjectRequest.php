<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest {
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
    public function rules() {
        if ($this->request->has('subject_group_id')){
            $subjectGroupId = $this->subject_group_id;
            $subjectId = isset($this->subject) ? $this->subject : '';
        }

        if (Request::isMethod('post')){
            return [
                'subject_group_id' => 'required',
                'title' => [
                    'required',
                    Rule::unique('subjects')->where(function ($query) use($subjectGroupId) {
                        return $query->where('subject_group_id', $subjectGroupId);
                    }),
                ],

                'code' => 'required|unique:subjects,code,'.$this->subject,
                'examSubTypes' => 'required|array|min:1',
                'examSubTypes.*' => 'required|min:1',
            ];

        }else{
            return [
                'subject_group_id' => 'required',
                'title' => [
                    'required',
                    Rule::unique('subjects')->where(function ($query) use($subjectGroupId, $subjectId) {
                        return $query->where('subject_group_id', $subjectGroupId)->where('id', '<>', $subjectId);
                    }),
                ],

                'code' => 'required|unique:subjects,code,'.$this->subject,
                'examSubTypes' => 'required|array|min:1',
                'examSubTypes.*' => 'required|min:1',
            ];
        }
    }

    public function messages()
    {
        return [
            'subject_group_id.required' => 'Subject Group is required',
            'code.required' => 'Subject Code is required',
            /*'examCategories.required' => 'You must select minimum one Exam Category',*/
            'examSubTypes.required' => 'You must select minimum one Exam Sub Type',
            'title.unique' => 'Subject title should be unique for current subject group',
        ];
    }
}
