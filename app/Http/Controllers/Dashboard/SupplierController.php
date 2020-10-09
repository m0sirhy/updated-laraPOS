<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier;
class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::when($request->search, function($q) use ($request){

            return $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('dashboard.suppliers.index', compact('suppliers'));

    }//end of index

    public function create()
    {
        return view('dashboard.suppliers.create');

    }//end of create

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $request_data = $request->all();

        Supplier::create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.suppliers.index');

    }//end of store

    public function edit(Supplier $supplier)
    {
        return view('dashboard.suppliers.edit', compact('supplier'));

    }//end of edit

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $request_data = $request->all();

        $client->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.suppliers.index');

    }//end of update

    public function destroy(Supplier $supplier)
    {
        $client->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.suppliers.index');

    }//end of destroy
}
