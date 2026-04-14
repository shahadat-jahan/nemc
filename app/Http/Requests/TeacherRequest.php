<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest {
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


        return [
            'first_name' => 'required',
            'last_name' => 'required',
//            'user_id' => 'required|alpha_dash|unique:users,user_id,'.$this->teacher,
            'user_id' => 'required',
            'password' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'email' => 'required',
//            'email' => 'required|unique:teachers,email,'.$this->teacher,
        ];


    }
    public function messages()
    {
        return [
            'user_id.required' => 'User name is required',
            'department_id.required' => 'Department is required',
            'designation_id.required' => 'Designation is required',
            'dob.required' => 'Birth day is required',
        ];
    }
}
