<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchace extends Model
{
    protected $guarded = [];

    //
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);

    }//end of supplier
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_purchace')->withPivot('quantity');

    }//end of products
}//end of purchase
