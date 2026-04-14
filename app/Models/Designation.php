<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Designation extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'designations';
    protected $guarded = ['id'];

    ////get teachers for designation
    public function teachers() {

        return $this->hasMany(Teacher::class);
    }
}
