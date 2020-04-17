@extends('administrator.master')
@section('title', 'Custom Bill')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            BILL
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Bill</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Custom Bill</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <form action="{{ url('/make-invoice') }}" method="post" name="file_name_add_form" id="invoice" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">

                    <div class="row">
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
                            @else
                            <p class="text-yellow">Enter file details. All field are required. </p>
                            @endif
                        </div>
                        <!-- /.Notification Box -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-3">
                            <label for="invoice_type">Invoice Type <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('invoice_type') ? ' has-error' : '' }} has-feedback">
                                <select name="invoice_type" id="invoice_type" class="form-control">
                                    <!-- <option value="" selected disabled>Select one</option>
                                        <option value="1">Invoice</option> -->
                                        <option value="2">Bill</option>
                                    </select>
                                    @if ($errors->has('invoice_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('invoice_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3">
                                <label for="date">Date <span class="text-danger">*</span></label>
                                <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                    <div class="input-group date">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="date" class="form-control pull-right" value="{{ old('date') }}" id="datepicker">
                                </div>
                                <!-- /.input group -->
                                @if ($errors->has('date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <label for="reference_no">Ref.No <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('reference_no') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="reference_no" id="reference_no" class="form-control" value="{{ old('reference_no') }}" placeholder="Enter reference no..">
                                @if ($errors->has('reference_no'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('reference_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3">
                            <label for="invoice_no">Bill No <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('invoice_no') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="{{ old('invoice_no') }}" placeholder="Enter invoice no..">
                                @if ($errors->has('invoice_no'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('invoice_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <!-- <label for="invoice_name">Invoice Name <span class="text-danger">*</span></label> -->
                            <label for="invoice_name">Billing To <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('invoice_name') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="invoice_name" id="invoice_name" class="form-control" value="{{ old('invoice_name') }}" placeholder="Enter billing to..">
                                @if ($errors->has('invoice_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('invoice_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <label for="subject">Subject</label>
                            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" placeholder="Enter subject..">
                                @if ($errors->has('subject'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('subject') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <label for="email_address">Email Address</label>
                            <div class="form-group{{ $errors->has('email_address') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="email_address" id="email_address" class="form-control" value="{{ old('email_address') }}" placeholder="Enter email address..">
                                @if ($errors->has('email_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email_address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-md-6">
                            <label for="contact_no">Contact No</label>
                            <div class="form-group{{ $errors->has('contact_no') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="contact_no" id="contact_no" class="form-control" value="{{ old('contact_no') }}" placeholder="Enter contact no..">
                                @if ($errors->has('contact_no'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->



                        <div class="col-md-6">
                            <label for="address_one">Address <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('address_one') ? ' has-error' : '' }} has-feedback">
                                <input type="text=" name="address_one" id="address_one" class="form-control" placeholder="Enter address.." value="{{ old('address_one') }}">
                                @if ($errors->has('address_one'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address_one') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('address_two') ? ' has-error' : '' }} has-feedback">
                                <input type="text=" name="address_two" id="address_two" class="form-control" placeholder="Enter address.." value="{{ old('address_two') }}">
                                @if ($errors->has('address_two'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address_two') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-md-6">
                            <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('payment_method') ? ' has-error' : '' }} has-feedback">
                                <select name="payment_method" id="payment_method" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    <option value="1">Cash</option>
                                    <option value="2">Check</option>
                                </select>
                                @if ($errors->has('payment_method'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('payment_method') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-md-12">
                            <label for="short_note">Note <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('short_note') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="short_note" id="short_note" class="form-control" value="Please pay the above Professional Bill within 7(seven) days of the above mentioned date. OR Please pay the above fees in advance in case before filling in the RJSC.">
                                @if ($errors->has('short_note'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('short_note') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-2">
                            <label for="sl">SL# <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" name="sl[]" id="sl" class="form-control" placeholder="Enter sl..">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-5">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" name="description[]" id="description" class="form-control" placeholder="Enter description..">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <label for="subtotal">Subtotal <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" name="subtotal[]" id="subtotal" class="form-control subtotal" placeholder="Enter subtotal..">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-1">
                            <label for="addbutton">&nbsp;</label>
                            <div class="form-group">
                                <button type="button" id="addbutton" class="btn btn-primary btn-flat"><i class="icon fa fa-plus"></i></button>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row" id="invoice_form"></div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-2 col-md-offset-9">
                            <label for="total">Total</label>
                            <div class="form-group">
                                <input type="text" name="total" id="total" class="form-control" disabled>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-2 col-md-offset-9">
                            <label for="discount">Discount</label>
                            <div class="form-group">
                                <input type="number" name="discount" id="discount" class="form-control" placeholder="Enter discount..">
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-2 col-md-offset-9">
                            <label for="tax">Tax %</label>
                            <div class="form-group">
                                <input type="number" name="tax" id="tax" class="form-control" placeholder="Enter tax..">
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-2 col-md-offset-9">
                            <label for="tax_amount">Tax Amount</label>
                            <div class="form-group">
                                <input type="text" name="tax_amount" id="tax_amount" class="form-control" disabled>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-2 col-md-offset-9">
                            <label for="net_total">Net Total</label>
                            <div class="form-group">
                                <input type="text" name="net_total" value="" id="net_total" class="form-control" disabled>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <label for="amount_in_word">Amount In Word</label>
                            <div class="form-group">
                                <input type="text" name="amount_in_word" id="amount_in_word" class="form-control" placeholder="Enter amount in word..">
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <label for="from_address">Thanking You</label>
                            <div class="form-group">
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
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->



                <!-- <div class="row">
                    <div class="col-md-2 col-md-offset-9">
                        <label for="paid_amount">Paid Amount </label>
                        <div class="form-group">
                            <input type="number" name="paid_amount" id="paid_amount" class="form-control" placeholder="Enter paid amount..">
                        </div>
                    </div>
                    /.col
                </div>
                /.row

                <div class="row">
                    <div class="col-md-2 col-md-offset-9">
                        <label for="due_amount">Due Amount</label>
                        <div class="form-group">
                            <input type="text" name="due_amount" id="due_amount" class="form-control" disabled>
                        </div>
                    </div>
                    /.col
                </div> -->
                <!-- /.row -->


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat"><i class="icon fa fa-print"></i> Print</button>
            </div>
        </form>
    </div>
    <!-- /.box -->


</section>
<!-- /.content -->
</div>
<script type="text/javascript">
    $('#addbutton').click(function(){
        $('#invoice_form').append('<div class="remove_row"><div class="col-md-2"><div class="form-group"><input type="text" name="sl[]" id="sl" class="form-control" placeholder="Enter sl.."></div></div><div class="col-md-5"><div class="form-group"><div class="form-group"><input type="text" name="description[]" id="description" class="form-control" placeholder="Enter description.."></div></div></div><div class="col-md-4"><div class="form-group"><div class="form-group"><input type="number" name="subtotal[]" class="form-control subtotal" placeholder="Enter subtotal.."></div></div></div><div class="col-md-1"><div class="form-group"><button type="button" id="removebutton" class="btn btn-danger btn-flat remove_field_btn"><i class="icon fa fa-trash"></i></button></div></div></div>')
    });

    $('#invoice_form').on('click', '.remove_field_btn', function(e) {
        e.preventDefault();
        $(this).parents('.remove_row').remove();

        calculation();
    });

    $(document).on("keyup", "#invoice", function() {
        calculation();
    });

    function calculation() {
        var sum = 0;
        $(".subtotal").each(function(){
            sum += +$(this).val();
        });

        $("#total").val(sum);
        discount = $("#discount").val();
        tax = $("#tax").val();
        tax_amount = ((+sum - +discount) * +tax) / 100;
        $("#tax_amount").val(tax_amount);
        net_total = (+sum - +discount) + +tax_amount;
        $("#net_total").val(net_total);

        paid_amount = $("#paid_amount").val();

        $("#due_amount").val(+net_total - +paid_amount);
    }
</script>
@endsection
