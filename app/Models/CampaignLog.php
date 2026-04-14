<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CampaignLog extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'campaign_logs';
    protected $guarded = ['id'];


    public function sender(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function receiver(){
        return $this->morphTo(__FUNCTION__, 'receiver_type', 'receiver_id');
    }
}
