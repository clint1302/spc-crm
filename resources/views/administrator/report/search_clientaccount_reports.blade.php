@extends('administrator.master')
@section('title', 'Account Reports')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CLIENT REPORTS
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a>Report</a></li>
            <li class="active">Client Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Search Report</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool"data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">

             
    <!-- /.box-body -->

        <div class="manage-clients-container">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL#</th>
                        <th>Client Name</th>
                        <th>Contact No</th>
                        <th>Address</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <div style="display:none;">{{ $sl = 1 }}</div>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $client['name'] }}</td>
                        <td>{{ $client['contact_no_one'] }}</td>
                        <td>{{ $client['present_address'] }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-xs btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/reports/show-clientaccount-reports/'. $client['id']) }}"><i class="icon fa fa-file-text"></i> Report</a></li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
<!-- /.box -->
</section>
<!-- /.content -->
</div>
@endsection