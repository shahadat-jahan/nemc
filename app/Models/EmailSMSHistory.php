<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EmailSMSHistory extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'email_sms_histories';
    protected $guarded = ['id'];


    public function receiver(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function sender(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
