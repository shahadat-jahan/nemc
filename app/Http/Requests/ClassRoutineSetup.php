<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoutineSetup extends FormRequest
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
//            'session_id' => 'required|min:1|class_routine_time_exist:session_id,'.$this->session_id.
//                            ',phase_id,'.$this->phase_id.',term_id,'.$this->term_id. ',class_type_id,'.$this->class_type_id.',start_date,'.$this->start_date.
//                            ',end_date,'.$this->end_date,'start_time,'.$this->start_time.',end_time,'.$this->end_time,
//            'course_id' => 'required|min:1',
//            'phase_id' => 'required|min:1',
//            'subject_id' => 'required|min:1',
////            'teacher_id' => 'required|min:1',
//            'class_type_id' => 'required|min:1',
////            'hall_id' => 'required|min:1',
//            'days' => 'required|array|min:1',
//            'days.*' => 'required|min:1',
            'batch_type_id' => 'required',
            'group_teachers' => [
                function ($attribute, $value, $fail) {
                    foreach ($this->student_group_id as $key => $studentGroup) {
                        if ($studentGroup > 0 && is_null($value[$key])) {
                            $fail('Please Select Teacher With Student Group');
                        }
                    }
                },
            ],
        ];
    }
}
