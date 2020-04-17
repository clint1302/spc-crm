<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EnquiryType;

class EnquiryTypesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $enquiryTypes = EnquiryType::all()
        ->sortBy('enquiry_type_title')
        ->where('deletion_status', 0);

        return view('administrator.setting.enquiry_types.manage_enquirytype', compact('enquiryTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        return view('administrator.setting.enquiry_types.add_enquirytype', compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $enquiryType = $this->validate(request(), [
            'enquiry_type_title' => 'required|max:255',
        ],[
            'enquiry_type_title.required' => 'The enquiry title field is required.',
        ]);

        $result = EnquiryType::create($enquiryType);
        $inserted_id = $result->id;

        if (!empty($inserted_id)) {
            return redirect('/setting/enquiry-types')->with('message', 'Add successfully.');
        }
        return redirect('/setting/enquiry-types')->with('exception', 'Operation failed !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $contract_id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $enquiryType = EnquiryType::find($id)->toArray();

        return view('administrator.setting.enquiry_types.edit_enquirytype', compact('enquiryType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $enquiryType = EnquiryType::find($id);
        $this->validate(request(), [
            'enquiry_type_title' => 'required|max:255'
        ],[
            'enquiry_type_title.required' => 'The enquiry title field is required.',
        ]);

        $enquiryType->enquiry_type_title = $request->get('enquiry_type_title');
        $affected_row = $enquiryType->save();

        if (!empty($affected_row)) {
            return redirect('/setting/enquiry-types')->with('message', 'Update successfully.');
        }
        return redirect('/setting/enquiry-types')->with('exception', 'Operation failed !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $affected_row = EnquiryType::where('id', $id)
                ->update(['deletion_status' => 1]);

        if (!empty($affected_row)) {
            return redirect('/setting/enquiry-types')->with('message', 'Delete successfully.');
        }
        return redirect('/setting/enquiry-types')->with('exception', 'Operation failed !');
    }

}
