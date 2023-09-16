<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table = 'guests';
    protected $fillable = [
        'event_information_id',
        'guest_name',
    ];

    public function eventInformation()
    {
        /**
         * Belong to Event Information
         *
         * @return Collection
         *
         **/
        $this->belongsTo(EventInformation::class);
    }
}
