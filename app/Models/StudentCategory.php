<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class StudentCategory extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'student_categories';
    protected $guarded = ['id'];
    //payment detail related to student category
    public function paymentDetails() {

        return $this->hasMany(PaymentDetail::class, 'student_category_id');
    }
}
