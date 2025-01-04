@extends('layouts-verticalmenu-light.master')

@section('css')
@endsection

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('plants.index') }}">Plants</a></li>
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
                        <h6 class="main-content-label">Plant Details</h6>
                    </div>
                    <form class="parsley-validate" method="POST" action="{{ route('plants.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="">Image</label>
                                    <input class="form-control" name="image" type="file" accept="image/*">
                                    @error('image')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" name="name" type="text" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="">Location</label>
                                    <input class="form-control" name="location" type="text"
                                        value="{{ old('location') }}">
                                    @error('location')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="">Area</label>
                                    <input class="form-control" name="area" type="text" value="{{ old('area') }}">
                                    @error('area')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="">Quantity <span class="text-danger">*</span></label>
                                    <input class="form-control" name="quantity" type="text"
                                        value="{{ old('quantity') }}" required>
                                    @error('quantity')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="">Price <span class="text-danger">*</span></label>
                                    <input class="form-control" name="price" type="text"
                                        onkeypress="return onlyDecimal(event)" value="{{ old('price') }}" required>
                                    @error('price')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="">Nursery</label>
                                    <input class="form-control" name="nursery" type="text" value="{{ old('nursery') }}">
                                    @error('nursery')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
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
                                        <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text"
                                            name="date" id="date" value="{{ old('date') }}">
                                        @error('date')
                                            <ul class="parsley-errors-list filled">
                                                <li class="parsley-required">{{ $message }}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm mt-4">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <a href="{{ route('plants.index') }}" class="btn btn-primary">Back</a>
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

        function onlyDecimal(event) {
            let key = event.keyCode || event.which;
            if ((key >= 48 && key <= 57) || key == 46 || key == 8 || key == 9) {
                return true;
            }
            return false;
        }
    </script>
@endsection
