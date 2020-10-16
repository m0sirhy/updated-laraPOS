<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Purchace;

class PurchaceController extends Controller
{
    public function index(Request $request)
    {
        $purchaces = Purchace::whereHas('supplier', function ($q) use ($request) {

            return $q->where('name', 'like', '%' . $request->search . '%');

        })->paginate(5);
    $total =Purchace::sum('total_price');

        return view('dashboard.purchaces.index', compact('purchaces','total'));

    }//end of index

    public function products(Purchace $purchace)
    {
        $products = $purchace->products;
        return view('dashboard.purchaces._products', compact('purchace', 'products'));

    }//end of products
    
    public function destroy(Purchace $purchace)
    {
        foreach ($purchace->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }//end of for each

        $purchace->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.purchases.index');
    
    }//end of purchace
}
