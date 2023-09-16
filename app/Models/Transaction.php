<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'transaction_code',
        'user_id',
        'template_id',
        'event_information_id',
        'transaction_verification',
    ];

    public function user()
    {
        /**
         * Belong to User
         *
         * @return Collection
         *
         **/
        $this->belongsTo(User::class);
    }

    public function template()
    {
        /**
         * Belong to User
         *
         * @return Collection
         *
         **/
        $this->belongsTo(Template::class);
    }

    public function eventInformation()
    {
        /**
         * Belong to EventInformation
         *
         * @return Collection
         *
         **/
        $this->belongsTo(EventInformation::class);
    }
    
}
