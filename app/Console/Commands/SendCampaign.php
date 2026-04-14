<?php

namespace App\Console\Commands;

use App\Models\Student;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCampaign extends Command
{
    const CHUNK_SIZE    = 100;
    const SMS_TEMPLATE  = 'Dear Students,%s%sPlease settle your Development fees. Otherwise, you will miss attendance
                            and your name will be stuck off the register.%s%sThank you.%s%sNEMC.%s%sMobile: +8801738988957';
    const EMAIL_SUBJECT = 'Payment Reminder for Due Development Fees';
    protected $signature = 'nemc:send-campaign {--dry-run : Run without sending messages}';
    protected $description = 'Send payment reminder campaign to students via SMS and Email';
    /** @var Client */
    private $client;

    /** @var int */
    private $successCount = 0;

    /** @var int */
    private $failureCount = 0;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        $this->client = new Client(['timeout' => 10]);
        $isDryRun     = $this->option('dry-run');

        $this->info('Starting campaign send process...');

        try {
            $this->processStudents($isDryRun);
            $this->displaySummary();
            return 0;
        } catch (Exception $e) {
            $this->error('Campaign failed: ' . $e->getMessage());
            Log::error('Campaign Error', ['exception' => $e]);
            return 1;
        }
    }

    /**
     * Process students in chunks
     *
     * @param bool $isDryRun
     *
     * @return void
     */
    private function processStudents($isDryRun)
    {
        $studentIds = [
            2025028088,
            2025028092,
            2025028093,
            2025028116,
            2025028117,
            2025028122,
            2025028124,
            2024027061,
            2024027093,
            2024027115,
            2024027125,
            2023026055,
            2023026059,
            2023026063,
            2023026112,
            2023026123,
            2022025029,
            2022025086,
            2022025087,
            2022025118,
            2022025121,
            2022025123,
            2022025124,
            2022025125,
            2021024028,
            2021024057,
            2021024058,
            2021024059,
            2021024077,
            2021024087,
            2021024090,
            2021024116,
            2021024117,
            2021024118,
            2021024119,
            2021024120,
        ];

        $query = Student::select('id', 'email', 'mobile')
                        ->whereNotNull(DB::raw('COALESCE(email, mobile)'))
                        ->whereHas('user', function ($q) use ($studentIds) {
                            $q->whereIn('user_id', $studentIds);
                        });

        $totalStudents = $query->count();

        $this->info("Processing {$totalStudents} students...");

        $bar = $this->output->createProgressBar($totalStudents);

        $query->chunk(self::CHUNK_SIZE, function ($students) use ($isDryRun, $bar) {
            foreach ($students as $student) {
                if ($isDryRun) {
                    $this->line('');
                    $this->info("[DRY RUN] Would send to Student ID: {$student->id} | Email: {$student->email} | Mobile: {$student->mobile}");
                } else {
                    $this->sendCampaign($student);
                }
                $bar->advance();
            }
        });

        $bar->finish();
        $this->line('');
    }

    /**
     * Send campaign to a student
     *
     * @param Student $student
     *
     * @return void
     */
    private function sendCampaign($student)
    {
        try {
            // Send email if student has email
            if ($student->email) {
                $this->sendEmail($student);
            }

            // Send SMS if student has mobile
            if ($student->mobile) {
                $this->sendSMS($student);
            }
        } catch (Exception $e) {
            $this->failureCount++;
            Log::error('Campaign send failed', [
                'student_id' => $student->id,
                'error'      => $e->getMessage()
            ]);
        }
    }

    /**
     * Send email to student
     *
     * @param Student $student
     *
     * @return void
     * @throws Exception
     */
    private function sendEmail($student)
    {
        $message = 'Dear Students,
                    <br>
                    Please settle your Development fees. Otherwise, you will miss attendance and your name will be stuck off the register.
                    <br>
                    Thank you.
                    <br>
                    NEMC.
                    <br>
                    +8801738988957';

        try {
            Mail::send('emails.defaultEmailTemplate', ['body' => $message], function ($mail) use ($student) {
                $mail->subject(self::EMAIL_SUBJECT)
                     ->from(config('mail.from.address'), config('mail.from.name'))
                     ->to(trim($student->email));
            });

            $this->logCampaign('Email', $message, null, $student->email, $student->id, 'Sent', 1);
            $this->successCount++;
        } catch (Exception $e) {
            throw new Exception("Email send failed: {$e->getMessage()}");
        }
    }

    /**
     * Log campaign activity
     *
     * @param string      $type
     * @param string      $message
     * @param string|null $mobile
     * @param string|null $email
     * @param int         $studentId
     *
     * @return void
     */
    private function logCampaign($type, $message, $mobile, $email, $studentId, $response, $status = 0)
    {
        DB::table('campaign_logs')->insert([
            'campaign_type' => $type,
            'purpose'       => 'payment_reminder',
            'message'       => $message,
            'mobile_number' => $mobile,
            'email'         => $email,
            'receiver_id'   => $studentId,
            'receiver_type' => 'App\Models\Student',
            'status'        => $status,
            'response'      => json_encode($response),
            'created_by'    => 1698, // System User ID
            'created_at'    => Carbon::now(),
            'updated_at'    => null,
        ]);
    }

    /**
     * Send SMS to student
     *
     * @param Student $student
     *
     * @return void
     * @throws Exception
     */
    private function sendSMS($student)
    {
        $message = sprintf(
            self::SMS_TEMPLATE,
            PHP_EOL, PHP_EOL, PHP_EOL, PHP_EOL, PHP_EOL, PHP_EOL, PHP_EOL, PHP_EOL
        );

        try {
            $response = $this->client->post('https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2', [
                'json' => [
                    'username'    => config('services.gp_sms.username'),
                    'password'    => config('services.gp_sms.password'),
                    'apicode'     => '1',
                    'msisdn'      => $student->mobile,
                    'countrycode' => '880',
                    'cli'         => 'NEMC',
                    'messagetype' => '1',
                    'message'     => $message,
                    'messageid'   => '0',
                ]
            ]);

            $result = json_decode($response->getBody()->getContents());

            if ($result->statusCode == 200) {
                // SMS sent successfully
                $status = 1;
                $this->successCount++;
            } else {
                // SMS sending failed
                $status = 0;
                $this->failureCount++;
            }
            $this->logCampaign('SMS', $message, $student->mobile, null, $student->id, $result, $status);
        } catch (GuzzleException $e) {
            throw new Exception("SMS send failed: {$e->getMessage()}");
        }
    }

    /**
     * Display campaign summary
     * @return void
     */
    private function displaySummary()
    {
        $this->line('');
        $this->info('Campaign Summary:');
        $this->table(
            ['Status', 'Count'],
            [
                ['Success', $this->successCount],
                ['Failure', $this->failureCount],
                ['Total', $this->successCount + $this->failureCount],
            ]
        );

        if ($this->failureCount > 0) {
            $this->warn('Some messages failed to send. Check logs for details.');
        }
    }
}
