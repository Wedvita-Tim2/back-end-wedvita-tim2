<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingWish extends Model
{
    protected $table = 'wedding_wishes';
    protected $fillable = [ 
        'guest_name',
        'message',
        'event_information_id',
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
