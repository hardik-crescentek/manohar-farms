<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");

        getTable();
    });

    $('.datatable').DataTable({});

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        getTable(startDate, endDate);
    });

    function getTable(startDate, endDate) {

        $.ajax({
            url: "{{ route('cowshed.grass-reports.get-table') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                startDate: startDate,
                endDate: endDate
            },
            success: function(res) {
                $('#grass-container').html(res);
                $('.datatable').DataTable({});
            }
        });
    }

    $(function() {
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

    });
</script>