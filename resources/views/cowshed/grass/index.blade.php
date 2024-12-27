@extends('cowshed.layouts.master')
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
        <h2 class="main-content-title tx-24 mg-b-5">Grass</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Grass</li>
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
                    <h6 class="main-content-label">Grass</h6>
                    <a href="{{ route('cowshed.grass.create') }}" class="btn btn-primary">Add</a>
                </div>
                <div class="table-responsive" id="grass-container">
                    <table class="table table-bordered datatable" id="grass-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Image</th>
                                <th>type</th>
                                <th>Volume (Kg)</th>
                                <th>Amount</th>
                                <th>Payment person</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grass as $item)
                                <tr class="tr-{{ $item->id }}">
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        <div class="container-img-holder">
                                            <img src="{{ asset('uploads/grass/'.$item->image) }}" alt="" width="50">
                                        </div>
                                    </td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->volume }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->payment_person }}</td>
                                    <td>{{ isset($item->date) && $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
                                    <td>
                                        <a href="{{ route('cowshed.grass.edit', $item->id) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pen text-primary mr-2"></i>
                                        </a>
                                        <a href="javascript:;" class="delete-grass" data-id="{{ $item->id }}" data-route="{{ route('cowshed.grass.destroy', $item->id) }}" data-toggle="tooltip" title="Delete">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
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

        $('.datatable').on('click', '.delete-grass', function() {
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
</script>
@endsection