<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\JobType;
use DB;

class JobTypeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $job_types = JobType::all()
                ->sortByDesc('job_type')
                ->where('deletion_status', 0)
                ->toArray();
        return view('administrator.setting.job_type.manage_job_types', compact('job_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('administrator.setting.job_type.add_job_type');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $job_type = $this->validate(request(), [
            'job_type' => 'required|unique:job_types|max:100',
            'publication_status' => 'required',
            'job_type_description' => 'required',
        ]);

        $result = JobType::create($job_type + ['created_by' => auth()->user()->id]);
        $inserted_id = $result->id;

        if (!empty($inserted_id)) {
            return redirect('/setting/job-types/create')->with('message', 'Add successfully.');
        }
        return redirect('/setting/job-types/create')->with('exception', 'Operation failed !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function published($id) {
        $affected_row = JobType::where('id', $id)
                ->update(['publication_status' => 1]);

        if (!empty($affected_row)) {
            return redirect('/setting/job-types')->with('message', 'Published successfully.');
        }
        return redirect('/setting/job-types')->with('exception', 'Operation failed !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unpublished($id) {
        $affected_row = JobType::where('id', $id)
                ->update(['publication_status' => 0]);

        if (!empty($affected_row)) {
            return redirect('/setting/job-types')->with('message', 'Unpublished successfully.');
        }
        return redirect('/setting/job-types')->with('exception', 'Operation failed !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $job_type = DB::table('job_types')
                ->join('users', 'job_types.created_by', '=', 'users.id')
                ->select('job_types.*', 'users.name')
                ->where('job_types.id', $id)
                ->first();
        return view('administrator.setting.job_type.show_job_type', compact('job_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $job_type = JobType::find($id)->toArray();
        return view('administrator.setting.job_type.edit_job_type', compact('job_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $job_type = JobType::find($id);
        $this->validate(request(), [
            'job_type' => 'required|max:100',
            'publication_status' => 'required',
            'job_type_description' => 'required',
        ]);

        $job_type->job_type = $request->get('job_type');
        $job_type->job_type_description = $request->get('job_type_description');
        $job_type->publication_status = $request->get('publication_status');
        $affected_row = $job_type->save();

        if (!empty($affected_row)) {
            return redirect('/setting/job-types')->with('message', 'Update successfully.');
        }
        return redirect('/setting/job-types')->with('exception', 'Operation failed !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $affected_row = JobType::where('id', $id)
                ->update(['deletion_status' => 1]);

        if (!empty($affected_row)) {
            return redirect('/setting/job-types')->with('message', 'Delete successfully.');
        }
        return redirect('/setting/job-types')->with('exception', 'Operation failed !');
    }

}
