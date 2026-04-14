<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Guardian extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'guardians';
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->where('user_group_id', 6);
    }

    public function students(){
        return $this->hasMany(Student::class, 'parent_id');
    }

    public function getFullNameAttribute()
    {
        return $this->father_name ;
    }

    public function campaigns()
    {
        return $this->morphMany(
            \App\Models\CampaignRecipient::class,
            'recipientable'
        );
    }
}
