<?php

namespace App\Console\Commands;

use App\Services\StudentFeeService;
use Illuminate\Console\Command;

class PaymentByStudentCredit extends Command
{
    protected $studentFeeService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nemc:student-advanced-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate student payments for any bill if credit is available';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StudentFeeService $studentFeeService)
    {
        parent::__construct();
        $this->studentFeeService = $studentFeeService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->studentFeeService->generateStudentPaymentWhenCreditAvailable();
        $this->info('process done');
    }
}
