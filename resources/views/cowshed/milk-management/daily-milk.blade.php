@extends('cowshed.layouts.master')
@section('css')
<!-- Internal DataTables css-->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />

<!-- Internal Sweet-Alert css-->
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Daily milk Delivery</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daily milk Delivery</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

@include('common.alerts')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <form method="POST" action="{{ route('cowshed.daily-milk.get-delivery-pdf') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mg-b-20 mt-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="datepicker" name="date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <button type="submit" class="btn btn-success" id="download-pdf">Download Pdf</button>
                        </div>
                        <div class="col-md-4 mt-4 row form-group">
                            <label for="milk">InHouse Milk(LTR) Used <span class="text-danger">*</span></label>
                            <div class="form-group ml-5">
                                <input type="text" class="form-control" id="milk" name="milk" required>
                            </div>
                        </div>
                        <div class="col-md-1 mt-4">
                            <button type="button" class="btn btn-success" id="save_entry">Save Entry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="table-responsive" id="milk-container">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
@endsection
@section('script')
<!-- Internal Data Table js -->
<script src="{{URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>

<!-- Internal Sweet-Alert js-->
<script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");

        $('.fc-datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            defaultDate: 0, // Set defaultDate to 0 for today
            maxDate: 0,
            onSelect: function(selectedDate) {
                // This function will be called when a date is selected
                // You can use selectedDate here to perform any action
                console.log('Selected date:', selectedDate);
                
                getDailyMilkTable();
            }
        });

        $('.fc-datepicker').datepicker('setDate', new Date());

        getDailyMilkTable();
    });

    $('.datatable').DataTable({
        // scrollX: true
    });

    function getDailyMilkTable() {

        var selectedDate = $('#datepicker').datepicker('getDate');
        var formattedDate = selectedDate.getFullYear() + '-' + (selectedDate.getMonth() + 1) + '-' + selectedDate.getDate();

        $.ajax({
            url: "{{ route('cowshed.daily-milk.get-table') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                date: formattedDate
            },
            success: function(res) {
                $('#milk-container').html(res);
                $('.datatable').DataTable({
                    // scrollX: true
                });
            }
        });
    }

    $(document).on('change', '.milk-qty', function() {
        var deliveryId = $(this).data('id');
        var milk = $(this).val();

        $.ajax({
            url: "{{ route('cowshed.daily-milk.update') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                milk: milk,
                deliveryId: deliveryId
            },
            success: function(res) {
                getDailyMilkTable();
            }
        });
    });

    $(document).on('change', '.milk_status', function() {
        var deliveryId = $(this).data('id');
        var milk = 0;
        $.ajax({
            url: "{{ route('cowshed.daily-milk.update') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                milk: milk,
                deliveryId: deliveryId
            },
            success: function(res) {
                getDailyMilkTable();
            }
        });
    });

    $(document).on('click', '#save_entry', function() {
        var selectedDate = $('#datepicker').datepicker('getDate');
        var formattedDate = selectedDate.getFullYear() + '-' + (selectedDate.getMonth() + 1) + '-' + selectedDate.getDate();
        // Remove previous error message if any
        $('#milk_error').remove();

        // Check if milk field is empty
        var milk = $('#milk').val();
        if (milk.trim() === '') {
            // Append error message below milk field
            $('#milk').after('<span id="milk_error" style="color: red;">Please enter the milk qty for inhouse used.</span>');
            return; // Prevent further execution
        }

        $.ajax({
            url: "{{ route('cowshed.daily-milk.save-inhouse-delivery') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                date: formattedDate,
                milk: milk
            },
            success: function(res) {
                // Handle success response
                // Optionally, you can reload the table or perform other actions
                location.reload();
            },
            error: function(err) {
                // Handle error response
            }
        });
    });


</script>
@endsection