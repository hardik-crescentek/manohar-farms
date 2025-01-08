<script>
    $(document).ready(function() {
        // Hide the loader initially
        $("#global-loader").fadeOut("slow");

        // Load the table without filters
        getTable();

        // Initialize the DataTable
        $('.datatable').DataTable();

        // Apply the date range filter
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            var startDate = picker.startDate.format('YYYY-MM-DD');
            var endDate = picker.endDate.format('YYYY-MM-DD');
            getTable(startDate, endDate);
        });
    });

    // Function to fetch table data via AJAX
    function getTable(startDate = null, endDate = null) {
        $.ajax({
            url: "{{ route('total-expenses-reports.get-table') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                startDate: startDate,
                endDate: endDate
            },
            success: function(res) {
                // Replace table content dynamically
                $('#total-expenses-container').html(res);

                // Reinitialize the DataTable for the updated content
                $('.datatable').DataTable();
            },
            error: function() {
                alert('Error fetching data. Please try again.');
            }
        });
    }

    // Initialize the date range picker
    $(function() {
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    });
</script>
