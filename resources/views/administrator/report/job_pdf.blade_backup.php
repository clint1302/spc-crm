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
        <img src="{{ url('public/backend/img/logo.png') }}">
    </div>
    <div class="footer"><p style="font-size: 14px;">Page: <span class="pagenum"></span></p></div>
    <div class="container">
         <table width="100%">
            <thead>
                    <tr>
                        <th>SL#</th>
                        <th>Name of Account</th>
                        <th>Client</th>
                        <th>Reference</th>
                        <th>Assign To</th>
                        <th>Net Payable</th>
                        <th>Due Amount</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php ($sl = 1)
                    @foreach($jobs as $job)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $job->name_of_account }}</td>
                        <td>
                            @foreach($users as $user)
                            @if($job->client == $user->id)
                            {{ $user->name }}
                            @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($users as $user)
                            @if($job->reference_by == $user->id)
                            {{ $user->name }}
                            @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($users as $user)
                            @if($job->assign_to == $user->id)
                            {{ $user->name }}
                            @endif
                            @endforeach
                        </td>

                        @php($total_payable_amount = number_format(0, 2))
                        @foreach($total_payables as $total_payable)
                        @if($job->id == $total_payable->job_id)
                        @php($total_payable_amount = $total_payable->total_payable_amount)
                        @endif
                        @endforeach

                        @php($total_discount_amount = number_format(0, 2))
                        @foreach($total_discounts as $total_discount)
                        @if($job->id == $total_discount->job_id)
                        @php($total_discount_amount = $total_discount->total_discount_amount)
                        @endif
                        @endforeach


                        @php($total_tax_amount = number_format(0, 2))
                        @foreach($total_payables as $total_payable)
                        @if($job->id == $total_payable->job_id)
                        @php($total_tax_amount = $total_payable->total_tax_amount)
                        @endif
                        @endforeach
                        <td>
                            @php($net_payable = $total_tax_amount + ($total_payable_amount - $total_discount_amount))
                            @if(!empty($net_payable))
                            {{ $net_payable }} /=
                            @else
                            0.00 /=
                            @endif
                        </td>

                        @php($total_installment_amount = number_format(0, 2))
                        @foreach($total_installments as $total_installment)
                        @if($job->id == $total_installment->job_id)
                        @php($total_installment_amount = $total_installment->total_installment_amount)
                        @endif
                        @endforeach

                        <td>
                            @php($due_amount = $net_payable - $total_installment_amount)
                            @if(!empty($due_amount))
                            {{ $due_amount }} /=
                            @else
                            0.00 /=
                            @endif
                        </td>
                        <td>
                            @if($job->job_status == 1)
                            Completed
                            @else
                            On Going
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </table>

        <div style="margin-top: 100px;">
            <p style="float: left">Prepared By</p>
            <p style="float: right">Authorised Signature</p>
        </div>
    </div>
</body>
</html>