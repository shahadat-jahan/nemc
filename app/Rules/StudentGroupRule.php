<?php

namespace App\Rules;

use App\Services\Admin\Admission\StudentGroupService;
use App\Services\Admin\StudentService;
use Illuminate\Contracts\Validation\Rule;
use App\Models\StudentGroup;

class StudentGroupRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private  $formData;
    private  $studentGroupService;
    private  $studentService;
    public function __construct($formData, StudentGroupService $studentGroupService, StudentService $studentService)
    {
        $this->formData = $formData;
        $this->studentGroupService = $studentGroupService;
        $this->studentService = $studentService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $notExist = true;
        $studentGroups = StudentGroup::with('students')
            ->where('type',$this->formData->type)
            ->where('session_id',$this->formData->session_id)
            ->where('course_id',$this->formData->course_id)
            ->where('phase_id',$this->formData->phase_id)
            ->where('department_id',$this->formData->department_id)
            ->get();

        if ($studentGroups->isNotEmpty()){
            $studentRolls = [];
            $rolls = [];

            foreach ($studentGroups as $studentGroup) {
                foreach ($studentGroup->students as $student) {
                    $studentRolls[] = $student->roll_no;
                }
            }

            if ($this->formData->roll_range == 1){
                for ($i = $this->formData->roll_from; $i <= $this->formData->roll_to; $i++) {
                    $rolls[] = $i;
                }
            }else{
                $rolls = $this->formData->rolls;
            }

            foreach ($rolls as $roll) {
                if (in_array($roll, $studentRolls)) {
                    $notExist = false;
                }
            }
        }
            return $notExist;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This Group Configuration Already Exist.';
    }
}
