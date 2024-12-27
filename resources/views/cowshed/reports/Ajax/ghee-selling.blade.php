<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <strong class="filter-detail-label">Total Litrs:</strong>
            <p class="filter-detail-value">{{ $totalLitrs }}</p>
        </div>
        <div class="form-group">
            <strong class="filter-detail-label">Total Amount:</strong>
            <p class="filter-detail-value">{{ $totalAmount }}</p>
        </div>
    </div>
</div>
@if ($gheeSellings->isNotEmpty())
<table class="table table-bordered datatable" id="ghee-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Image</th>
            <th>Customer</th>
            <th>Quantity (Litr)</th>
            <th>Price</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gheeSellings as $item)
        <tr class="tr-{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>
                <div class="container-img-holder">
                    <img src="{{ asset('uploads/ghee/'.$item->image) }}" alt="" width="50">
                </div>
            </td>
            <td>{{ isset($item->customer->name) ? $item->customer->name : $item->customer_name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->total }}</td>
            <td>{{ isset($item->date) && $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No records found for this filter.</p>
@endif