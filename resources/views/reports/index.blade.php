@extends('layouts-verticalmenu-light.master')
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
        <h2 class="main-content-title tx-24 mg-b-5">Reports</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reports</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<!-- Row -->
<div class="row row-sm">
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <a class="card-order" href="{{ route('plant-reports.index') }}">
                    <label class="main-content-label mb-3 pt-1">Total Plant amount</label>
                    <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ number_format($totalPlantExpense, 0) }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <a class="card-order" href="{{ route('fertilizer-pesticides-reports.index') }}">
                    <label class="main-content-label mb-3 pt-1">Total Fertilizer and pesticides amount</label>
                    <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ number_format($totalFPamount, 0) }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <a class="card-order" href="{{ route('staffs-reports.index') }}">
                    <label class="main-content-label mb-3 pt-1">Total Salaried Staff expenses</label>
                    <h2 class="text-right"><i class="zmdi zmdi-money-box icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ number_format($totalSalaryStaffExpense, 0) }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <a class="card-order" href="{{ route('staffs-reports.index') }}">
                    <label class="main-content-label mb-3 pt-1">Total On-demand Staff expenses</label>
                    <h2 class="text-right"><i class="zmdi zmdi-money-box icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ number_format($totalDayStaffExpense, 0) }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <a class="card-order" href="{{ route('diesel-reports.index') }}">
                    <label class="main-content-label mb-3 pt-1">Total Diesel amount</label>
                    <h2 class="text-right"><i class="zmdi zmdi-gas-station icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ number_format($totalDieselExpense, 0) }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <a class="card-order" href="{{ route('water-reports.index') }}">
                    <label class="main-content-label mb-3 pt-1">Total Water amount</label>
                    <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ number_format($totalWaterExpense, 0) }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <a class="card-order " href="{{ route('bill-reports.index') }}">
                    <label class="main-content-label mb-3 pt-1">Total Bill amount</label>
                    <h2 class="text-right card-item-icon card-icon">
                        <i class="zmdi zmdi-money-box icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ number_format($totalBillExpense, 0) }}</span>
                    </h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <a class="card-order" href="{{ route('expenses-reports.index') }}">
                    <label class="main-content-label mb-3 pt-1">Total Expenses</label>
                    <h2 class="text-right"><i class="icon-size zmdi zmdi-money-box   float-left text-primary"></i><span class="font-weight-bold">₹{{ number_format($totalExpense, 0) }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <a class="card-order" href="{{ route('vehicles-services-reports.index') }}">
                    <label class="main-content-label mb-3 pt-1">Total Vehicle Service amount</label>
                    <h2 class="text-right"><i class="mdi mdi-flower icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ number_format($totalVSamount, 0) }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->


<!-- <div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                
            </div>
        </div>
    </div>
</div> -->

@endsection
@section('script')
<!-- Internal Apexchart js-->
<script src="{{URL::asset('assets/plugins/apexcharts/apexcharts.min.js')}}"></script>

<!-- Internal Data Table js -->
<script src="{{URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>

@include('reports.JS.expenses_js')

@endsection