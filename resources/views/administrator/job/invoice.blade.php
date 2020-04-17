@extends('administrator.master')
@section('title', 'Invoice')

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
<div class="pad margin no-print">
    <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        This page has been enhanced for printing. Click the print button at the bottom of the invoice to print.
    </div>
</div>
<section class="invoice">
    <form action="{{ url('jobs/print-invoice/'.$installment->id) }}" method="post">
     {{ csrf_field() }}
     <!-- title row -->
     <div class="row" style="border-bottom: 1px solid #ddd; margin-bottom: 20px;">
        <div class="col-xs-6">
            <div class="form-group">
                <input type="text" name="reference_no" placeholder="Enter reference no" class="form-control" style="width: 250px;" required="">
                @if ($errors->has('reference_no'))
                <span class="help-block">
                    <small style="color:#dd4b39;">{{ $errors->first('reference_no') }}</small>
                </span>
                @endif
            </div>
        </div>
        <div class="col-xs-6">
            <small class="pull-right" style="color: #666; display: block; margin-top: 5px;">{{ date("d F Y", strtotime($installment->created_at)) }}</small>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong>{{ $installment->name }}</strong><br>
                {{ $installment->present_address }}<br>
                Phone: {{ $installment->contact_no_one }}<br>
                <!-- Email: {{ $installment->email }} -->
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-offset-4 col-sm-4 invoice-col">
            @php($total_payable = $total_payables->total_payable_amount)
            @php($tax = $total_payables->total_tax_amount)
            @if(!empty($total_discounts->total_discount_amount))
            @php($total_discount = $total_discounts->total_discount_amount)
            @else
            @php($total_discount = 0)
            @endif
            <table  class="table table-bordered">
                <tbody>
                    <tr>
                        <td width="50%">Invoice No</td>
                        <td>#{{ $installment->id }}</td>
                    </tr>
                    <!-- <tr>
                        <td>Account No</td>
                        <td>#{{ $installment->job_id }}</td>
                    </tr> -->
                    <tr>
                        <td>Net Payable</td>
                        <td>{{ $net_payable = $tax + ($total_payable - $total_discount) }} /=</td>
                    </tr>
                    <tr>
                        <td>Paid Amount</td>
                        <td>
                            @if(!empty($total_installments->total_installment_amount))
                            {{ $paid_amount = $total_installments->total_installment_amount }} /=
                            @else
                            {{ $paid_amount = 0 }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Amount Due</td>
                        <td>{{ $due = $net_payable - $paid_amount }} /=</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive ">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="10%">SL#</th>
                        <th>Description</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $installment->installment_name }}</td>
                        <td>{{ $installment->installment_amount }} /=</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="pull-right"><strong>Total</strong></td>
                            <td>{{ $installment->installment_amount }} /=</td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="pull-right"><strong>Tax (5%)</strong></span></td>
                            <td>Included</td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="pull-right"><strong>Net Amount</strong></td>
                                <td>{{ $installment->installment_amount }} /=</td>
                            </tr>
                            <tr>
                                <td><strong>In Word:</strong></td>
                                <td colspan="2">
                                    <input type="text" name="amount_in_word" placeholder="Enter amount in word.." class="form-control" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- Payment Short Note -->
                @if(!empty($installment->short_note))
                <div class="col-xs-12">
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        <b>Note:</b> {{ $installment->short_note }}
                    </p>
                </div>
                @endif
                <!-- Payment details info -->
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table  class="table table-bordered">
                            <tbody>
                                <!-- <tr>
                                    <td width="20%"><strong>Payment Status</strong></td>
                                    <td width="1%">:</td>
                                    <td>Paid</td>
                                </tr> -->
                                <tr>
                                    <td width="20%"><strong>Payment Methods</strong></td>
                                    <td width="1%">:</td>
                                    <td>
                                        <strong>{{ $installment->installment_method == 1? 'Cash': 'Check' }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Next Payment Date</strong></td>
                                    <td>:</td>
                                    <td>
                                        @if(!empty($next_payment_date))
                                            @if($next_payment_date->next_payment_date > $installment->created_at))
                                                {{ date("d F Y", strtotime($next_payment_date->next_payment_date)) }}
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Extra Note</strong></td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="extra_note" placeholder="Enter extra note.." class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-12">
                    <p style="padding: 10px 0px">Thanking You</p>
                    <textarea class="textarea" name="from_address" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                        <!-- For and on behalf of:
                        <br>
                        <strong>M. MIZANUR RAHMAN</strong><br>
                        Advocate, Supreme Court
                        <br>
                        Head of Chamber
                        <br>
                        For: <strong>The Lawyers Consortium</strong> -->
                    </textarea>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <br>
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection