<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        if (request()->has('id')) {
            return [
                'user_group_id' => 'required',
                'user_id' => 'required',
                'department_id' => 'required',
                'designation_id' => 'required',
                'first_name' => 'required',
//                'password' => 'required|confirmed',
//                'password_confirmation' => 'required',

                //'email' => 'required|unique:users,email,'.$this->user
            ];
        }

        return [
            'user_group_id' => 'required',
            'user_id' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'first_name' => 'required',
//                'password' => 'required|confirmed',
//                'password_confirmation' => 'required',
            //'email' => 'required|unique:users,email,'.$this->user
        ];
    }
}
