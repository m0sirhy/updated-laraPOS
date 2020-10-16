<?php

namespace App\Http\Controllers\Dashboard\Supplier;


use App\Category;
use App\Client;
use App\Order;
use App\Purchace;
use App\Product;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier;

class PurchaceController extends Controller
{

    
   
        public function create(Supplier $supplier)
        {
            
            $categories = Category::with('products')->get();
            $purchaces = $supplier->purchaces()->with('products')->paginate(5);
            return view('dashboard.suppliers.purchaces.create', compact( 'supplier', 'categories', 'purchaces'));
    
        }//end of create
    
        public function store(Request $request, Supplier $supplier)
        {
            $request->validate([
                'products' => 'required|array',
            ]);
    
            $this->attach_purchace($request, $supplier);
    
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.purchaces.index');
    
        }//end of store
    
        public function edit(Supplier $supplier, Purchace $purchace)
        {
            $categories = Category::with('products')->get();
            $purchaces = $supplier->purchaces()->with('products')->paginate(5);
            return view('dashboard.suppliers.purchaces.edit', compact('supplier', 'purchace', 'categories', 'purchaces'));
    
        }//end of edit
    
        public function update(Request $request, Supplier $supplier, Purchace $purchace)
        {
            $request->validate([
                'products' => 'required|array',
            ]);
    
            $this->detach_purchace($purchace);
    
            $this->attach_purchace($request, $supplier);
    
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.purchaces.index');
    
        }//end of update
    
        private function attach_purchace($request, $supplier)
        {
            $purchace = $supplier->purchaces()->create([]);
    
            $purchace->products()->attach($request->products);
    
            $total_price = 0;
    
            foreach ($request->products as $id => $quantity) {
    
                $product = Product::FindOrFail($id);
                $total_price += $product->sale_price * $quantity['quantity'];
    
                $product->update([
                    'stock' => $product->stock + $quantity['quantity']
                ]);
    
            }//end of foreach
            $total_price -=$request->discount ;
            $purchace->update([
                'total_price' => $total_price,
                'discount' => $request->discount,
                'status' =>$request->cash
            ]);
    
        }//end of attach purchace
    
        private function detach_purchace($purchace)
        {
            foreach ($purchace->products as $product) {
    
                $product->update([
                    'stock' => $product->stock + $product->pivot->quantity
                ]);
    
            }//end of for each
    
            $purchace->delete();
    
        }//end of detach purchace
    
    }//end of controller
    

