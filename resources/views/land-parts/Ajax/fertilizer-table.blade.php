<table class="table table-bordered datatable" id="fertilizer-entries-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fertilizer</th>
            <th>Date</th>
            <th>Time</th>
            <th>QTY</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($fertilizerEntries) && !$fertilizerEntries->isEmpty())
        @foreach($fertilizerEntries as $key => $item)
        <tr class="tr-{{$item->id}}">
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->fertilizer_name }}</td>
            <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
            <td>{{ date('h:i A', strtotime($item->time)) }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->remarks }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>