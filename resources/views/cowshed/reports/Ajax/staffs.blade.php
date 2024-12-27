<table class="table table-bordered datatable" id="staffs-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Role</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Salary</th>
            <th>Joining Date</th>
            <th>Resign Date</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($staffs) && !$staffs->isEmpty())
        @foreach($staffs as $key => $item)
        <tr class="tr-{{$item->id}}">
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->type == 1 ? 'Salaried' : 'On demand' }}</td>
            <td>{{ $item->role }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->type == 1 ? $item->salary : $item->rate_per_day }}</td>
            <td>{{ $item->joining_date != null ? date('d-m-Y', strtotime($item->joining_date)) : '' }}</td>
            <td>{{ $item->resign_date != null ? date('d-m-Y', strtotime($item->resign_date)) : '' }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>