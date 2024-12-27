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
        <h2 class="main-content-title tx-24 mg-b-5">Camera Details</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Camera Details</li>
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
                    <h6 class="main-content-label">Camera Details</h6>
                    @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('cameras-add'))
                        <a href="{{ route('cameras.create') }}" class="btn btn-primary">Add</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="expense-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Camera Location</th>
                                <th>Amount</th>
                                <th>Purchase Date</th>
                                <th>Memory Detail</th>
                                <th>Sim Number</th>
                                <th>Camera Company Name</th>
                                <th>Service Person Name</th>
                                <th>Service Person Number</th>
                                <th>Last Cleaning Date</th>
                                <th>Recharge Notification</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($cameras) && !$cameras->isEmpty())
                                @foreach($cameras as $key => $item)
                                    <tr class="tr-{{$item->id}}">
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <div class="container-img-holder">
                                                <img src="{{ asset('uploads/cameras/'.$item->image) }}" alt="" width="50">
                                            </div>
                                        </td>
                                        <td>{{ $item->camera_location }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ isset($item->purchase_date) && $item->purchase_date != null ? date('d-m-Y', strtotime($item->purchase_date)) : '' }}</td>
                                        <td>{{ $item->memory_detail }}</td>
                                        <td>{{ $item->sim_number }}</td>
                                        <td>{{ $item->camera_company_name }}</td>
                                        <td>{{ $item->service_person_name }}</td>
                                        <td>{{ $item->service_person_number }}</td>
                                        <td>{{ isset($item->last_cleaning_date) && $item->last_cleaning_date != null ? date('d-m-Y', strtotime($item->last_cleaning_date)) : '' }}</td>
                                        <td>{{ $item->recharge_notification . ' Days' }}</td>
                                        <td>
                                            @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('cameras-edit'))
                                                <a href="{{ route('cameras.edit', $item->id) }}" data-toggle="tooltip" title="Edit"> <i class="fa fa-pen text-primary mr-2"></i> </a>
                                            @endif
                                            @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('cameras-delete'))
                                                <a href="javascript:;" class="delete-camera" data-id="{{ $item->id }}" data-route="{{ route('cameras.destroy', $item->id) }}" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
                                            @endif
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
@endsection
@section('script')
<!-- Internal Data Table js -->
<script src="{{URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>

<!-- Internal Sweet-Alert js-->
<script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>

<script src="{{URL::asset('assets/js/image-popup.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");

        $('.datatable').on('click', '.delete-camera',function() {
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
                        data: {_token: '{{ csrf_token() }}', _method: 'DELETE'},
                        success: function() {
                            swal("Deleted!", "Your data has been deleted.", "success");
                            $(".tr-"+id).remove();
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
</script>
@endsection