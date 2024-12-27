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
        <h2 class="main-content-title tx-24 mg-b-5">Compost Beds</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Compost Beds</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

@include('common.alerts')

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="main-content-label">Compost Beds</h6>
                    <a href="{{ route('vermi-compost.create') }}" class="btn btn-primary">Add Bed</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="fp-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Water (Litr)</th>
                                <th>Soil (Kg)</th>
                                <th>Soil Details</th>
                                <th>Worms (Kg)</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($vermiComposts) && !$vermiComposts->isEmpty())
                                @foreach($vermiComposts as $vermiCompost)
                                <tr class="tr-{{ $vermiCompost->id }}">
                                    <td>{{ $vermiCompost->id }}</td>
                                    <td>{{ $vermiCompost->name }}</td>
                                    <td>{{ $vermiCompost->water }}</td>
                                    <td>{{ $vermiCompost->soil }}</td>
                                    <td>{{ $vermiCompost->soil_details }}</td>
                                    <td>{{ $vermiCompost->worms }}</td>
                                    <td>{{ $vermiCompost->date != null ? date('d-m-Y', strtotime($vermiCompost->date)) : '' }}</td>
                                    <td>{{ $vermiCompost->completed_date != null ? date('d-m-Y', strtotime($vermiCompost->completed_date)) : '' }}</td>
                                    <!-- <td>
                                        @if($vermiCompost->status == 1)
                                        <span class="badge badge-success">Completed</span>
                                        @else 
                                        <span class="badge badge-primary">Inprogress</span>
                                        @endif
                                    </td> -->
                                    <td>
                                        @if($vermiCompost->status == 1)
                                            <span class="badge badge-success">Completed</span>
                                        @else 
                                            <span class="badge badge-primary status-update" data-id="{{ $vermiCompost->id }}" style="cursor: pointer;">Inprogress</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('vermi-compost.edit', $vermiCompost->id) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pen text-primary mr-2"></i>
                                        </a>
                                        <a href="javascript:;" class="delete-fertilizer-pesticides" data-id="{{ $vermiCompost->id }}" data-route="{{ route('vermi-compost.destroy', $vermiCompost->id) }}" data-toggle="tooltip" title="Delete">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->


<!-- Status Update Modal -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1" role="dialog" aria-labelledby="statusUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="statusUpdateForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="statusUpdateModalLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="compostBedId">
                    <div class="form-group">
                        <label for="completed_date">End Date</label>
                        <input type="date" class="form-control" id="completed_date" name="completed_date" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Status Update Modal -->
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

        $('.datatable').on('click', '.delete-fertilizer-pesticides', function() {
            var route = $(this).data('route');
            var id = $(this).data('id');
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: route,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function() {
                                swal("Deleted!", "Your data has been deleted.", "success");
                                $(".tr-" + id).remove();
                            }
                        });
                    } else {
                        swal("Cancelled", "Your data is safe :)", "error");
                    }
                });
        });
    });

    $('.datatable').DataTable({
        // scrollX: true
    });

    // status update code
    $('.datatable').on('click', '.status-update', function() {
        var id = $(this).data('id');
        $('#compostBedId').val(id);

        // Set today's date if no date exists
        var today = new Date().toISOString().split('T')[0];
        $('#completed_date').val(today);

        $('#statusUpdateModal').modal('show');
    });

    $('#statusUpdateForm').submit(function(e) {
        e.preventDefault();
        var id = $('#compostBedId').val();
        var route = "{{ route('vermi-compost.updateStatus', ':id') }}".replace(':id', id);
        var data = $(this).serialize();
        $.ajax({
            url: route,
            type: 'PATCH',
            data: data,
            success: function(response) {
                $('#statusUpdateModal').modal('hide');
                location.reload();
            },
            error: function(response) {
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>
@endsection