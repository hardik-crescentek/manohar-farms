<table class="table table-bordered datatable" id="water-entries-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Time</th>
            <th>Volume (Litr)</th>
            <th>Hours</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($waterEntries) && !$waterEntries->isEmpty())
        @foreach($waterEntries as $key => $item)
        <tr class="tr-{{$item->id}}">
            <td>{{ $key + 1 }}</td>
            <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
            <td>{{ date('h:i A', strtotime($item->time)) }}</td>
            <td>{{ $item->volume }}</td>
            <td>{{ $item->hours }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>