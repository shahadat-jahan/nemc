<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest {
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
                'unique:topics,title,' . $this->topic
            ],
            'serial_number' => 'required',
        ];

    }
    public function messages()
    {
        return [
            'title.required' => 'Topic name is required',
            'serial_number.required' => 'Topic serial no is required',
        ];
    }
}
