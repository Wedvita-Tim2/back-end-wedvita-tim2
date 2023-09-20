<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInformation extends Model
{
    protected $table = 'event_informations';
    protected $fillable = [ 
        'bride_name',
        'bride_mother_name',
        'bride_father_name',
        'groom_name',
        'groom_mother_name',
        'groom_father_name',
        'date',
        'address',
        'building_name',
 ];

    public function order()
    {
        /**
         * Has One to Order
        *
        * @return Collection
        *
        **/
        return $this->hasOne(Order::class);
    }

    public function attachment()
    {
        /**
         * Has Many to Attachment
        *
        * @return Collection
        *
        **/
        return $this->hasMany(Attachment::class);
    }

    public function guest()
    {
        /**
         * Has Many to Guest
        *
        * @return Collection
        *
        **/
        return $this->hasMany(Guest::class);
    }

}
