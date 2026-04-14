<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PhasePromotionHistory extends Model
{
    use BlamableTrait, SoftDeletes;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'phase_promotion_histories';
    protected $guarded = ['id'];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function promotedFrom(){
        return $this->belongsTo(Phase::class, 'promoted_from');
    }

    public function promotedTo(){
        return $this->belongsTo(Phase::class, 'promoted_to');
    }
}
