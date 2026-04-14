<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LectureMaterial extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'lecture_materials';
    protected $guarded = ['id'];

    //class routine related to lecture material
    public function classRoutine(){
        return $this->belongsTo(ClassRoutine::class);
    }

}
