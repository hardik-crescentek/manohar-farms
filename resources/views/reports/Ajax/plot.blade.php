<table class="table table-bordered" id="dynamic-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>


            {{-- Fields for Land --}}
            <th>Land Name</th>
            <th>Address</th>
            <th>Plant</th>

            <th>Date</th>
            <th>Time</th>

            {{-- Dynamic fields for other categories --}}
            @if (isset($category) && $category == 'water')
                <th>Volume (L)</th>
                <th>Hours</th>
            @endif

            @if (isset($category) && $category == 'fertilizer')
                <th>Fertilizer</th>
                <th>Quantity</th>
                <th>Remarks</th>
            @endif

            @if (isset($category) && $category == 'jivamrut')
                <th>Size (Liters)</th>
                <th>Barrels</th>
                <th>Remarks</th>
            @endif

        </tr>
    </thead>
    <tbody>
        @if (isset($entries) && !$entries->isEmpty())
            @foreach ($entries as $key => $item)
                <tr class="tr-{{ $item->id }}">
                    <td>{{ $key + 1 }}</td>

                    {{-- Common fields for Land --}}
                    <td>{{ $item->land->name ?? 'N/A' }}</td>
                    <td>{{ $item->land->address ?? 'N/A' }}</td>
                    <td>{{ $item->land->plant->name ?? 'N/A' }}</td>

                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                    <td>{{ date('h:i A', strtotime($item->time)) }}</td>


                    {{-- Dynamic fields for Water --}}
                    @if (isset($category) && $category == 'water')
                        <td>
                            {{ $item->volume ?? 'N/A' }}
                        </td>
                    @endif
                    @if (isset($category) && $category == 'water')
                        <td>
                            {{ $item->hours ?? 'N/A' }}
                        </td>
                    @endif

                    {{-- Dynamic fields for Fertilizer --}}
                    @if (isset($category) && $category == 'fertilizer')
                        <td>
                            {{ $item->fertilizer_name ?? 'N/A' }}
                        </td>
                    @endif
                    @if (isset($category) && $category == 'fertilizer')
                        <td>
                            {{ $item->quantity ?? 'N/A' }}
                        </td>
                    @endif

                    @if (isset($category) && $category == 'fertilizer')
                        <td>
                            {{ $item->remarks ?? 'N/A' }}
                        </td>
                    @endif

                    @if (isset($category) && $category == 'jivamrut')
                        <td>
                            {{ $item->size ?? 'N/A' }}
                        </td>
                    @endif

                    @if (isset($category) && $category == 'jivamrut')
                        <td>
                            {{ $item->barrels ?? 'N/A' }}
                        </td>
                    @endif

                    @if (isset($category) && $category == 'jivamrut')
                        <td>
                            {{ $item->notes ?? 'N/A' }}
                        </td>
                    @endif

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11" class="text-center">No records found</td>
            </tr>
        @endif
    </tbody>
</table>
