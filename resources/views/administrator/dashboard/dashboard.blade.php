@extends('administrator.master')
@section('title', 'Dashboard')

@section('main_content')
<style type="text/css">
.bg-grey{
  background-color: #BDBDBD;
}
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-grey">
          <div class="inner">
            <p style="margin-bottom:6px;font-size:16px;"><strong>Active Clients:</strong> <u>{{ count($clients_active) }}</u></p>
            <p style="margin-bottom:6px;font-size:16px;"><strong>Deactive Clients:</strong> <u>{{ count($clients_deactive) }}</u></p>
            <p style="margin-bottom:6px;font-size:16px;"><strong>Total Clients:</strong> <u>{{ count($clients) }}</u></p>
            <!--<p>Clients</p>-->
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          @permission('manage-clients')
          <a href="{{ url('/people/clients') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          @endpermission
        </div>
      </div>

      <!-- ./col 
      <div class="col-lg-3 col-xs-6">
         small box 
        <div class="small-box bg-grey">
          <div class="inner">
            <h3>{{ count($references) }}</h3>

            <p>References</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          <a href="{{ url('/people/references') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>-->

      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-grey">
          <div class="inner">
            <h3>{{ count($employees) }}</h3>

            <p>Employees</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          @permission('manage-team')
          <a href="{{ url('/people/employees') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          @endpermission
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-grey">
          <div class="inner">
            <p style="margin-bottom:6px;font-size:16px;"><strong>Active Jobs:</strong> <u>{{ count($jobs_active) }}</u></p>
            <p style="margin-bottom:6px;font-size:16px;"><strong>Deactive Jobs:</strong> <u>{{ count($jobs_deactive) }}</u></p>
            <p style="margin-bottom:6px;font-size:16px;"><strong>Total Jobs:</strong> <u>{{ count($jobs) }}</u></p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          @permission('manage-jobs')
          <a href="{{ url('/jobs') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          @endpermission
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- ./row -->

@if(count($notes) > 0)
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title"><strong>Reminder</strong></h3>

        <!--<div class="box-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

            <div class="input-group-btn">
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>-->

      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <tr>
            <th>SL#</th>
            <th>Follow up date</th>
            <th>Follow up time</th>
            <th>Job Name</th>
            <th>Client</th>
            <th>Contact No</th>
            <th>Note</th>
            <th>Created by</th>
          </tr>
          @php($sl = 1)
          @foreach($notes as $note)
            <tr>
              <td>{{ $sl++ }}</td>
              <td><span class="label label-primary">{{date("d F Y", strtotime($note->remind_date))}}</span></td>
              <td>{{ $note->remind_time }}</td>
              <td><a href="{{ url('jobs/details/' . $note->id) }}">{{ $note->name_of_account }}</a></td>
              <td>{{ $note->name }}</td>
              <td><span class="label label-success">{{ $note->contact_no_one }}</span></td>
              <td><span class="label label-warning">{{ $note->note }}</span></td>
              <td>{{ $note->createdby }}</td>
            </tr>
          @endforeach
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
    @endif

    <!--@if(count($next_payment_dates)>0)
    <div class="box box-danger">
      <div class="box-header">
        <h3 class="box-title">Next Payment Dates</h3>

        <div class="box-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

            <div class="input-group-btn">
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      /.box-header 
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <tr>
            <th>SL#</th>
            <th>Reg No</th>
            <th>Name of account</th>
            <th>Client</th>
            <th>Contact No</th>
            <th>Next Payment Date</th>
          </tr>
          @php($sl = 1)
          @foreach($next_payment_dates as $next_payment_date)
          <tr>
            <td>{{ $sl++ }}</td>
            <td><span class="label label-primary">{{ $next_payment_date->id }}</span></td>
            <td><a href="{{ url('jobs/details/' . $next_payment_date->id) }}">{{ $next_payment_date->name_of_account }}</a></td>
            <td>{{ $next_payment_date->name }}</td>
            <td><span class="label label-success">{{ $next_payment_date->contact_no_one }}</span></td>
            <td><span class="label label-warning">{{ date("d F Y", strtotime($next_payment_date->next_payment_date)) }}</span></td>
          </tr>
          @endforeach
        </table>
      </div>
      /.box-body
    </div>
    /.box 
    @endif-->

    </section>
    <!-- /.content -->
  </div>
  @endsection