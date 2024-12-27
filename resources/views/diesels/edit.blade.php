@extends('layouts-verticalmenu-light.master')
@section('css')
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Edit Diesel Management</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('diesels.index') }}"> Diesel Management</a></li>
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
                    <h6 class="main-content-label">Diesel Management Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('diesels.update', $diesel->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Volume (Litr) <span class="text-danger">*</span></label>
                                <input class="form-control" name="volume" required="" onkeypress="return onlyDecimal(event)" type="text" value="{{ old('volume', $diesel->volume) }}">
                                @error('volume') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Price / Litr <span class="text-danger">*</span></label>
                                <input class="form-control" name="price" required="" onkeypress="return onlyDecimal(event)" type="text" value="{{ old('price', $diesel->price) }}">
                                @error('price') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Payment person <span class="text-danger">*</span></label>
                                <input class="form-control" name="payment_person" required="" type="text" value="{{ old('payment_person', $diesel->payment_person) }}">
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
                            <a href="{{ route('diesels.index') }}" class="btn btn-primary">Back</a>
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
        $('.datepicker').datepicker("setDate", new Date('{{ date("Y,m,d", strtotime($diesel->date)) }}'));
    });
</script>
@endsection