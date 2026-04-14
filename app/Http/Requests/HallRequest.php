<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HallRequest extends FormRequest {
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
        $hallId = $this->hall ?? 'null';

        return [
            'title' => [
                'required',
                Rule::unique('halls', 'title')->ignore($hallId),
            ],
            'room_number' => [
                'required',
                Rule::unique('halls')
                    ->where('floor_number', $this->input('floor_number'))
                    ->ignore($hallId),
            ],
            'floor_number' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'floor_number.required' => 'Floor number is required',
            'room_number.required' => 'Room number is required',
            'room_number.unique' => 'Room number must be unique',
        ];
    }


}
