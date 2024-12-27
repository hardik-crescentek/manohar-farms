@extends('cowshed.layouts.master')
@section('css')
<!-- Internal DataTables css-->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
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
            <li class="breadcrumb-item"><a href="{{ route('cowshed.cows.index') }}">Cows</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="main-content-label">Cow detail</h6>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="label-value">
                            <strong>Name:</strong>
                            <span>{{ $cow->name ?? '' }}</span>
                        </div>
                        <div class="label-value mt-2">
                            <strong>date:</strong>
                            <span>{{ $cow->date ? date('d-m-Y', strtotime($cow->date)) : '' }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="label-value">
                            <strong>Tag number:</strong>
                            <span>{{ $cow->tag_number ?? '' }}</span>
                        </div>
                        <div class="label-value mt-2">
                            <strong>Grade:</strong>
                            <span> {{ $cow->grade ?? '' }} </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="label-value">
                            <strong>Mother name:</strong>
                            <span>{{ $cow->motherName->name ?? '' }}</span>
                        </div>
                        <div class="label-value mt-2">
                            <strong>Father name:</strong>
                            <span> {{ $cow->fatherName->name ?? '' }} </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="main-content-label">Vaccinations</h6>
                    <a href="javascript:;" class="btn btn-primary" data-target="#addVaccination" data-toggle="modal">Add</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="fp-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Disease Name</th>
                                <th>Medicine Name</th>
                                <th>date</th>
                                <th>Hospital/doctor</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($vaccinations))
                                @foreach($vaccinations as $key => $vaccination)
                                    <tr class="tr-{{$key + 1}}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $vaccination->disease_name }}</td>
                                        <td>{{ $vaccination->medicine_name }}</td>
                                        <td>{{ $vaccination->date }}</td>
                                        <td>{{ $vaccination->hospital }}</td>
                                        <!-- <td>
                                            <a href="javascript:;" data-toggle="tooltip" title="Edit"> <i class="fa fa-pen text-primary mr-2"></i> </a>
                                            <a href="javascript:;" class="delete-fertilizer-pesticides" data-id="1" data-route="javascript:;" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
                                        </td> -->
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

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="main-content-label">calfs</h6>
                    <!-- <a href="javascript:;" class="btn btn-primary" data-target="#addCalf" data-toggle="modal">Add</a> -->
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="fp-table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Gender</th>
                                <th>Name</th>
                                <th>date</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($calfs))
                                @foreach($calfs as $key => $calf)
                                    <tr class="tr-{{ $key + 1 }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $calf->gender }}</td>
                                        <td>{{ $calf->name }}</td>
                                        <td>{{ $calf->date != null ? date('d-m-Y', strtotime($calf->date)) : '' }}</td>
                                        <!-- <td>
                                            <a href="javascript:;" data-toggle="tooltip" title="Edit"> <i class="fa fa-pen text-primary mr-2"></i> </a>
                                            <a href="javascript:;" class="delete-fertilizer-pesticides" data-id="1" data-route="javascript:;" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
                                        </td> -->
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

@section('modal')
<div class="modal" id="addVaccination">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Vaccination</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="parsley-validate" method="post" action="{{ route('cowshed.vaccinations.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row row-sm">
                        <input type="hidden" name="cow_id" value="{{ $cow->id }}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Disease name <span class="text-danger">*</span></label>
                                <input class="form-control" name="disease_name" required="" type="text" value="{{ old('disease_name') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Medicine name</label>
                                <input class="form-control" name="medicine_name" required="" type="text" value="{{ old('medicine_name') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Hospital/Doctor</label>
                                <input class="form-control" name="hospital" type="text" value="{{ old('hospital') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="date" id="date" value="">
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

<div class="modal" id="addCalf">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Calf</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="parsley-validate" method="post" action="javascript:;" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row row-sm">
                        <input type="hidden" name="cow_id" value="1">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" required="" type="text" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Gender</label>
                                <input class="form-control" name="gender" type="text" value="{{ old('gender') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date">Birth Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="date" id="date" value="">
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
@endsection

@section('script')
<!-- Internal Data Table js -->
<script src="{{URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");

        $('.datatable').DataTable({
            // scrollX: true
        });
    });

    $(function() {
        $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            format: "d-m-yyyy"
        });
    });
</script>
@endsection