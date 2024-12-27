@extends('layouts-verticalmenu-light.master')
@section('css')

@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Edit Diesel Entry</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('diesel-entries.index') }}"> Diesel Entry</a></li>
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
                    <h6 class="main-content-label">Diesel Entry Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('diesel-entries.update', $dieselEntry->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Vehicle <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="vehicle_id" id="vehicle_id">
                                    <option value="">Select vehicle</option>
                                    @if(isset($vehicles) && !empty($vehicles))
                                        @foreach($vehicles as $id => $name)
                                            <option value="{{ $id }}" {{ isset($dieselEntry->vehicle_id) && $dieselEntry->vehicle_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('vehicle_id') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Volume (Litr) <span class="text-danger">*</span></label>
                                <input class="form-control" name="volume" required="" onkeypress="return onlyDecimal(event)" type="text" value="{{ old('volume', $dieselEntry->volume) }}">
                                @error('volume') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Person </label>
                                <input class="form-control" name="payment_person" type="text" value="{{ old('payment_person', $dieselEntry->payment_person) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Amount </label>
                                <input class="form-control" name="amount" onkeypress="return onlyDecimal(event)" type="text" value="{{ old('amount', $dieselEntry->amount) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
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
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('diesel-entries.index') }}" class="btn btn-primary">Back</a>
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

    $(function() {
        $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            format: "d-m-yyyy"
        });
        $('.datepicker').datepicker("setDate", new Date('{{ date("Y,m,d", strtotime($dieselEntry->date)) }}'));
    });
</script>
@endsection