
<table class="table table-bordered datatable" id="staffs-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Role</th>
            <th>Joindate</th>
            <th>Enddate</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($teamMembers) && $teamMembers)
            @foreach($teamMembers as $key => $member)
                <tr class="tr-{{ $key + 1 }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->role }}</td>
                    <td>{{ date('d-m-Y', strtotime($member->join_date)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($member->end_date)) }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
