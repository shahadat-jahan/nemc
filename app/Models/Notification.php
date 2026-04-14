<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Notification
 * @package App\Models
 */
class Notification extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    /**
     * @var string
     */
    protected $table = 'notifications';
    /**
     * @var array
     */
    protected $guarded = ['id'];



    public function user() {

        return $this->belongsTo(User::class, 'user_id');
    }

    public function resource(){
        return $this->morphTo();
    }
}
