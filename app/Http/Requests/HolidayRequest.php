<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidayRequest extends FormRequest {
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
                //'unique:holidays,title,' . $this->holiday
            ],
            'from_date' => 'required',
            'batch_type_id' => '',
            'session_id' => 'required_with:batch_type_id',
        ];

    }
    public function messages()
    {
        return [
            'title.required' => 'Holiday title is required',
            'from_date.required' => 'Holiday start date is required',
            'session_id.required_with' => 'Session field is require if you select batch type field',
        ];
    }
}
