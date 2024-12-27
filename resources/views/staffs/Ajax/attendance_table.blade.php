
<div class="row">
    <div class="col-lg-4">
        @if(isset($leader) && $leader != null)
        <div class="form-group">
            <strong class="filter-detail-label">Leader:</strong>
            <p class="filter-detail-value">{{ $leader->name }}</p>
        </div>
        @endif
        @if(isset($date) && $date != null)
            <div class="form-group">
                <strong class="filter-detail-label">Attendance Date:</strong>
                <p class="filter-detail-value">{{ date('d-m-Y', strtotime($date)) }}</p>
            </div>
        @endif
        @if(isset($type) && $type != null)
            <div class="form-group">
                <strong class="filter-detail-label">Type:</strong>
                <p class="filter-detail-value">
                    @if($type == 1)
                        Salaried
                    @endif
                    @if($type == 2)
                        On demand
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@if ($dailyAttendances->isNotEmpty())
    <table class="table table-bordered datatable" id="staffs-table" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Staff Name</th>
                <th>Staff Member Name</th>
                <th>Role</th>
                <th>Join Date</th>
                <th>End Date</th>
                <th>Attendance Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailyAttendances as $key => $attendance)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        @if ($attendance->staff)
                            {{ $attendance->staff->name }}
                        @else
                            No Staff Assigned
                        @endif
                    </td>
                    <td>
                        @if ($attendance->staffMember)
                            {{ $attendance->staffMember->name }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($attendance->staffMember)
                            {{ $attendance->staffMember->role }}
                        @elseif($attendance->staff)
                            {{ $attendance->staff->role }}
                        @else
                            No Role Assigned
                        @endif
                    </td>
                    <td>
                        @if ($attendance->staffMember)
                            {{ $attendance->staffMember->join_date ? $attendance->staffMember->join_date->format('d-m-Y') : '' }}
                        @elseif($attendance->staff)
                            {{ $attendance->staff->join_date ? $attendance->staff->join_date->format('d-m-Y') : '' }}
                        @else

                        @endif
                    </td>
                    <td>
                        @if ($attendance->staffMember)
                            {{ $attendance->staffMember->end_date ? $attendance->staffMember->end_date->format('d-m-Y') : 'Present' }}
                        @elseif($attendance->staff)
                            {{ $attendance->staff->end_date ? $attendance->staff->end_date->format('d-m-Y') : 'Present' }}
                        @else
                            
                        @endif
                    </td>
                    <td>
                        <div class="form-group">
                            <select class="form-control attendance-status" name="status" id="status_{{ $attendance->id }}" data-attendance-id="{{ $attendance->id }}">
                                <option value="0" {{ $attendance->status == 0 ? 'selected' : '' }}>Present</option>
                                <option value="1" {{ $attendance->status == 1 ? 'selected' : '' }}>On Leave</option>
                                <option value="2" {{ $attendance->status == 2 ? 'selected' : '' }}>Half Day</option>
                            </select>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No attendance records found for this date and leader.</p>
@endif