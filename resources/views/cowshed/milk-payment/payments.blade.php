@extends('cowshed.layouts.master')
@section('css')
<!-- Internal DataTables css-->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />

<!-- Internal Sweet-Alert css-->
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Milk Payments</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Milk Payments</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

@include('common.alerts')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <form method="POST" action="{{ route('cowshed.milk-payments.get-report') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <div class="form-group">
                                <input type="text" class="form-control" id="monthpicker" placeholder="m/Y" name="date" required="">
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success btn-block" id="download-pdf">Download Pdf</button>
                                </div>
                            </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="{{URL::asset('assets/js/image-popup.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");

        // Handle status change on click
        $(document).on('click', '.status-badge',function() {
            var paymentId = $(this).data('id');
            var currentStatus = $(this).data('status');
            var newStatus = (currentStatus == 1) ? 0 : 1;

            $.ajax({
                url: "{{ route('cowshed.milk-payments.status-update') }}",
                type: 'POST',
                data: {
                    status: newStatus,
                    _token: '{{ csrf_token() }}',
                    id: paymentId
                },
                success: function(response) {
                    if (response.success) {
                        // Update badge text and color
                        var badge = (newStatus == 1) ? '<span class="badge badge-success">Paid</span>' : '<span class="badge badge-warning">Unpaid</span>';
                        $('.status-badge[data-id="' + paymentId + '"]').html(badge);
                        // Update stored status
                        $('.status-badge[data-id="' + paymentId + '"]').data('status', newStatus);
                    }
                }
            });
        });

        // Handle image upload
        $(document).on('change', '.image-upload', function() {
            var paymentId = $(this).data('payment-id');
            var formData = new FormData();
            formData.append('image', $(this)[0].files[0]);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id', paymentId);

            $.ajax({
                url: "{{ route('cowshed.milk-payments.save-image') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        // Handle success
                    }
                }
            });
        });
    });

    var today = new Date();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();

    $('#monthpicker').datepicker({
        autoclose: true,
        minViewMode: 1,
        format: 'mm/yyyy',
        // startDate: new Date(currentYear - 5, currentMonth),
        endDate: new Date(currentYear, currentMonth - 1)
    });

    $('.datatable').DataTable({
        // scrollX: true
    });

    var selectedDate;
    $('#monthpicker').on('changeDate', function(e) {
        selectedDate = e.format();
        getDailyMilkTable();
    });

    function getDailyMilkTable() {

        $.ajax({
            url: "{{ route('cowshed.milk-payments.history') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                date: selectedDate
            },
            success: function(res) {
                $('#milk-container').html(res);
                $('.datatable').DataTable({
                    // scrollX: true
                });
            }
        });
    }
</script>
@endsection