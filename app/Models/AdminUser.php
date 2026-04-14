<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class AdminUser extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'admin_users';
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   /* protected $hidden = [
        'password', 'remember_token',
    ];*/
   public function user(){
       return $this->belongsTo(User::class, 'user_id');
   }
   public function department(){
       return $this->belongsTo(Department::class, 'department_id');
   }
   public function designation(){
       return $this->belongsTo(Designation::class, 'designation_id');
   }

   public function course(){
       return $this->belongsTo(Course::Class, 'course_id');
   }
}
