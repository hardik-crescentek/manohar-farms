@extends('cowshed.layouts.master')
@section('css')

@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cowshed.cows.index') }}">Cows</a></li>
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
                    <h6 class="main-content-label">Cows Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('cowshed.grass.update', $grass->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Type <span class="text-danger">*</span></label>
                                <input class="form-control" name="type" required="" type="text" value="{{ old('type', $grass->type) }}">
                                @error('type') <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul> @enderror
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
                                <label class="">Volume <span class="text-danger">*</span></label>
                                <input class="form-control" name="volume" type="text" onkeypress="return onlyDecimal(event)" value="{{ old('volume', $grass->volume) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Amount <span class="text-danger">*</span></label>
                                <input class="form-control" name="amount" type="text" onkeypress="return onlyDecimal(event)" value="{{ old('amount', $grass->amount) }}" required="">
                                @error('amount') <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control datepicker" placeholder="DD-MM-YYYY" type="text" name="date" id="date" value="{{ $grass->date != null ? date('d-m-Y', strtotime($grass->date)) : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Payment person</label>
                                <input class="form-control" name="payment_person" type="text" value="{{ old('payment_person', $grass->payment_person) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('cowshed.grass.index') }}" class="btn btn-primary">Back</a>
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

        $('.datepicker').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: 'dd-mm-yy'
        });
    });
</script>
@endsection