@extends('cowshed.layouts.master')
@section('css')
<link rel="stylesheet" src="{{URL::asset('assets/plugins/apexcharts/apexcharts.min.css')}}">

<!-- Internal DataTables css-->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Milk Reports</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Milk Reports</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<!-- Row -->
<div class="row row-sm">
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">Total Litrs(Clients)</label>
                    <h2 class="text-right"><i class="icon-size mdi mdi-flower float-left text-primary"></i><span class="font-weight-bold">{{ $totalMilk }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">Current month Litrs(Clients)</label>
                    <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $currentMonthMilk }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order ">
                    <label class="main-content-label mb-3 pt-1">Previous month Litrs(Clients)</label>
                    <h2 class="text-right card-item-icon card-icon">
                        <i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $prevMonthMilk }}</span>
                    </h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">This Year Litrs(Clients)</label>
                    <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $currentYearMilk }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">Current Month Inhouse Litrs</label>
                    <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $currentMonthInHouseMilk }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row row-sm">
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">Total Earning(Clients)</label>
                    <h2 class="text-right"><i class="icon-size mdi mdi-flower float-left text-primary"></i><span class="font-weight-bold">₹{{ $totalEarning }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">Current month Earning(Clients)</label>
                    <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ $currentMonthEarning }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order ">
                    <label class="main-content-label mb-3 pt-1">Previous month Earning(Clients)</label>
                    <h2 class="text-right card-item-icon card-icon">
                        <i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ $prevMonthEarning }}</span>
                    </h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">This Year Earning(Customers)</label>
                    <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ $currentYearEarning }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">This Year InHouse Ltrs</label>
                    <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $currentYearInHouseMilk }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<!-- row opened -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <form method="POST" action="{{ route('cowshed.milk-deliveries.get-delivery-report') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <div class="form-group">
                                <select class="form-control select2" name="customer_id" id="customer_id">
                                    <option value="" selected disabled>Customers</option>
                                    @if(isset($customers) && !empty($customers))
                                        <option value="">All</option>
                                        @foreach($customers as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="input-group">
                                <input type="text" name="reportrange" id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <button type="submit" class="btn btn-success" id="download-pdf">Report Pdf</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

@endsection
@section('script')

<!-- Internal Data Table js -->
<script src="{{URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");
    });

    $('.datatable').DataTable({
        // scrollX: true
    });

    $(function() {
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            getDailyMilkTable();
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

    $('#customer_id').change(function() {
        getDailyMilkTable();
    });

    function getDailyMilkTable() {

        var customerId = $('#customer_id').find(':selected').val();
        var picker = $('#reportrange').data('daterangepicker');
        var startdate = picker.startDate.format('YYYY-MM-DD');
        var enddate = picker.endDate.format('YYYY-MM-DD');

        $.ajax({
            url: "{{ route('cowshed.milk-deliveries.milk-history-table') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                customerId: customerId,
                startdate: startdate,
                enddate: enddate,
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