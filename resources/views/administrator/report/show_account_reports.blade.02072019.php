@extends('administrator.master')
@section('title', 'Account Reports')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ACCOUNT REPORTS
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a>Report</a></li>
            <li class="active">Account Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Search Account Reports</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool"data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form name="account_report_form" action="{{ url('/reports/show-account-reports') }}" method="post">
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

                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="input-group date">
                            <button class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Search</button>
                            &nbsp;
                            <button class="btn btn-default btn-flat" type="button" onclick="printDiv('printable_area')" ><i class="fa fa-print"></i> Print
                            </button>
                            &nbsp;
                            <a href="{{ url('/reports/account-reports-pdf/' . $form_date .'/' .$to_date) }}" class="btn btn-default btn-flat" type="button" ><i class="fa fa-file-pdf-o"></i> PDF
                            </a>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>

            </div>
            <!-- /.row -->
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
        <table class="table table-bordered table-striped" id="">
            <thead>
                <tr>
                    <th>SL#</th>
                    <th>Reg.No</th>
                    <th>Name of Account</th>
                    <th>Client</th>
                    <th>Reference</th>
                    <th>Total Payable</th>
                    <th>Discount Amount</th>
                    <th>Tax Amount</th>
                    <th>Net Payable</th>
                    <th>Total Installment</th>
                    <th>Due Amount</th>
                </tr>
            </thead>
            <tbody>
                @php ($sl = 1)
                @foreach($jobs as $job)
                <tr>
                    <td>{{ $sl }}</td>
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
                        @php($total_payable_amount = number_format(0, 2))
                        @foreach($total_payables as $total_payable)
                        @if($job->id == $total_payable->job_id)
                        @php($total_payable_amount = $total_payable->total_payable_amount)
                        @endif
                        @endforeach
                        {{ $total_payable_amount }} /=
                    </td>
                    <td>
                        @php($total_discount_amount = number_format(0, 2))
                        @foreach($total_discounts as $total_discount)
                        @if($job->id == $total_discount->job_id)
                        @php($total_discount_amount = $total_discount->total_discount_amount)
                        @endif
                        @endforeach
                        {{ $total_discount_amount }} /=
                    </td>
                    <td>
                        @php($total_tax_amount = number_format(0, 2))
                        @foreach($total_payables as $total_payable)
                        @if($job->id == $total_payable->job_id)
                        @php($total_tax_amount = $total_payable->total_tax_amount)
                        @endif
                        @endforeach
                        {{ $total_tax_amount }} /=
                    </td>
                    <td>
                        @php($net_payable = $total_tax_amount + ($total_payable_amount - $total_discount_amount))
                        @if(!empty($net_payable))
                        {{ $net_payable }} /=
                        @else
                        0.00 /=
                        @endif
                    </td>
                    <td>
                        @php($total_installment_amount = number_format(0, 2))
                        @foreach($total_installments as $total_installment)
                        @if($job->id == $total_installment->job_id)
                        @php($total_installment_amount = $total_installment->total_installment_amount)
                        @endif
                        @endforeach
                        {{ $total_installment_amount }} /=
                    </td>

                    <td>
                        @php($due_amount = $net_payable - $total_installment_amount)
                        @if(!empty($due_amount))
                        {{ $due_amount }} /=
                        @else
                        0.00 /=
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
    document.forms['account_report_form'].elements['form_date'].value = "{{ $form_date }}";
    document.forms['account_report_form'].elements['to_date'].value = "{{ $to_date }}";
</script>
@endsection