<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentAttachments extends FormRequest
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
            'file_path' => 'required|array|min:1',
            'file_path.*' => 'required|min:1',
        ];
    }

    public function messages()
    {
        return [
            'file_path.required' => 'Attachment missing. You have to add at least one file',
            'file_path.min' => 'Attachment missing. You have to add at least one file',
        ];
    }
}
