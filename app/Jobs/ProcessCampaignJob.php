<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignRecipient;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 600;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    protected $campaignId;

    /**
     * Create a new job instance.
     *
     * @param int $campaignId
     * @return void
     */
    public function __construct($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function handle()
    {
        $campaign = Campaign::find($this->campaignId);

        if (!$campaign) {
            Log::error("ProcessCampaignJob: Campaign not found (ID: {$this->campaignId})");
            return;
        }

        $campaign->update(['status' => 'processing']);

        $recipients = CampaignRecipient::where('campaign_id', $campaign->id)
                                       ->where('status', 'pending')
                                       ->get();

        if ($recipients->isEmpty()) {
            $campaign->update(['status' => 'completed']);
            return;
        }

        try {
            foreach ($recipients as $recipient) {
                // Dispatch each recipient as a separate job immediately
                SendSingleCampaignMessageJob::dispatch($campaign->id, $recipient->id);
            }
        } catch (Exception $e) {
            Log::error("ProcessCampaignJob failed for Campaign {$this->campaignId}: " . $e->getMessage());
            $campaign->update(['status' => 'failed']);
        }
    }
}
