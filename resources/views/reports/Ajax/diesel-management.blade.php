<table class="table table-bordered datatable" id="diesel-management-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Volume (Litr)</th>
            <th>Price</th>
            <th>Total price</th>
            <th>Payment person</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($diesels) && !$diesels->isEmpty())
        @foreach($diesels as $key => $item)
        <tr class="tr-{{$item->id}}">
            <td>{{ $item->id }}</td>
            <td>{{ $item->volume }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->total_price }}</td>
            <td>{{ $item->payment_person }}</td>
            <td>{{ isset($item->date) && $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>