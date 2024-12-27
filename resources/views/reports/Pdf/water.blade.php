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
        <h2>Water Report</h2>
        <table class="report-header">
            <tr>
                <td class="left-container">
                    @if(isset($from))
                    <p><strong>From date:</strong> {{ $from }}</p>
                    @endif
                    @if(isset($to))
                    <p><strong>To date:</strong> {{ $to }}</p>
                    @endif
                </td>
                <td class="right-container">
                    @if(isset($landDetail))
                        <p>Land: {{ $landDetail->name }}</p>
                    @endif
                    @if(isset($total))
                        <p><strong>Total:</strong> {{ number_format($total) }}</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <table>
        <thead>
            <tr>
                <th>Land</th>
                <th>Source</th>
                <th>Volume (Litr)</th>
                <th>Date</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($water) && !$water->isEmpty())
            @foreach($water as $key => $item)
            <tr>
                <td>{{ isset($item->land->name) ? $item->land->name : '' }}</td>
                <td>{{ $item->source }}</td>
                <td>{{ $item->volume }}</td>
                <td>{{ $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
                <td>{{ $item->price }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

</body>

</html>