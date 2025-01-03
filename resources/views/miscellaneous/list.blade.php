@extends('layouts-verticalmenu-light.master')
@section('css')
    <!-- Internal DataTables css-->
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />

    <!-- Internal Sweet-Alert css-->
    <link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Miscellaneous</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Miscellaneous</li>
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
                        <h6 class="main-content-label">Miscellaneous Records</h6>
                        @if (Auth::user()->hasrole('super-admin') || Auth::user()->can('miscellaneous-add'))
                            <a href="{{ route('miscellaneous.create') }}" class="btn btn-primary">Add</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="miscellaneous-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Heading</th>
                                    <th>PDF</th>
                                    <th>Year</th>
                                    <th>Date</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($miscellaneous) && !$miscellaneous->isEmpty())
                                    @foreach ($miscellaneous as $item)
                                        <tr class="tr-{{ $item->id }}">
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @if ($item->image)
                                                    <img src="{{ asset('uploads/miscellaneouses/images/' . $item->image) }}"
                                                        alt="Image" width="50">
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->heading }}</td>
                                            <td>
                                                @if ($item->pdf)
                                                    <a href="{{ asset('uploads/miscellaneouses/pdfs/' . $item->pdf) }}"
                                                        target="_blank">View PDF</a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->year ?? 'N/A' }}</td>
                                            <td>{{ isset($item->date) ? date('d-m-Y', strtotime($item->date)) : 'N/A' }}
                                            </td>
                                            <td>{{ $item->remarks ?? 'N/A' }}</td>
                                            <td>
                                                @if (Auth::user()->hasrole('super-admin') || Auth::user()->can('miscellaneous-edit'))
                                                    <a href="{{ route('miscellaneous.edit', $item->id) }}"
                                                        data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-pen text-primary mr-2"></i>
                                                    </a>
                                                @endif
                                                @if (Auth::user()->hasrole('super-admin') || Auth::user()->can('miscellaneous-delete'))
                                                    <a href="javascript:;" class="delete-miscellaneous"
                                                        data-id="{{ $item->id }}"
                                                        data-route="{{ route('miscellaneous.destroy', $item->id) }}"
                                                        data-toggle="tooltip" title="Delete">
                                                        <i class="fa fa-trash text-danger"></i>
                                                    </a>
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
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <!-- Internal Sweet-Alert js-->
    <script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#global-loader").fadeOut("slow");

            $('.datatable').on('click', '.delete-miscellaneous', function() {
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
                                    swal("Deleted!", "Your data has been deleted.",
                                        "success");
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
