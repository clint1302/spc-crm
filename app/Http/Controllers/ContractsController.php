<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use App\ClientContract;
use App\Department;

class ContractsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $contracts = ClientContract::all()
        ->sortBy('name')
        ->where('deletion_status', 0);

        return view('administrator.setting.contracts.manage_contracts', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        return view('administrator.setting.contracts.add_contracts', compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $contracts = $this->validate(request(), [
            'name' => 'required|max:50',
            'time' => 'nullable',
        ],[
            'name.required' => 'The contract name field is required.',
        ]);

        $result = ClientContract::create($contracts);
        $inserted_id = $result->id;

        if (!empty($inserted_id)) {
            return redirect('/setting/contracts')->with('message', 'Add successfully.');
        }
        return redirect('/setting/contracts')->with('exception', 'Operation failed !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $contract_id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $contract = ClientContract::find($id)->toArray();

        return view('administrator.setting.contracts.edit_contracts', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $contract = ClientContract::find($id);
        $this->validate(request(), [
            'name' => 'required|max:50',
            'time' => 'nullable',
        ],[
            'name.required' => 'The name field is required.',
        ]);

        $contract->name = $request->get('name');
        $contract->time = $request->get('time');
        $affected_row = $contract->save();

        if (!empty($affected_row)) {
            return redirect('/setting/contracts')->with('message', 'Update successfully.');
        }
        return redirect('/setting/contracts')->with('exception', 'Operation failed !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $affected_row = ClientContract::where('id', $id)
                ->update(['deletion_status' => 1]);

        if (!empty($affected_row)) {
            return redirect('/setting/contracts')->with('message', 'Delete successfully.');
        }
        return redirect('/setting/contracts')->with('exception', 'Operation failed !');
    }

}
