<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class SessionPhaseDetail
 * @package App\Models
 */
class SessionPhaseDetail extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    /**
     * @var string
     */
    protected $table = 'session_phase_details';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects(){
        return $this->belongsToMany(Subject::class, 'session_phase_detail_subjects', 'session_phase_detail_id', 'subject_id');
    }

    public function phase(){
        return $this->belongsTo(Phase::class, 'phase_id');
    }

    public function sessionDetail(){
        return $this->belongsTo(SessionDetail::class, 'session_detail_id');
    }
}
