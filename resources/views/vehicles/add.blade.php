@extends('layouts-verticalmenu-light.master')
@section('css')

@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}">Vehicles and Attachments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
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
                <form class="parsley-validate" method="post" action="{{ route('vehicles.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <label for="">Type </label>
                            <div class="custom-radio-div">
                                <label class="rdiobox d-inline-block mr-4" for="vehicle"><input type="radio" class="type" name="type" value="1" id="vehicle" checked> <span>Vehicle</span></label>
                                <label class="rdiobox d-inline-block" for="attachments"><input type="radio" class="type" name="type" value="2" id="attachments"> <span>Attachments</span></label>
                            </div>
                            @error('type') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Documents</label>
                                <input id="documents" type="file" name="documents[]" accept=".jpg, .png, image/jpeg, image/png, doc, pdf" multiple>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span> </label>
                                <input class="form-control" name="name" required="" type="text" value="{{ old('name') }}">
                                @error('name') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Number <span class="text-danger">*</span> </label>
                                <input class="form-control" name="number" required="" type="text" value="{{ old('number') }}">
                                @error('number') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Service Cycle Type</label>
                                <select class="form-control select2" name="service_cycle_type" id="service_cycle_type">
                                    <option value="">Select Service Types</option>
                                    <option value="1">Day</option>
                                    <option value="2">Hours</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Service Vehicle Notification </label>
                                <input class="form-control" name="vehicle_notification" type="text" value="{{ old('vehicle_notification') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('vehicles.index') }}" class="btn btn-primary">Back</a>
                            <button type="submit" class="btn ripple btn-main-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $("#global-loader").fadeOut("slow");
    });
</script>
@endsection
