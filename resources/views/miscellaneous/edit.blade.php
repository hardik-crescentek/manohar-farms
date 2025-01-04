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
                        <h6 class="main-content-label">Edit Miscellaneous</h6>
                    </div>
                    <form class="parsley-validate" method="post"
                        action="{{ route('miscellaneous.update', $miscellaneous->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Heading <span class="text-danger">*</span></label>
                                    <input class="form-control" name="heading" required type="text"
                                        value="{{ old('heading', $miscellaneous->heading) }}">
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
                                        max="{{ date('Y') }}" value="{{ old('year', $miscellaneous->year) }}">
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
                                    <small class="text-muted">Current Image:</small>
                                    <div style="margin-top: 10px;">
                                        <img src="{{ asset('uploads/miscellaneouses/images/' . $miscellaneous->image) }}"
                                            alt="Image Preview"
                                            style="max-width: 150px; max-height: 150px; object-fit: contain; display: block;">
                                    </div>
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
                                    <small class="text-muted">Current PDF:</small>
                                    @if ($miscellaneous->pdf)
                                        <div style="margin-top: 10px;">
                                            <a href="{{ asset('uploads/miscellaneouses/pdfs/' . $miscellaneous->pdf) }}"
                                                target="_blank" class="btn btn-sm btn-primary">
                                                View PDF
                                            </a>
                                        </div>
                                    @else
                                        <p>No PDF available</p>
                                    @endif
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
                                            name="date" id="date" value="{{ old('date', $miscellaneous->date) }}">
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
                                    <textarea class="form-control" name="remarks" rows="4">{{ old('remarks', $miscellaneous->remarks) }}</textarea>
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
            $('.datepicker').datepicker("setDate", new Date(
                '{{ date('Y-m-d', strtotime($miscellaneous->date)) }}'));
        });
    </script>
@endsection
