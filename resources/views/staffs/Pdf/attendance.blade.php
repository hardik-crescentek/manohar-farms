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
        <h2>Attendance Report</h2>
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
                    @if(isset($leader))
                        <p><strong>Leader:</strong> {{ $leader->name }}</p>
                        @if($leader->type == 1)
                            <p><strong>Salary:</strong> {{ $leader->salary }}</p>
                        @endif
                        @if($leader->type == 2)
                            <p><strong>Salary/day:</strong> {{ $leader->rate_per_day }}</p>
                        @endif
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
                <th>Date / Employee</th>
                @foreach ($members as $member)
                <th>{{ $member->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($dates as $date)
            <tr>
                <td>{{ isset($date) && $date != null ? date('d-m-Y', strtotime($date)) : '' }}</td>
                @foreach ($members as $member)
                    @php
                        $status[0] = 'present';
                        $status[1] = 'leave';
                        $status[2] = 'half-day';

                        $currentStatus = $attendanceData[$date][$member->id] ?? null;
                    @endphp
                    <td>
                        {{ $status[$currentStatus] ?? '' }}
                    </td>
                @endforeach
            </tr>
            @endforeach
            <tr>
                <td><strong>Total</strong></td>
                @foreach ($members as $member)
                    <td><strong>{{ isset($staffTotal[$member->id]) ? number_format($staffTotal[$member->id]) : 0 }}</strong></td>
                @endforeach
            </tr>
        </tbody>
    </table>

</body>

</html>