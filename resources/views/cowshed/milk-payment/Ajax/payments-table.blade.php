<table class="table table-bordered datatable" id="milk-payment-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Image</th>
            <th>Customer</th>
            <th>Milk (Litr)</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($payments) && $payments)
            @foreach($payments as $key => $payment)
                <tr class="tr-{{ $key + 1 }}">
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <div class="container-img-holder">
                            <img src="{{ asset('uploads/payments/'.$payment->image) }}" alt="" width="50">
                        </div>
                    </td>
                    <td>{{ $payment->customer->name }}</td>
                    <td>{{ $payment->milk }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>
                        <span class="status-badge" data-id="{{ $payment->id }}" data-status="{{ $payment->status }}">
                            @if($payment->status == 1)
                                <span class="badge badge-success">Paid</span>
                            @else
                                <span class="badge badge-warning">Unpaid</span>
                            @endif
                        </span>
                    </td>
                    <td>
                        <input type="file" name="image" class="image-upload" data-payment-id="{{ $payment->id }}" accept="image/*">
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>