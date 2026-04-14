<?php

namespace App\Jobs;

use App\Mail\LowAttendanceNotification;
use App\Models\Student;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use romanzipp\QueueMonitor\Traits\IsMonitored;

class LowAttendanceNotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    protected $studentId;
    protected $subjectTitle;
    protected $message;
    protected $percentageType;
    protected $percentageFilter;
    protected $period;
    protected $createdBy;

    public function __construct($studentId, $subjectTitle, $message, $percentageType, $percentageFilter, $period, $createdBy)
    {
        $this->studentId        = $studentId;
        $this->subjectTitle     = $subjectTitle;
        $this->message          = $message;
        $this->percentageType   = $percentageType;
        $this->percentageFilter = $percentageFilter;
        $this->period           = $period;
        $this->createdBy        = $createdBy;
    }

    public function handle()
    {
        // Check if the request is from a production environment and not on port 90
        $port = $port = env('APP_PORT');
        if (config('mail.sms_email_send') == false || $port == 90) {
            return;
        }

        $student = Student::with('parent')->find($this->studentId);
        $user    = $student ? User::find($student->user_id) : null;

        if (!$student || !$student->parent) {
            return;
        }

        if ($student->student_category_id == 2 && $student->parent->father_email) {
            // Send email
            $data = [
                'student_name'          => $student->full_name_en,
                'roll_no'               => $student->roll_no,
                'subject_name'          => $this->subjectTitle,
                'attendance_percentage' => $student->percentage,
                'threshold_percentage'  => $this->percentageFilter,
                'attendance_type'       => ucfirst($this->percentageType),
                'period'                => $this->period,
                'message'               => $this->message
            ];

            Mail::to($student->parent->father_email)
                ->send(new LowAttendanceNotification($data));

            // Log email history
            DB::table('email_sms_histories')->insert([
                'user_id'       => $student->user_id,
                'user_group_id' => $student->user_group_id ?? null,
                'message_type'  => 'email',
                'purpose'       => 'low_attendance',
                'message'       => $this->message,
                'email'         => $student->parent->father_email ?? null,
                'phone'         => $student->parent->father_phone ?? null,
                'response'      => json_encode(['message' => 'Email sent', 'statusCode' => 200]),
                'created_by'    => $this->createdBy,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);
        } elseif ($student->student_category_id != 2 && $student->parent->father_phone) {
            // Send SMS
            try {
                $client       = new \GuzzleHttp\Client();
                $response     = $client->post('https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2', [
                    'json' => [
                        "username"    => "NEMPLdt058",
                        "password"    => "Nemc@1998",
                        "apicode"     => "1",
                        "msisdn"      => $student->parent->father_phone,
                        "countrycode" => "880",
                        "cli"         => "NEMC",
                        "messagetype" => "1",
                        "message"     => $this->message,
                        "messageid"   => "0",
                    ]
                ]);
                $responseBody = json_decode($response->getBody()->getContents());
                $responseMsg  = ($responseBody && $responseBody->statusCode == 200)
                    ? ['message' => 'Sms sent', 'statusCode' => 200]
                    : $responseBody;
            } catch (\Exception $e) {
                $responseMsg = [
                    'message'    => $e->getMessage(),
                    'statusCode' => 500,
                ];
            }

            // Log SMS history
            DB::table('email_sms_histories')->insert([
                'user_id'       => $user ? $user->id : null,
                'user_group_id' => $user ? $user->user_group_id : null,
                'message_type'  => 'sms',
                'purpose'       => 'low_attendance',
                'message'       => $this->message,
                'email'         => $student->parent->father_email ?? null,
                'phone'         => $student->parent->father_phone ?? null,
                'response'      => json_encode($responseMsg),
                'created_by'    => $this->createdBy,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
