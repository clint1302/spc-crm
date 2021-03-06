@extends('administrator.master')
@section('title', 'Add client')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CLIENTS
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ url('/people/clients') }}">Clients</a></li>
            <li class="active">Add client</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Add client</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <form action="{{ url('people/clients/store') }}" method="post" name="client_add_form">
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
                            <p class="text-yellow">Enter client type details. All field are required. </p>
                            @endif
                        </div>
                        <!-- /.Notification Box -->

                        <div class="col-md-6">
                            <label for="name">Client Name <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Enter name..">
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="spc_client_sex">Sex </label>
                            <div class="form-group has-feedback">
                                <select name="spc_client_sex" id="spc_client_sex" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <!-- /.form-group -->

                            <label for="email">Email</label>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Enter email address..">
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="email_no_two">Email 2</label>
                            <div class="form-group{{ $errors->has('email_no_two') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="email_no_two" id="email_no_two" class="form-control" value="{{ old('email_no_two') }}" placeholder="Optional..">
                                @if ($errors->has('email_no_two'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email_no_two') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="contact_no_one">Contact No<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('contact_no_one') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="contact_no_one" id="contact_no_one" class="form-control" value="{{ old('contact_no_one') }}" placeholder="Enter contact no..">
                                @if ($errors->has('contact_no_one'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_no_one') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="spc_pest">Pest<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('spc_pest') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="spc_pest" id="spc_pest" class="form-control" value="{{ old('spc_pest') }}" placeholder="Enter pest type..">
                                @if ($errors->has('spc_pest'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('spc_pest') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <!--<label for="web">Web</label>
                            <div class="form-group{{ $errors->has('web') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="web" id="web" class="form-control" value="{{ old('web') }}" placeholder="Enter web..">
                                @if ($errors->has('web'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('web') }}</strong>
                                </span>
                                @endif
                            </div>-->
                            <!-- /.form-group -->

                           <!-- <label for="gender">Gender <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} has-feedback">
                                <select name="gender" id="gender" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    <option value="m">Male</option>
                                    <option value="f">Female</option>
                                </select>
                                @if ($errors->has('gender'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                                @endif
                            </div>-->
                            <!-- /.form-group -->

                            <!--<label for="datepicker">Date of Birth</label>
                            <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }} has-feedback">
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="date_of_birth" class="form-control pull-right" value="{{ old('date_of_birth') }}" id="datepicker">
                                </div>
                                @if ($errors->has('date_of_birth'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_of_birth') }}</strong>
                                </span>
                                @endif
                            </div>-->
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <div class="col-md-6">
                            
                            <label for="spc_update">Update<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('spc_update') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="spc_update" id="spc_update" class="form-control" value="{{ old('spc_update') }}" placeholder="Enter update type..">
                                @if ($errors->has('spc_update'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('spc_update') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->


                            <label for="present_address">Address<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('present_address') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="present_address" id="present_address" class="form-control" value="{{ old('present_address') }}" placeholder="Enter address..">
                                @if ($errors->has('present_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('present_address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="spc_contactpersoon">Contact Persoon</label>
                            <div class="form-group{{ $errors->has('spc_contactpersoon') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="spc_contactpersoon" id="spc_contactpersoon" class="form-control" value="{{ old('spc_contactpersoon') }}" placeholder="Enter contact persoon..">
                                @if ($errors->has('spc_contactpersoon'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('spc_contactpersoon') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="spc_serviceadres">Service Address</label>
                            <div class="form-group{{ $errors->has('spc_serviceadres') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="spc_serviceadres" id="spc_serviceadres" class="form-control" value="{{ old('spc_serviceadres') }}" placeholder="Enter service address..">
                                @if ($errors->has('spc_serviceadres'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('spc_serviceadres') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="client_type_id">Client Type <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('client_type_id') ? ' has-error' : '' }} has-feedback">
                                <select name="client_type_id" id="client_type_id" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    @foreach($client_types as $client_type)
                                    <option value="{{ $client_type['id'] }}">{{ $client_type['client_type'] }} - {{ $client_type['client_type_description'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('client_type_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('client_type_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="datepicker">Enquiry Date<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('spc_date') ? ' has-error' : '' }} has-feedback">
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="spc_date" class="form-control pull-right" value="{{ old('spc_date') }}" id="datepicker">
                                </div>
                                @if ($errors->has('spc_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('spc_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="enquiry_type_id">Enquiry Source <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('enquiry_type') ? ' has-error' : '' }} has-feedback">
                                <select name="enquiry_type_id" id="enquiry_type_id" class="form-control">
                                    <option value="" selected disabled>Select one</option>
                                    @foreach($enquiry_types as $enquiry_type)
                                    <option value="{{ $enquiry_type['id'] }}">{{ $enquiry_type['enquiry_type_title'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('enquiry_type_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('enquiry_type_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ url('/people/clients') }}" class="btn btn-danger btn-flat"><i class="icon fa fa-close"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="icon fa fa-plus"></i> Add client</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">

    //document.forms['client_add_form'].elements['gender'].value = "{{ old('gender') }}";
    document.forms['client_add_form'].elements['client_type_id'].value = "{{ old('client_type_id') }}";
    document.forms['client_add_form'].elements['spc_date'].value = "{{ old('spc_date') }}";
    //document.forms['client_add_form'].elements['designation_id'].value = "{{ old('designation_id') }}";
</script>
@endsection
