<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clients Report</title>

    <style type="text/css">
    table {
        border-collapse: collapse
    }
    table, th, td {
        border: 1px solid black
    }
    th {
        padding: 6px 15px; font-size: 14px
    }
    td {
        padding: 6px 15px; font-size: 14px
    }
    container {
        page-break-after: always
    }
    .header {
        position: fixed; top: 0px; margin: 100px 0px
    }
    .footer {
        position: fixed; bottom: 0px
    }
    .pagenum:before {content: counter(page);}
    @page {
   size: 29.7cm 21cm;
   margin-top: 1.27cm;
   margin-left: 1.27cm;
   margin-right: 1.27cm;
}
</style>

</head>
<body>
    <div class="header">
        <img src="{{ url('public/backend/img/spc_logo.png') }}">
    </div>
    <div class="footer"><p style="font-size: 14px;">Page: <span class="pagenum"></span></p></div>
    <div class="container">
         <table width="100%">
            <thead>
                <tr>
                    <th>SL#</th>
                    <th>Client Name</th>
                    <th>Client Type</th>
                    <th>Contract Type</th>
                    <th>Contact No</th>
                    <th>Address</th>
                    <th class="text-center">Enquiry Date</th>
                    <th class="text-center">Enquiry Year</th>
                    <th class="text-center">Sold Date</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                    <div style="display:none;">{{ $sl = 1 }}</div>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $client['name'] }}</td>
                        <td><a data-toggle="tooltip" data-placement="right" title="{{ $client['client_type_description'] }}">{{ $client['client_type'] }}</a></td>
                        <td>{{ $client['contract'] }}</td>
                        <td>{{ $client['contact_no_one'] }}</td>
                        <td>{{ $client['present_address'] }}</td>
                        <td class="text-center">
                        @if ($client['spc_date'] != "")
                        {{ $client['spc_date'] }}
                        @endif
                        </td>
                        <td class="text-center">
                        @if ($client['spc_eyear'] != "")
                        {{ $client['spc_eyear'] }}
                        @endif
                        </td>
                        <td class="text-center">
                        @if ($client['spc_sold_date'] != "")
                            {{  \Carbon\Carbon::parse($client['spc_sold_date'])->format('d-M-y') }}
                        @else
                            not yet
                        @endif
                        </td>
                        <td class="text-center">
                            @if ($client['activation_status'] == 1)
                                <a class="btn btn-success btn-xs btn-flat btn-block">Active</i></a>
                            @else
                                <a class="btn btn-warning btn-xs btn-flat btn-block">Deactive</a>
                            @endif
                        </td>
                        
                    </tr>
                    @endforeach
            </tbody>
        </table>

        <div style="margin-top: 100px;">
            <p style="float: left">Prepared By</p>
            <p style="float: right">Date: <br><?php $mytime = Carbon\Carbon::now();
echo $mytime->toDateTimeString(); ?></p>
        </div>
    </div>
</body>
</html>