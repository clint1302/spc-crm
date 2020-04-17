<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Job Report</title>

    <style type="text/css">
    table {
        border-collapse: collapse
    }
    table, th, td {
        border: 1px solid black
    }
    th {
        padding: 3px 6px; font-size: 12px
    }
    td {
        padding: 3px 6px; font-size: 12px
    }
</style>

</head>
<body onload="window.print();" style="padding: 0px; margin: 0px">
    <div class="container">
       <table width="100%">
        <thead>
            <tr>
                <th>SL#</th>
                <th>Client Name</th>
                <th>Contact No</th>
                <th>Address</th>
                <th>Pest</th>
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
                <td>{{ $client['contact_no_one'] }}</td>
                <td>{{ $client['present_address'] }}</td>
                <td>{{ $client['spc_pest'] }}</td>
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