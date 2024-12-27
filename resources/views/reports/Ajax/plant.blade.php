<table class="table table-bordered datatable" id="plant-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Image</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Nursery</th>
            <th>Price</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($plants) && !$plants->isEmpty())
        @foreach($plants as $key => $plant)
        <tr class="tr-{{$plant->id}}">
            <td>{{ $plant->id }}</td>
            <td> <img src="{{ asset('uploads/plants/'.$plant->image) }}" alt="" width="50"></td>
            <td>{{ $plant->name }}</td>
            <td>{{ $plant->quantity }}</td>
            <td>{{ $plant->nursery }}</td>
            <td>{{ $plant->price }}</td>
            <td>{{ isset($plant->date) && $plant->date != null ? date('d-m-Y', strtotime($plant->date)) : '' }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>