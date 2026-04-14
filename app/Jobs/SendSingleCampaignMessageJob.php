<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignRecipient;
use App\Services\CampaignSendingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSingleCampaignMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 30;

    protected $campaignId;
    protected $recipientId;

    /**
     * Create a new job instance.
     *
     * @param int $campaignId
     * @param int $recipientId
     * @return void
     */
    public function __construct($campaignId, $recipientId)
    {
        $this->campaignId  = $campaignId;
        $this->recipientId = $recipientId;
    }

    /**
     * Execute the job.
     *
     * @param CampaignSendingService $sendingService
     * @return void
     */
    public function handle(CampaignSendingService $sendingService)
    {
        $campaign  = Campaign::find($this->campaignId);
        $recipient = CampaignRecipient::find($this->recipientId);

        if (!$campaign || !$recipient) {
            return;
        }

        // Only send if still pending (prevents duplicate sending if job is retried)
        if ($recipient->status !== 'pending') {
            return;
        }

        $contact  = $this->getRecipientContact($campaign, $recipient);
        $status   = false;
        $response = "No contact information";
        $result   = null;

        if ($contact) {
            if ($campaign->channel === 'sms') {
                $result = $sendingService->sendSms($contact, $campaign->message);
            } else {
                $subject = $campaign->subject ?: $campaign->title;
                $result  = $sendingService->sendEmail($contact, $subject, $campaign->message);
            }

            $status   = $result['success'] ?? false;
            $response = $result['response'] ?? 'No response received';
        } else {
            $response = ($campaign->channel === 'sms') ? "Number not found" : "Email not found";
        }

        // Update recipient status
        $recipient->update([
            'status'   => $status ? 'sent' : 'failed',
            'sent_at'  => now(),
            'response' => is_array($response) ? json_encode($response) : $response
        ]);

        // Log the message event
        $sendingService->logMessage($campaign, $recipient, $status, $response);

        // Check if this was the last pending recipient to update campaign status
        $this->checkCampaignCompletion($campaign);
    }

    /**
     * Extract contact information based on channel
     */
    protected function getRecipientContact(Campaign $campaign, CampaignRecipient $recipient)
    {
        $receiver = $recipient->recipientable;

        if (!$receiver) {
            return null;
        }

        if ($campaign->channel === 'sms') {
            return $receiver->mobile ?? $receiver->phone ?? $receiver->father_phone ?? null;
        }

        return $receiver->email ?? $receiver->father_email ?? null;
    }

    /**
     * Check if all recipients have been processed
     */
    protected function checkCampaignCompletion(Campaign $campaign)
    {
        $pendingCount = CampaignRecipient::where('campaign_id', $campaign->id)
                                         ->where('status', 'pending')
                                         ->count();

        if ($pendingCount === 0) {
            $campaign->update(['status' => 'completed']);
        }
    }
}
