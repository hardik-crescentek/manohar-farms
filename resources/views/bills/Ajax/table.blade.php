<table class="table table-bordered datatable" id="bills-table" style="width:100%">
    <thead>
        <tr>
            <th>Image</th>
            <th>Type</th>
            <th>Payment person</th>
            <th>Land</th>
            <th>Period start</th>
            <th>Period end</th>
            <th>Amount</th>
            <th>Due date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($bills) && !$bills->isEmpty())
        @foreach($bills as $key => $item)
        <tr class="tr-{{$item->id}}">
            <td>
                <div class="container-img-holder">
                    <img src="{{ asset('uploads/bills/'.$item->image) }}" alt="" width="50">
                </div>
            </td>
            <td>{{ $item->type }}</td>
            <td>{{ $item->payment_person }}</td>
            <td>{{ isset($item->land->name) ? $item->land->name : '' }}</td>
            <td>{{ $item->period_start != null ? date('d-m-Y', strtotime($item->period_start)) : '' }}</td>
            <td>{{ $item->period_end != null ? date('d-m-Y', strtotime($item->period_end)) : '' }}</td>
            <td>{{ $item->amount }}</td>
            <td>{{ $item->due_date != null ? date('d-m-Y', strtotime($item->due_date)) : '' }}</td>
            <td>{{ $item->status == 1 ? 'Paid' : 'Unpaid' }}</td>
            <td>
                @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('bills-edit'))
                <a href="{{ route('bills.edit', $item->id) }}" data-toggle="tooltip" title="Edit"> <i class="fa fa-pen text-primary mr-2"></i> </a>
                @endif
                @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('bills-delete'))
                <a href="javascript:;" class="delete-bills" data-id="{{ $item->id }}" data-route="{{ route('bills.destroy', $item->id) }}" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
                @endif
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>