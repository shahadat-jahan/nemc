<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AdmissionAttachment extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'admission_attachments';
    protected $guarded = ['id'];

    public function attachmentType(){
        return $this->belongsTo(AttachmentType::class, 'attachment_type_id');
    }
}
