<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AdmissionParent extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'admission_parents';
    protected $guarded = ['id'];

    public function admissionStudents(){
        return $this->hasMany(AdmissionStudent::class, 'admission_parent_id');
    }

    public function admissionStudent(){
        return $this->hasOne(AdmissionStudent::class, 'admission_parent_id');
    }
}
