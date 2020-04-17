<?php

namespace App\Http\Controllers;

use App\Job;
use App\User;
use DB;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('administrator.report.search_account_reports');
	}

	public function client_index() {

		$clients = User::query()
			->join('client_types', 'client_types.id', '=', 'users.client_type_id')
			->leftjoin('client_contracts', 'client_contracts.id', '=', 'users.contract_id')
			->where('users.access_label', 5)
			->where('users.deletion_status', 0)
			->select('users.id', 'users.name', 'users.contact_no_one','users.present_address')
			->orderBy('users.id', 'DESC')
			->get()
			->toArray();
		return view('administrator.report.search_clientaccount_reports', compact('clients'));

		//return view('administrator.report.search_clientaccount_reports');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function show_account_reports(Request $request) {
		$data = request()->validate([
			//'form_date' => 'required|date',
			//'to_date' => 'required|date',
			'enquiry_year' => 'required|max:20',
			'client_status' => 'required|max:20',
		], [
			'enquiry_year.required' => 'The enquiry year is required.',
			'client_status.required' => 'The client status is required.',
		]);

		$enquiry_year = $request->enquiry_year;
		$client_status = $request->client_status;

		/*$form_date = $request->form_date;
		$to_date = $request->to_date;*/

		/*$jobs = Job::where('deletion_status', 0)
		->where('receiving_date', '>=', $data['form_date'])
		->where('receiving_date', '<=', $data['to_date'])
		->where('deletion_status', 0)
		->select('id', 'name_of_account', 'receiving_date', 'client', 'reference_by')
		->orderBy('id', 'ASC')
		->get();*/
		
		
		if($client_status == "*"){

			$clients = User::query()
			->join('client_types', 'client_types.id', '=', 'users.client_type_id')
			->leftjoin('enquiry_types', 'users.enquiry_type_id', '=', 'enquiry_types.id')
			->leftjoin('client_contracts', 'client_contracts.id', '=', 'users.contract_id')
			->where('spc_eyear', '=', $enquiry_year)
			->where('users.access_label', 5)
			->where('users.deletion_status', 0)
			//->where('spc_eyear', '<=', '2016')
			->select('users.id','enquiry_types.enquiry_type_title AS etype', 'users.name', 'users.contact_no_one','users.spc_sold_date', 'users.present_address', 'users.spc_date','users.spc_eyear', 'users.created_at', 'users.activation_status', 'client_types.client_type', 'client_types.client_type_description','client_contracts.name AS contract')
			->orderBy('users.id', 'DESC')
			->get()
			->toArray();
			
		}else{

			$clients = User::query()
			->join('client_types', 'client_types.id', '=', 'users.client_type_id')
			->leftjoin('enquiry_types', 'users.enquiry_type_id', '=', 'enquiry_types.id')
			->leftjoin('client_contracts', 'client_contracts.id', '=', 'users.contract_id')
			->where('spc_eyear', '=', $enquiry_year)
			->where('users.activation_status', $client_status)
			->where('users.access_label', 5)
			->where('users.deletion_status', 0)
			//->where('spc_eyear', '<=', '2016')
			->select('users.id','enquiry_types.enquiry_type_title AS etype', 'users.name', 'users.contact_no_one','users.spc_sold_date', 'users.present_address', 'users.spc_date','users.spc_eyear', 'users.created_at', 'users.activation_status', 'client_types.client_type', 'client_types.client_type_description','client_contracts.name AS contract')
			->orderBy('users.id', 'DESC')
			->get()
			->toArray();
		}
		
		
		return view('administrator.report.show_account_reports', compact('clients','enquiry_year','client_status'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function show_clientaccount_reports($client_id) {

		$client = DB::table('users')
			->join('client_types', 'users.client_type_id', '=', 'client_types.id')
			->leftjoin('enquiry_types', 'users.enquiry_type_id', '=', 'enquiry_types.id')
			->select('users.*', 'client_types.client_type', 'client_types.client_type_description','enquiry_types.enquiry_type_title AS etype')
			//->select('users.*', 'client_types.client_type', 'client_types.client_type_description')
			->where('users.id', $client_id)
			->first();
		$created_by = User::where('id', $client->created_by)
			->select('id', 'name')
			->first();
		$client_contract = DB::table('users')
			->join('client_contracts', 'users.contract_id', '=', 'client_contracts.id')
			->select('users.*', 'client_contracts.name', 'client_contracts.time')
			->where('users.id', $client_id) 
			->first();
		$client_contract_second = DB::table('users')
			->join('client_contracts', 'users.contract_id_second', '=', 'client_contracts.id')
			->select('users.*', 'client_contracts.name', 'client_contracts.time')
			->where('users.id', $client_id) 
			->first();
		$jobs = DB::table('jobs')
			->join('job_types', 'jobs.job_type', '=', 'job_types.id')
			->join('users', 'jobs.client', '=', 'users.id')
			->select('jobs.id', 'jobs.name_of_account', 'jobs.receiving_date','jobs.auto_kenteken','jobs.job_time', 'jobs.created_at', 'jobs.publication_status', 'assign_to','assign_to_second', 'jobs.job_status', 'users.name', 'users.id as user_id')
			->where('jobs.deletion_status', 0)
			->where('jobs.client', $client_id)
			->orderBy('jobs.id', 'DESC')
			->get();
		$users = User::where('access_label', '>=', 2)
			->where('access_label', '<=', 3)
			->select('id', 'name')
			->get();

			/*$clientInfo = User::query()
			->join('client_types', 'client_types.id', '=', 'users.client_type_id')
			->leftjoin('enquiry_types', 'users.enquiry_type_id', '=', 'enquiry_types.id')
			->leftjoin('client_contracts', 'client_contracts.id', '=', 'users.contract_id')
			->where('users.id','=', $client_id)
			->where('users.access_label', 5)
			->where('users.deletion_status', 0)
			->select('users.id','enquiry_types.enquiry_type_title AS etype', 'users.name', 'users.contact_no_one','users.spc_sold_date', 'users.present_address', 'users.spc_date','users.spc_eyear', 'users.created_at', 'users.activation_status', 'client_types.client_type', 'client_types.client_type_description','client_contracts.name AS contract')
			->first();*/
		
		return view('administrator.report.show_clientaccount_reports', compact('client','created_by','created_by','client_contract','client_contract_second','jobs','users'));
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function account_pdf($enquiry_year,$client_status) {

		//pdf name
		$pdf_client_status ="all";
		if($client_status == "1"){$pdf_client_status = "active";}
		if($client_status == "0"){$pdf_client_status = "deactive";}
		
		if($client_status == "*"){

			$clients = User::query()
			->join('client_types', 'client_types.id', '=', 'users.client_type_id')
			->leftjoin('client_contracts', 'client_contracts.id', '=', 'users.contract_id')
			->where('spc_eyear', '=', $enquiry_year)
			->where('users.access_label', 5)
			->where('users.deletion_status', 0)
			//->where('spc_eyear', '<=', '2016')
			->select('users.*', 'client_types.*','client_contracts.name AS contract')
			//->select('users.id', 'users.name', 'users.contact_no_one','users.spc_sold_date', 'users.present_address', 'users.spc_date','users.spc_eyear', 'users.created_at', 'users.activation_status', 'client_types.client_type', 'client_types.client_type_description','client_contracts.name AS contract')
			->orderBy('users.id', 'DESC')
			->get()
			->toArray();
			
		}else{

			$clients = User::query()
			->join('client_types', 'client_types.id', '=', 'users.client_type_id')
			->leftjoin('client_contracts', 'client_contracts.id', '=', 'users.contract_id')
			->where('spc_eyear', '=', $enquiry_year)
			->where('users.activation_status', $client_status)
			->where('users.access_label', 5)
			->where('users.deletion_status', 0)
			//->where('spc_eyear', '<=', '2016')
			//->select('users.id', 'users.name', 'users.contact_no_one','users.spc_sold_date', 'users.present_address', 'users.spc_date','users.spc_eyear', 'users.created_at', 'users.activation_status', 'client_types.client_type', 'client_types.client_type_description','client_contracts.name AS contract')
			->select('users.*', 'client_types.*','client_contracts.name AS contract')
			->orderBy('users.id', 'DESC')
			->get()
			->toArray();
		}

		//$pdf = PDF::loadView('administrator.report.account_pdf', compact('jobs', 'users', 'total_payables', 'total_discounts', 'total_installments'));
		$pdf = PDF::loadView('administrator.report.account_pdf', compact('clients'));
		return $pdf->download('clients_report_'.$enquiry_year.'_'.$pdf_client_status.'.pdf');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function search_job_reports() {
		$users = User::whereBetween('access_label', [2, 3])
		->where('deletion_status', 0)
		->orderBy('name', 'ASC')
		->get(['id', 'name']);

		return view('administrator.report.search_job_reports', compact('users'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function show_job_reports(Request $request) {
		$data = request()->validate([
			'form_date' => 'required|date',
			'to_date' => 'required|date',
		], [
			'form_date.required' => 'The form date is required.',
			'to_date.required' => 'The to date is required.',
		]);

		$form_date = $request->form_date;
		$to_date = $request->to_date;
		$assign_to = $request->assign_to;

		if ($request->assign_to > 0) {
			$jobs = Job::where('deletion_status', 0)
			//->join('users', 'jobs.client', '=', 'users.id')
			->where('receiving_date', '>=', $data['form_date'])
			->where('receiving_date', '<=', $data['to_date'])
			->where('deletion_status', 0)
			->where('assign_to', $request->assign_to)
			->orwhere('assign_to_second', $request->assign_to)
			->select('id', 'name_of_account', 'assign_to','assign_to_second', 'client','auto_kenteken', 'reference_by', 'job_status','receiving_date','job_time')
			->orderBy('id', 'ASC')
			->get();
		} else {
			$jobs = Job::where('deletion_status', 0)
			->where('receiving_date', '>=', $data['form_date'])
			->where('receiving_date', '<=', $data['to_date'])
			->where('deletion_status', 0)
			->select('id', 'name_of_account', 'assign_to', 'client', 'reference_by', 'job_status')
			->orderBy('id', 'ASC')
			->get();
		}

		//$users = User::where('deletion_status', 0)
		$users_search = User::whereBetween('access_label', [2, 3])
		->where('deletion_status', 0)
		->select('id', 'name')
		->orderBy('name', 'ASC')
		->get();

		$clients = User::whereBetween('access_label', [2, 5])
		->select('id', 'name')
		->get();

		$total_payables = DB::table('payables')
		->select(DB::raw('sum(payables.payable_amount) AS total_payable_amount', 'sum(payables.tax_amount) AS total_tax_amount'), DB::raw('sum(payables.tax_amount) AS total_tax_amount'), 'payables.job_id')
		->groupBy('payables.job_id')
		->get();

		$total_discounts = DB::table('discounts')
		->select(DB::raw('sum(discounts.discount_amount) AS total_discount_amount'), 'discounts.job_id')
		->groupBy('discounts.job_id')
		->get();

		$total_installments = DB::table('installments')
		->select(DB::raw('sum(installments.installment_amount) AS total_installment_amount'), 'installments.job_id')
		->groupBy('installments.job_id')
		->get();

		return view('administrator.report.show_job_reports', compact('jobs', 'users_search','clients','total_payables', 'total_discounts', 'total_installments', 'form_date', 'to_date', 'assign_to'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function job_pdf($form_date, $to_date, $assign_to) {
		if ($assign_to > 0) {
			$jobs = Job::where('deletion_status', 0)
			->where('receiving_date', '>=', $form_date)
			->where('receiving_date', '<=', $to_date)
			->where('assign_to', $assign_to)
			->where('deletion_status', 0)
			->select('id', 'name_of_account', 'assign_to', 'client', 'reference_by', 'job_status')
			->orderBy('id', 'ASC')
			->get();
		} else {
			$jobs = Job::where('deletion_status', 0)
			->where('receiving_date', '>=', $form_date)
			->where('receiving_date', '<=', $to_date)
			->where('deletion_status', 0)
			->select('id', 'name_of_account', 'assign_to', 'client', 'reference_by', 'job_status')
			->orderBy('id', 'ASC')
			->get();
		}

		$users = User::where('deletion_status', 0)
		->select('id', 'name')
		->get();

		$total_payables = DB::table('payables')
		->select(DB::raw('sum(payables.payable_amount) AS total_payable_amount', 'sum(payables.tax_amount) AS total_tax_amount'), DB::raw('sum(payables.tax_amount) AS total_tax_amount'), 'payables.job_id')
		->groupBy('payables.job_id')
		->get();

		$total_discounts = DB::table('discounts')
		->select(DB::raw('sum(discounts.discount_amount) AS total_discount_amount'), 'discounts.job_id')
		->groupBy('discounts.job_id')
		->get();

		$total_installments = DB::table('installments')
		->select(DB::raw('sum(installments.installment_amount) AS total_installment_amount'), 'installments.job_id')
		->groupBy('installments.job_id')
		->get();

		$pdf = PDF::loadView('administrator.report.job_pdf', compact('jobs', 'users', 'total_payables', 'total_discounts', 'total_installments'));
		return $pdf->download('job_report.pdf');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function search_task_reports() {
		return view('administrator.report.search_task_reports');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function show_task_reports(Request $request) {
		$data = request()->validate([
			'form_date' => 'required|date',
			'to_date' => 'required|date',
		], [
			'form_date.required' => 'The form date is required.',
			'to_date.required' => 'The to date is required.',
		]);

		$form_date = $request->form_date;
		$to_date = $request->to_date;

		$jobs = Job::where('deletion_status', 0)
		->where('receiving_date', '>=', $data['form_date'])
		->where('receiving_date', '<=', $data['to_date'])
		->where('deletion_status', 0)
		->select('id', 'name_of_account', 'client', 'reference_by', 'assign_to', 'description', 'job_status')
		->orderBy('id', 'ASC')
		->get();

		$users = User::where('deletion_status', 0)
		->select('id', 'name')
		->get();

		return view('administrator.report.show_task_reports', compact('jobs', 'users', 'form_date', 'to_date'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function task_pdf($form_date, $to_date) {
		$jobs = Job::where('deletion_status', 0)
		->where('receiving_date', '>=', $form_date)
		->where('receiving_date', '<=', $to_date)
		->where('deletion_status', 0)
		->select('id', 'name_of_account', 'client', 'reference_by', 'assign_to', 'description', 'job_status')
		->orderBy('id', 'ASC')
		->get();

		$users = User::where('deletion_status', 0)
		->select('id', 'name')
		->get();

		$pdf = PDF::loadView('administrator.report.task_pdf', compact('jobs', 'users'));
		return $pdf->download('task_report.pdf');
	}

}
