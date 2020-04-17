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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function show_account_reports(Request $request) {
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
		->select('id', 'name_of_account', 'receiving_date', 'client', 'reference_by')
		->orderBy('id', 'ASC')
		->get();

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

		return view('administrator.report.show_account_reports', compact('jobs', 'users', 'total_payables', 'total_discounts', 'total_installments', 'form_date', 'to_date'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function account_pdf($form_date, $to_date) {
		$jobs = Job::where('deletion_status', 0)
		->where('receiving_date', '>=', $form_date)
		->where('receiving_date', '<=', $to_date)
		->where('deletion_status', 0)
		->select('id', 'name_of_account', 'receiving_date', 'client', 'reference_by')
		->orderBy('id', 'ASC')
		->get();

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

		$pdf = PDF::loadView('administrator.report.account_pdf', compact('jobs', 'users', 'total_payables', 'total_discounts', 'total_installments'));
		return $pdf->download('account_report.pdf');
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
