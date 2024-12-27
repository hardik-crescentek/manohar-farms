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
        <h2 class="main-content-title tx-24 mg-b-5">Plots</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Plots</li>
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
                    <h6 class="main-content-label">Plots</h6>
                    @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('lands-add'))
                        <a href="{{ route('lands.create') }}" class="btn btn-primary">Add</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="lands-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Plant</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>No of plants</th>
                                <th>Wells</th>
                                <th>Valves</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($lands) && !$lands->isEmpty())
                                @foreach($lands as $key => $item)
                                    @if(Auth::user()->hasrole('super-admin') || Auth::user()->can($item->slug))
                                    <tr class="tr-{{$item->id}}">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ isset($item->plant->name) ? $item->plant->name : '' }}</td>
                                        <td> <img src="{{ asset('uploads/lands/'.$item->image) }}" alt="" width="50"></td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->plants }}</td>
                                        <td>{{ $item->wells }}</td>
                                        <td>{{ $item->pipeline }}</td>
                                        <td>
                                            @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('lands-edit'))
                                                <a href="{{ route('lands.edit', $item->id) }}" data-toggle="tooltip" title="Edit"> <i class="fa fa-pen text-primary mr-2"></i> </a>
                                                <a href="{{ route('lands.maps', $item->id) }}" data-toggle="tooltip" title="Map"> <i class="fa fa-map text-primary mr-2"></i> </a>
                                            @endif
                                            @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('lands-delete'))
                                                <a href="javascript:;" class="delete-land" data-id="{{ $item->id }}" data-route="{{ route('lands.destroy', $item->id) }}" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
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
<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");

        $('.datatable').on('click', '.delete-land',function() {
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