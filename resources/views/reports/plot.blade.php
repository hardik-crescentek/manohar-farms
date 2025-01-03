@extends('layouts-verticalmenu-light.master')
@section('css')
    <link rel="stylesheet" src="{{ URL::asset('assets/plugins/apexcharts/apexcharts.min.css') }}">

    <!-- Internal DataTables css-->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />
@endsection
@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Plot</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Plot</li>
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
                        <label class="main-content-label mb-3 pt-1">Total plot</label>
                        <h2 class="text-right"><i class="icon-size mdi mdi-water   float-left text-primary"></i><span
                                class="font-weight-bold">{{ $totalLandCount }}</span></h2>
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
                        <label class="main-content-label mb-3 pt-1">Total Water (volume)</label>
                        <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{ $totalWaterVolume }} Ltr</span></h2>
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
                        <label class="main-content-label mb-3 pt-1">Total Jivamrut (Liters)</label>
                        <h2 class="text-right card-item-icon card-icon">
                            <i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{$totalJivamrutliter}} Ltr</span>
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
                        <label class="main-content-label mb-3 pt-1">Total Fertilizer (Qty)</label>
                        <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{ $totalFertilizerQty }}</span></h2>
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
                    <form method="post" action="{{ route('plot-reports.generate-pdf') }}">
                        <div class="row">
                            @csrf
                            <div class="col-md-3 mt-2">
                                <div class="input-group">
                                    <input type="text" name="reportrange" id="reportrange" class="form-control"
                                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mt-2">
                                <div class="form-group">
                                    <select class="form-control select2" name="land_id" id="land_id">
                                        <option value="" selected disabled>Lands</option>
                                        @if (isset($lands) && !empty($lands))
                                            <option value="">All</option>
                                            @foreach ($lands as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 mt-2">
                                <div class="form-group">
                                    <select class="form-control select2" name="category" id="category">
                                        <option value="" selected disabled>Category</option>
                                        <option value="water">Water</option>
                                        <option value="fertilizer">Fertilizer</option>
                                        <option value="jivamrut">Jivamrut</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 mt-2">
                                <button type="submit" class="btn btn-success">Generate Report</button>
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
                    <div class="table-responsive" id="plot-container">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <!-- Internal Apexchart js-->
    <script src="{{ URL::asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Internal Data Table js -->
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>

    @include('reports.JS.plot_js')
@endsection
