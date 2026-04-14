<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Phase extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'phases';
    protected $guarded = ['id'];

    public function sessionPhaseDetails(){
        return $this->hasMany(SessionPhaseDetail::class, 'phase_id');
    }
}
