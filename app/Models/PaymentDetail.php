<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PaymentDetail extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'payment_details';
    protected $guarded = ['id'];

    //payment type related to payment detail
    public function paymentType() {
        return $this->belongsTo(PaymentType::class);
    }
    //student category related to payment detail
    public function studentCategory() {
        return $this->belongsTo(StudentCategory::class);
    }

    //course related to payment detail
    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function session(){
        return $this->belongsTo(Session::class);
    }
}
