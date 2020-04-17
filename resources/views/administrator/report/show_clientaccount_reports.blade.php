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
            <li><a href="{{ url('/reports/clientaccount-reports') }}">Report</a></li>
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
            <tbody>
                <tr>
                    <td width="25%" style="font-weight:600;">Client Name</td>
                    <td width="75%">{{ $client->name }}</td>
                </tr>
                <tr>
                    <td width="25%" style="font-weight:600;">Sex</td>
                    <td width="75%">{{ $client->spc_client_sex }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600;">Email</td>
                    <td>{{ $client->email }}</td>
                </tr>
                @if ($client->email_no_two != "")
                
                @endif
                <tr>
                    <td style="font-weight:600;">Email 2</td>
                    <td>{{ $client->email_no_two }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600;">Contact No</td>
                    <td>{{ $client->contact_no_one }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600;">Address</td>
                    <td>{{ $client->present_address }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600;">Pest</td>
                    <td>{{ $client->spc_pest }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600;">Update</td>
                    <td>{{ $client->spc_update }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600;">Contact persoon</td>
                    <td>{{ $client->spc_contactpersoon }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600;">Service Address</td>
                    <td>{{ $client->spc_serviceadres }}</td>
                </tr>
                <tr>
                    <td style="font-weight:600;">Client Type</td>
                    <td>{{ $client->client_type }} - {{ $client->client_type_description }}</td>
                </tr>

                @if ($client->activation_status == 1)
                <tr>
                    <td style="font-weight:600;">Contract type</td>
                    @if ($client->contract_id != "")
                        <td times="{{ $client_contract->time }}">{{ $client_contract->name }} </td>
                    @endif
                </tr>
                <tr>
                    <td style="font-weight:600;">Contract type 2</td>
                    @if ($client->contract_id_second != "")
                        <td times="{{ $client_contract->time }}">{{ $client_contract_second->name }} </td>
                    @endif
                </tr>
                @endif
            
                <tr>
                    <td style="font-weight:600;">Enquiry date</td>
                    <td>
                    @if ($client->spc_date != "")
                    {{ \Carbon\Carbon::parse($client->spc_date)->format('d-M-y') }}
                    @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:600;">Enquiry Source</td>
                    <td>
                    {{ $client->etype }}
                    </td>
                </tr>

                @if ($client->activation_status == 1)
                <tr>
                    <td style="font-weight:600;">Sold date</td>
                    <td>
                    @if ($client->spc_sold_date != "")
                    {{ \Carbon\Carbon::parse($client->spc_sold_date)->format('d-M-y') }}
                    @endif
                    </td>
                </tr>
                @endif

                <tr>
                    <td style="font-weight:600;">Added</td>
                    <td>
                    @if ($client->created_at != "")
                    {{  \Carbon\Carbon::parse($client->created_at)->format('d-M-y') }}
                    @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:600;">Created By</td>
                    <td>{{ $created_by->name }}</td>
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
    //document.forms['account_report_form'].elements['client_id'].value = "";
    //document.forms['account_report_form'].elements['client_id'].value = "";
</script>
@endsection