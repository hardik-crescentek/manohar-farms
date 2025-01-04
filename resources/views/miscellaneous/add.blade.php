@extends('layouts-verticalmenu-light.master')
@section('css')
@endsection
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('miscellaneous.index') }}">Miscellaneous</a></li>
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
                        <h6 class="main-content-label">Add Miscellaneous</h6>
                    </div>
                    <form class="parsley-validate" method="post" action="{{ route('miscellaneous.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Heading <span class="text-danger">*</span></label>
                                    <input class="form-control" name="heading" required="" type="text"
                                        value="{{ old('heading') }}">
                                    @error('heading')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Year</label>
                                    <input class="form-control" name="year" type="text" min="1900"
                                        max="{{ date('Y') }}" value="{{ old('year') }}">
                                    @error('year')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label>
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
                                    <label>PDF</label>
                                    <input class="form-control" name="pdf" type="file" accept="application/pdf">
                                    @error('pdf')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
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
                                            name="date" id="date" value="{{ old('date') }}">
                                    </div>
                                    @error('date')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remarks" rows="4">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm mt-4">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <a href="{{ route('miscellaneous.index') }}" class="btn btn-primary">Back</a>
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
            // Regular date picker for the 'date' field
            $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });
        });
    </script>
@endsection
