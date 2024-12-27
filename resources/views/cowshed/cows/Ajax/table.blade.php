<table class="table table-bordered datatable" id="cows-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Image</th>
            <th>Birthdate</th>
            <th>Tag number</th>
            <th>Mother</th>
            <th>Father</th>
            <th>Grade</th>
            <th>Remark</th>
            <th>Pregnancy details</th>
            <th>Milk (Litr)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if($cows->count() > 0)
        @foreach($cows as $key => $cow)
        <tr class="tr-{{ $key }}">
            <td>{{ $cow->id }}</td>
            <td><a href="{{ route('cowshed.cows.show', $cow->id) }}">{{ $cow->name }}</a></td>
            <td>
                <div class="container-img-holder">
                    <img src="{{ asset('uploads/cows/'.$cow->image) }}" alt="" width="50">
                </div>
            </td>
            <td>{{ isset($cow->date) && $cow->date != null ? date('d-m-Y', strtotime($cow->date)) : '' }}</td>
            <td>{{ $cow->tag_number }}</td>
            <td>{{ $cow->motherName->name ?? '-' }}</td>
            <td>{{ $cow->fatherName->name ?? '-' }}</td>
            <td>{{ $cow->grade ?? '-' }}</td>
            <td>{{ $cow->remark }}</td>
            <td>{{ $cow->children()->count() }}</td>
            <td>{{ $cow->milk }}</td>
            <td>
                <a href="{{ route('cowshed.cows.edit', $cow->id) }}" data-toggle="tooltip" title="Edit">
                    <i class="fa fa-pen text-primary mr-2"></i>
                </a>
                <a href="javascript:;" class="delete-cowshed-cows" data-id="{{ $cow->id }}" data-route="{{ route('cowshed.cows.destroy', $cow->id) }}" data-toggle="tooltip" title="Delete" >
                    <i class="fa fa-trash text-danger"></i>
                </a>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>