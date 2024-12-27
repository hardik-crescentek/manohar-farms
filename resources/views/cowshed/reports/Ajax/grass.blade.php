<table class="table table-bordered datatable" id="grass-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>type</th>
            <th>Volume (Kg)</th>
            <th>Amount</th>
            <th>Payment person</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($grass as $item)
        <tr class="tr-{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>{{ $item->type }}</td>
            <td>{{ $item->volume }}</td>
            <td>{{ $item->amount }}</td>
            <td>{{ $item->payment_person }}</td>
            <td>{{ isset($item->date) && $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>