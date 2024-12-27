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
        <h2 class="main-content-title tx-24 mg-b-5">Expenses</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Expenses</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<!-- Row -->
<div class="row row-sm">
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">Total</label>
                    <h2 class="text-right"><i class="icon-size zmdi zmdi-money-box float-left text-primary"></i><span class="font-weight-bold">₹{{ $totalExpense }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">Current month</label>
                    <h2 class="text-right"><i class="zmdi zmdi-money-box icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ $currentMonthExpense }}</span></h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order ">
                    <label class="main-content-label mb-3 pt-1">Previous month</label>
                    <h2 class="text-right card-item-icon card-icon">
                        <i class="zmdi zmdi-money-box icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ $prevMonthExpense }}</span>
                    </h2>
                    <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- COL END -->
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order">
                    <label class="main-content-label mb-3 pt-1">This Year</label>
                    <h2 class="text-right"><i class="zmdi zmdi-money-box icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ $currentYearExpense }}</span></h2>
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
                <form method="POST" action="{{ route('cowshed.expenses-reports.generate-pdf') }}">
                    <div class="row">
                        @csrf
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
                <div class="table-responsive" id="expenses-container">

                </div>
            </div>
        </div>
    </div>
</div>

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

@include('cowshed.reports.JS.expenses_js')

@endsection