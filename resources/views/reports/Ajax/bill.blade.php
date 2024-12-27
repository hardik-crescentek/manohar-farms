<table class="table table-bordered datatable" id="staffs-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Land</th>
            <th>Type</th>
            <th>Payment person</th>
            <th>Period start</th>
            <th>Period end</th>
            <th>Amount</th>
            <th>Due date</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($bills) && !$bills->isEmpty())
            @foreach($bills as $key => $item)
                <tr class="tr-{{$item->id}}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ isset($item->land->name) ? $item->land->name : '' }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->payment_person }}</td>
                    <td>{{ $item->period_start != null ? date('d-m-Y', strtotime($item->period_start)) : '' }}</td>
                    <td>{{ $item->period_end != null ? date('d-m-Y', strtotime($item->period_end)) : '' }}</td>
                    <td>₹{{ $item->amount }}</td>
                    <td>{{ $item->due_date != null ? date('d-m-Y', strtotime($item->due_date)) : '' }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>