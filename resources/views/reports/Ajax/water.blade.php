<table class="table table-bordered datatable" id="staffs-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Land</th>
            <th>Source</th>
            <th>Price</th>
            <th>Volume (Litr)</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($water) && !$water->isEmpty())
            @foreach($water as $key => $item)
                <tr class="tr-{{$item->id}}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ isset($item->land->name) ? $item->land->name : '' }}</td>
                    <td>{{ $item->source }}</td>
                    <td>₹{{ $item->price }}</td>
                    <td>{{ $item->volume }}</td>
                    <td>{{ $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>