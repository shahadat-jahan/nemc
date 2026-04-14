<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use BlamableTrait;
    use Notifiable;
    use SoftDeletes;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $ignoreChangedAttributes = ['remember_token'];
    protected static $logAttributesToIgnore = ['remember_token'];


    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
     * Get user group
     */
    public function userGroup()
    {
        return $this->belongsTo(UserGroup::class, 'user_group_id');
    }

    /*
     * Get user details
     */
    public function userDetail()
    {
        return $this->hasOne('App\Models\UserDetail', 'user_id');
        //return $this->hasOne(AdminUser::class, 'user_id');
    }

    public function student(){
        return $this->hasOne(Student::class, 'user_id');
    }

    public function parent(){
        return $this->hasOne(Guardian::class, 'user_id');
    }

    public function teacher(){
        return $this->hasOne(Teacher::class, 'user_id' );
    }

    public function department() {
        return $this->hasOne(Department::class);
    }

    public function notifications() {
        return $this->hasMany(Notification::class, 'user_id');
    }
    //message related to user
    public function messages(){
        return $this->hasMany(Message::class, 'user_id');
    }
    //message reply related to users
    public function messageReplies(){
        return $this->hasMany(MessageReply::class, 'user_id');
    }
    public function adminUser(){
        return $this->hasOne(AdminUser::class, 'user_id');
    }

    public function group() {
        return $this->belongsTo(UserGroup::class,'user_group_id');
    }

    public function studentPayments(){
        return $this->hasMany(StudentPayment::class, 'created_by');
    }
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
