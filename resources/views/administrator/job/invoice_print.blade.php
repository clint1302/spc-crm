<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Invoice</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('public/backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href=" {{ asset('public/backend/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionic        ons -->
    <link rel="stylesheet" href=" {{ asset('public/backend/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme st        yle -->
    <link rel="stylesheet" href=" {{ asset('public/backend/dist/css/AdminLTE.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media quer        ies -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file        :// -->
        <!--[if lt        IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
      body {margin: 0px}
          table { border-collapse: collapse }
          table, th, td { border: 1px solid #ccc }
          th { padding: 0px 15px; font-size: 14px }
          td { padding: 0px 15px; font-size: 14px }
            @page {
    /*size: auto;    auto is the initial value */
    size: 21cm 29.7cm;
    /* this affects the margin in the printer settings */
    margin: 1.27cm 1.27cm 1.27cm 1.27cm ;
    /*margin: 2.54cm 2.54cm 2.54cm 2.54cm ;*/
}
    </style>
</head>
<body onload="window.print();">
    <div class="wrapper">
        <!-- Main content -->

        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header" style="font-size: 14px">Ref: {{ $ref }}
                        <span class="pull-right">{{ date("d F Y", strtotime($installment->created_at)) }}</span>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-12" style="padding: 0px; margin: 0px;">
                    <h3 style="text-align: center;">INVOICE</h3>
                </div>
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
                <div class="col-sm-4 invoice-col">
                    <address> &nbsp; </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    @php($total_payable = $total_payables->total_payable_amount)
                    @php($tax = $total_payables->total_tax_amount)
                    @if(!empty($total_discounts->total_discount_amount))
                    @php($total_discount = $total_discounts->total_discount_amount)
                    @else
                    @php($total_discount = 0)
                    @endif
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="60%">Invoice No</td>
                                <td class="text-right">{{ $installment->id }}</td>
                            </tr>
                    <!-- <tr>
                        <td>Account No</td>
                        <td>#{{ $installment->job_id }}</td>
                    </tr> -->
                    <tr>
                        <td>Net Payable</td>
                        <td class="text-right">{{ $net_payable = $tax + ($total_payable - $total_discount) }}</td>
                    </tr>
                    <tr>
                        <td>Paid Amount</td>
                        <td class="text-right">
                            @if(!empty($total_installments->total_installment_amount))
                            {{ $paid_amount = $total_installments->total_installment_amount }}
                            @else
                            {{ $paid_amount = 0 }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Amount Due</td>
                        <td class="text-right">{{ $due = $net_payable - $paid_amount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table width="100%">
                <thead>
                    <tr>
                        <th width="12%">SL</th>
                        <th class="text-center">Description</th>
                        <th class="text-center" width="20%">Taka</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $installment->installment_name }}</td>
                        <td class="text-right">{{ $installment->installment_amount }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="pull-right"><strong>Total</strong></span></td>
                        <td class="text-right">{{ $installment->installment_amount }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="pull-right"><strong>Tax (5%)</strong></span></td>
                            <td class="text-right">Included</td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="pull-right"><strong>Net Amount</strong></span></td>
                            <td class="text-right">{{ $installment->installment_amount }}</td>
                            </tr>
                            <tr>
                                <td><strong>In Word:</strong></td>
                                <td colspan="2">{{ $amount_in_word }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row" style="margin-top: 40px">
                <!-- Payment Short Note -->
                <!-- @if(!empty($installment->short_note))
                <div class="col-xs-12">
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        <b>Note:</b> {{ $installment->short_note }}
                    </p>
                </div>
                @endif -->
                <!-- Payment details info -->
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table width="100%">
                            <tbody>
                                <!-- <tr>
                                    <td width="20%"><strong>Payment Status</strong></td>
                                    <td width="1%">:</td>
                                    <td>Paid</td>
                                </tr> -->
                                <tr>
                                    <td width="25%"><strong>Payment Methods</strong></td>
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
                                        @if($next_payment_date->next_payment_date > $installment->created_at)
                                        {{ date("d F Y", strtotime($next_payment_date->next_payment_date)) }}
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Note</strong></td>
                                    <td>:</td>
                                    <td>{{ $extra_note }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-12">
                    <p style="padding: 50px 0px">Thanking You</p>
                    <address>{!! $from_address !!}</address>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <a href="{{ url('jobs/details/'.$installment->job_id) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
</body>
</html>
