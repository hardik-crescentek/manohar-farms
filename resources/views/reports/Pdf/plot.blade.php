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

        .report-header td {
            border: none;
            text-align: left;
            vertical-align: top;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>{{ ucfirst($category) }} Report</h2>
        <table class="report-header">
            <tr>
                <td>
                    @if ($from)
                        <p><strong>From:</strong> {{ $from }}</p>
                    @endif
                    @if ($to)
                        <p><strong>To:</strong> {{ $to }}</p>
                    @endif
                </td>
                <td style="text-align: right;">
                    @if ($landDetail)
                        <p><strong>Land:</strong> {{ $landDetail->name }}</p>
                    @endif
                    @if (isset($total))
                        <p><strong>Total:</strong> {{ $total }}</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Land Name</th>
                <th>Address</th>
                <th>Plant</th>
                <th>Date</th>
                <th>Time</th>
                @if ($category === 'water')
                    <th>Volume (L)</th>
                    <th>Hours</th>
                @elseif ($category === 'fertilizer')
                    <th>Fertilizer</th>
                    <th>Quantity</th>
                    <th>Remarks</th>
                @elseif ($category === 'jivamrut')
                    <th>Size (Liters)</th>
                    <th>Barrels</th>
                    <th>Remarks</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($entries as $item)
                <tr>
                    <td>{{ $item->land->name ?? 'N/A' }}</td>
                    <td>{{ $item->land->address ?? 'N/A' }}</td>
                    <td>{{ $item->land->plant->name ?? 'N/A' }}</td>
                    <td>{{ $item->date ? date('d-m-Y', strtotime($item->date)) : 'N/A' }}</td>
                    <td>{{ $item->time ? date('h:i A', strtotime($item->time)) : 'N/A' }}</td>
                    @if ($category === 'water')
                        <td>{{ $item->volume ?? 'N/A' }}</td>
                        <td>{{ $item->hours ?? 'N/A' }}</td>
                    @elseif ($category === 'fertilizer')
                        <td>{{ $item->fertilizer_name ?? 'N/A' }}</td>
                        <td>{{ $item->quantity ?? 'N/A' }}</td>
                        <td>{{ $item->remarks ?? 'N/A' }}</td>
                    @elseif ($category === 'jivamrut')
                        <td>{{ $item->size ?? 'N/A' }}</td>
                        <td>{{ $item->barrels ?? 'N/A' }}</td>
                        <td>{{ $item->notes ?? 'N/A' }}</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
