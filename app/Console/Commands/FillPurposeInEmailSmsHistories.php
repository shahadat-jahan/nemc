<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FillPurposeInEmailSmsHistories extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'fill:purpose-in-email-sms-histories';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Fill the purpose column in email_sms_histories based on message content';

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        $this->info('Starting to fill purpose for email_sms_histories...');

        $rows = DB::table('email_sms_histories')->get();

        foreach ($rows as $row) {
            $purpose = null;
            $message = strtolower($row->message ?? '');

            if (stripos($message, 'password has been reset') !== false || stripos($message, 'password reset') !== false) {
                $purpose = 'password_reset';
            } elseif (stripos($message, 'account has been generated') !== false || stripos($message, 'welcome') !== false) {
                $purpose = 'new_account';
            } elseif (stripos($message, 'absent in a scheduled class') !== false || stripos($message, 'absent') !== false) {
                $purpose = 'attendance';
            } elseif (stripos($message, 'result') !== false) {
                $purpose = 'result';
            } elseif (stripos($message, 'fee') !== false || stripos($message, 'payment') !== false) {
                $purpose = 'fee';
            } elseif (stripos($message, 'admission') !== false) {
                $purpose = 'admission';
            } elseif (stripos($message, 'notification') !== false || stripos($message, 'notice') !== false) {
                $purpose = 'notification';
            } elseif (stripos($message, 'less than') !== false) {
                $purpose = 'low_attendance';
            } else {
                $purpose = 'other';
            }

            DB::table('email_sms_histories')
              ->where('id', $row->id)
              ->update(['purpose' => $purpose]);
        }

        $this->info('Purpose field updated for all records.');
        return 0;
    }
}
