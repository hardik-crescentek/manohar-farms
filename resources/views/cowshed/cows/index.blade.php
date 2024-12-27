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
        <h2 class="main-content-title tx-24 mg-b-5">Cows</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cows</li>
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
                    <h6 class="main-content-label">Cows</h6>
                    <a href="{{ route('cowshed.cows.create') }}" class="btn btn-primary">Add</a>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <div class="custom-radio-div">
                        <label class="rdiobox d-inline-block mr-4" for="all"><input type="radio" class="type" name="type" value="0" id="all" checked> <span>All</span></label>
                        <label class="rdiobox d-inline-block mr-4" for="salaried"><input type="radio" class="type" name="type" value="1" id="salaried"> <span>Mliking</span></label>
                        <label class="rdiobox d-inline-block" for="on-demand"><input type="radio" class="type" name="type" value="2" id="on-demand"> <span>non milking</span></label>
                    </div>
                </div>
                <div class="table-responsive" id="cows-container">

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

        $('.datatable').on('click', '.delete-cowshed-cows',function() {
            alert("sac");
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

        getTable();
    });

    $('.datatable').DataTable({
        // scrollX: true
    });

    $('.type').change(function() {
        getTable();
    });

    function getTable() {

        var type = $('input[name="type"]:checked').val();

        $.ajax({
            url: "{{ route('cowshed.cows.get-table') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                type: type
            },
            success: function(res) {
                $('#cows-container').html(res);
                $('.datatable').DataTable({
                    // scrollX: true
                });
            }
        });
    }
</script>
@endsection