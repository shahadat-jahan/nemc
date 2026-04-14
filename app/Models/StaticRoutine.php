<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class StaticRoutine extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'static_routines';
    protected $guarded = ['id'];

    /**
     * Get the phase that owns the static routine.
     */
    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    /**
     * Get the session that owns the static routine.
     */
    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
