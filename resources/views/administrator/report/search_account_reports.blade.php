@extends('administrator.master')
@section('title', 'Account Reports')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ALL CLIENT REPORTS
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a>Report</a></li>
            <li class="active">All Client Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Search Reports</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool"data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">

                <form action="{{ url('/reports/show-account-reports') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">

                            <label for="enquiry_year">Enquiry Year <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('enquiry_year') ? ' has-error' : '' }} has-feedback">
                                <select name="enquiry_year" id="enquiry_year" class="form-control">
                                    <option value="" selected disabled>Select year</option>
                                    <option value="2015">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                </select>
                                @if ($errors->has('enquiry_year'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('enquiry_year') }}</strong>
                                </span>
                                @endif
                            </div>

                           
                        </div>
                        <!-- /.form group -->

                    <div class="col-md-3">
                        <label for="client_status">Client Status</label>
                        <div class="form-group{{ $errors->has('client_status') ? ' has-error' : '' }} has-feedback">
                            <select name="client_status" id="client_status" class="form-control">
                                <option value="*" selected>All</option>
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                            @if ($errors->has('client_status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('client_status') }}</strong>
                            </span>
                            @endif
                        </div>

                    </div>
                    <!-- /.form group -->

                <div class="col-md-6">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="input-group date">
                            <button class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Search</button>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
            </div>
        </form>
        
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
</section>
<!-- /.content -->
</div>
@endsection