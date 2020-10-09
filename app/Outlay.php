<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outlay extends Model
{
    //
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);

    }//end fo category
}
