<table class="table table-bordered datatable" id="staffs-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Image</th>
            <th>Type</th>
            <th>Role</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Salary</th>
            <th>Joining Date</th>
            <th>Resign Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($staffs) && !$staffs->isEmpty())
        @foreach($staffs as $key => $item)
        <tr class="tr-{{$item->id}}">
            <td>{{ $key + 1 }}</td>
            <td>
                <div class="container-img-holder">
                    <img src="{{ asset('uploads/staffs/'.$item->image) }}" alt="" width="50">
                </div>
            </td>
            <td>{{ $item->type == 1 ? 'Salaried' : 'On demand' }}</td>
            <td>{{ $item->role }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->type == 1 ? $item->salary : $item->rate_per_day }}</td>
            <td>{{ $item->joining_date != null ? date('d-m-Y', strtotime($item->joining_date)) : '' }}</td>
            <td>{{ $item->resign_date != null ? date('d-m-Y', strtotime($item->resign_date)) : '' }}</td>
            <td>
                @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('staffs-edit'))
                <a href="{{ route('cowshed.staffs.edit', $item->id) }}" data-toggle="tooltip" title="Edit"> <i class="fa fa-pen text-primary mr-2"></i> </a>
                @endif
                @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('staffs-delete'))
                <a href="javascript:;" class="delete-staffs" data-id="{{ $item->id }}" data-route="{{ route('cowshed.staffs.destroy', $item->id) }}" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
                @endif
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>