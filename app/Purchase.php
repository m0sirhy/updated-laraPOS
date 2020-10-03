<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);

    }//end of supplier
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order')->withPivot('quantity');

    }//end of products
}//end of purchase
