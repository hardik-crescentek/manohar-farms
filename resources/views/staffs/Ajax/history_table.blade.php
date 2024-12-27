<table class="table table-bordered datatable" width="100%">
    <thead>
        <tr>
            <th>Employee</th>
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
                    <td>
                        @php
                            $status[0] = 'present';
                            $status[1] = 'leave';
                            $status[2] = 'half-day';

                            $currentStatus = $attendanceData[$date][$member->id] ?? null;
                        @endphp
                        {{ $status[$currentStatus] ?? '' }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
