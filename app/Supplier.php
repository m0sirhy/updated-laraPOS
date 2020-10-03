<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'phone' => 'array'
    ];

    public function getNameAttribute($value)
    {
        return ucfirst($value);

    }//end of get name attribute

    public function purchaces()
    {
        return $this->hasMany(Purchace::class);

    }//end of orders

}
