<?php

namespace  App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Message extends Model
{
    use SoftDeletes, BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    /**
     * @var string
     */
    protected $table = 'messages';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    //user related to message
    public function user(){
      return $this->belongsTo(User::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class,'created_by');
    }
    //message reply related to message
    public function messageReplies(){
        return $this->hasMany(MessageReply::class, 'message_id');
    }
}
