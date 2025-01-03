@extends('layouts-verticalmenu-light.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />

    <style>
        .ui-datepicker {
            z-index: 9999 !important;
            top: 235px !important;
        }
    </style>
@endsection
@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('lands.index') }}">Lands</a></li>
                <li class="breadcrumb-item"><a href="{{ route('lands.maps', $partDetail->land_id) }}">Map</a></li>
                <li class="breadcrumb-item active" aria-current="page">Land part</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    @include('common.alerts')

    <!-- Row -->
    <div class="row row-sm">
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="javascript:;">
                        <label class="main-content-label mb-3 pt-1">Total Water Usage</label>
                        <h2 class="text-right"><i class="icon-size mdi mdi-water float-left text-primary"></i><span
                                class="font-weight-bold">{{ $totalWaterUsage }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="javascript:;">
                        <label class="main-content-label mb-3 pt-1">Monthly water Usage</label>
                        <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{ $monthlyWaterUsage }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order " href="javascript:;">
                        <!-- <label class="main-content-label mb-3 pt-1">Water Used (Litr)</label> -->
                        <label class="main-content-label mb-3 pt-1">Water Used (Hours)</label>
                        <h2 class="text-right card-item-icon card-icon">
                            <i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{ $totalLitrUsed }}</span>
                        </h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="javascript:;">
                        <!-- <label class="main-content-label mb-3 pt-1">Monthly Water Used (Litr)</label> -->
                        <label class="main-content-label mb-3 pt-1">Monthly Water Used (Hours)</label>
                        <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{ $monthlyLitrUsed }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="main-content-label">Lands detail</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="label-value">
                                <strong>Land:</strong>
                                <span>{{ $partDetail->land->name }}</span>
                            </div>
                            <div class="label-value mt-2">
                                <strong>Land Part:</strong>
                                <span>{{ $partDetail->name }}</span>
                            </div>
                            <div class="label-value mt-2">
                                <strong>Land Part:</strong>
                                <img src="{{ asset('uploads/land_parts/' . $partDetail->image) }}" alt=""
                                    width="80">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <div class="input-group">
                                <input type="text" name="waterrange" id="waterrange" class="form-control reportrange"
                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">

                        </div>
                        <div class="col-md-4 mt-2 d-flex justify-content-end">
                            <a href="javascript:;" class="btn btn-primary" data-target="#addWaterEntry"
                                data-toggle="modal">Add Water entry</a>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="main-content-label">Water Entries</h6>
                            </div>
                            <div class="table-responsive" id="water-container">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <div class="input-group">
                                <input type="text" name="jivamrutrange" id="jivamrutrange"
                                    class="form-control reportrange"
                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">

                        </div>
                        <div class="col-md-4 mt-2 d-flex justify-content-end">
                            <a href="javascript:;" class="btn btn-primary" data-target="#addJivamrutEntry"
                                data-toggle="modal">Add Jivamrut entry</a>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="main-content-label">Jivamrut Entries</h6>
                            </div>
                            <div class="table-responsive" id="jivamrut-container">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <div class="input-group">
                                <input type="text" name="fertilizerrange" id="fertilizerrange"
                                    class="form-control reportrange"
                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">

                        </div>
                        <div class="col-md-4 mt-2 d-flex justify-content-end">
                            <a href="javascript:;" class="btn btn-primary" data-target="#addFertilizerEntry"
                                data-toggle="modal">Add Fertilizer</a>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="main-content-label">Fertilizer Entries</h6>
                            </div>
                            <div class="table-responsive" id="fertilizer-container">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="addWaterEntry">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add Water Entry</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('land-parts.save-water-entries') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row row-sm">
                            <input type="hidden" name="land_id" value="{{ $partDetail->land_id }}">
                            <input type="hidden" name="land_part" value="{{ $partDetail->id }}">
                            <div class="col-md-12">
                                <p class="mg-b-10">Valves</p>
                                <select class="form-control select2" multiple="multiple" name="land_part_id[]">
                                    @if (isset($landParts) && !$landParts->isEmpty())
                                        @foreach ($landParts as $key => $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text"
                                            name="date" id="water-date" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Time</label>
                                    <input class="form-control" name="time" type="text"
                                        value="{{ old('time') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Hours</label>
                                    <input class="form-control" name="hours" type="text"
                                        value="{{ old('hours') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Person</label>
                                    <input class="form-control" name="person" type="text"
                                        value="{{ old('person') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Volume</label>
                                    <input class="form-control" name="volume" type="text"
                                        value="{{ old('volume') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">Save changes</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add jivamrut Entries --}}
    <div class="modal" id="addJivamrutEntry">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add Jivamrut Entry</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('land-parts.save-jivamrut-entries') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row row-sm">
                            <input type="hidden" name="land_id" value="{{ $partDetail->land_id }}">
                            <input type="hidden" name="land_part" value="{{ $partDetail->id }}">
                            <div class="col-md-12">
                                <p class="mg-b-10">Valves</p>
                                <select class="form-control select2" multiple="multiple" name="land_part_id[]">
                                    @if (isset($landParts) && !$landParts->isEmpty())
                                        @foreach ($landParts as $key => $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text"
                                            name="date" id="jivamrut-date" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Time</label>
                                    <input class="form-control" name="time" type="text"
                                        value="{{ old('time') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="size">Size (Liters)</label>
                                    <input class="form-control" name="size" type="text"
                                        value="{{ old('size') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="barrels">Barrels</label>
                                    <input class="form-control" name="barrels" type="number"
                                        value="{{ old('barrels') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Person</label>
                                    <input class="form-control" name="person" type="text"
                                        value="{{ old('person') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">Save changes</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="addFertilizerEntry">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add Fertilizer entry</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('land-parts.save-fertilizer-entries') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row row-sm">
                            <input type="hidden" name="land_id" value="{{ $partDetail->land_id }}">
                            <input type="hidden" name="land_part" value="{{ $partDetail->id }}">
                            <div class="col-md-12">
                                <p class="mg-b-10">Valves</p>
                                <select class="form-control select2" multiple="multiple" name="land_part_id[]">
                                    @if (isset($landParts) && !$landParts->isEmpty())
                                        @foreach ($landParts as $key => $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text"
                                            name="date" id="fertilizer-date" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Time</label>
                                    <input class="form-control" name="time" type="text"
                                        value="{{ old('time') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Fertilizer name</label>
                                    <input class="form-control" name="fertilizer_name" type="text"
                                        value="{{ old('fertilizer_name') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Person</label>
                                    <input class="form-control" name="person" type="text"
                                        value="{{ old('person') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">QTY</label>
                                    <input class="form-control" name="qty" type="number"
                                        value="{{ old('qty') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Remarks</label>
                                    <input class="form-control" name="remarks" type="text"
                                        value="{{ old('remarks') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">Save changes</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#global-loader").fadeOut("slow");

            getWaterTable();
            getJivamrutTable();
            getFertilizerTable();
        });

        $('.datatable').DataTable({
            // scrollX: true
        });

        $('#waterrange').on('apply.daterangepicker', function(ev, picker) {
            var startDate = picker.startDate.format('YYYY-MM-DD');
            var endDate = picker.endDate.format('YYYY-MM-DD');
            getWaterTable(startDate, endDate);
        });

        function getWaterTable(startDate, endDate) {

            $.ajax({
                url: "{{ route('water-entries.get-table') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    startDate: startDate,
                    endDate: endDate,
                    landId: '{{ $partDetail->land_id }}',
                    landPartId: '{{ $partDetail->id }}'
                },
                success: function(res) {
                    $('#water-container').html(res);
                    $('#water-entries-table').DataTable({});
                }
            });
        }

        // Jivamrut Datatable Part
        $('#jivamrutrange').on('apply.daterangepicker', function(ev, picker) {
            var startDate = picker.startDate.format('YYYY-MM-DD');
            var endDate = picker.endDate.format('YYYY-MM-DD');
            getJivamrutTable(startDate, endDate);
        });

        function getJivamrutTable(startDate, endDate) {

            $.ajax({
                url: "{{ route('jivamrut-entries.get-table') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    startDate: startDate,
                    endDate: endDate,
                    landId: '{{ $partDetail->land_id }}',
                    landPartId: '{{ $partDetail->id }}'
                },
                success: function(res) {
                    $('#jivamrut-container').html(res);
                    $('#jivamrut-entries-table').DataTable({});
                }
            });
        }

        $('#fertilizerrange').on('apply.daterangepicker', function(ev, picker) {
            var startDate = picker.startDate.format('YYYY-MM-DD');
            var endDate = picker.endDate.format('YYYY-MM-DD');
            getFertilizerTable(startDate, endDate);
        });

        function getFertilizerTable(startDate, endDate) {

            $.ajax({
                url: "{{ route('fertilizer-entries.get-table') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    startDate: startDate,
                    endDate: endDate,
                    landId: '{{ $partDetail->land_id }}',
                    landPartId: '{{ $partDetail->id }}'
                },
                success: function(res) {
                    $('#fertilizer-container').html(res);
                    $('#fertilizer-entries-table').DataTable({});
                }
            });
        }

        $(function() {
            var start = moment();
            var end = moment();

            function cb(start, end) {
                $('.reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('.reportrange').daterangepicker({
                startDate: moment().startOf('month'),
                endDate: moment().endOf('month'),
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

        });

        $(function() {
            $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });
        });
    </script>
@endsection
