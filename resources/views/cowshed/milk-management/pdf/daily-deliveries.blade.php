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
    </style>
</head>

<body>
    <div class="header">
        <h2>Milk Deliveries</h2>
        @if(isset($date))
            <p>Date: {{ $date }}</p>
        @endif
    </div>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Customer</th>
                <th>Milk (Litr)</th>
                <th>Address</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($dailyDeliveries) && $dailyDeliveries)
                @foreach($dailyDeliveries as $key => $delivery)
                    <tr class="tr-{{ $key + 1 }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $delivery->customer->name }}</td>
                        <td>{{ $delivery->milk }}</td>
                        <td>{{ $delivery->customer->address }}</td>
                        <td>{{ $delivery->customer->mobile }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</body>

</html>