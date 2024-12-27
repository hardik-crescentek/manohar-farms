@extends('layouts-verticalmenu-light.master')
@section('css')

@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('lands.index') }}">Plots</a></li>
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
                    <h6 class="main-content-label">Plots Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('lands.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Image</label>
                                <input class="form-control" name="image" type="file" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" required="" type="text" value="{{ old('name') }}">
                                @error('name') <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Plant <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="plant_id" id="plant_id">
                                    <option value="">Select plant</option>
                                    @if(isset($plants) && !empty($plants))
                                    @foreach($plants as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('plant_id') <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">No of plants</label>
                                <input class="form-control" name="plants" type="text" value="{{ old('plants') }}" onkeypress="return onlyNumbers(event)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">No of wells</label>
                                <input class="form-control" name="wells" type="text" value="{{ old('wells') }}" onkeypress="return onlyNumbers(event)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">No of valves</label>
                                <input class="form-control" name="pipeline" type="text" value="{{ old('pipeline') }}" onkeypress="return onlyNumbers(event)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Address</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="5">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('lands.index') }}" class="btn btn-primary">Back</a>
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