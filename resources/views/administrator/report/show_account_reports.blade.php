@extends('administrator.master')
@section('title', 'Account Reports')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CLIENT REPORT
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a>Report</a></li>
            <li class="active">Client Report</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Search Client Report</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool"data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            
            <div class="box-body">
                <form name="account_report_form" action="{{ url('/reports/show-clientaccount-reports') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label for="client_status">Client Status</label>
                            <div class="form-group{{ $errors->has('client_status') ? ' has-error' : '' }} has-feedback">
                                <select name="client_status" id="client_status" class="form-control">
                                    <option value="*" selected>All</option>
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                            <!-- /.input group -->
                            @if ($errors->has('client_status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('client_status') }}</strong>
                            </span>
                            @endif
                        </div>
                        <!-- /.form group -->

                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="input-group date">
                            <button class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Search</button>
                            &nbsp;
                            <button class="btn btn-default btn-flat" type="button" onclick="printDiv('printable_area')" ><i class="fa fa-print"></i> Print
                            </button>
                            &nbsp;
                            <a href="{{ url('/reports/account-reports-pdf/' . $enquiry_year.'/' .$client_status) }}" class="btn btn-default btn-flat" type="button" ><i class="fa fa-file-pdf-o"></i> PDF
                            </a>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
            
                </div>
            <!-- /.row -->
        
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
        <table class="table table-bordered table-striped" id="">
                <thead>
                    <tr>
                        <th>SL#</th>
                        <th>Client Name</th>
                        <!--<th>Client Type</th>-->
                        <th>Contract Type</th>
                        <th>Contact No</th>
                        <th>Address</th>
                        <th class="text-center">Enquiry Source</th>
                        <th class="text-center">Enquiry Date</th>
                        <th class="text-center">Enquiry Year</th>
                        <th class="text-center">Sold Date</th>
                        <th class="text-center">Status</th>
                        <!--<th>Actions</th>-->
                    </tr>
                </thead>
                <tbody>
                    <div style="display:none;">{{ $sl = 1 }}</div>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $client['name'] }}</td>
                        <!--<td><a data-toggle="tooltip" data-placement="right" title="{{ $client['client_type_description'] }}">{{ $client['client_type'] }}</a></td>-->
                        <td>{{ $client['contract'] }}</td>
                        <td>{{ $client['contact_no_one'] }}</td>
                        <td>{{ $client['present_address'] }}</td>
                        <td>{{ $client['etype'] }}</td>
                        <td class="text-center">
                        @if ($client['spc_date'] != "")
                        {{ $client['spc_date'] }}
                        @endif
                        </td>
                        <td class="text-center">
                        @if ($client['spc_eyear'] != "")
                        {{ $client['spc_eyear'] }}
                        @endif
                        </td>
                        <td class="text-center">
                        @if ($client['spc_sold_date'] != "")
                            {{  \Carbon\Carbon::parse($client['spc_sold_date'])->format('d-M-y') }}
                        @else
                            not yet
                        @endif
                        </td>
                        <td class="text-center">
                            @if ($client['activation_status'] == 1)
                                <a class="btn btn-success btn-xs btn-flat btn-block">Active</i></a>
                            @else
                                <a class="btn btn-warning btn-xs btn-flat btn-block">Deactive</a>
                            @endif
                        </td>

                        <!--<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-xs btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/people/clients/details/' . $client['id']) }}"><i class="icon fa fa-file-text"></i> Details</a></li>
                                    
                                </ul>
                            </div>
                        </td>-->
                        
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>

</div>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</section>
<!-- /.content -->
</div>
<script type="text/javascript">
    document.forms['account_report_form'].elements['enquiry_year'].value = "{{ $enquiry_year }}";
    document.forms['account_report_form'].elements['client_status'].value = "{{ $client_status }}";
</script>
@endsection