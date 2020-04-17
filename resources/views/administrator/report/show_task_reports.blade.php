@extends('administrator.master')
@section('title', 'Task Reports')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            TASK REPORTS
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a>Report</a></li>
            <li class="active">Task Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Task Reports</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool"data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form name="task_report_form" action="{{ url('/reports/show-task-reports') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group{{ $errors->has('form_date') ? ' has-error' : '' }}">
                                <label for="datepicker3">Form:</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="form_date" class="form-control pull-right" value="{{ old('form_date') }}" id="datepicker3" placeholder="yyyy-mm-dd" required>
                            </div>
                            <!-- /.input group -->
                            @if ($errors->has('form_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('form_date') }}</strong>
                            </span>
                            @endif
                        </div>
                        <!-- /.form group -->
                    </div>

                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has('to_date') ? ' has-error' : '' }}">
                            <label for="datepicker4">To:</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="to_date" class="form-control pull-right" value="{{ old('to_date') }}" id="datepicker4" placeholder="yyyy-mm-dd" required>
                        </div>
                        <!-- /.input group -->
                        @if ($errors->has('to_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('to_date') }}</strong>
                        </span>
                        @endif
                    </div>
                    <!-- /.form group -->
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="input-group date">
                            <button class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Search
                            </button>
                            &nbsp;
                            <button class="btn btn-primary btn-flat" type="button" onclick="printDiv('printable_area')" ><i class="fa fa-print"></i> Print
                            </button>
                            &nbsp;
                            <a href="{{ url('/reports/task-reports-pdf/' . $form_date .'/' .$to_date) }}" class="btn btn-default btn-flat" type="button" ><i class="fa fa-file-pdf-o"></i> PDF
                            </a>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
            </div>
        </form>

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
        <div id="printable_area">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL#</th>
                        <th>Reg.No</th>
                        <th>Name of Account</th>
                        <th>Client</th>
                        <th>Reference</th>
                        <th>Assign TO</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php ($sl = 1)
                    @foreach($jobs as $job)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $job->id }}</td>
                        <td>{{ $job->name_of_account }}</td>
                        <td>
                            @foreach($users as $user)
                            @if($job->client == $user->id)
                            {{ $user->name }}
                            @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($users as $user)
                            @if($job->reference_by == $user->id)
                            {{ $user->name }}
                            @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($users as $user)
                            @if($job->assign_to == $user->id)
                            {{ $user->name }}
                            @endif
                            @endforeach
                        </td>
                        <td>{!! $job->description !!}</td>
                        <td>
                            @if($job->job_status == 1)
                            Completed
                            @else
                            On Going
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
</section>
<!-- /.content -->
</div>
<script type="text/javascript">
    document.forms['task_report_form'].elements['form_date'].value = "{{ $form_date }}";
    document.forms['task_report_form'].elements['to_date'].value = "{{ $to_date }}";
</script>
@endsection