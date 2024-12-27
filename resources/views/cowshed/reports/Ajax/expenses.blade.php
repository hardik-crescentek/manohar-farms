<table class="table table-bordered datatable" id="staffs-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($expenses) && !$expenses->isEmpty())
            @foreach($expenses as $key => $item)
                <tr class="tr-{{$item->id}}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>₹{{ $item->amount }}</td>
                    <td>{{ $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>