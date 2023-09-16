<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [ 'role_name' ];

    public function user()
    {
        /**
         * Has Many to User
         *
         * @return Collection
         *
         **/
        return $this->hasMany(User::class);
    }
}
