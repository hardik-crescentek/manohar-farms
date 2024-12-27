@extends('layouts-verticalmenu-light.master')
@section('css')

@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Edit Bore & Wells Management</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('bore-wells.index') }}">Bore & Wells Management</a></li>
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
                    <h6 class="main-content-label">Bore & Wells Management Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('bore-wells.update', $boreWell->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Type <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="type" id="type">
                                    <option value="">Select Type</option>
                                    @if(isset($types) && !empty($types))
                                        @foreach($types as $id => $type)
                                            <option value="{{ $id }}" {{ $boreWell->type != null && $boreWell->type == $id ? 'selected' : '' }}>
                                            {{ ucwords($type) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('type') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Land <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="land_id" id="land_id">
                                    <option value="">Select land</option>
                                    @if(isset($lands) && !empty($lands))
                                        @foreach($lands as $id => $name)
                                            <option value="{{ $id }}" {{ $boreWell->land_id != null && $boreWell->land_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('land_id') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Image</label>
                                <input class="form-control" name="image" type="file" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Name/Location</label>
                                <input class="form-control" name="name" type="text" value="{{ old('name',$boreWell->name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Depth</label>
                                <input class="form-control" name="depth" type="text" value="{{ old('depth',$boreWell->depth) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Select Status <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="status" id="status">
                                    @if(isset($status) && !empty($status))
                                        @foreach($status as $id => $status)
                                            <option value="{{ $id }}" {{ $boreWell->status != null && $boreWell->status == $id ? 'selected' : '' }}>
                                            {{ ucwords($status) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('bore-wells.index') }}" class="btn btn-primary">Back</a>
                            <button type="submit" class="btn ripple btn-main-primary">Save</button>
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