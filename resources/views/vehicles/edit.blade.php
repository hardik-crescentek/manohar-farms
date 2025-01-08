@extends('layouts-verticalmenu-light.master')
@section('css')
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">

<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<style>
    .ui-datepicker {
        z-index: 9999 !important;
        top: 260px !important;
    }
</style>
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Edit Vehicles and Attachments</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}"> Vehicles and Attachments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="main-content-label">Vehicles and Attachments Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('vehicles.update', $vehicle->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <label for="">Type </label>
                            <div class="custom-radio-div">
                                <label class="rdiobox d-inline-block mr-4" for="vehicle"><input type="radio" class="type" name="type" value="1" id="vehicle" {{ $vehicle->type == 1 ? 'checked' : '' }}> <span>Vehicle</span></label>
                                <label class="rdiobox d-inline-block" for="attachments"><input type="radio" class="type" name="type" value="2" id="attachments" {{ $vehicle->type == 2 ? 'checked' : '' }}> <span>Attachments</span></label>
                            </div>
                            @error('type') <ul class="parsley-errors-list filled">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul> @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Documents</label>
                                <input id="documents" type="file" name="documents[]" accept=".jpg, .png, image/jpeg, image/png, doc, pdf" multiple>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" required="" type="text" value="{{ old('name', $vehicle->name) }}">
                                @error('name') <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Number <span class="text-danger">*</span></label>
                                <input class="form-control" name="number" required="" type="text" value="{{ old('number', $vehicle->number) }}">
                                @error('number') <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Service Cycle Type</label>
                                <!-- <select class="form-control select2" name="service_cycle_type" id="service_cycle_type" value="{{ old('service_cycle_type', $vehicle->service_cycle_type) }}">
                                    <option value="">Select Service Types</option>
                                    <option value="1">Day</option>
                                    <option value="2">Hours</option>
                                </select> -->
                                <select class="form-control select2" name="service_cycle_type" id="service_cycle_type">
                                    <option value="">Select Service Types</option>
                                    @if(isset($serviceTypes) && !empty($serviceTypes))
                                        @foreach($serviceTypes as $id => $name)
                                            <option value="{{ $id }}" {{ $vehicle->service_cycle_type != null && $vehicle->service_cycle_type == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('land_id') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Service Vehicle Notification </label>
                                <input class="form-control" name="vehicle_notification" type="text" value="{{ old('vehicle_notification', $vehicle->vehicle_notification) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('vehicles.index') }}" class="btn btn-primary">Back</a>
                            <button type="submit" class="btn ripple btn-main-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="main-content-label">Vehicles and Attachments Documents</h6>
                </div>
                <div class="row row-sm document-container">
                    <ul class="">
                        <input type="hidden" id="vehicle_id" value="{{ $vehicle->id }}">
                        @php
                        $documents = isset($vehicle->documents) && $vehicle->documents != null ? $vehicle->documents : [];
                        @endphp

                        <div class="grid-container">
                            @foreach($documents as $key => $document)
                            <div class="box">
                                <div class="name">{{ $document }}</div>
                                <img src="{{ asset('uploads/vehicles_and_attachments/'.$document) }}" alt="{{ $document }}" class="image">
                                <div class="overlay">
                                    <div class="overlay-content">
                                        <img src="{{ asset('uploads/vehicles_and_attachments/'.$document) }}" alt="{{ $document }}" style="max-width: 100%; max-height: 100%;">
                                    </div>
                                </div>
                                <div class="box-content">
                                    <div class="icons">
                                        <a href="{{ asset('uploads/vehicles_and_attachments/'.$document) }}" download="" data-doc="{{ $document }}" data-id="{{ $key }}" class="download-icon">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        <a href="javascript:;" data-doc="{{ $document }}" data-id="{{ $key }}" class="delete-icon">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </ul>
                </div>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="main-content-label">Vehicles Services</h6>
                            @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('vehicle-services-add'))
                                <a href="javascript:;" class="btn btn-primary" data-target="#addVehicleService" data-toggle="modal">Add</a>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered datatable" id="vehicles-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Service</th>
                                        <th>Price</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($vehicleServices) && !$vehicleServices->isEmpty())
                                        @foreach($vehicleServices as $key => $item)
                                            <tr class="tr-{{$item->id}}">
                                                <td>{{ $key + 1 }}</td>
                                                <td> {{ $item->service }} </td>
                                                <td> {{ $item->price }} </td>
                                                <td> {{ $item->note }} </td>
                                                <td>{{ isset($item->date) && $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}</td>
                                                <td>
                                                    @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('vehicle-services-edit'))
                                                        <a href="javascript:;" data-target="#editVehicleService{{$item->id}}" data-toggle="modal"><i class="fa fa-pen text-primary mr-2"></i></a>
                                                        <div class="modal" id="editVehicleService{{$item->id}}">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content modal-content-demo">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title">Edit Vehicle service</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <form class="parsley-validate" method="post" action="{{ route('vehicle.service-update', $item->id) }}" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body">
                                                                            <div class="row row-sm">
                                                                                <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="">Service type <span class="text-danger">*</span></label>
                                                                                        <input class="form-control" name="service" required="" type="text" value="{{ old('service', $item->service) }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="date">Date <span class="text-danger">*</span></label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <div class="input-group-text">
                                                                                                    <i class="fe fe-calendar lh--9 op-6"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <input class="form-control datepicker" required="" placeholder="YYYY/MM/DD" type="text" name="date" id="date" value="{{ date('d-m-Y', strtotime($item->date)) }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="">Service Price <span class="text-danger">*</span></label>
                                                                                        <input class="form-control" name="price" required="" type="text" value="{{ old('price', $item->price) }}" required="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="">Remark</label>
                                                                                        <input class="form-control" name="note" type="text" value="{{ old('note', $item->note) }}">
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
                                                    @endif
                                                    @if(Auth::user()->hasrole('super-admin') || Auth::user()->can('vehicle-services-delete'))
                                                    <a href="javascript:;" class="delete-service" data-id="{{ $item->id }}" data-route="{{ route('vehicle.service-destroy', $item->id) }}" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash text-danger"></i> </a>
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
    </div>
</div>
<!-- End Row -->

@endsection

@section('modal')
<div class="modal" id="addVehicleService">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Vehicle service</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="parsley-validate" method="post" action="{{ route('vehicle.service-store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row row-sm">
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Service type <span class="text-danger">*</span></label>
                                <input class="form-control" name="service" required="" type="text" value="{{ old('service') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date">Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control datepicker" required="" placeholder="YYYY/MM/DD" type="text" name="date" id="date" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Service Price <span class="text-danger">*</span></label>
                                <input class="form-control" name="price" required="" type="text" value="{{ old('price') }}" required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Remark</label>
                                <input class="form-control" name="note" type="text" value="{{ old('note') }}">
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
<script src="{{URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>

<script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");

        $('.delete-icon').click(function() {
            var name = $(this).data('doc');
            var elementId = $(this).data('id');
            var id = $('#vehicle_id').val();

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
                            url: "{{ route('vehicle.delete-document') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                document: name,
                                id: id
                            },
                            success: function(response) {
                                swal("Deleted!", "Your data has been deleted.", "success");
                                $('#doc-' + elementId).remove();
                            }
                        });
                    } else {
                        swal("Cancelled", "Your data is safe :)", "error");
                    }
                });
        });

        $('.datatable').on('click', '.delete-service',function() {
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

    $('.modal').on('shown.bs.modal', function () {
        $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            format: "d-m-yyyy"
        });
    });
</script>
@endsection
