<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateTemplate extends Model
{
    protected $table = 'rate_templates';
    protected $fillable = [ 
        'template_id',
        'user_id',
        'comment',
        'rating',
        'rate_status' 
    ];

    public function template()
    {
        /**
         * Belong to Template
         *
         * @return Collection
         *
         **/
        return $this->belongsTo(Template::class);
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
}
