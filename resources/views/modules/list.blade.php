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
        <h2 class="main-content-title tx-24 mg-b-5">Modules</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modules</li>
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
                    <h6 class="main-content-label">Modules</h6>
                    @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('modules-add'))
                        <a href="{{ route('modules.create') }}" class="btn btn-primary">Add</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="module-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($modules) && !$modules->isEmpty())
                                @foreach($modules as $key => $module)
                                    <tr class="tr-{{$module->id}}">
                                        <td>{{ $module->id }}</td>
                                        <td>{{ $module->name }}</td>
                                        <td>
                                            @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('modules-edit'))
                                                <a href="{{ route('modules.edit', $module->id) }}" data-toggle="tooltip" title="Edit"> <i class="fa fa-pen text-primary mr-2"></i> </a>
                                            @endif
                                            @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('modules-delete'))
                                                <a href="javascript:;" class="delete-module" data-id="{{ $module->id }}" data-route="{{ route('modules.destroy', $module->id) }}" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
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

        $('.datatable').on('click', '.delete-module',function() {
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