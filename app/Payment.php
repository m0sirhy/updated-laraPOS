<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);

    }
    //
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);

    }//end of supplier
}
