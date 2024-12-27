@extends('layouts-verticalmenu-light.master')
@section('css')

@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('bore-wells.index') }}">Bore & Wells Management</a></li>
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
                    <h6 class="main-content-label">Bore & Wells Management Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('bore-wells.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Select Type <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="type" id="type" required="">
                                    <option value="">Select Type</option>
                                    <option value="bore">Bore</option>
                                    <option value="Wells">Wells</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Land <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="land_id" id="land_id" required="">
                                    <option value="">Select land</option>
                                    @if(isset($lands) && !empty($lands))
                                        @foreach($lands as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
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
                                <input class="form-control" name="name" type="text" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Depth</label>
                                <input class="form-control" name="depth" type="text" value="{{ old('depth') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Select Status <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="status" id="status" required="">
                                    <option value="active">Active</option>
                                    <option value="inactive">InActive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('bore-wells.index') }}" class="btn btn-primary">Back</a>
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

        var rowCounter = 1;
        var rowWellsCounter = 1;

        $(document).on('click', '.add-row', function () {

            var rowHtml =   `<div class="row bore-detail" id="bore-row-`+rowCounter+`">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="">Land <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="bore_land_id" id="bore_land_name_`+rowCounter+`" required="">
                                            <option value="">Select land</option>
                                            @if(isset($lands) && !empty($lands))
                                                @foreach($lands as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('bore_land_id') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="">Bore Name</label>
                                        <input class="form-control" name="bore_name[]" id="bore_name_`+rowCounter+`" type="text" value="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="">Bore Filter</label>
                                        <input class="form-control" name="bore_filter[]" id="bore_filter_`+rowCounter+`" type="text" value="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success add-row mt-4">+</button>
                                        <button type="button" class="btn btn-danger remove-row mt-4" data-index="`+rowCounter+`">-</button>
                                    </div>
                                </div>
                            </div>`;
                        
           
            // Append the cloned row to the container
            $(".bore-detail:last").after(rowHtml);

            // Increment the row counter
            rowCounter++;
        });

        $(document).on('click', '.add-wells-row', function () {
            var rowWellsHtml =  `<div class="row wells-detail" id="wells-row-`+rowWellsCounter+`">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="">Land <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" name="wells_land_id" id="wells_land_name_`+rowWellsCounter+`" required="">
                                                            <option value="">Select land</option>
                                                            @if(isset($lands) && !empty($lands))
                                                                @foreach($lands as $id => $name)
                                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @error('wells_land_id') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="">Wells Name</label>
                                                        <input class="form-control" name="wells_name[]" id="wells_name_`+rowWellsCounter+`" type="text" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="">Wells Filter</label>
                                                        <input class="form-control" name="wells_filter[]" id="wells_filter_`+rowWellsCounter+`" type="text" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-success add-wells-row mt-4">+</button>
                                                        <button type="button" class="btn btn-danger remove-wells-row mt-4" data-index="`+rowWellsCounter+`">-</button>
                                                    </div>
                                                </div>
                                            </div>`;
            
                // Append the cloned row to the container
                $(".wells-detail:last").after(rowWellsHtml);

                // Increment the row counter
                rowWellsCounter++;
        });
    });

    // Remove row
    $(document).on('click', '.remove-row', function () {
        if ($(".bore-detail").length > 1) {
            var index = $(this).data('index');
            $("#bore-row-"+index).remove();
        }
    });
    $(document).on('click', '.remove-wells-row', function () {
        if ($(".wells-detail").length > 1) {
            var index = $(this).data('index');
            $("#wells-row-"+index).remove();
        }
    });
</script>
@endsection