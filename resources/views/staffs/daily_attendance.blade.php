@extends('layouts-verticalmenu-light.master')
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
        <h2 class="main-content-title tx-24 mg-b-5">Daily attendance</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('staffs.index') }}">Staff</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daily attendance</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

@include('common.alerts')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control select2" name="staff_type" id="staff_type">
                                <option value="">Select leader</option>
                                <option value="1">Salaried</option>
                                <option value="2">On Demand</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 leader-select-container">
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
                    <div class="col-lg-4">
                        <div class="mg-b-20 mt-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fe fe-calendar lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="datepicker">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="table-responsive" id="staff-container">
                    
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
            showOtherMonths: true,
            selectOtherMonths: true,
            defaultDate: 0, // Set defaultDate to 0 for today
            maxDate: 0,
            onSelect: function(selectedDate) {
                // This function will be called when a date is selected
                // You can use selectedDate here to perform any action
                console.log('Selected date:', selectedDate);
                
                getStaffTable();
            }
        });

        $('.fc-datepicker').datepicker('setDate', new Date());

        getStaffTable();
    });

    $('.datatable').DataTable({
        // scrollX: true
    });

    $('.type').change(function() {
        getStaffTable();
    });
    $('#leader_id').change(function() {
        getStaffTable();
    });
    $('#staff_type').change(function() {
        var staff_type = $('#staff_type').find(':selected').val();
        if(staff_type == 1) {
            $('.leader-select-container').hide();
        } else if(staff_type == 2) {
            $('.leader-select-container').show();
        }
        $('#leader_id').val('');
        getStaffTable();
    });

    function getStaffTable() {

        var leader_id = $('#leader_id').find(':selected').val();
        var staff_type = $('#staff_type').find(':selected').val();
        var selectedDate = $('#datepicker').datepicker('getDate');
        var formattedDate = selectedDate.getFullYear() + '-' + (selectedDate.getMonth() + 1) + '-' + selectedDate.getDate();

        $.ajax({
            url: "{{ route('staff.get-attendance') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                leader_id: leader_id,
                date: formattedDate,
                type: staff_type
            },
            success: function(res) {
                $('#staff-container').html(res);
                $('.datatable').DataTable({
                    // scrollX: true
                });
            }
        });
    }

    $(document).on('change', '.attendance-status', function() {
        var staffId = $(this).data('staff-id');
        var memberId = $(this).data('member-id');
        var status = $(this).val();

        $.ajax({
            url: "{{ route('staff.members-attendance') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                staff_id: staffId,
                staff_member_id: memberId,
                status: status
            },
            success: function(res) {
                
            }
        });
    });
</script>
@endsection