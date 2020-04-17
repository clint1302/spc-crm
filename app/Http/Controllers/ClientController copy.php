<?php

namespace App\Http\Controllers;

use App\ClientType;
use App\ClientContract;
use App\Designation;
use App\User;
use App\EnquiryType;
use DB;
use Illuminate\Http\Request;
use PDF;

class ClientController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$clients = User::query()
			->join('client_types', 'client_types.id', '=', 'users.client_type_id')
			->leftjoin('client_contracts', 'client_contracts.id', '=', 'users.contract_id')
			->leftjoin('client_contracts AS client_contracts_second', 'client_contracts_second.id', '=', 'users.contract_id_second')
			
			->where('users.access_label', 5)
			->where('users.deletion_status', 0)
			->select('users.id', 'users.name', 'users.contact_no_one','users.spc_sold_date', 'users.present_address', 'users.spc_date', 'users.created_at', 'users.activation_status', 'client_types.client_type', 'client_types.client_type_description','client_contracts.name AS contract','client_contracts_second.name AS contract_second')
			->orderBy('users.id', 'DESC')
			->get()
			->toArray();
		return view('administrator.people.client.manage_clients', compact('clients'));
	}

	public function print() {
		$clients = User::query()
			->join('client_types', 'client_types.id', '=', 'users.client_type_id')
			->where('users.access_label', 5)
			->where('users.deletion_status', 0)
			->select('users.*', 'client_types.client_type', 'client_types.client_type_description')
			->orderBy('users.id', 'DESC')
			->get()
			->toArray();
		return view('administrator.people.client.clients_print', compact('clients'));
	}

	public function clients_pdf() {
		$clients = User::query()
			->join('client_types', 'client_types.id', '=', 'users.client_type_id')
			->where('users.access_label', 5)
			->where('users.deletion_status', 0)
			->select('users.*', 'client_types.client_type', 'client_types.client_type_description')
			->orderBy('users.id', 'DESC')
			->get()
			->toArray();

		$pdf = PDF::loadView('administrator.people.client.clients_pdf', compact('clients'));
		$file_name = 'clients.pdf';
		return $pdf->download($file_name);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$enquiry_types = EnquiryType::where('deletion_status', 0)
			->where('publication_status', 1)
			->orderBy('enquiry_type_title', 'ASC')
			->select('id', 'enquiry_type_title')
			->get()
			->toArray();
		$client_types = ClientType::where('deletion_status', 0)
			->where('publication_status', 1)
			->orderBy('client_type', 'ASC')
			->select('id', 'client_type', 'client_type_description')
			->get()
			->toArray();
		$designations = Designation::where('deletion_status', 0)
			->where('publication_status', 1)
			->orderBy('designation', 'ASC')
			->select('id', 'designation')
			->get()
			->toArray();
		return view('administrator.people.client.add_client', compact('client_types', 'designations','enquiry_types'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$url = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
		$string = '/^[A-Za-z\s-_]+$/';
		$companyName = "SPC";
		$companyCountry = "Suriname";
		$created_year = date("Y");
		$enquiry_date = \Carbon\Carbon::parse($request->spc_date)->format('d-M-y');

		/*$client = request()->validate([
			'name' => 'required|max:100|regex:' . $string,
			'email' => 'nullable|email|unique:users|max:100',
			'contact_no_one' => 'required|max:20',
			'web' => 'nullable|max:150|regex:' . $url,
			'gender' => 'required',
			'date_of_birth' => 'nullable|date',
			'present_address' => 'required|max:250',
			'contact_no_two' => 'nullable|max:250',
			'client_type_id' => 'required|numeric',
		], [
			'client_type_id.required' => 'The client type field is required.',
			'contact_no_one.required' => 'The contact no field is required.',
			'web.regex' => 'The URL format is invalid.',
			'name.regex' => 'No number is allowed.',
		]);*/

		$client = request()->validate([
			'name' => 'required|max:100|regex:' . $string,
			'email' => 'nullable|email|max:100',
			'email_no_two' => 'nullable|email|max:100',
			'contact_no_one' => 'required|max:250',
			//'web' => 'nullable|max:150|regex:' . $url,
			//'gender' => 'required',
			//'date_of_birth' => 'nullable|date',
			//'contact_no_two' => 'nullable|max:250',
			'present_address' => 'required|max:250',
			'spc_pest' => 'nullable|max:250',
			//'spc_date' => 'nullable|max:250',
			'spc_update' => 'nullable|max:250',
			'spc_contactpersoon' => 'nullable|max:250',
			'spc_serviceadres' => 'nullable|max:250',
			'spc_client_sex' => 'nullable|max:250',
			'spc_eyear' => 'nullable|numeric',
			'spc_company' => 'nullable|max:250',
			'spc_country' => 'nullable|max:250',
			'contract_id' => 'nullable|numeric',
			'client_type_id' => 'required|numeric',
			'enquiry_type_id' => 'required|numeric',
		], [
			'client_type_id.required' => 'The client type field is required.',
			'enquiry_type_id.required' => 'The enquiry type field is required.',
			'contact_no_one.required' => 'The contact no field is required.',
			//'web.regex' => 'The URL format is invalid.',
			'name.regex' => 'No number is allowed.',
		]);

		$result = User::create($client + ['created_by' => auth()->user()->id, 'password' => bcrypt(12345678), 'access_label' => 5 ,'spc_eyear' => $created_year, 'spc_country' => $companyCountry, 'spc_company' => $companyName, 'spc_date' => $enquiry_date]);
		$inserted_id = $result->id;

		if (!empty($inserted_id)) {
			return redirect('/people/clients/create')->with('message', 'Add successfully.');
		}
		return redirect('/people/clients/create')->with('exception', 'Operation failed !');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function active($id) {
		$user_id = User::where('id',$id)
			->select('id')
			->first();

		$affected_row = User::where('id', $id)
			->update(['activation_status' => 1]);

		if (!empty($affected_row)) {
			return redirect('/people/clients/details/'.$user_id->id)->with('message', 'Activate successfully.');
		}
		//return redirect('/people/clients')->with('exception', 'Operation failed !');
		return redirect('/people/clients/details/'.$user_id->id)->with('exception', 'Operation failed !');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function deactive($id) {
		$user_id = User::where('id',$id)
			->select('id')
			->first();

		$affected_row = User::where('id', $id)
			->update(['activation_status' => 0]);

		if (!empty($affected_row)) {
			return redirect('/people/clients/details/'.$user_id->id)->with('message', 'Deactive successfully.');
		}
		return redirect('/people/clients/details/'.$user_id->id)->with('exception', 'Operation failed !');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$client = DB::table('users')
			->join('client_types', 'users.client_type_id', '=', 'client_types.id')
			->leftjoin('enquiry_types', 'users.enquiry_type_id', '=', 'enquiry_types.id')
			->select('users.*', 'client_types.client_type', 'client_types.client_type_description','enquiry_types.enquiry_type_title AS etype')
			//->select('users.*', 'client_types.client_type', 'client_types.client_type_description')
			->where('users.id', $id)
			->first();
		$created_by = User::where('id', $client->created_by)
			->select('id', 'name')
			->first();
		$client_contract = DB::table('users')
			->join('client_contracts', 'users.contract_id', '=', 'client_contracts.id')
			->select('users.*', 'client_contracts.name', 'client_contracts.time')
			->where('users.id', $id) 
			->first();
		$client_contract_second = DB::table('users')
			->join('client_contracts', 'users.contract_id_second', '=', 'client_contracts.id')
			->select('users.*', 'client_contracts.name', 'client_contracts.time')
			->where('users.id', $id) 
			->first();
		$jobs = DB::table('jobs')
			->join('job_types', 'jobs.job_type', '=', 'job_types.id')
			->join('users', 'jobs.client', '=', 'users.id')
			->select('jobs.id', 'jobs.name_of_account', 'jobs.receiving_date','jobs.auto_kenteken','jobs.job_time', 'jobs.created_at', 'jobs.publication_status', 'assign_to','assign_to_second', 'jobs.job_status', 'users.name', 'users.id as user_id')
			->where('jobs.deletion_status', 0)
			->where('jobs.client', $id)
			->orderBy('jobs.id', 'DESC')
			->get();
		$users = User::where('access_label', '>=', 2)
			->where('access_label', '<=', 3)
			->select('id', 'name')
			->get();
		return view('administrator.people.client.show_client', compact('client', 'created_by','client_contract','client_contract_second','jobs','users'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function pdf($id) {
		$client = DB::table('users')
			->join('client_types', 'users.client_type_id', '=', 'client_types.id')
			->select('users.*', 'client_types.client_type', 'client_types.client_type_description')
			->where('users.id', $id)
			->first();

		$created_by = User::where('id', $client->created_by)
			->select('id', 'name')
			->first();

		$pdf = PDF::loadView('administrator.people.client.pdf', compact('client', 'created_by'));
		$file_name = str_replace(' ', '', $client->name) . '.pdf';
		return $pdf->download($file_name);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$client = User::find($id)->toArray();
		$enquiry_types = EnquiryType::where('deletion_status', 0)
			->where('publication_status', 1)
			->orderBy('enquiry_type_title', 'ASC')
			->select('id', 'enquiry_type_title')
			->get()
			->toArray();
		$client_types = ClientType::where('deletion_status', 0)
			->where('publication_status', 1)
			->orderBy('client_type', 'ASC')
			->select('id', 'client_type', 'client_type_description')
			->get()
			->toArray();
		$client_contracts = ClientContract::where('deletion_status', 0)
			->where('publication_status', 1)
			->orderBy('name', 'ASC')
			->select('id', 'name', 'time')
			->get()
			->toArray();
		$designations = Designation::where('deletion_status', 0)
			->where('publication_status', 1)
			->orderBy('designation', 'ASC')
			->select('id', 'designation')
			->get()
			->toArray();
		return view('administrator.people.client.edit_client', compact('client', 'client_types','enquiry_types','client_contracts', 'designations'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$user_id = User::where('id',$id)
			->select('id')
			->first();

		$client = User::find($id);

		$url = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
		$string = '/^[A-Za-z\s-_]+$/';		
		//$enquiry_date = \Carbon\Carbon::parse($request->spc_date)->format('d-M-y');
		$enquiry_date = $request->spc_date;

		request()->validate([
			'name' => 'required|max:100|regex:' . $string,
			'email' => 'nullable|email|max:100',
			'email_no_two' => 'nullable|email|max:100',
			'contact_no_one' => 'required|max:250',
			//'web' => 'nullable|max:150|regex:' . $url,
			//'gender' => 'required',
			//'date_of_birth' => 'nullable|date',
			//'contact_no_two' => 'nullable|max:250',
			'present_address' => 'required|max:250',
			'spc_pest' => 'nullable|max:250',
			'spc_update' => 'nullable|max:250',
			'spc_contactpersoon' => 'nullable|max:250',
			'spc_serviceadres' => 'nullable|max:250',
			'spc_client_sex' => 'nullable|max:250',
			'contract_id' => 'nullable|numeric',
			'contract_id_second' => 'nullable|numeric',
			'client_type_id' => 'required|numeric',
			'enquiry_type' => 'required|numeric',
		], [
			'client_type_id.required' => 'The client type field is required.',
			'enquiry_type.required' => 'The enquiry source field is required.',
			'contact_no_one.required' => 'The contact no field is required.',
			//'web.regex' => 'The URL format is invalid.',
			'name.regex' => 'No number is allowed.',
		]);

		$client->name = $request->get('name');
		$client->email = $request->get('email');
		$client->email_no_two = $request->get('email_no_two');
		$client->contact_no_one = $request->get('contact_no_one');
		//$client->web = $request->get('web');
		//$client->gender = $request->get('gender');
		//$client->date_of_birth = $request->get('date_of_birth');
		$client->spc_sold_date = $request->get('spc_sold_date');
		$client->present_address = $request->get('present_address');
		$client->spc_pest = $request->get('spc_pest');
		$client->spc_update = $request->get('spc_update');
		$client->spc_contactpersoon = $request->get('spc_contactpersoon');
		$client->spc_serviceadres = $request->get('spc_serviceadres');
		$client->spc_client_sex = $request->get('spc_client_sex');
		//$client->spc_company = $companyName;
		$client->contract_id = $request->get('contract_id');
		$client->contract_id_second = $request->get('contract_id_second');
		$client->client_type_id = $request->get('client_type_id');
		$client->enquiry_type_id = $request->get('enquiry_type');
		$client->spc_date = $enquiry_date;

		$affected_row = $client->save();

		if (!empty($affected_row)) {
			return redirect('/people/clients/details/'.$user_id->id)->with('message', 'Update successfully.');
		}
		//return redirect('/people/clients')->with('exception', 'Operation failed !');
		return redirect('/people/clients/details/'.$user_id->id)->with('exception', 'Operation failed !');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$affected_row = User::where('id', $id)
			->update(['deletion_status' => 1]);

		if (!empty($affected_row)) {
			return redirect('/people/clients')->with('message', 'Delete successfully.');
		}
		return redirect('/people/clients')->with('exception', 'Operation failed !');
	}

}
