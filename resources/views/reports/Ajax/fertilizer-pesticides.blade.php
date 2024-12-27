<table class="table table-bordered datatable" id="fertilizer-pesticides-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($fertilizerPesticides) && !$fertilizerPesticides->isEmpty())
        @foreach($fertilizerPesticides as $key => $item)
        <tr class="tr-{{$item->id}}">
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ isset($item->date) && $item->date != NULL ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>