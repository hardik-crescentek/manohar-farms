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
        <h2 class="main-content-title tx-24 mg-b-5">Jivamrut fertilizer</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jivamrut fertilizer</li>
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
                    <h6 class="main-content-label">Jivamrut fertilizer</h6>
                    <a href="{{ route('jivamrut-fertilizer.create') }}" class="btn btn-primary">Add barrels</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="fp-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Size (Litr)</th>
                                <th>Ingredients</th>
                                <th>Total Barrels</th>
                                <th>Current Barrels</th>
                                <th>Removed Barrels</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($jivamrutFertilizers) && !$jivamrutFertilizers->isEmpty())
                                @foreach($jivamrutFertilizers as $jivamrutFertilizer)
                                    <tr class="tr-{{ $jivamrutFertilizer->id }}">
                                        <td>{{ $jivamrutFertilizer->id }}</td>
                                        <td> <a href="{{ route('jivamrut-fertilizer.show', $jivamrutFertilizer->id) }}"> {{ $jivamrutFertilizer->name }} </a></td>
                                        <td>{{ $jivamrutFertilizer->size }}</td>
                                        <td>{{ is_array($jivamrutFertilizer->ingredients) ? implode(', ', $jivamrutFertilizer->ingredients) : '' }}</td>
                                        <td>{{ $jivamrutFertilizer->total_barrels_sum   }}</td>
                                        <td>{{ $jivamrutFertilizer->current_barrels_sum  }}</td>
                                        <td>{{ $jivamrutFertilizer->removed_barrels_sum  }}</td>
                                        <td>{{ $jivamrutFertilizer->date != null ? date('d-m-Y', strtotime($jivamrutFertilizer->date)) : '' }}</td>
                                        <td>
                                            <a href="{{ route('jivamrut-fertilizer.edit', $jivamrutFertilizer->id) }}" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pen text-primary mr-2"></i>
                                            </a>
                                            <a href="javascript:;" class="delete-fertilizer-pesticides" data-id="{{ $jivamrutFertilizer->id }}" data-route="{{ route('jivamrut-fertilizer.destroy', $jivamrutFertilizer->id) }}" data-toggle="tooltip" title="Delete">
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

        $('.datatable').on('click', '.delete-fertilizer-pesticides',function() {
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