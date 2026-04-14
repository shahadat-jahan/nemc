<?php

namespace App\Jobs;

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

class ClassAbsentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    protected $queuedData;

    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct($queuedData)
    {
        $this->queuedData = $queuedData;
    }

    /**
     * Execute the job.
     * @return false
     */

    function updateAttendanceAndLog($attendanceId, $sendMedium)
    {
        $attendance_update = [
            'send_sms'   => 1,
            'updated_at' => now(),
        ];

        DB::table('attencance')->where('id', $attendanceId)->update($attendance_update);

        $sms_email_update = [
            'status'      => 1,
            'send_medium' => $sendMedium,
            'updated_at'  => now(),
        ];
        DB::table('sms_email_log')->where('id', $this->queuedData->id)->update($sms_email_update);
    }

    function insertHistory($user, $student, $sendMedium, $responseMsg)
    {
        $history = DB::table('email_sms_histories')->insertGetId([
            'user_id'       => $user->id,
            'user_group_id' => $user->user_group_id,
            'message_type'  => $sendMedium,
            'purpose'       => 'attendance',
            'message'       => $this->queuedData->message,
            'email'         => $student->parent->father_email ?: 'Email not found',
            'phone'         => $student->parent->father_phone ?: 'Phone number not found',
            'response'      => json_encode($responseMsg),
            'created_by'    => $this->queuedData->created_by,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);
    }

    public function handle()
    {
        try {
            $student = Student::with('parent')->where('id', $this->queuedData->student_id)->first();
            $user    = User::where('id', $student->user_id)->first();

            $sendMedium = null;

            if ($student->student_category_id != 2) {
                $to = $student->parent->father_phone;

                // Check if the request is from a production environment and not on port 90
                $port = env('APP_PORT');
                if (config('app.env') === 'production' && $port != 90) {
                    if ($to) {
                        $client = new \GuzzleHttp\Client();
                        $response = $client->post('https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2', [
                            'json' => [
                                "username" => "NEMPLdt058",
                                "password" => "Nemc@1998",
                                "apicode" => "1",
                                "msisdn" => $to,
                                "countrycode" => "880",
                                "cli" => "NEMC",
                                "messagetype" => "1",
                                "message" => $this->queuedData->message,
                                "messageid" => "0",
                            ]
                        ]);

                        $responseBody = json_decode($response->getBody()->getContents());

                        if ($responseBody->statusCode == 200) {
                            $responseMsg = [
                                'message' => 'Sms sent',
                                'statusCode' => 200,
                            ];
                            $sendMedium = 'sms';
                            $this->updateAttendanceAndLog($this->queuedData->attendance_id, $sendMedium);

                            // Insert data to email_sms_histories table
                            $this->insertHistory($user, $student, $sendMedium, $responseMsg);
                        } else {
                            $responseMsg = $responseBody;

                            // Insert data to email_sms_histories table
                            $this->insertHistory($user, $student, $sendMedium, $responseMsg);

                            $this->fail($responseMsg);
                        }
                    } else {
                        $responseMsg = [
                            'message' => 'Phone number not found',
                            'statusCode' => 404,
                        ];

                        // Insert data to email_sms_histories table
                        $this->insertHistory($user, $student, $sendMedium, $responseMsg);

                        $this->fail($responseMsg);
                    }
                }else{
                    $responseMsg = [
                        'message' => 'Sms dose not sent without production',
                        'statusCode' => 204,
                    ];

                    // Insert data to email_sms_histories table
                    $this->insertHistory($user, $student, $sendMedium, $responseMsg);

//                    $this->fail($responseMsg);
                }
            } else {
                $to = $student->parent->father_email;

                if ($to) {
                    Mail::send('emails.defaultEmailTemplate', ['body' => $this->queuedData->message], function ($message) use ($to) {
                        $subject = 'Class Absent Notification';
                        $message->subject($subject)
                                ->from(config('mail.from.address'), config('mail.from.name'))
                                ->to(trim($to));
                    });
                    $responseMsg = [
                        'message'    => 'Email sent',
                        'statusCode' => 200,
                    ];
                    $sendMedium  = 'email';
                    $this->updateAttendanceAndLog($this->queuedData->attendance_id, $sendMedium);

                    // Insert data to email_sms_histories table
                    $this->insertHistory($user, $student, $sendMedium, $responseMsg);
                } else {
                    $responseMsg = [
                        'message'    => 'Email not found',
                        'statusCode' => 404,
                    ];

                    // Insert data to email_sms_histories table
                    $this->insertHistory($user, $student, $sendMedium, $responseMsg);
                    $this->fail($responseMsg);
                }
            }
        } catch (\Exception $e) {
            // Handle exceptions here
            echo "An error occurred: " . $e->getMessage();
            $this->fail($e);
        }
    }
}
