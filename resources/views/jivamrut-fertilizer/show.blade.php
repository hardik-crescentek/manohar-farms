    @extends('layouts-verticalmenu-light.master')
    @section('css')
    <link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />

    <style>
        .ui-datepicker {
            z-index: 9999 !important;
            top: 260px !important;
        }
        .tab-content .tab-pane {
            display: none; /* Hide all tab panes by default */
        }

        .tab-content .tab-pane.show {
            display: block; /* Show active tab pane */
        }
    </style>
    @endsection
    @section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jivamrut-fertilizer.index') }}">Jivamrut fertilizer</a></li>
                <li class="breadcrumb-item active" aria-current="page">Jivamrut barrels</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    @include('common.alerts')

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="main-content-label">Jivamrut Fertilizer detail</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="label-value">
                                <strong>Name:</strong>
                                <span>{{ $jivamrutFertilizer->name }}</span>
                            </div>
                            <div class="label-value mt-2">
                                <strong>Ingredients:</strong>
                                <span>{{ is_array($jivamrutFertilizer->ingredients) ? implode(', ', $jivamrutFertilizer->ingredients) : '' }}</span>
                            </div>
                            <div class="label-value mt-2">
                                <strong>Total Barrels:</strong>
                                <!-- <span>{{ $jivamrutFertilizer->barrels }}</span> -->
                                <span>{{ $totalBarrels }}</span>
                            </div>
                            <div class="label-value mt-2">
                                <strong>Current Barrels:</strong>
                                <span>{{ $currentBarrels }}</span>
                            </div>
                            <div class="label-value mt-2">
                                <strong>Removed Barrels:</strong>
                                <span>{{ $removedBarrels }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-12">
                            <!-- <div class="d-flex justify-content-between mb-2">
                                <h6 class="main-content-label">Current Barrels</h6>
                                <div class="col-md-4 d-flex justify-content-end">
                                    <a href="javascript:;" class="btn btn-primary" data-target="#addBarrelEntry" data-toggle="modal">Add Barrel</a>
                                </div>
                            </div>
                            <div class="table-responsive" id="current-barrels-container">
                                
                            </div> -->

                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="current-barrels-tab" data-bs-toggle="tab" href="#current-barrels" role="tab" aria-controls="current-barrels" aria-selected="true">Current Barrels</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link empty-barrel" id="removed-barrels-tab" data-bs-toggle="tab" href="#removed-barrels" role="tab" aria-controls="removed-barrels" aria-selected="false">Removed Barrels</a>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="current-barrels" role="tabpanel" aria-labelledby="current-barrels-tab">
                                    <div class="d-flex justify-content-end mb-2 row">
                                        <a href="javascript:;" class="btn btn-primary mr-3" data-target="#addBarrelEntry" data-toggle="modal">Add Barrel</a>
                                        <!-- <a href="javascript:;" class="btn btn-primary mr-3" data-target="#removeBarrelEntry" data-toggle="modal">Remove Barrel</a> -->
                                    </div>
                                    <div class="table-responsive" id="current-barrels-container">
                                        <!-- Current Barrels Table will be loaded here via AJAX -->
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="removed-barrels" role="tabpanel" aria-labelledby="removed-barrels-tab">
                                    <div class="d-flex justify-content-end mb-2 row">
                                        <!-- <a href="javascript:;" class="btn btn-primary mr-3" data-target="#addBarrelEntry" data-toggle="modal">Add Barrel</a> -->
                                        <a href="javascript:;" class="btn btn-primary mr-3" data-target="#removeBarrelEntry" data-toggle="modal">Remove Barrel</a>
                                    </div>
                                    <div class="table-responsive" id="removed-barrels-container">
                                        <!-- Removed Barrels Table will be loaded here via AJAX -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="addBarrelEntry">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add Barrel Entry</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('jivamrut-fertilizer.save-barrel-entries') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row row-sm">
                            <input type="hidden" name="jivamrut_fertilizer_id" value="{{ $jivamrutFertilizer->id }}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control datepicker" placeholder="DD/MM/YYYY" type="text" name="date" id="jivamrut-date" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Barrel  (QTY)</label>
                                    <input class="form-control" name="barrel_qty" type="number" value="{{ old('barrel_qty') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Ingredients</label>
                                    <input class="form-control" name="ingredients" type="text" value="{{ old('ingredients') }}">
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

    <div class="modal" id="removeBarrelEntry">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Remove Barrel Entry</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('jivamrut-fertilizer.remove-barrel', $jivamrutFertilizer->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row row-sm">
                        <input type="hidden" name="jivamrut_fertilizer_id" value="{{ $jivamrutFertilizer->id }}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="removed_date">Removed Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="removed_date" name="removed_date" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Barrel  (QTY)</label>
                                <input class="form-control" name="barrel_qty" type="number" value="{{ old('barrel_qty') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Ingredients</label>
                                <input class="form-control" name="ingredients" type="text" value="{{ old('ingredients') }}">
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
    <script src="{{URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initial content load for active tab
            getBarrelsTable('current-barrels');

            $('#myTab a').on('click', function (e) {
                e.preventDefault();
                var tabId = $(this).attr('href').substring(1); // Get the tab ID (e.g., 'current-barrels')

                // Remove 'active' class from all tabs and tab panes
                $('#myTab a').removeClass('active');
                $('.tab-pane').removeClass('show active');

                // Add 'active' class to clicked tab and show the corresponding tab pane
                $(this).addClass('active');
                $($(this).attr('href')).addClass('show active');

                // Load content for the selected tab
                getBarrelsTable(tabId);
            });

        });

        $('.datatable').DataTable({
            // scrollX: true
        });

        $(document).on('click', '.plus-barrel', function() {
            var id = $(this).data('id');
            changeStatus(id, 0);
        });

        function getBarrelsTable(tab) {
            var url = '';
            var containerId = '';

            if (tab === 'current-barrels') {
                url = '{{ route("jivamrut-fertilizer.get-barrel-tables") }}';
                containerId = '#current-barrels-container';
            } else if (tab === 'removed-barrels') {
                url = '{{ route("jivamrut-fertilizer.get-removed-barrel-tables") }}';
                containerId = '#removed-barrels-container';
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: '{{ $jivamrutFertilizer->id }}'
                },
                success: function(res) {
                    console.log('AJAX Response:', res); // Log the response to check its content
                    if (res && res.currentTable) {
                        $(containerId).html(res.currentTable);
                    } else {
                        $(containerId).html('No data available.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $(containerId).html('Failed to load data.');
                }
            });
        }

        $(function() {
            $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });
        });

        $(document).on('shown.bs.modal', '.editBarrel', function () {
            $(this).find('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });
        });

        $(document).on('click', '.empty-barrel', function() {
            var targetModalId = $(this).data('target');
            $(targetModalId).modal('show');
            // Optional: Set date here if needed
            var today = new Date().toISOString().split('T')[0];
            $(targetModalId).find('#removed_date').val(today);
        });

    </script>
    @endsection