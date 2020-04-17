@extends('administrator.master')
@section('title', 'SMS Setting')

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            SMS SETTING
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a>Setting</a></li>
            <li><a href="{{ url('/setting/sms-setting') }}">SMS Setting</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Edit SMS Setting</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <form action="{{ url('/setting/sms-setting/update/'. $sms_setting->id) }}" method="post" name="sms_setting_edit_form">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="row">
                        <!-- Notification Box -->
                        <div class="col-md-8 col-md-offset-2">
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

                        <div class="col-md-8 col-md-offset-2">
                            <label for="sms_from">SMS From <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('sms_from') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="sms_from" id="sms_from" class="form-control" value="{{ $sms_setting->sms_from }}" placeholder="ex: ClusterCode">
                                @if ($errors->has('sms_from'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sms_from') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="api_key">API Key <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('api_key') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="api_key" id="api_key" class="form-control" value="{{ $sms_setting->api_key }}" placeholder="ex: 55ACA57958E3D4">
                                @if ($errors->has('api_key'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('api_key') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="routeid">Route ID <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('routeid') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="routeid" id="routeid" class="form-control" value="{{ $sms_setting->routeid }}" placeholder="ex: 100016">
                                @if ($errors->has('routeid'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('routeid') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="url">URL <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="url" id="url" class="form-control" value="{{ $sms_setting->url }}" placeholder="ex: http://cloud.circlesms.com/app/smsapi/index.php">
                                @if ($errors->has('url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('url') }}</strong>
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
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-primary btn-flat"><i class="icon fa fa-edit"></i> Update Setting</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->


    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">
    document.forms['sms_setting_edit_form'].elements['publication_status'].value = "{{ $sms_setting['publication_status'] }}";
</script>
@endsection
