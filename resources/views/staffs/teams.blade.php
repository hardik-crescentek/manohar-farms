@extends('layouts-verticalmenu-light.master')
@section('css')
<!-- Internal DataTables css-->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />

<!-- Internal Sweet-Alert css-->
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">

<style>
    .ui-datepicker {
        z-index: 9999 !important;
        top: 342px !important;
    }
</style>
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Team</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('staffs.index') }}">Staff</a></li>
            <li class="breadcrumb-item active" aria-current="page">Team</li>
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
                    <h6 class="main-content-label">Staff Team</h6>
                    <a href="javascript:;" title="Add" data-target="#addStaffMember" data-toggle="modal" class="btn btn-primary"> Add </a>
                </div>
                <div class="table-responsive" id="staff-container">
                    <table class="table table-bordered datatable" id="staffs-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Joindate</th>
                                <th>Enddate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($teamMembers) && $teamMembers)
                                @foreach($teamMembers as $key => $member)
                                    <tr class="tr-{{ $key + 1 }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->role }}</td>
                                        <td>{{ isset($member->join_date) && $member->join_date != null ? date('d-m-Y', strtotime($member->join_date)) : '' }}</td>
                                        <td>{{ isset($member->end_date) && $member->end_date != null ? date('d-m-Y', strtotime($member->end_date)) : '' }}</td>
                                        <td>
                                            <a href="javascript:;" title="Edit" data-target="#editStaffMember{{$member->id}}" data-toggle="modal"> <i class="fa fa-pen text-primary mr-2"></i> </a>

                                            <div class="modal" id="editStaffMember{{$member->id}}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">Edit Staff Member</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <form class="parsley-validate" method="post" action="{{ route('staff-member.update', $member->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <input type="hidden" name="staff_id" value="{{ $member->staff_id }}">
                                                                <div class="row row-sm">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="">Name <span class="text-danger">*</span></label>
                                                                            <input class="form-control" name="name" required="" type="text" value="{{ $member->name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="">Role</label>
                                                                            <input class="form-control" name="role" type="text" value="{{ $member->role }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="date">Joining date <span class="text-danger">*</span></label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text">
                                                                                        <i class="fe fe-calendar lh--9 op-6"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <input class="form-control joining-date" required="" placeholder="DD/MM/YYYY" type="text" name="joining_date" id="joining_date{{$member->id}}" value="{{ $member->join_date != null ? date('d-m-Y', strtotime($member->join_date)) : '' }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="date">End date</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text">
                                                                                        <i class="fe fe-calendar lh--9 op-6"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <input class="form-control resign-date" placeholder="DD/MM/YYYY" type="text" name="resign_date" id="resign_date{{$member->id}}" value="{{ $member->end_date != null ? date('d-m-Y', strtotime($member->end_date)) : '' }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn ripple btn-primary" type="submit">Save changes</button>
                                                                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="javascript:;" class="delete-team-member" data-id="{{ $member->id }}" data-route="{{ route('staff-member.delete', $member->id) }}" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
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

<div class="modal" id="addStaffMember">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Staff Member</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="parsley-validate" method="post" action="{{ route('staff-member.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="staff_id" value="{{ $leader_id }}">
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" required="" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Role</label>
                                <input class="form-control" name="role" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Joining date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control joining-date" required="" placeholder="DD/MM/YYYY" type="text" name="joining_date" id="joining_date" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">End date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control resign-date" placeholder="DD/MM/YYYY" type="text" name="resign_date" id="resign_date" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit">Save changes</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                </div>
            </form>
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

        $(function() {
            $('.joining-date').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy",
                defaultDate: null
            });

            $('.resign-date').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy",
                defaultDate: null
            });
        });

        $('.datatable').on('click', '.delete-team-member',function() {
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