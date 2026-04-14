<?php

namespace App\Services;

use App\Models\CampaignDetail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CampaignSendingService
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    /**
     * Send SMS via Grameenphone API
     */
    public function sendSms($mobile, $message)
    {
        try {
            $response = $this->httpClient->post('https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2', [
                'json' => [
                    "username"    => "NEMPLdt058",
                    "password"    => "Nemc@1998",
                    "apicode"     => "1",
                    "msisdn"      => $mobile,
                    "countrycode" => "880",
                    "cli"         => "NEMC",
                    "messagetype" => "1",
                    "message"     => $message,
                    "messageid"   => "0",
                ],
                'timeout' => 30,
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'response' => $body
            ];
        } catch (\Exception $e) {
            Log::error("Campaign SMS Sending Failed: " . $e->getMessage());
            return [
                'success' => false,
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Send Email
     */
    public function sendEmail($email, $subject, $message)
    {
        try {
            Mail::send('emails.defaultEmailTemplate', ['body' => $message], function ($mail) use ($subject, $email) {
                $mail->subject($subject);
                $mail->from(config('mail.from.address'), config('mail.from.name'));
                $mail->to(trim($email));
            });

            return [
                'success' => true,
                'response' => 'Email sent successfully'
            ];
        } catch (\Exception $e) {
            Log::error("Campaign Email Sending Failed: " . $e->getMessage());
            return [
                'success' => false,
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Log message to message_logs table
     */
    public function logMessage($campaign, $recipient, $status, $response)
    {
        $receiver = $recipient->recipientable;

        return CampaignDetail::create([
            'campaign_type' => $campaign->title,
            'receiver_id'   => $recipient->recipientable_id,
            'receiver_type' => $recipient->recipientable_type,
            'mobile_number' => $receiver->mobile ?? $receiver->phone ?? $receiver->father_phone ?? null,
            'email'         => $receiver->email ?? $receiver->father_email ?? null,
            'message'       => $campaign->message,
            'channel'       => $campaign->channel,
            'status'        => $status ? 1 : 0,
            'response'      => $response,
            'sent_at'       => Carbon::now(),
        ]);
    }
}
