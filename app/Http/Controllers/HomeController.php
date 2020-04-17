<?php

namespace App\Http\Controllers;

use App\Job;
use App\User;
use Carbon;
use DB;

class HomeController extends Controller {

/**
 * Create a new controller instance.
 *
 * @return void
 */
	public function __construct() {
		$this->middleware('auth');
	}

/**
 * Show the application dashboard.
 *
 * @return \Illuminate\Http\Response
 */
	public function index() {
		$today = Carbon\Carbon::now();
		$date_today = $today->toDateString();

		$next_payment_dates = DB::table('next_payment_dates')
			->join('jobs', 'next_payment_dates.job_id', '=', 'jobs.id')
			->join('users', 'jobs.client', '=', 'users.id')
			->select('jobs.id', 'jobs.name_of_account', 'users.name', 'users.contact_no_one', 'next_payment_dates.next_payment_date')
			->where('jobs.deletion_status', 0)
			->where('next_payment_dates.next_payment_date', '>=', $date_today)
			->orderBy('next_payment_dates.next_payment_date', 'ASC')
			->get();

		$notes = DB::table('notes')
			->join('jobs', 'notes.job_id', '=', 'jobs.id')
			->join('users', 'jobs.client', '=', 'users.id')
			->join('users AS user_created', 'notes.created_by', '=', 'user_created.id')
			->select('jobs.id', 'jobs.name_of_account', 'users.name', 'users.contact_no_one','user_created.name AS createdby', 'notes.id AS note_id','notes.remind_date','notes.remind_time','notes.note')
			->where('jobs.deletion_status', 0)
			//->where('notes.created_by', auth()->user()->id)
			->where('notes.deletion_status', 0)
			->where('notes.remind_date', '>=', $date_today)
			->orderBy('notes.created_at', 'ASC')
			->get();

		$clients_active = User::where('access_label', 5)
			->where('deletion_status', 0)
			->where('activation_status', 1)
			->get();

		$clients_deactive = User::where('access_label', 5)
			->where('deletion_status', 0)
			->where('activation_status', 0)
			->get();

		$clients = User::where('access_label', 5)
			->where('deletion_status', 0)
			->get();

		$references = User::where('access_label', 4)
			->where('deletion_status', 0)
			->get();

		$employees = User::where('access_label', '>=', 2)
			->where('access_label', '<=', 3)
			->where('deletion_status', 0)
			->get();

		$jobs = Job::where('deletion_status', 0)
			->get();

		$jobs_active= Job::where('job_status', 1)
			->where('deletion_status', 0)
			->get();

		$jobs_deactive= Job::where('job_status', 0)
			->where('deletion_status', 0)
			->get();

		return view('administrator.dashboard.dashboard', compact('next_payment_dates','jobs_active','jobs_deactive', 'notes','clients', 'clients_active','clients_deactive', 'references', 'employees', 'jobs'));
	}

}
