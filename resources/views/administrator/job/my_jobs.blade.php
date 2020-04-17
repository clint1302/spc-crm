@extends('administrator.master')
@section('title', 'My Jobs')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            MY JOBS
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a>People</a></li>
            <li class="active">Jobs</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Manage jobs</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <div class="box-body">
                <a href="{{ url('/jobs/create') }}" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Add job</a>
                <hr>
                <!-- Notification Box -->
                <div class="col-md-12">
                    @if (!empty(Session::get('message')))
                    <div class="alert alert-success alert-dismissible" id="notification_box">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i> {{ Session::get('message') }}
                    </div>
                    @elseif (!empty(Session::get('exception')))
                    <div class="alert alert-warning alert-dismissible" id="notification_box">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-warning"></i> {{ Session::get('exception') }}
                    </div>
                    @endif
                </div>
                <!-- /.Notification Box -->
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <tr>
                            ‎<th>SL#</th>
                            <!--<th>Reg.No</th>-->
                            <th>Job Name</th>
                            <th>Client</th>
                            <th dbname="Assign TO">Team Leader</th>
                            <th dbname="Assign to second">Team Member</th>
                            <th>Job Date</th>
                            <th>Job Time</th>
                            <th>Car Plate</th>
                            <!--<th class="text-center">Added</th>-->
                            <th class="text-center">Job Status</th>
                            <!-- <th width="" class="text-center">Publication Status</th> 
                            <th class="text-center">Payment Details</th>-->
                            <th class="text-center">Actions</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @php ($sl = 1)
                        @foreach($jobs as $job)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <!--<td>{{ $job->id }}</td>-->
                            <td>{{ $job->name_of_account }}</td>
                            <td>{{ $job->name }}</td>
                            <td>
                            @foreach($users as $user)
                            @if($user->id == $job->assign_to)
                            {{ $user->name }}
                            @endif
                            @endforeach
                            </td>
                            <td>
                            @if($job->assign_to_second != "")
                                @foreach($users as $user)
                                    @if($user->id == $job->assign_to_second)
                                    {{ $user->name }}
                                    @endif
                                @endforeach
                            @else
                                    None
                            @endif
                            </td>
                            <td>{{ date("d F Y", strtotime($job->receiving_date)) }}</td>
                            <td>{{ $job->job_time }}</td>
                            <td>{{ $job->auto_kenteken }}</td>
                            <!--<td>{{ date("d F Y", strtotime($job->created_at)) }}</td>-->
                            <td class="text-center">
                                @if ($job->job_status == 1)
                                <a href="{{ url('/jobs/incomplete/' . $job->id) }}" class="btn btn-success btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to re-open"><i class="icon fa fa-arrow-down"> Complete</i></a>
                                @else
                                <a href="{{ url('/jobs/complete/' . $job->id) }}" class="btn btn-warning btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Click to complete"><i class="icon fa fa-arrow-up"></i> Incomplete</a>
                                @endif
                            </td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-xs btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ url('/jobs/details/' . $job->id) }}"><i class="icon fa fa-file-text"></i> Details</a></li>
                                        <li><a href="{{ url('/jobs/edit/' . $job->id) }}"><i class="icon fa fa-edit"></i> Edit</a></li>
                                        <li><a href="{{ url('/jobs/delete/' . $job->id) }}" onclick="return confirm('Are you sure to delete this ?');"><i class="icon fa fa-trash"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
@endsection