<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowAttendanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->message = $data['message'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Low Attendance Alert - ' . config('app.name'))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('emails.defaultEmailTemplate')
            ->with([
                'body' => $this->message
            ]);
    }
}
