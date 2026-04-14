<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class CampaignDetail extends Model
{
    use BlamableTrait, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'campaign_details';
    protected $guarded = ["id"];

    protected $casts = [
        'response' => 'json',
    ];
}
