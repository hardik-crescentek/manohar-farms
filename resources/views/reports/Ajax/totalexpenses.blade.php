<div id="total-expenses-container">
    <table class="table table-bordered datatable" id="expenses-table" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                @foreach($expenses as $expense)
                    <td>₹{{ number_format($expense) }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>
