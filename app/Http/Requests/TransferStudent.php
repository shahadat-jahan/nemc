<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferStudent extends FormRequest
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
        if ($this->request->has('course_id')  and $this->request->has('session_id')){
            $courseId = $this->course_id;
            $sessionId = $this->session_id;
        }

        return [
            'roll_no' => 'required',
            'user_id' => 'required|unique:users,user_id',
            'password' => 'required',
            'mobile' => [
                'required',
                'regex:/^(?=.*[1-9])[0-9+]{11,}$/',
                'unique:students,mobile',
            ],
            //studentId unique for current course and session
            'student_id' => [
                'required',
                Rule::unique('students')->where(function ($query) use($courseId, $sessionId) {
                    return $query->where('course_id', $courseId)->where('session_id', $sessionId);
                }),
            ],
        ];
    }
}
