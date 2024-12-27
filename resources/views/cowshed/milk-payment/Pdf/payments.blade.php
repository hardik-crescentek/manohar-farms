<!-- resources/views/pdf/table.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-header {
            width: 100%;
            border-collapse: collapse;
        }

        .report-header td {
            border: 0px solid #000;
            /* Add borders as needed */
        }

        .left-container,
        .right-container {
            vertical-align: top;
            /* Align contents at the top */
        }

        .left-container p,
        .right-container p {
            margin: 0;
            /* Remove default margins */
        }

        .left-container {
            text-align: left;
        }

        .right-container {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Milk Payment Report</h2>
        <table class="report-header">
            <tr>
                <td class="left-container">
                    @if(isset($month) && isset($year))
                    <p><strong>Date:</strong> {{ $month }} - {{ $year }}</p>
                    @endif
                </td>
                <td class="right-container">
                    @if(isset($totalLitrs))
                    <p><strong>Total Litrs:</strong> {{ $totalLitrs }}</p>
                    @endif
                    @if(isset($totalAmount))
                    <p><strong>Total Amount:</strong> {{ $totalAmount }}</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Milk (Litr)</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($payments) && $payments)
                @foreach($payments as $key => $payment)
                    <tr class="tr-{{ $key + 1 }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $payment->customer->name }}</td>
                        <td>
                            @if(isset($payment->status) && $payment->status == 1)
                            <p class="badge badge-success">Paid</p>
                            @else
                            <p class="badge badge-warning">Unpaid</p>
                            @endif
                        </td>
                        <td>{{ $payment->milk }}</td>
                        <td>{{ $payment->amount }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</body>

</html>