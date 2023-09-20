<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignerList extends Model
{
    protected $table = 'designer_lists';
    protected $fillable = [ 'user_id' ];

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
}
