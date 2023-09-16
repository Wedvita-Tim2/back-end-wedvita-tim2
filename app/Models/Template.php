<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'templates';
    protected $fillable = [ 'template_code' ];

    public function transaction()
    {
        /**
         * Has Many to Transaction
         *
         * @return Collection
         *
         **/
        return $this->hasMany(Transaction::class);
    }
}
