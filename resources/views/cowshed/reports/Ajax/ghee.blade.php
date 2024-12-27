<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <strong class="filter-detail-label">Total Litrs:</strong>
            <p class="filter-detail-value">{{ $totalLitrs }}</p>
        </div>
    </div>
</div>
@if ($ghee->isNotEmpty())
<table class="table table-bordered datatable" id="ghee-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Ghee (Litr)</th>
            <th>Milk (Litr)</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ghee as $item)
        <tr class="tr-{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>{{ $item->ghee }}</td>
            <td>{{ $item->milk }}</td>
            <td>{{ isset($item->date) && $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No records found for this filter.</p>
@endif