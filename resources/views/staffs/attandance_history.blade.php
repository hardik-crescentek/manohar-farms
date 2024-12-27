@extends('layouts-verticalmenu-light.master')
@section('css')
<!-- Internal DataTables css-->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />

<!-- Internal Sweet-Alert css-->
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Attendance history</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('staffs.index') }}">Staff</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attendance history</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

@include('common.alerts')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <form method="POST" action="{{ route('attendance.generate-pdf') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="">Leader</label>
                                <select class="form-control select2" name="leader_id" id="leader_id">
                                    <option value="">Select leader</option>
                                    @if(isset($leaders) && !empty($leaders))
                                        @foreach($leaders as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="">Staff Member</label>
                                <select class="form-control" name="staff_member" id="staff_member">
                                    <option value="">Select Member</option>
                                    @if(isset($members) && !empty($members))
                                        @foreach($members as $id => $member)
                                            <option value="{{ $member->id }}" data-leader-id="{{ $member->staff_id }}">{{ $member->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mt-4">
                                <input type="text" name="reportrange" id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-43 mt-4">
                            <button type="submit" class="btn btn-success" id="download-pdf">Report Pdf</button>
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
                <div class="table-responsive" id="attendance-container">
                    
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

<script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");

        $('#leader_id').on('change', function () {
            var leaderId = $(this).val();

            // If a leader is selected
            if (leaderId) {
                // Show all options first in case some were hidden previously
                $('#staff_member option').show();

                // Filter options and hide those that don't match the selected leader's ID
                $('#staff_member option').each(function() {
                    if ($(this).data('leader-id') != leaderId) {
                        $(this).hide();
                    }
                });
            } else {
                // If no leader is selected, show all options
                $('#staff_member option').show();
            }
        });
    });

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        getAttendanceHistory();
    });

    $(function() {
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            getAttendanceHistory();
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

    $('.datatable').DataTable({
        // scrollX: true
        order: []
    });

    $('#staff_member').change(function() {
        getAttendanceHistory();
    });

    $('#leader_id').change(function() {
        getAttendanceHistory();
    });

    function getAttendanceHistory() {

        var picker = $('#reportrange').data('daterangepicker');
        var startdate = picker.startDate.format('YYYY-MM-DD');
        var enddate = picker.endDate.format('YYYY-MM-DD');

        var leader_id = $('#leader_id').val();
        var staff_member = $('#staff_member').val();

        $.ajax({
            url: "{{ route('staff.get-attendance-history') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                startdate: startdate,
                enddate: enddate,
                leader_id: leader_id,
                staff_member: staff_member
            },
            success: function(res) {
                $('#attendance-container').html(res);
                $('.datatable').DataTable({
                    scrollX: true,
                    order: []
                });
            }
        });
    }
</script>
@endsection