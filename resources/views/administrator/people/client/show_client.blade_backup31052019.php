@extends('administrator.master')
@section('title', 'Client Types')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CLIENTS
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a>People</a></li>
            <li><a href="{{ url('/people/clients') }}">Clients</a></li>
            <li class="active">Details</li>
        </ol>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Details of client</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <a href="{{ url('/people/clients') }}" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Back</a>
            @if ($client->activation_status == 1)
                <a href="{{ url('/jobs/create') }}" class="btn btn-warning btn-flat" style="float:right;"><i class="fa fa-plus"></i> Add job</a>
            @endif
            <hr>

            <div id="printable_area">
                <table id="example1" class="table table-bordered table-striped">
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
                        <!--<tr>
                            <td style="font-weight:600;">Address</td>
                            <td>{{ $client->present_address }}</td>
                        </tr>-->
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
                            <td style="font-weight:600;">Sold date</td>
                            <td>
                            @if ($client->spc_sold_date != "")
                            {{ \Carbon\Carbon::parse($client->spc_sold_date)->format('d-M-y') }}
                            @endif
                            </td>
                        </tr>
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
                        <!--<tr>
                            <td>Web</td>
                            <td>{{ $client->web }}</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>
                                @if($client->gender == 'm')
                                <p>Male</p>
                                @else
                                <p>Female</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td>
                                @if($client->date_of_birth != NULL)
                                {{ date("d F Y", strtotime($client->date_of_birth)) }}
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td>Date Added</td>
                            <td>{{ date("D d F Y - h:ia", strtotime($client->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td>Last Updated</td>
                            <td>{{ date("D d F Y - h:ia", strtotime($client->updated_at)) }}</td>
                        </tr>-->
                    </tbody>
                </table>
            </div>
            <div class="btn-group btn-group-justified">
                @if ($client->activation_status == 1)
                <div class="btn-group">
                    <a href="{{ url('/people/clients/deactive/' . $client->id)}}" class="tip btn btn-success btn-flat" data-toggle="tooltip" data-original-title="Click to deactive">
                        <i class="fa fa-arrow-down"></i>
                        <span class="hidden-sm hidden-xs"> Active</span>
                    </a>
                </div>
                @else
                <div class="btn-group">
                    <a href="{{ url('/people/clients/active/' . $client->id)}}" class="tip btn btn-warning btn-flat" data-toggle="tooltip" data-original-title="Click to active">
                        <i class="fa fa-arrow-up"></i>
                        <span class="hidden-sm hidden-xs"> Deactive</span>
                    </a>
                </div>
                @endif
                <div class="btn-group">
                    <button type="button" class="tip btn btn-primary btn-flat" title="Print" data-original-title="Label Printer" onclick="printDiv('printable_area')">
                        <i class="fa fa-print"></i>
                        <span class="hidden-sm hidden-xs"> Print</span>
                    </button>
                </div>

                @if ($client->activation_status == 1)
                <div class="btn-group">
                    <a href="{{ url('/jobs/create') }}" class="tip btn btn-warning btn-flat" title="" data-original-title="Add job">
                        <i class="fa fa-plus"></i>
                        <span class="hidden-sm hidden-xs"> Add Job</span>
                    </a>
                </div>
                @endif

                <div class="btn-group">
                    <a href="{{ url('/people/clients/download-pdf/' . $client->id) }}" class="tip btn btn-primary btn-flat" title="" data-original-title="PDF">
                        <i class="fa fa-file-pdf-o"></i>
                        <span class="hidden-sm hidden-xs"> PDF</span>
                    </a>
                </div>
                <div class="btn-group">
                    <a href="{{ url('/people/clients/edit/' . $client->id) }}" class="tip btn btn-warning tip btn-flat" title="" data-original-title="Edit Product">
                        <i class="fa fa-edit"></i>
                        <span class="hidden-sm hidden-xs"> Edit</span>
                    </a>
                </div>
                <div class="btn-group">
                    <a href="{{ url('/people/clients/delete/' . $client->id) }}" class="tip btn btn-danger btn-flat" data-toggle="tooltip" data-original-title="Click to delete" onclick="return confirm('Are you sure to delete this ?');">
                        <i class="fa fa-arrow-up"></i>
                        <span class="hidden-sm hidden-xs"> Delete</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
</div>
@endsection