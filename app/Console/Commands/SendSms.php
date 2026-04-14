<?php

namespace App\Console\Commands;

use App\Services\Admin\SmsService;
use Illuminate\Console\Command;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nemc:send-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attendance Absent Sms Send';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SmsService $smsService)
    {
        parent::__construct();
        $this->smsService = $smsService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->smsService->sendSmsToParents();
        $this->info('process done');
    }
}
