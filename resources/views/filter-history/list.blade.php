@extends('layouts-verticalmenu-light.master')
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<!-- InternalFancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">

<style>
    .ui-datepicker {
        z-index: 9999 !important;
        top: 235px !important;
    }
</style>
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('bore-wells.index') }}">Bore & Wells</a></li>
            <li class="breadcrumb-item active" aria-current="page">Filter History</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

@include('common.alerts')

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="main-content-label">Filter history</h6>
                    @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('bore-wells-add'))
                        <a href="{{ route('filter-history.create',['id' => $boreWells->id]) }}" class="btn btn-primary">Add</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="filter-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Company</th>
                                <th>Cleaning Notificatin</th>
                                <th>Clening Date</th>
                                <th>Next Cleaning Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @if(isset($filterHistory) && !$filterHistory->isEmpty())
                                    @foreach($filterHistory as $key => $filterHistory)
                                        <tr class="tr-{{$filterHistory->id}}">
                                            <td>{{ $filterHistory->id }}</td>
                                            <td>{{ $filterHistory->name }}</td>
                                            <td>{{ $filterHistory->location }}</td>
                                            <td>{{ $filterHistory->company }}</td>
                                            <td>{{ $filterHistory->filter_notification . ' Days' }}</td>
                                            <td>{{ isset($filterHistory->last_cleaning_date) && $filterHistory->last_cleaning_date != null ? date('d-m-Y', strtotime($filterHistory->last_cleaning_date)) : '' }}</td>
                                            <td>{{ isset($filterHistory->last_cleaning_date) && isset($filterHistory->filter_notification) && $filterHistory->last_cleaning_date != null ? date('d-m-Y', strtotime($filterHistory->last_cleaning_date . ' + ' . $filterHistory->filter_notification . ' days')) : '' }}</td>
                                            <td>
                                                @if(Auth::user()->hasrole('super-admin'))
                                                    <a href="{{ route('filter-history.edit',['boreWellsId' => $filterHistory->id,'id' => $filterHistory->id]) }}" data-toggle="tooltip" title="Edit"> <i class="fa fa-pen text-primary mr-2"></i> </a>
                                                @endif
                                                @if(Auth::user()->hasrole('super-admin'))
                                                    <a href="javascript:;" class="delete-filter-history" data-id="{{ $filterHistory->id }}" data-route="{{ route('filter-history.destroy', $filterHistory->id) }}" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
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
<!-- InternalFancy uploader js-->
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>

<script src="{{URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>

<script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>

<script src="{{URL::asset('assets/js/select2.js')}}"></script>

<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");

        $('.select2').select2();

        $('.datatable').on('click', '.delete-filter-history',function() {
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