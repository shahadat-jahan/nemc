<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EducationHistory extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'education_histories';
    protected $guarded = ['id'];

    public function educationBoard(){
        return $this->belongsTo(EducationBoard::class, 'education_board_id');
    }
}
