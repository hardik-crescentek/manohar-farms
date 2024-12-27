<table class="table table-bordered datatable" id="expense-table" style="width:100%">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Payment person</th>
            <th>Date</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($infrastructures) && !$infrastructures->isEmpty())
        @foreach($infrastructures as $key => $item)
        <tr class="tr-{{$item->id}}">
            <td>
                <div class="container-img-holder">
                    <img src="{{ asset('uploads/infrastructures/'.$item->image) }}" alt="" width="50">
                </div>
            </td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->payment_person }}</td>
            <td>{{ isset($item->date) && $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
            <td>{{ $item->amount }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>