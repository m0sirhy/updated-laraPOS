<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Outlay;
use Illuminate\Support\Facades\Auth;
class OutlayController extends Controller
{

    public function index(Request $request)
    {
        $outlays = Outlay::when($request->search, function ($q) use ($request) {

            return $q->where('payee', 'like', '%'  . $request->search . '%');
        })->latest()->paginate(5);
        $total =Outlay::sum('amount');

        return view('dashboard.outlays.index', compact('outlays','total'));
    } //end of index

    public function create()
    {
        return view('dashboard.outlays.create');
    } //end of create

    public function store(Request $request)
    {

        $rules = [
            'amount' => 'required|integer|min:1',
            'payee' => 'required',
            'statment' => 'required',
        ];

        $request->validate($rules);
        $request_data = $request->all();
        $request_data+=['user_id'=>Auth::id()];


        outlay::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.outlays.index');
    } //end of store

    public function edit(outlay $outlay)
    {
        return view('dashboard.outlays.edit', compact('outlay'));
    } //end of edit

    public function update(Request $request, outlay $outlay)
    {
        $rules = [
            'amount' => 'required|integer|min:1',
            'payee' => 'required',
            'statment' => 'required',
        ];

        $request->validate($rules);

        $request_data = $request->all();


        $outlay->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.outlays.index');
    } //end of update

    public function destroy(outlay $outlay)
    {


        $outlay->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.outlays.index');
    } //end of destroy
}//end of controller
