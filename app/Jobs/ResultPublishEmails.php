<?php

namespace App\Jobs;

use App\Mail\SendMailToParentsWhenResultAnnounced;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use romanzipp\QueueMonitor\Traits\IsMonitored;

class ResultPublishEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    public $exam, $subjectInfo, $examTypeSubType, $examResult, $receiver;

    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct($receiver, $exam, $subject, $examTypeSubType, $examResult)
    {
        $this->receiver        = $receiver;
        $this->exam            = $exam;
        $this->subjectInfo     = $subject;
        $this->examTypeSubType = $examTypeSubType;
        $this->examResult      = $examResult;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        // Check if the request is from a production environment and not on port 90
        $port = env('APP_PORT');
        if (config('app.env') != 'production' || $port == 90) {
            return;
        }

        Mail::to($this->receiver)->send(new SendMailToParentsWhenResultAnnounced($this->exam, $this->subjectInfo, $this->examTypeSubType, $this->examResult));

        DB::table('email_sms_histories')->insert([
            'user_id'       => $this->receiver->id,
            'user_group_id' => $this->receiver->user_group_id,
            'message_type'  => 'email',
            'purpose'       => 'result',
            'message'       => 'Result published for exam: ' . $this->exam->name,
            'email'         => $this->receiver->email,
            'phone'         => null,
            'response'      => null,
            'created_by'    => auth()->id(),
            'created_at'    => now(),
            'updated_at'    => now()
        ]);
    }
}
