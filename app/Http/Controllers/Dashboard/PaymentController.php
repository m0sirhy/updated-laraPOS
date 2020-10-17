<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Supplier;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {

        $payments = Payment::when($request->search, function ($q) use ($request) {

            return $q->where('supplier_id', 'like', '%'  . $request->search . '%');
        })->latest()->paginate(5);
        $suppliers=Supplier::get();
        $total =Payment::sum('amount');
    
        return view('dashboard.payments.index', compact('payments','suppliers','total'));
    } //end of index

    public function create()
    {
        $suppliers=Supplier::get();
        return view('dashboard.payments.create' ,compact('suppliers'));
    } //end of create

    public function store(Request $request)
    {

        $rules = [
            'supplier_id'=>'required',
            'amount' => 'required|integer|min:1',
            'statment' => 'required',
        ];

        $request->validate($rules);
        $request_data = $request->all();
        $request_data+=['user_id'=>Auth::id()];


        payment::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.payments.index');
    } //end of store

    public function edit(Payment $payment)
    {
        $suppliers=Supplier::get();

        return view('dashboard.payments.edit', compact('payment','suppliers'));
    } //end of edit

    public function update(Request $request, payment $payment)
    {
        $rules = [
            'supplier_id'=>'required',
            'amount' => 'required|integer|min:1',
            'statment' => 'required',
        ];

        $request->validate($rules);

        $request_data = $request->all();


        $payment->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.payments.index');
    } //end of update

    public function destroy(Payment $payment)
    {


        $payment->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.payments.index');
    } //end of destroy
}
