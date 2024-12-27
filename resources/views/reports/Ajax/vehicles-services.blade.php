<table class="table table-bordered datatable" id="vehicles-services-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Service</th>
            <th>Price</th>
            <th>Remark</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($vehicleServices) && !$vehicleServices->isEmpty())
        @foreach($vehicleServices as $key => $item)
        <tr class="tr-{{$item->id}}">
            <td>{{ $key + 1 }}</td>
            <td> {{ $item->service }} </td>
            <td> {{ $item->price }} </td>
            <td> {{ $item->note }} </td>
            <td>{{ isset($item->date) && $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>