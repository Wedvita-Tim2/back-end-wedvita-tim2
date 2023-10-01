<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';
    protected $fillable = [
        'event_information_id',
        'attachment_name',
    ];

    public function eventInformation()
    {
        /**
         * Belong to Event Information
         *
         * @return Collection
         *
         **/
        return $this->belongsTo(EventInformation::class);
    }
}
