<?php

namespace  App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MessageReply extends Model
{
    use SoftDeletes, BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    /**
     * @var string
     */
    protected $table = 'message_replies';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    //message  related to message reply
    public function message(){
        return $this->belongsTo(Message::class);
    }
    //user related to message reply
    public function user(){
        return $this->belongsTo(User::class);
    }

    //user who created the reply
    public function createdBy() {
        return $this->belongsTo(User::class,'created_by');
        }
}
