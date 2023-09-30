<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'order_code',
        'user_id',
        'template_id',
        'event_information_id',
        'order_verification',
    ];

    public function user()
    {
        /**
         * Belong to User
         *
         * @return Collection
         *
         **/
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        /**
         * Belong to User
         *
         * @return Collection
         *
         **/
        return $this->belongsTo(Template::class);
    }

    public function eventInformation()
    {
        /**
         * Belong to EventInformation
         *
         * @return Collection
         *
         **/
        return $this->belongsTo(EventInformation::class);
    }
    
}
