@extends('administrator.master')
@section('title', 'Job Details')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            JOBS
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ url('/jobs') }}">Jobs</a></li>
            <li class="active">Details</li>
        </ol>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ asset('/public/backend/dist/img/profile-icon.png') }}" alt="User profile picture">

                    <h3 class="profile-username text-center">{{ $job->name }}</h3>

                    <p class="text-muted text-center">{{ $job->designation }}</p>

                    @if(!empty($total_payables))

                    @php($total_payable = $total_payables->total_payable_amount)
                    @php($tax = $total_payables->total_tax_amount)


                    @if(!empty($total_discounts->total_discount_amount))
                    @php($total_discount = $total_discounts->total_discount_amount)
                    @else
                    @php($total_discount = 00.00)
                    @endif

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Net Payable</b> <p class="pull-right">{{ $net_payable = $tax + ($total_payable - $total_discount) }} /=</p>
                        </li>
                        <li class="list-group-item">
                            <b>Paid Amount</b> <p class="pull-right">
                                @if(!empty($total_installments->total_installment_amount))
                                {{ $paid_amount = $total_installments->total_installment_amount }}
                                @else
                                {{ $paid_amount = 00.00 }}
                                @endif
                                /=
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>Due</b> <p class="pull-right text-yellow">{{ $due = $net_payable - $paid_amount }} /=</p>
                        </li>
                        <li class="list-group-item">
                            <b>Next Payment</b> <p class="pull-right text-red">
                                @if($due > 0)
                                @if(!empty($next_payment_date->next_payment_date))
                                {{ date("d F Y", strtotime($next_payment_date->next_payment_date)) }}
                                @else
                                No schedule add for this payment.
                                @endif
                                @else
                                Paid
                                @endif
                            </p>
                        </li>
                    </ul>
                    @else
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                         <b>No Payment Added !</b>
                     </li>
                 </ul>
                 @endif

                 <strong><i class="fa fa-phone margin-r-5"></i> Contact No</strong>
                 <p class="text-muted">{{ $job->contact_no_one }}</p>
                 <hr>

                 <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
                 <p class="text-muted">{{ $job->email }}</p>
                 <hr>

                 <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
                 <p class="text-muted">{{ $job->present_address }}</p>
                 <hr>

                 <strong><i class="fa fa-info-circle margin-r-5"></i> Status</strong>

                 <p>
                    @if ($job->job_status == 1)
                    <span class="label label-success">Complete</span>
                    @else
                    <span class="label label-warning">Incomplete</span>
                    @endif

                    @if ($job->publication_status == 1)
                    <span class="label label-success">Published</span>
                    @else
                    <span class="label label-warning">Unpublished</span>
                    @endif
                </p>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#payment" data-toggle="tab" aria-expanded="false">Payment</a></li>
                <li class=""><a href="#job_details" data-toggle="tab" aria-expanded="true">Job Details</a></li>
                <li class=""><a href="#note" data-toggle="tab" aria-expanded="false">Note</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="payment">
                            <div class="box box-solid">
                                @if(!empty($total_payables->total_payable_amount))
                                <div class="box-header with-border">
                                    <h3 class="box-title">Payment Summary:</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt>Total Payable:</dt>
                                        <dd>{{ $total_payable = $total_payables->total_payable_amount }} /=</dd>
                                        <dt>Tax ({{$payables[0]->tax }}%):</dt>
                                        <dd>{{ $tax = $total_payables->total_tax_amount }}/=</dd>
                                        <dt>Total Discount:</dt>
                                        <dd>
                                            @if(!empty($total_discounts->total_discount_amount))
                                            {{ $total_discount = $total_discounts->total_discount_amount }}
                                            @else
                                            {{ $total_discount = 00.00 }}
                                            @endif
                                            /=
                                        </dd>
                                        <dt>Net Payable:</dt>
                                        <dd class="text-green">
                                            {{ $net_payable = $tax + ($total_payable - $total_discount) }} /=
                                        </dd>
                                        <dt>Paid Amount:</dt>
                                        <dd>
                                            @if(!empty($total_installments->total_installment_amount))
                                            {{ $paid_amount = $total_installments->total_installment_amount }}
                                            @else
                                            {{ $paid_amount = 00.00 }}
                                            @endif
                                            /=
                                        </dd>
                                        <dt>Due:</dt>
                                        <dd class="text-yellow">
                                            {{ $due = $net_payable - $paid_amount }} /=
                                        </dd>
                                        <dt>Next Payment Date:</dt>
                                        <dd class="text-red">
                                            @if($due > 0)
                                            @if(!empty($next_payment_date->next_payment_date))
                                            {{ date("d F Y", strtotime($next_payment_date->next_payment_date)) }}
                                            @else
                                            No schedule add for this payment.
                                            @endif
                                            @else
                                            Paid
                                            @endif

                                        </dd>
                                    </dl>
                                </div>
                                @else
                                <div class="box-body">
                                    <p class="text-yellow">Please add payable amount first.</p>
                                </div>
                                <!-- /.box-body -->
                                @endif
                                <div class="box-footer">
                                    <a id="payable" class="btn btn-xs btn-flat"> Payable</a>
                                    @if(!empty($total_payables->total_payable_amount))
                                    <a id="discount" class="btn btn-xs btn-flat"> Discount</a>
                                    <a id="installment" class="btn btn-xs btn-flat"> Installment</a>
                                    <a id="next_payment_date" class="btn btn-xs btn-flat"> Next Payment Date</a>
                                    <a id="payable_report" class="btn btn-xs btn-flat"> Payable Report</a>
                                    <a id="discount_report" class="btn btn-xs btn-flat"> Discount Report</a>
                                    <a id="installment_report" class="btn btn-xs btn-flat"> Installment Report / Invoice</a>
                                    @endif
                                </div>
                            </div>

                            <!-- Payable -->
                            <div id="payable_form" class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Payable:</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <form name="payable_form" action="{{ url('/jobs/payables/create/'. $job->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="name_of_account" class="col-sm-3 control-label">Name of A/C</label>

                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $job->name_of_account }}" class="form-control" id="name_of_account" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('payable_amount') ? ' has-error' : '' }} has-feedback">
                                            <label for="payable_amount" class="col-sm-3 control-label">Payable Amount <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <input type="number" name="payable_amount" class="form-control" id="payable_amount" value="{{ old('payable_amount')}}" placeholder="Enter payable amount" required>
                                                @if ($errors->has('payable_amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('payable_amount') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>


                                        <!-- Start Tax Section-->
                                        @if(empty($total_payables->total_payable_amount))
                                        <div class="form-group{{ $errors->has('tax') ? ' has-error' : '' }} has-feedback">
                                            <label for="tax" class="col-sm-3 control-label">Tax <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <select name="tax" id="tax" class="form-control">
                                                    <option value="" selected disabled>Select one</option>
                                                    <option value="0">No Tax</option>
                                                    <option value="5">VAT @5%</option>
                                                    <option value="10">VAT @10%</option>
                                                    <option value="15">VAT @15%</option>
                                                </select>
                                                @if ($errors->has('tax'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tax') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('tax_method') ? ' has-error' : '' }} has-feedback">
                                            <label for="tax_method" class="col-sm-3 control-label">Tax Method <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <select name="tax_method" id="tax_method" class="form-control">
                                                    <option value="" selected disabled>Select one</option>
                                                    <option value="1">Inclusive</option>
                                                    <option value="2">Exclusive</option>
                                                </select>
                                                @if ($errors->has('tax_method'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tax_method') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        @else
                                        <div class="form-group">
                                            <label for="tax" class="col-sm-3 control-label">Tax</label>

                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $payables[0]->tax }}%" class="form-control" id="tax" disabled>
                                                <input type="hidden" name="tax" value="{{ $payables[0]->tax }}" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tax_method" class="col-sm-3 control-label">Tax Method</label>

                                            <div class="col-sm-9">
                                                @php($tax_method = $payables[0]->tax_method)
                                                <input type="hidden" name="tax_method" value="{{ $tax_method }}">
                                                <input type="text" value="{{ $tax_method = 1 ? 'Inclusive' : 'Exclusive' }}" class="form-control" id="tax_method" disabled>

                                            </div>
                                        </div>
                                        @endif
                                        <!-- End Tax Section-->



                                        <div class="form-group{{ $errors->has('short_note') ? ' has-error' : '' }} has-feedback">
                                            <label for="short_note" class="col-sm-3 control-label">Short Note</label>

                                            <div class="col-sm-9">
                                                <input type="text" name="short_note" class="form-control" id="short_note" value="{{ old('short_note')}}" placeholder="Enter short note">
                                                @if ($errors->has('short_note'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('short_note') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.payable end -->

                            <!-- Discount -->
                            <div id="discount_form" class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Discount:</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <form action="{{ url('/jobs/discounts/create/' . $job->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="name_of_account" class="col-sm-3 control-label">Name of A/C <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $job->name_of_account }}" class="form-control" id="name_of_account" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('discount_amount') ? ' has-error' : '' }} has-feedback">
                                            <label for="discount_amount" class="col-sm-3 control-label">Discount Amount <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <input type="number" name="discount_amount" class="form-control" id="discount_amount" value="{{ old('discount_amount')}}" placeholder="Enter payable amount" required>
                                                @if ($errors->has('discount_amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('discount_amount') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('short_note') ? ' has-error' : '' }} has-feedback">
                                            <label for="short_note" class="col-sm-3 control-label">Short Note </label>

                                            <div class="col-sm-9">
                                                <input type="text" name="short_note" class="form-control" id="short_note" value="{{ old('short_note')}}" placeholder="Enter short note">
                                                @if ($errors->has('short_note'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('short_note') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.discount end -->

                            <!-- Installment -->
                            <div id="installment_form" class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Installment:</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <form action="{{ url('/jobs/installments/create/'.$job->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="name_of_account" class="col-sm-3 control-label">Name of A/C <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $job->name_of_account }}" class="form-control" id="name_of_account" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('installment_name') ? ' has-error' : '' }} has-feedback">
                                            <label for="installment_name" class="col-sm-3 control-label">Installment Name <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="installment_name" name="installment_name" placeholder="Enter installment name">
                                                @if ($errors->has('installment_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('installment_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('installment_amount') ? ' has-error' : '' }} has-feedback">
                                            <label for="installment_amount" class="col-sm-3 control-label">Installment Amount <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="installment_amount" id="installment_amount" placeholder="Enter installment amount">
                                                @if ($errors->has('installment_amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('installment_amount') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('installment_method') ? ' has-error' : '' }} has-feedback">
                                            <label for="installment_method" class="col-sm-3 control-label">Installment Method <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <select name="installment_method" id="installment_method" class="form-control">
                                                    <option value="" selected disabled>Select one</option>
                                                    <option value="1">Cash</option>
                                                    <option value="2">Check</option>
                                                </select>
                                                @if ($errors->has('installment_method'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('installment_method') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('short_note') ? ' has-error' : '' }} has-feedback">
                                            <label for="short_note" class="col-sm-3 control-label">Short Note <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="short_note" id="short_note" placeholder="Enter short note">
                                                @if ($errors->has('short_note'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('short_note') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.installment end -->

                            <!-- Next Payment Date -->
                            <div id="next_payment_date_form" class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Next Payment Date:</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <form action="{{ url('/jobs/next_payment_date/create/' . $job->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="name_of_account" class="col-sm-3 control-label">Name of A/C <span class="text-red">*</span></label>

                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $job->name_of_account }}" class="form-control" id="name_of_account" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('next_payment_date') ? ' has-error' : '' }} has-feedback">
                                            <label for="datepicker2" class="col-sm-3 control-label">Next Payment Date <span class="text-red">*</span></label>

                                            <div class="col-sm-9 ">
                                                <div class="input-group date">
                                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                    <input type="text" name="next_payment_date" value="{{ old('next_payment_date') }}" class="form-control pull-right" id="datepicker2" placeholder="yyy-mm-dd" required>
                                                </div>
                                                @if ($errors->has('next_payment_date'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('next_payment_date') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('short_note') ? ' has-error' : '' }} has-feedback">
                                            <label for="short_note" class="col-sm-3 control-label">Short Note </label>

                                            <div class="col-sm-9">
                                                <input type="text" name="short_note" class="form-control" id="short_note" value="{{ old('short_note')}}" placeholder="Enter short note" >
                                                @if ($errors->has('short_note'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('short_note') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.next payment date end -->

                            <!-- Payable Report -->
                            <div id="payable_report_table" class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Payable Report:</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="">SL#</th>
                                                <th width="">Name of Account</th>
                                                <th width="">Date</th>
                                                <th width="">Payable Amount</th>
                                                <th width="">Short Note</th>
                                                <!--<th width="">Actions</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php ($sl = 1)
                                            @foreach($payables as $payable)
                                            <tr>
                                                <td>{{ $sl++ }}</td>
                                                <td>{{ $job->name_of_account }}</td>
                                                <td>{{ date("d F Y - h:ia", strtotime($payable->created_at)) }}</td>
                                                <td>{{ $payable->payable_amount }}</td>
                                                <td>{{ $payable->short_note }}</td>
                                                <!--<td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary btn-xs btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{{ url('/jobs/details/' ) }}"><i class="icon fa fa-file-text"></i> Details</a></li>
                                                            <li><a href="{{ url('/jobs/edit/' ) }}"><i class="icon fa fa-edit"></i> Edit</a></li>
                                                            <li><a href="{{ url('/jobs/delete/' ) }}" onclick="return confirm('Are you sure to delete this ?');"><i class="icon fa fa-trash"></i> Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>-->
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /. End Payable Report -->

                            <!-- Discount Report -->
                            <div id="discount_report_table" class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Discount Report:</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="">SL#</th>
                                                <th width="">Name of Account</th>
                                                <th width="">Date</th>
                                                <th width="">Discount Amount</th>
                                                <th width="">Short Note</th>
                                                <!--<th width="">Actions</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php ($sl = 1)
                                            @foreach($discounts as $discount)
                                            <tr>
                                                <td>{{ $sl++ }}</td>
                                                <td>{{ $job->name_of_account }}</td>
                                                <td>{{ date("d F Y - h:ia", strtotime($discount->created_at)) }}</td>
                                                <td>{{ $discount->discount_amount }}</td>
                                                <td>{{ $discount->short_note }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /. End Discount Report -->

                            <!-- Installment Report -->
                            <div id="installment_report_table" class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Installment Report:</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="">SL#</th>
                                                <th width="">Name of A/C</th>
                                                <th width="">Date</th>
                                                <th width="">Inst. Name</th>
                                                <th width="">Inst. Amount</th>
                                                <th width="">Inst. Method</th>
                                                <th width="">Short Note</th>
                                                <th width="">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php ($sl = 1)
                                            @foreach($installments as $installment)
                                            <tr>
                                                <td>{{ $sl++ }}</td>
                                                <td>{{ $job->name_of_account }}</td>
                                                <td>{{ date("d F Y - h:ia", strtotime($installment->created_at)) }}</td>
                                                <td>{{ $installment->installment_name }}</td>
                                                <td>{{ $installment->installment_amount }} /=</td>
                                                <td>
                                                    @if($installment->installment_method == 1)
                                                    Cash
                                                    @else
                                                    Check
                                                    @endif
                                                </td>
                                                <td>{{ $installment->short_note }}</td>
                                                <td><a href="{{ url('/jobs/invoice/'.$installment->id ) }}" class="btn btn-sm btn-primary btn-flat"><i class="icon fa fa-file-text"></i> Invoice</a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /. End Installment Report -->


                        </div>
                        <!-- /.tab-pane -->
                <div class="tab-pane" id="job_details">
                    <!-- Notification Box -->
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
                    <!-- /.Notification Box -->

                    <!-- job details -->
                    <table id="example1" class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td width="25%">Name of Account</td>
                                <td width="75%">{{ $job->name_of_account }}</td>
                            </tr>
                            <tr>
                                <td>Client</td>
                                <td>{{ $job->name }}</td>
                            </tr>
                            <tr>
                                <td>Reference by</td>
                                <td>{{ $reference_by->name }}</td>
                            </tr>
                            <tr>
                                <td>Assign to</td>
                                <td>{{ $assign_to->name }}</td>
                            </tr>
                            <tr>
                                <td>Job Type</td>
                                <td>{{ $job_type->job_type }}</td>
                            </tr>
                            <tr>
                                <td>Receiving Date</td>
                                <td>{{ date("d F Y", strtotime($job->receiving_date)) }}</td>
                            </tr>
                            <tr>
                                <td>Created by</td>
                                <td>{{ $created_by->name }}</td>
                            </tr>
                            <tr>
                                <td>Created at</td>
                                <td>{{ date("d F Y", strtotime($job->created_at)) }}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{!! $job->description !!}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="btn-group btn-group-justified">
                                        @if ($job->publication_status == 1)
                                        <div class="btn-group">
                                            <a href="{{ url('/jobs/unpublished/' . $job->id) }}" class="tip btn btn-success btn-flat" data-toggle="tooltip" data-original-title="Click to unpublished">
                                                <i class="fa fa-arrow-down"></i>
                                                <span class="hidden-sm hidden-xs"> Published</span>
                                            </a>
                                        </div>
                                        @else
                                        <div class="btn-group">
                                            <a href="{{ url('/jobs/published/' . $job->id) }}" class="tip btn btn-warning btn-flat" data-toggle="tooltip" data-original-title="Click to published">
                                                <i class="fa fa-arrow-up"></i>
                                                <span class="hidden-sm hidden-xs"> Unpublished</span>
                                            </a>
                                        </div>
                                        @endif

                                        @if ($job->job_status == 1)
                                        <div class="btn-group">
                                            <a href="{{ url('/jobs/incomplete/' . $job->id) }}" class="tip btn btn-success btn-flat" data-toggle="tooltip" data-original-title="Click to re-open">
                                                <i class="fa fa-arrow-down"></i>
                                                <span class="hidden-sm hidden-xs"> Complete</span>
                                            </a>
                                        </div>
                                        @else
                                        <div class="btn-group">
                                            <a href="{{ url('/jobs/complete/' . $job->id) }}" class="tip btn btn-warning btn-flat" data-toggle="tooltip" data-original-title="Click to complete">
                                                <i class="fa fa-arrow-up"></i>
                                                <span class="hidden-sm hidden-xs"> Incomplete</span>
                                            </a>
                                        </div>
                                        @endif

                                                <!-- <div class="btn-group">
                                                    <a href="#" class="tip btn btn-primary btn-flat" title="" data-original-title="Label Printer">
                                                        <i class="fa fa-print"></i>
                                                        <span class="hidden-sm hidden-xs"> Print</span>
                                                    </a>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="#" class="tip btn btn-primary btn-flat" title="" data-original-title="PDF">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                        <span class="hidden-sm hidden-xs"> PDF</span>
                                                    </a>
                                                </div> -->
                                                <div class="btn-group">
                                                    <a href="{{ url('/jobs/edit/' . $job->id) }}" class="tip btn btn-primary tip btn-flat" title="" data-original-title="Edit Product">
                                                        <i class="fa fa-edit"></i>
                                                        <span class="hidden-sm hidden-xs"> Edit</span>
                                                    </a>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="{{ url('/jobs/delete/' . $job->id) }}" onclick="return confirm('Are you sure to delete this ?');" class="tip btn btn-danger bpo btn-flat" title="" data-content="<div style='width:150px;'><p>Are you sure?</p><a class='btn btn-danger' href='https://btrc.gunitok.com/products/delete/1'>Yes I'm sure</a> <button class='btn bpo-close'>No</button></div>" data-html="true" data-placement="top" data-original-title="<b>Delete Product</b>">
                                                    <i class="fa fa-trash-o"></i>
                                                    <span class="hidden-sm hidden-xs"> Delete</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- /.job details -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="note">
                        <p class="text-yellow">Enter job type note. All field are required. </p>
                        <form class="form-horizontal" action="{{ url('/jobs/notes/create/'. $job->id) }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }} has-feedback">
                                <div class="col-sm-12">
                                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" placeholder="Enter title.." required>
                                    @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }} has-feedback">
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="note" name="note" placeholder="Enter note.." required>{{ old('note')}}</textarea>
                                    @if ($errors->has('note'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('remind_date') ? ' has-error' : '' }} has-feedback">
                                <div class="col-sm-12">
                                    <input type="text" name="remind_date" class="form-control" id="datepicker" value="{{ old('remind_date') }}" placeholder="Select remind date.." required>
                                    @if ($errors->has('remind_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('remind_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.form group -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary pull-right btn-flat">Add Note</button>
                                </div>
                            </div>
                        </form>
                        <!-- The timeline -->
                        <ul class="timeline timeline-inverse">
                            @foreach($notes as $note)
                            <!-- timeline time label -->
                            <li class="time-label">
                                <span class="bg-green">
                                    {{ date("d F Y", strtotime($note->created_at)) }}
                                </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-envelope bg-blue"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> {{ date("h:ia", strtotime($note->created_at)) }}</span>

                                    <h3 class="timeline-header">{{ $note->title }} (<a>{{ $note->name }}</a>)</h3>

                                    <div class="timeline-body">
                                        {{ $note->note }}
                                    </div>
                                        <!--<div class="timeline-footer">
                                            <a class="btn btn-primary btn-xs">Read more</a>
                                            <a class="btn btn-danger btn-xs">Delete</a>
                                        </div>-->
                                    </div>
                                </li>
                                @endforeach
                                <!-- END timeline item -->
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<script>
    $(document).ready(function () {
        $("#payable_form").hide();
        $("#discount_form").hide();
        $("#installment_form").hide();
        $("#next_payment_date_form").hide();
        $("#payable_report_table").hide();
        $("#discount_report_table").hide();
        $("#installment_report_table").hide();

        $("#payable").click(function () {
            $("#discount_form").hide();
            $("#installment_form").hide();
            $("#next_payment_date_form").hide();
            $("#payable_report_table").hide();
            $("#discount_report_table").hide();
            $("#installment_report_table").hide();
            $("#payable_form").show(500);
        });
        $("#discount").click(function () {
            $("#installment_form").hide();
            $("#payable_form").hide();
            $("#next_payment_date_form").hide();
            $("#payable_report_table").hide();
            $("#discount_report_table").hide();
            $("#installment_report_table").hide();
            $("#discount_form").show(500);
        });
        $("#installment").click(function () {
            $("#payable_report_table").hide();
            $("#discount_report_table").hide();
            $("#installment_report_table").hide();
            $("#payable_form").hide();
            $("#discount_form").hide();
            $("#next_payment_date_form").hide();
            $("#installment_form").show(500);
        });
        $("#next_payment_date").click(function () {
            $("#payable_report_table").hide();
            $("#discount_report_table").hide();
            $("#installment_report_table").hide();
            $("#payable_form").hide();
            $("#discount_form").hide();
            $("#installment_form").hide();
            $("#next_payment_date_form").show(500);
        });

        $("#payable_report").click(function () {
            $("#payable_form").hide();
            $("#discount_form").hide();
            $("#next_payment_date_form").hide();
            $("#installment_form").hide();
            $("#discount_report_table").hide();
            $("#installment_report_table").hide();
            $("#payable_report_table").show(500);
        });
        $("#discount_report").click(function () {
            $("#payable_form").hide();
            $("#discount_form").hide();
            $("#installment_form").hide();
            $("#next_payment_date_form").hide();
            $("#installment_report_table").hide();
            $("#payable_report_table").hide();
            $("#discount_report_table").show(500);
        });
        $("#installment_report").click(function () {
            $("#payable_form").hide();
            $("#discount_form").hide();
            $("#installment_form").hide();
            $("#next_payment_date_form").hide();
            $("#payable_report_table").hide();
            $("#discount_report_table").hide();
            $("#installment_report_table").show(500);
        });
    });
</script>
@endsection