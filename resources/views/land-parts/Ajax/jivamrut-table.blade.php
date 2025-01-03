<table class="table table-bordered datatable" id="jivamrut-entries-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Time</th>
            <th>Size (Liters)</th>
            <th>Barrels</th>
            {{-- <th>Volume (Liters)</th> --}}
            <th>Person</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($jivamrutEntries) && !$jivamrutEntries->isEmpty())
            @foreach($jivamrutEntries as $key => $item)
                <tr class="tr-{{$item->id}}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                    <td>{{ date('h:i A', strtotime($item->time)) }}</td>
                    <td>{{ $item->size }}</td>
                    <td>{{ $item->barrels }}</td>
                    {{-- <td>{{ $item->volume }}</td> --}}
                    <td>{{ $item->person }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">No entries found.</td>
            </tr>
        @endif
    </tbody>
</table>
