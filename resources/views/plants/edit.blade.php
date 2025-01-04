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
                        <h6 class="main-content-label">Edit Plant</h6>
                    </div>
                    <form class="parsley-validate" method="post" action="{{ route('plants.update', $plant->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input class="form-control" name="image" type="file" accept="image/*">
                                    <small class="text-muted">Current Image:</small>
                                    <div style="margin-top: 10px;">
                                        <img src="{{ asset('uploads/plants/' . $plant->image) }}" alt="Image Preview"
                                            style="max-width: 150px; max-height: 150px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input class="form-control" name="name" required type="text"
                                        value="{{ old('name', $plant->name) }}">
                                    @error('name')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input class="form-control" name="location" type="text"
                                        value="{{ old('location', $plant->location) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Area</label>
                                    <input class="form-control" name="area" type="text"
                                        value="{{ old('area', $plant->area) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantity <span class="text-danger">*</span></label>
                                    <input class="form-control" name="quantity" required type="text"
                                        value="{{ old('quantity', $plant->quantity) }}">
                                    @error('quantity')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input class="form-control" name="price" required type="text"
                                        onkeypress="return onlyDecimal(event)" value="{{ old('price', $plant->price) }}">
                                    @error('price')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nursery</label>
                                    <input class="form-control" name="nursery" type="text"
                                        value="{{ old('nursery', $plant->nursery) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text"
                                            name="date" value="{{ old('date', $plant->date) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm mt-4">
                            <div class="col-md-12">
                                <a href="{{ route('plants.index') }}" class="btn btn-primary">Back</a>
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
                dateFormat: "yy-mm-dd"
            });

            // Set existing date
            $('.datepicker').datepicker("setDate", new Date('{{ date('Y-m-d', strtotime($plant->date)) }}'));
        });
    </script>
@endsection
