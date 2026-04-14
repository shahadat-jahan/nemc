<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Campaign extends Model
{
    use BlamableTrait, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'campaigns';
    protected $guarded = ["id"];    

    public function recipients()
    {
        return $this->hasMany(CampaignRecipient::class);
    }
}
