<?php

namespace App\Http\Controllers;

use App\CustomInvoice;
use App\CustomInvoiceDetails;
use Illuminate\Http\Request;

class InvoiceController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('administrator.invoice.custom_invoice');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$invoice_items = $request->all();
		$invoice = request()->validate([
			'invoice_type' => 'required',
			'date' => 'date|required',
			'reference_no' => 'required|max:100',
			'invoice_no' => 'required|max:100',
			'invoice_name' => 'required|max:100',
			'subject' => 'required|max:255',
			'address_one' => 'required|max:250',
			'address_two' => 'required|max:250',
			'contact_no' => 'nullable|max:20',
			'email_address' => 'nullable|max:100',
			'short_note' => 'nullable|max:255',
			'payment_method' => 'required',
			'discount' => 'nullable|numeric',
			'tax' => 'nullable|numeric',
			'paid_amount' => 'nullable|numeric',
		], [
			'invoice_type.required' => 'The invoice type field is required.',
			'invoice_name.required' => 'The billing to field is required.',
			'address_one.required' => 'The address field is required.',
			'address_two.required' => 'The address field is required.',
			'invoice_no.required' => 'The bill no field is required.',
		]);

		$custom_invoice_result = CustomInvoice::create($invoice + [
			'created_by' => auth()->user()->id,
		]);
		$inserted_id = $custom_invoice_result->id;

		for ($i = 0; $i < count($request->sl); $i++) {
			$custom_invoice_result = CustomInvoiceDetails::create([
				'invoice_id' => $inserted_id,
				'sl' => $request->sl[$i],
				'description' => $request->description[$i],
				'subtotal' => $request->subtotal[$i],
			]);
		}

		return view('administrator.invoice.invoice', compact('invoice_items'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}
