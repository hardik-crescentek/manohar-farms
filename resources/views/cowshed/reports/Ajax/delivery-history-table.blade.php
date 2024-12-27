
<table class="table table-bordered datatable" id="daily-milk-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Customer</th>
            <th>Milk (Litr)</th>
            <th>Date</th>
            <th>Address</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($deliveries) && $deliveries)
            @foreach($deliveries as $key => $delivery)
                <tr class="tr-{{ $key + 1 }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $delivery->customer->name }}</td>
                    <td> {{ $delivery->milk }} </td>
                    <td> {{ $delivery->date != null ? date('d-m-Y', strtotime($delivery->date)) : ''  }} </td>
                    <td>{{ $delivery->customer->address }}</td>
                    <td>{{ $delivery->customer->mobile }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
