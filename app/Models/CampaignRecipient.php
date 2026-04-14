<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class CampaignRecipient extends Model
{
    use BlamableTrait, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'campaign_recipients';
    protected $guarded = ["id"];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function recipientable()
    {
        return $this->morphTo();
    }
}
