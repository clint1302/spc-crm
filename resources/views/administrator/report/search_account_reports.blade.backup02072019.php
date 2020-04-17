@extends('administrator.master')
@section('title', 'Account Reports')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ACCOUNT/CLIENT REPORTS
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a>Report</a></li>
            <li class="active">Account/Client Reports</li>
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
                            <div class="form-group{{ $errors->has('form_date') ? ' has-error' : '' }}">
                                <label for="datepicker">Form:</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="form_date" class="form-control pull-right" value="{{ old('form_date') }}" id="datepicker" placeholder="yyyy-mm-dd" required>
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
                            <label for="datepicker2">To:</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="to_date" class="form-control pull-right" value="{{ old('to_date') }}" id="datepicker2" placeholder="yyyy-mm-dd" required>
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