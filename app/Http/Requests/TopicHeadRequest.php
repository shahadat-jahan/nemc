<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicHeadRequest extends FormRequest {
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
            'subject_id' => 'required',
            'title' => [
                'required',
                'unique:topic_heads,title,' . $this->topic_head
                //here topic_head comes from url (/admin/topic_head/292/edit)
            ],
        ];

    }
    public function messages()
    {
        return [
            'title.required' => 'Topic head name is required',
            'subject_id.required' => 'Subject is required',
        ];
    }
}
