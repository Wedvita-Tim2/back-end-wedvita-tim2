<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'role_id',
        'username',
        'email',
        'password',
        'phone_number',
    ];

    public function role()
    {
        /**
         * Belong to Role
         *
         * @return Collection
         *
         **/
        $this->belongsTo(Role::class);
    }

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

    public function template()
    {
        /**
         * Has Many to Template
         *
         * @return Collection
         *
         **/
        return $this->hasMany(Template::class);
    }

    public function designerList()
    {
        /**
         * Has Many to Designer List
         *
         * @return Collection
         *
         **/
        return $this->hasOne(DesignerList::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
