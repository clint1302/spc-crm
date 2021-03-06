<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clients</title>

    <style type="text/css">
    table {
        border-collapse: collapse
    }
    table, th, td {
        border: 1px solid black
    }
    th {
        padding: 6px 15px; font-size: 16px
    }
    td {
        padding: 6px 15px; font-size: 16px
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
   size: 21cm 29.7cm;
   margin-top: 1.27cm;
   margin-left: 1.27cm;
   margin-right: 1.27cm;
}
</style>

</head>
<body>
    <div class="header">
        <img src="{{ url('public/backend/img/logo.png') }}">
    </div>
    <div class="footer"><p style="font-size: 14px;">Page: <span class="pagenum"></span></p></div>
    <div class="container">
        <table width="100%">
        <thead>
            <tr>
                <th>SL#</th>
                <th>Client Name</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>Address</th>
                <th>Pest</th>
                <th>Update</th>
                <th>Contact Persoon</th>
                <th>Service Address</th>
                <th>Client Type</th>
                <th>Enquiry date</th>
            </tr>
        </thead>
        <tbody>
            @php($sl = 1)
            @foreach($clients as $client)
            <tr>
                <td>{{ $sl++ }}</td>
                <td>{{ $client['name'] }}</td>
                <td>{{ $client['email'] }}</td>
                <td>{{ $client['contact_no_one'] }}</td>
                <td>{{ $client['present_address'] }}</td>
                <td>{{ $client['spc_pest'] }}</td>
                <td>{{ $client['spc_update'] }}</td>
                <td>{{ $client['spc_contactpersoon'] }}</td>
                <td>{{ $client['spc_serviceadres'] }}</td>
                <td>{{ $client['client_type'] }} - {{ $client['client_type_description'] }}</td>
                <td>{{ $client['spc_date'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</body>
</html>