<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $invoice_items['invoice_type'] == 1 ? 'Invoice' : 'Bill' }}</title>
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
  table {border-collapse: collapse}
  table, th, td {border: 1px solid #ccc}
  th {padding: 0px 15px}
  td {padding: 0px 15px}
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
                    <h2 class="page-header" style="font-size: 14px"> Ref: {{ $invoice_items['reference_no'] }}
                        <span class="pull-right">{{ date("d F Y", strtotime($invoice_items['date'])) }}</span>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>{{ $invoice_items['invoice_name'] }}</strong><br>
                        {{ $invoice_items['address_one'] }}<br>
                        {{ $invoice_items['address_two'] }}<br>
                        <!--Phone: {{ $invoice_items['contact_no'] }}<br>-->
                        {{ !empty($invoice_items['email_address']) ? 'Email: ' . $invoice_items['email_address'] : '' }}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <address> &nbsp; </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <p class="pull-right" style="font-weight: bold">{{ $invoice_items['invoice_type'] == 1 ? 'Invoice' : 'Bill' }} #{{ $invoice_items['invoice_no'] }}</p>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Subject -->
            <div class="row">
                <div class="col-sm-12">
                    <p style="padding: 10px 0px; font-weight: bold;">Subject: {{ $invoice_items['subject'] }}</p>
                    <p>Dear Sir</p>
                    <p class="text-justify">Please arrange to pay the following professional bill in respect of the above mentioned subject.
                    </p>
                    <p style="text-align: center">(PLEASE MAKE THE CHEQUE PAYABLE TO <strong>"THE LAWYERS CONSORTIUM"</strong>)</p>

                </div>
            </div>

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table width="100%">
                        <thead>
                            <tr>
                                <th width="12%">SL</th>
                                <th style="text-align: center;">Bill Description</th>
                                <th>Taka</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($total = 0)
                            @for($i=0; $i < count($invoice_items['sl']); $i++)
                            <tr>
                                <td>{{ $invoice_items['sl'][$i] }}</td>
                                <td>{{ $invoice_items['description'][$i] }}</td>
                                <td class="text-right">{{ $invoice_items['subtotal'][$i] }}</td>
                                @php($total += $invoice_items['subtotal'][$i])
                            </tr>
                            @endfor
                            <tr class="text-right">
                                <td colspan="2"><span class="pull-right">Total</td>
                                    <td>{{ $total }}</td>
                                </tr>
                                @php($discount = 0)
                                @if(!empty($invoice_items['discount']))
                                @php($discount = $invoice_items['discount'])
                                @endif
                                <tr class="text-right">
                                    <td colspan="2">Discount</td>
                                    <td>{{ $discount }}‎</td>
                                </tr>
                                <tr class="text-right">
                                    @php($tax = 0)
                                    @php($tax_amount = 0)
                                    @if(!empty($invoice_items['tax']))
                                    @php($tax = $invoice_items['tax'])
                                    @php($tax_amount = ((($total-$discount)*$tax)/100))
                                    @endif
                                    <td colspan="2">Tax ({{ $tax }} %)</td>
                                    <td>{{ $tax_amount }}</td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="2">Net Amount:</td>
                                    <td>{{ $net_amount = ($total-$discount)+$tax_amount}}</td>
                                </tr>
                                <tr>
                                    <td>In Word</td>
                                    <td colspan="2">{{ $invoice_items['amount_in_word'] }}</td>
                                </tr>
                        <!-- <tr>
                            <td colspan="2"><span class="pull-right">Paid Amount:</td>
                            <td>
                                @php($paid_amount = 0)
                                @if(!empty($invoice_items['paid_amount']))
                                @php($paid_amount = $invoice_items['paid_amount'])
                                @endif
                                {{ $paid_amount }} ‎
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="pull-right">Total Due:</td>
                            <td>
                                {{ $net_amount-$paid_amount }} ‎
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-12">
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px; font-weight: bold; border: 0px">
                Note: {{ $invoice_items['short_note'] }}</p>
                <p style="padding: 5px 0px; text-align: center">If you have any queries, Please do not hesitate contact us.</p>
            </div>
            <!-- /.col -->
            <div class="col-xs-12">
                <p style="padding: 5px 0px;">Thanking You</p>
                <br><br>
                <address>{!! $invoice_items['from_address'] !!}</address>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="{{ url('/custom-invoice') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
