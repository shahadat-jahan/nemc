<?php

namespace App\Console\Commands;

use App\Services\StudentFeeService;
use Illuminate\Console\Command;

class GenerateMonthlyTuitionFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nemc:monthly-tuition-fee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly tuition fee';

    protected $studentFeeService;

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
        $this->studentFeeService->generateMonthlyTuitionFeeForAllStudents();
        $this->info('process done');
    }
}
