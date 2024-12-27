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
        <h2 class="main-content-title tx-24 mg-b-5">Staffs</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Staffs</li>
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
                    <label class="main-content-label mb-3 pt-1">Total Ondemand staff Expense </label>
                    <h2 class="text-right"><i class="icon-size zmdi zmdi-gas-station   float-left text-primary"></i><span class="font-weight-bold">₹{{ $totalDemandStaffExpense }}</span></h2>
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
                    <label class="main-content-label mb-3 pt-1">Total Salaried staff Expense</label>
                    <h2 class="text-right"><i class="zmdi zmdi-gas-station icon-size float-left text-primary"></i><span class="font-weight-bold">₹{{ $totalSalariedStaffExpense }}</span></h2>
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
                    <label class="main-content-label mb-3 pt-1">Total Salaried staff</label>
                    <h2 class="text-right card-item-icon card-icon">
                        <i class="zmdi zmdi-gas-station icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $totalSalariedStaff }}</span>
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
                    <label class="main-content-label mb-3 pt-1">Total Ondemand staff </label>
                    <h2 class="text-right"><i class="zmdi zmdi-gas-station icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $totalDemandStaff }}</span></h2>
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
                <form method="POST" action="{{ route('cowshed.staffs-reports.generate-pdf') }}">
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
                            <div class="d-flex justify-content-between mb-2">
                                <div class="custom-radio-div">
                                    <label class="rdiobox d-inline-block mr-4" for="all"><input type="radio" class="type" name="type" value="" id="all" checked> <span>All</span></label>
                                    <label class="rdiobox d-inline-block mr-4" for="salaried"><input type="radio" class="type" name="type" value="1" id="salaried"> <span>Salaried</span></label>
                                    <label class="rdiobox d-inline-block" for="on-demand"><input type="radio" class="type" name="type" value="2" id="on-demand"> <span>On demand</span></label>
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
                <div class="table-responsive" id="staffs-container">

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

@include('cowshed.reports.JS.staffs_js')

@endsection