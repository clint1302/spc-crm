<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Installment;
use App\Job;
use App\JobType;
use App\NextPaymentDate;
use App\Note;
use App\Payable;
use App\User;
use DB;
use Illuminate\Http\Request;

class JobController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$jobs = DB::table('jobs')
			->join('job_types', 'jobs.job_type', '=', 'job_types.id')
			->join('users', 'jobs.client', '=', 'users.id')
			->select('jobs.id', 'jobs.name_of_account', 'jobs.receiving_date','jobs.auto_kenteken','jobs.job_time', 'jobs.created_at', 'jobs.publication_status', 'assign_to','assign_to_second', 'jobs.job_status', 'users.name', 'users.id as user_id')
			->where('jobs.deletion_status', 0)
			->orderBy('jobs.id', 'DESC')
			->get();
		$users = User::where('access_label', '>=', 2)
			->where('access_label', '<=', 3)
			->select('id', 'name')
			->get();
		return view('administrator.job.manage_jobs', compact('jobs', 'users'));
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function my_jobs() {
		$jobs = DB::table('jobs')
			->join('job_types', 'jobs.job_type', '=', 'job_types.id')
			->join('users', 'jobs.client', '=', 'users.id')
			->select('jobs.id', 'jobs.name_of_account', 'jobs.receiving_date', 'jobs.created_at', 'jobs.publication_status','jobs.job_time','jobs.auto_kenteken', 'assign_to','assign_to_second', 'jobs.job_status', 'users.name', 'users.id as user_id')
			->where('assign_to', auth()->user()->id)
			->orwhere('assign_to_second', auth()->user()->id)
			->where('jobs.deletion_status', 0)
			->orderBy('jobs.id', 'DESC')
			->get();
		$users = User::where('access_label', '>=', 2)
			->where('access_label', '<=', 3)
			->select('id', 'name')
			->get();
		return view('administrator.job.my_jobs', compact('jobs', 'users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$job_types = JobType::all()
			->sortByDesc('job_type')
			->where('deletion_status', 0)
			->where('publication_status', 1)
			->toArray();
		$clients = User::all()
			->sortByDesc('name')
			->where('access_label', 5)
			->where('deletion_status', 0)
			->where('activation_status', 1)
			->toArray();
		$references = User::all()
			->sortByDesc('name')
			->where('access_label', 4)
			->where('deletion_status', 0)
			->toArray();
		$associates = User::all()
			->sortByDesc('name')
			->where('access_label', '>=', 2)
			->where('access_label', '<=', 3)
			->where('deletion_status', 0)
			->toArray();
		return view('administrator.job.add_job', compact('job_types', 'clients', 'references', 'associates'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$job = request()->validate([
			'name_of_account' => 'required|max:250',
			'job_type' => 'required|numeric',
			'client' => 'required|numeric',
			'job_time' => 'required',
			//'reference_by' => 'required|numeric',
			'auto_kenteken' => 'required|max:10',
			'assign_to' => 'required|numeric',
			'receiving_date' => 'required|date',
			'description' => 'required',
			'publication_status' => 'required|numeric',
		], [
			'client_type_id.required' => 'The client type field is required.',
			'job_type.required' => 'The job type field is required.',
			'client.required' => 'The client field is required.',
			'job_time.required' => 'The job time field is required.',
			//'reference_by.required' => 'The reference field is required.',
			'auto_kenteken.required' => 'The Car Plate field is required.',
			'assign_to.required' => 'The assign field is required.',
			'receiving_date.required' => 'The receving date field is required.',
			'publication_status.required' => 'The publication status field is required.',
		]);

		$result = Job::create($job + ['created_by' => auth()->user()->id]);
		$inserted_id = $result->id;

		if (!empty($inserted_id)) {
			return redirect('/jobs/create')->with('message', 'Add successfully.');
		}
		return redirect('/jobs/create')->with('exception', 'Operation failed !');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function published($id) {
		$affected_row = Job::where('id', $id)
			->update(['publication_status' => 1]);

		if (!empty($affected_row)) {
			return redirect('/jobs')->with('message', 'Published successfully.');
		}
		return redirect('/jobs')->with('exception', 'Operation failed !');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function unpublished($id) {
		$affected_row = Job::where('id', $id)
			->update(['publication_status' => 0]);

		if (!empty($affected_row)) {
			return redirect('/jobs')->with('message', 'Unpublished successfully.');
		}
		return redirect('/jobs')->with('exception', 'Operation failed !');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function complete($id) {
		$affected_row = Job::where('id', $id)
			->update(['job_status' => 1]);

		if (!empty($affected_row)) {
			return redirect('/jobs')->with('message', 'Complete successfully.');
		}
		return redirect('/jobs')->with('exception', 'Operation failed !');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function incomplete($id) {
		$affected_row = Job::where('id', $id)
			->update(['job_status' => 0]);

		if (!empty($affected_row)) {
			return redirect('/jobs')->with('message', 'Re-open successfully.');
		}
		return redirect('/jobs')->with('exception', 'Operation failed !');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		/*$job = DB::table('jobs')
			->join('job_types', 'jobs.job_type', '=', 'job_types.id')
			->join('users', 'jobs.client', '=', 'users.id')
			->join('designations', 'users.designation_id', '=', 'designations.id')
			->select('jobs.*', 'users.name', 'users.contact_no_one', 'users.email', 'users.present_address', 'designations.designation')
			->where('jobs.deletion_status', 0)
			->where('jobs.id', $id)
			->first();*/

		$job = Job::query()
			->join('job_types', 'jobs.job_type', '=', 'job_types.id')
			->join('users', 'jobs.client', '=', 'users.id')
			->where('jobs.deletion_status', 0)
			->where('jobs.id', $id)
			->first(['jobs.*', 'users.name', 'users.contact_no_one', 'users.email', 'users.present_address']);

		$notes = DB::table('notes')
			->join('users', 'notes.created_by', '=', 'users.id')
			->select('notes.title','notes.id', 'notes.note', 'notes.created_at', 'users.name','notes.remind_date','notes.remind_time')
			->where('notes.deletion_status', 0)
			->where('notes.job_id', $id)
			->orderBy('notes.id', 'DESC')
			->get();
		$payables = DB::table('payables')
			->join('users', 'payables.created_by', '=', 'users.id')
			->select('payables.payable_amount', 'payables.tax', 'payables.tax_method', 'payables.short_note', 'payables.created_at', 'users.name')
			->where('payables.job_id', $id)
			->orderBy('payables.id', 'DESC')
			->get();
		$total_payables = DB::table('payables')
			->select(DB::raw('sum(payables.payable_amount) AS total_payable_amount', 'sum(payables.tax_amount) AS total_tax_amount'), DB::raw('sum(payables.tax_amount) AS total_tax_amount'))
			->where('payables.job_id', $id)
			->groupBy('payables.job_id')
			->first();
		$discounts = DB::table('discounts')
			->join('users', 'discounts.created_by', '=', 'users.id')
			->select('discounts.discount_amount', 'discounts.short_note', 'discounts.created_at', 'users.name')
			->where('discounts.job_id', $id)
			->orderBy('discounts.id', 'DESC')
			->get();
		$total_discounts = DB::table('discounts')
			->select(DB::raw('sum(discounts.discount_amount) AS total_discount_amount'))
			->where('discounts.job_id', $id)
			->groupBy('discounts.job_id')
			->first();
		$installments = DB::table('installments')
			->join('users', 'installments.created_by', '=', 'users.id')
			->select('installments.id', 'installments.installment_name', 'installments.installment_amount', 'installments.installment_method', 'installments.short_note', 'installments.created_at', 'users.name')
			->where('installments.job_id', $id)
			->orderBy('installments.id', 'DESC')
			->get();
		$total_installments = DB::table('installments')
			->select(DB::raw('sum(installments.installment_amount) AS total_installment_amount'))
			->where('installments.job_id', $id)
			->groupBy('installments.job_id')
			->first();
		$created_by = User::where('id', $job->created_by)
			->select('id', 'name')
			->first();
		$next_payment_date = NextPaymentDate::where('job_id', $job->id)
			->select('next_payment_date')
			->orderBy('id', 'desc')
			->first();
		$job_type = JobType::where('id', $job->job_type)
			->select('id', 'job_type')
			->first();
		$reference_by = User::where('id', $job->reference_by)
			->select('id', 'name')
			->first();
		$assign_to = User::where('id', $job->assign_to)
			->select('id', 'name')
			->first();
		$assign_to_second = User::where('id', $job->assign_to_second)
			->select('id', 'name')
			->first();
		return view('administrator.job.show_job', compact('job', 'created_by', 'job_type', 'reference_by', 'assign_to','assign_to_second', 'notes', 'payables', 'discounts', 'next_payment_date', 'total_payables', 'total_discounts', 'installments', 'total_installments'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$job = Job::find($id)->toArray();
		$job_types = JobType::all()
			->sortByDesc('job_type')
			->where('deletion_status', 0)
			->where('publication_status', 1)
			->toArray();
		$clients = User::all()
			->sortByDesc('name')
			->where('access_label', 5)
			->where('deletion_status', 0)
			->toArray();
		$references = User::all()
			->sortByDesc('name')
			->where('access_label', 4)
			->where('deletion_status', 0)
			->toArray();
		$associates = User::all()
			->sortByDesc('name')
			->where('access_label', 2)
			->where('deletion_status', 0)
			->toArray();
		$associates_second = User::all()
			->sortByDesc('name')
			->where('access_label', 2)
			->where('deletion_status', 0)
			->toArray();
		return view('administrator.job.edit_job', compact('job', 'job_types', 'clients', 'references', 'associates','associates_second'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$job = Job::find($id);
		request()->validate([
			'name_of_account' => 'required|max:250',
			'job_type' => 'required|numeric',
			'client' => 'required|numeric',
			'job_time' => 'required',
			//'reference_by' => 'required|numeric',
			'auto_kenteken' => 'required|max:10',
			'assign_to' => 'required|numeric',
			'receiving_date' => 'required|date',
			'description' => 'required',
			'publication_status' => 'required|numeric',
		], [
			'client_type_id.required' => 'The client type field is required.',
			'job_type.required' => 'The job type field is required.',
			'client.required' => 'The client field is required.',
			'job_time.required' => 'The job time field is required.',
			//'reference_by.required' => 'The reference field is required.',
			'assign_to.required' => 'The assign field is required.',
			'receiving_date.required' => 'The receving date field is required.',
			'publication_status.required' => 'The publication status field is required.',
		]);

		$job->name_of_account = $request->get('name_of_account');
		$job->job_type = $request->get('job_type');
		$job->client = $request->get('client');
		$job->job_time = $request->get('job_time');
		//$job->reference_by = $request->get('reference_by');
		$job->auto_kenteken = $request->get('auto_kenteken');
		$job->assign_to = $request->get('assign_to');
		$job->assign_to_second = $request->get('assign_to_second');
		$job->receiving_date = $request->get('receiving_date');
		$job->description = $request->get('description');
		$job->publication_status = $request->get('publication_status');
		$affected_row = $job->save();

		if (!empty($affected_row)) {
			return redirect('/jobs')->with('message', 'Update successfully.');
		}
		return redirect('/jobs')->with('exception', 'Operation failed !');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$affected_row = Job::where('id', $id)
			->update(['deletion_status' => 1]);

		if (!empty($affected_row)) {
			return redirect('/jobs')->with('message', 'Delete successfully.');
		}
		return redirect('/jobs')->with('exception', 'Operation failed !');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function store_note(Request $request, $job_id) {
		$note = request()->validate([
			'title' => 'required|max:250',
			'note' => 'nullable',
			'remind_date' => 'required',
			'remind_time' => 'required',
		], [
			'note.required' => 'The note field is required.',
		]);

		$result = Note::create($note + ['job_id' => $job_id, 'created_by' => auth()->user()->id]);
		$inserted_id = $result->id;

		if (!empty($inserted_id)) {
			return redirect('/jobs/details/' . $job_id)->with('message', 'Add successfully.');
		}
		return redirect('/jobs/details/' . $job_id)->with('exception', 'Operation failed !');
	}

	public function destroy_note($id) {

		$job_id = Note::where('id',$id)
			->select('job_id')
			->first();
		$affected_row = Note::where('id', $id)
			->update(['deletion_status' => 1]);

		if (!empty($affected_row)) {
			return redirect('/jobs/details/'.$job_id->job_id)->with('message', 'Note deleted successfully.');
		}
		return redirect('/jobs/details/'.$job_id->job_id)->with('exception', 'Operation failed !');
	}

	public function store_payable(Request $request, $job_id) {
		$payable = request()->validate([
			'payable_amount' => 'required|numeric',
			'tax' => '',
			'tax_method' => '',
			'short_note' => 'nullable|max:250',
		], [
			'payable_amount.numeric' => 'Only numeric is allowed.',
		]);

		$payable['tax_amount'] = $tax_amount = ($payable['payable_amount'] * $payable['tax']) / 100;

		if ($payable['tax_method'] == 1) {
			$payable['payable_amount'] = $payable_amount = $payable['payable_amount'] - $tax_amount;
		} else {
			$payable['payable_amount'] = $payable_amount = $payable['payable_amount'];
		}

		$result = Payable::create($payable + ['job_id' => $job_id, 'created_by' => auth()->user()->id]);
		$inserted_id = $result->id;

		if (!empty($inserted_id)) {
			return redirect('/jobs/details/' . $job_id)->with('message', 'Add successfully.');
		}
		return redirect('/jobs/details/' . $job_id)->with('exception', 'Operation failed !');
	}

	public function store_discount(Request $request, $job_id) {
		$discount = request()->validate([
			'discount_amount' => 'required|numeric',
			'short_note' => 'nullable|max:250',
		], [
			'discount_amount.numeric' => 'Only numeric is allowed.',
		]);

		$result = Discount::create($discount + ['job_id' => $job_id, 'created_by' => auth()->user()->id]);
		$inserted_id = $result->id;

		if (!empty($inserted_id)) {
			return redirect('/jobs/details/' . $job_id)->with('message', 'Add successfully.');
		}
		return redirect('/jobs/details/' . $job_id)->with('exception', 'Operation failed !');
	}

	public function store_installment(Request $request, $job_id) {
		$installment = request()->validate([
			'installment_name' => 'required|max:250',
			'installment_amount' => 'required|numeric',
			'installment_method' => 'required',
			'short_note' => 'nullable|max:250',
		], [
			'installment_amount.numeric' => 'Only numeric is allowed.',
		]);

		$result = Installment::create($installment + ['job_id' => $job_id, 'created_by' => auth()->user()->id]);
		$inserted_id = $result->id;

		if (!empty($inserted_id)) {
			return redirect('/jobs/details/' . $job_id)->with('message', 'Add successfully.');
		}
		return redirect('/jobs/details/' . $job_id)->with('exception', 'Operation failed !');
	}

	public function store_next_payment_date(Request $request, $job_id) {
		$next_payment_date = request()->validate([
			'next_payment_date' => 'required',
			'short_note' => 'nullable|max:250',
		], [
			'next_payment_date.required' => 'The next payment date is required.',
		]);

		$result = NextPaymentDate::create($next_payment_date + ['job_id' => $job_id, 'created_by' => auth()->user()->id]);
		$inserted_id = $result->id;

		if (!empty($inserted_id)) {
			return redirect('/jobs/details/' . $job_id)->with('message', 'Add successfully.');
		}
		return redirect('/jobs/details/' . $job_id)->with('exception', 'Operation failed !');
	}

	public function invoice($id) {

		$installment = DB::table('installments')
			->join('jobs', 'installments.job_id', '=', 'jobs.id')
			->join('users', 'jobs.client', '=', 'users.id')
			->select('users.*', 'installments.job_id', 'installments.id', 'installments.installment_name', 'installments.installment_amount', 'installments.installment_method', 'installments.short_note', 'installments.created_at')
			->where('installments.id', $id)
			->first();

		$job_id = ($installment->job_id);

		$total_payables = DB::table('payables')
			->select(DB::raw('sum(payables.payable_amount) AS total_payable_amount', 'sum(payables.tax_amount) AS total_tax_amount'), DB::raw('sum(payables.tax_amount) AS total_tax_amount'))
			->where('payables.job_id', $job_id)
			->groupBy('payables.job_id')
			->first();

		$tax = DB::table('payables')
			->select('payables.tax')
			->where('payables.job_id', $job_id)
			->orderBy('payables.id', 'DESC')
			->first();

		$total_discounts = DB::table('discounts')
			->select(DB::raw('sum(discounts.discount_amount) AS total_discount_amount'))
			->where('discounts.job_id', $job_id)
			->groupBy('discounts.job_id')
			->first();

		$total_installments = DB::table('installments')
			->select(DB::raw('sum(installments.installment_amount) AS total_installment_amount'))
			->where('installments.job_id', $job_id)
			->groupBy('installments.job_id')
			->first();

		$next_payment_date = NextPaymentDate::where('job_id', $job_id)
			->select('next_payment_date')
			->orderBy('id', 'desc')
			->first();

		return view('administrator.job.invoice', compact('installment', 'total_payables', 'total_discounts', 'total_installments', 'next_payment_date', 'tax'));
	}

	public function print_invoice(Request $request, $id) {

		request()->validate([
			'reference_no' => 'required',
			'amount_in_word' => 'required',
		], [
			'reference_no.required' => 'Reference is required.',
			'amount_in_word.required' => 'Amount in word is required.',
		]);

		$ref = $request->reference_no;
		$amount_in_word = $request->amount_in_word;
		$extra_note = $request->extra_note;
		$from_address = $request->from_address;

		$installment = DB::table('installments')
			->join('jobs', 'installments.job_id', '=', 'jobs.id')
			->join('users', 'jobs.client', '=', 'users.id')
			->select('users.*', 'installments.job_id', 'installments.id', 'installments.installment_name', 'installments.installment_amount', 'installments.installment_method', 'installments.short_note', 'installments.created_at')
			->where('installments.id', $id)
			->first();

		$job_id = ($installment->job_id);

		$total_payables = DB::table('payables')
			->select(DB::raw('sum(payables.payable_amount) AS total_payable_amount', 'sum(payables.tax_amount) AS total_tax_amount'), DB::raw('sum(payables.tax_amount) AS total_tax_amount'))
			->where('payables.job_id', $job_id)
			->groupBy('payables.job_id')
			->first();

		$tax = DB::table('payables')
			->select('payables.tax')
			->where('payables.job_id', $job_id)
			->orderBy('payables.id', 'DESC')
			->first();

		$total_discounts = DB::table('discounts')
			->select(DB::raw('sum(discounts.discount_amount) AS total_discount_amount'))
			->where('discounts.job_id', $job_id)
			->groupBy('discounts.job_id')
			->first();

		$total_installments = DB::table('installments')
			->select(DB::raw('sum(installments.installment_amount) AS total_installment_amount'))
			->where('installments.job_id', $job_id)
			->groupBy('installments.job_id')
			->first();

		$next_payment_date = NextPaymentDate::where('job_id', $job_id)
			->select('next_payment_date')
			->orderBy('id', 'desc')
			->first();

		return view('administrator.job.invoice_print', compact('installment', 'total_payables', 'total_discounts', 'total_installments', 'next_payment_date', 'tax', 'ref', 'amount_in_word', 'extra_note', 'from_address'));
	}

}
