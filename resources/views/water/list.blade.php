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
        <h2 class="main-content-title tx-24 mg-b-5">Water Management</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Water Management</li>
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
                    <h6 class="main-content-label">Water Management</h6>
                    @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('water-add'))
                        <a href="{{ route('water.create') }}" class="btn btn-primary">Add</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="fp-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Land</th>
                                <th>Source</th>
                                <th>Volume (Litr)</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($waters) && !$waters->isEmpty())
                                @foreach($waters as $key => $item)
                                    <tr class="tr-{{$item->id}}">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->land->name }}</td>
                                        <td>{{ $item->source }}</td>
                                        <td>{{ $item->volume }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ isset($item->date) && $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
                                        <td>
                                            @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('water-edit'))
                                                <a href="{{ route('water.edit', $item->id) }}" data-toggle="tooltip" title="Edit"> <i class="fa fa-pen text-primary mr-2"></i> </a>
                                            @endif
                                            @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('water-delete'))
                                                <a href="javascript:;" class="delete-water" data-id="{{ $item->id }}" data-route="{{ route('water.destroy', $item->id) }}" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
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
<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");

        $('.datatable').on('click', '.delete-water',function() {
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