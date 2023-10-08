<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInformation extends Model
{
    protected $table = 'event_informations';
    protected $fillable = [ 
        'bride_name',
        'groom_name',
        'bride_mother_name',
        'bride_father_name',
        'groom_mother_name',
        'groom_father_name',
        'cover_image',
        'date_event',
        'guests',
        'account_number',
        'account_holder_name',
        'quotes',
        'address',
        'building_name',
        'lat',
        'lng',
        'maps_url',

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

    public function weddingWish()
    {
        /**
         * Has Many to Wedding Wish
        *
        * @return Collection
        *
        **/
        return $this->hasMany(WeddingWish::class);
    }

}
