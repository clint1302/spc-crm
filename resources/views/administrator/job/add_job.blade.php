@extends('administrator.master')
@section('title', 'Add job')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            JOBS
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a>Jobs</a></li>
            <li class="active">Add job</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Add job</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <form action="{{ url('jobs/store') }}" method="post" name="job_add_form">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="row">
                        <!-- Notification Box -->
                        <div class="col-md-12" style="color: ">
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
                            @else
                            <p class="text-yellow">Enter job type details. All field are required. </p>
                            @endif
                        </div>
                        <!-- /.Notification Box -->

                        <div class="col-md-6">

                            <label for="name_of_account">Job Name<span class="text-red">*</span></label>
                            <div class="form-group{{ $errors->has('name_of_account') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="name_of_account" id="name_of_account" class="form-control" value="{{ old('name_of_account') }}" placeholder="Name of account..">
                                @if ($errors->has('name_of_account'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name_of_account') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="datepicker">Job Date <span class="text-red">*</span></label>
                            <div class="form-group{{ $errors->has('receiving_date') ? ' has-error' : '' }} has-feedback">
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="receiving_date" class="form-control pull-right" value="{{ old('receiving_date')}}" id="datepicker" placeholder="yyy-mm-dd">
                                </div>
                                @if ($errors->has('receiving_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('receiving_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="job_time">Job Time<span class="text-red">*</span></label>
                            <div class="form-group{{ $errors->has('job_time') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="job_time" id="job_time" class="form-control" value="{{ old('job_time') }}" placeholder="00:00 AM">
                                @if ($errors->has('job_time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('job_time') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="assign_to">Team Leader <span class="text-red">*</span></label>
                            <div class="form-group{{ $errors->has('assign_to') ? ' has-error' : '' }} has-feedback">
                                <select name="assign_to" id="assign_to" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    @foreach($associates as $associate)
                                    <option value="{{ $associate['id'] }}">{{ $associate['name'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('assign_to'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('assign_to') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="assign_to_second">Team Member </label>
                            <div class="form-group{{ $errors->has('assign_to_second') ? ' has-error' : '' }} has-feedback">
                                <select name="assign_to_second" id="assign_to_second" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    <option value="">None</option>
                                    @foreach($associates as $associate)
                                    <option value="{{ $associate['id'] }}">{{ $associate['name'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('assign_to_second'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('assign_to_second') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->
                           
                        </div>

                        <div class="col-md-6">

                            <label for="client">Client Name <span class="text-red">*</span></label>
                            <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }} has-feedback">
                                <select name="client" id="client" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    @foreach($clients as $client)
                                    <option value="{{ $client['id'] }}">{{ $client['name'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('client'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('client') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="job_type">Job Type <span class="text-red">*</span></label>
                            <div class="form-group{{ $errors->has('job_type') ? ' has-error' : '' }} has-feedback">
                                <select name="job_type" id="job_type" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    @foreach($job_types as $job_type)
                                    <option value="{{ $job_type['id'] }}">{{ $job_type['job_type'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('job_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('job_type') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="auto_kenteken">Car Plate <span class="text-red">*</span></label>
                            <div class="form-group{{ $errors->has('auto_kenteken') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="auto_kenteken" id="name_of_account" class="form-control" value="{{ old('auto_kenteken') }}" placeholder="Car Plate..">
                                @if ($errors->has('auto_kenteken'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('auto_kenteken') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <!--<label for="reference_by">Reference Name <span class="text-red">*</span></label>
                            <div class="form-group{{ $errors->has('reference_by') ? ' has-error' : '' }} has-feedback">
                                <select name="reference_by" id="reference_by" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    @foreach($references as $reference)
                                    <option value="{{ $reference['id'] }}">{{ $reference['name'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('reference_by'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('reference_by') }}</strong>
                                </span>
                                @endif
                            </div>
                             /.form-group -->

                            <label for="publication_status">Publication Status <span class="text-red">*</span></label>
                            <div class="form-group{{ $errors->has('publication_status') ? ' has-error' : '' }} has-feedback">
                                <select name="publication_status" id="publication_status" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    <option value="1">Published</option>
                                    <option value="0">Unpublished</option>
                                </select>
                                @if ($errors->has('publication_status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('publication_status') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                        </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            <label for="description">Description <span class="text-red">*</span></label>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} has-feedback">
                                <textarea class="textarea" name="description" id="description" placeholder="Enter description.." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ url('/jobs') }}" class="btn btn-danger btn-flat"><i class="icon fa fa-close"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="icon fa fa-plus"></i> Add job</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">
    document.forms['job_add_form'].elements['job_type'].value = "{{ old('job_type') }}";
    document.forms['job_add_form'].elements['client'].value = "{{ old('client') }}";
    //document.forms['job_add_form'].elements['reference_by'].value = "{{ old('reference_by') }}";
    document.forms['job_add_form'].elements['assign_to'].value = "{{ old('assign_to') }}";
    document.forms['job_add_form'].elements['publication_status'].value = "{{ old('publication_status') }}";
</script>
@endsection
