@extends('cowshed.layouts.master')
@section('css')

@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cowshed.ghee-sellings.index') }}">Ghee management</a></li>
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
                    <h6 class="main-content-label">Ghee sellings Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('cowshed.ghee-sellings.update', $gheeSelling->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Image</label>
                                <input class="form-control" name="image" type="file" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <img src="{{ asset('uploads/ghee/'.$gheeSelling->image) }}" alt="" width="150">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Customer <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="customer_id" id="customer_id" required="">
                                    <option value="">Select plant</option>
                                    @if(isset($customers) && !empty($customers))
                                        @foreach($customers as $id => $name)
                                            <option value="{{ $id }}" {{ $gheeSelling->customer_id != null && $gheeSelling->customer_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('customer_id') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Customer name </label>
                                <input type="text" class="form-control" name="customer_name" value="{{ old('customer_name', $gheeSelling->customer_name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Quantity (Litr) </label>
                                <input class="form-control" name="quantity" onkeypress="return onlyDecimal(event)" type="text" value="{{ old('quantity', $gheeSelling->quantity) }}" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Price/Litr </label>
                                <input class="form-control" name="price" onkeypress="return onlyDecimal(event)" type="text" value="{{ old('price', $gheeSelling->price) }}">
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
                                    <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="date" id="date" value="{{ $gheeSelling->date != null ? date('d-m-Y', strtotime($gheeSelling->date)) : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('cowshed.ghee-sellings.index') }}" class="btn btn-primary">Back</a>
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

    $(function() {
        $('.datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            format: "d-m-yyyy"
        });
    });
</script>
@endsection