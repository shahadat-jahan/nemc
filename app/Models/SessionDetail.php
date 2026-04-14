<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class SessionDetail
 * @package App\Models
 */
class SessionDetail extends Model
{
    use SoftDeletes, BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    /**
     * @var string
     */
    protected $table = 'session_details';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessionPhaseDetails(){
        return $this->hasMany(SessionPhaseDetail::class, 'session_detail_id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function  session(){
        return $this->belongsTo(Session::class,'session_id');
    }
}
