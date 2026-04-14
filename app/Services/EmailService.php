<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 11/23/18
 * Time: 7:32 PM
 */

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

class EmailService
{

    public function mailSend($to, $cc, $subject, $purpose, $message, $template = '', $user = NULL)
    {
        $template = empty($template) ? 'emails.defaultEmailTemplate' : $template;
        Mail::send($template, ['body' => $message], function ($message) use ($subject, $to, $cc) {
            $message->subject($subject);
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to(trim($to));
            if ($cc) {
                $message->cc($cc);
            }
        });
        if ($user) {
            $history = DB::table('email_sms_histories')->insertGetId(
                array(
                    'user_id'       => $user->id,
                    'user_group_id' => $user->user_group_id,
                    'message_type'  => 'email',
                    'purpose'       => $purpose ?? 'other',
                    'message'       => $message,
                    'email'         => $to,
                    'phone'         => NULL,
                    'response'      => NULL,
                    'created_by'    => Auth::user()->id,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                )
            );
        }
        return true;
    }
}
