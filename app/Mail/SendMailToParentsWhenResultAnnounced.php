<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailToParentsWhenResultAnnounced extends Mailable
{
    use Queueable, SerializesModels;

    public $exam, $subjectInfo, $examTypeSubType, $examResult;

    /**
     * Create a new mail instance.
     *
     * @return void
     */
    public function __construct($exam, $subject, $examTypeSubType, $examResult)
    {
        $this->exam = $exam;
        $this->subjectInfo = $subject;
        $this->examTypeSubType = $examTypeSubType;
        $this->examResult = $examResult;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return
            $this->from('no-reply@nemc.edu.bd')
                ->subject('Result has been published: ' . $this->exam->title . ' - '. $this->subjectInfo->title)
                ->view('emails.result')
                ->with([
                    'examInfo' => $this->exam,
                    'subjectInfo' => $this->subjectInfo,
                    'examTypeSubType' => $this->examTypeSubType,
                    'examResult' => $this->examResult
                ]);
    }
}
