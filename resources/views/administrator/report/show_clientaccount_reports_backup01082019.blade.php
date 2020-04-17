@extends('administrator.master')
@section('title', 'Client Report')

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
                        <th class="text-center">Enquiry Date</th>
                        <th class="text-center">Enquiry Year</th>
                        <th class="text-center">Sold Date</th>
                        <th class="text-center">Status</th>
                        <!--<th>Actions</th>-->
                    </tr>
                </thead>
                <tbody>
                    <div style="display:none;">{{ $sl = 1 }}</div>
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $clientInfo['name'] }}</td>
                        <td>{{ $clientInfo['contract'] }}</td>
                        <td>{{ $clientInfo['contact_no_one'] }}</td>
                        <td>{{ $clientInfo['present_address'] }}</td>
                        <td class="text-center">
                        @if ($clientInfo['spc_date'] != "")
                        {{ $clientInfo['spc_date'] }}
                        @endif
                        </td>
                        <td class="text-center">
                        @if ($clientInfo['spc_eyear'] != "")
                        {{ $clientInfo['spc_eyear'] }}
                        @endif
                        </td>
                        <td class="text-center">
                        @if ($clientInfo['spc_sold_date'] != "")
                            {{  \Carbon\Carbon::parse($clientInfo['spc_sold_date'])->format('d-M-y') }}
                        @else
                            not yet
                        @endif
                        </td>
                        <td class="text-center">
                            @if ($clientInfo['activation_status'] == 1)
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
                                    <li><a href="{{ url('/people/clients/details/' . $clientInfo['id']) }}"><i class="icon fa fa-file-text"></i> Details</a></li>
                                    
                                </ul>
                            </div>
                        </td>-->
                        
                    </tr>
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
    //document.forms['account_report_form'].elements['client_id'].value = "{{ $clientInfo['id'] }}";
</script>
@endsection