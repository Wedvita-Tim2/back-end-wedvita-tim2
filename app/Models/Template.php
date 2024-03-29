<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'templates';
    protected $fillable = [ 
        'template_name',
        'user_id',
        'thumbnail',
        'price',
    ];

    public function order()
    {
        /**
         * Has Many to Order
         *
         * @return Collection
         *
         **/
        return $this->hasMany(Order::class);
    }

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

    public function rate()
    {
        /**
         * Has Many to Rate Template
         *
         * @return Collection
         *
         **/
        return $this->hasMany(RateTemplate::class);
    }
}
