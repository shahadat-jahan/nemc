<?php

namespace App\Listeners;

use App\Events\UpdateStudentCredit;
use App\Services\Admin\StudentService;
use App\Services\StudentFeeService;

class UpdateStudentCreditListener
{
    protected $studentFeeService;
    protected $studentService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(StudentFeeService $studentFeeService, StudentService $studentService)
    {
        $this->studentFeeService = $studentFeeService;
        $this->studentService = $studentService;
    }

    /**
     * Handle the event.
     *
     * @param  UpdateStudentCredit  $event
     * @return void
     */
    public function handle(UpdateStudentCredit $event)
    {
        $amount = $this->studentFeeService->getStudentAvailableCreditByStudentId($event->studentId);
        $student = $this->studentService->find($event->studentId);

        $student->available_amount_for_tuition = $amount['available_tuition_amount'];
        $student->available_amount_for_development = $amount['available_development_amount'];
        $student->save();
    }
}
