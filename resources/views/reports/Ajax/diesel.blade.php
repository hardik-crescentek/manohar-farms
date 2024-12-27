<table class="table table-bordered datatable" id="diesel-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Vehicle</th>
            <th>Volume (Litr)</th>
            <th>Payment person</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($diesel) && !$diesel->isEmpty())
            @foreach($diesel as $key => $item)
                <tr class="tr-{{$item->id}}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ isset( $item->vehicle->name) ? $item->vehicle->name : '' }}</td>
                    <td>{{ $item->volume }}</td>
                    <td>{{ $item->payment_person }}</td>
                    <td>₹{{ $item->amount }}</td>
                    <td>{{ $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>