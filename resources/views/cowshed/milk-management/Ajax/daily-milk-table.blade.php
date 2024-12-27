
<table class="table table-bordered datatable" id="daily-milk-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Customer</th>
            <th>Milk (Litr)</th>
            <th>Address</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($dailyDeliveries) && $dailyDeliveries)
            @foreach($dailyDeliveries as $key => $delivery)
                <tr class="tr-{{ $key + 1 }}">
                    <td>
                        <div class="form-group">
                            <input class="form-control milk_status" type="checkbox" name="milk_status" data-id="{{ $delivery->id }}" id="milkStatus{{$key + 1}}" {{ $delivery->milk > 0 ? 'checked' : '' }} style="width: 20px;">
                        </div>
                    </td>
                    <td>{{ $delivery->customer->name }}</td>
                    <td> <input class="form-control milk-qty" type="text" data-id="{{ $delivery->id }}" value="{{ $delivery->milk }}" id="milk_qty_{{ $key + 1 }}"> </td>
                    <td>{{ $delivery->customer->address }}</td>
                    <td>{{ $delivery->customer->mobile }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
