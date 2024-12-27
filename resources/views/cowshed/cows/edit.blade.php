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
                <form class="parsley-validate" method="post" action="{{ route('cowshed.cows.update', $cow->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" required="" type="text" value="{{ old('name', $cow->name) }}">
                                @error('name') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Image </label>
                                <input class="form-control" name="image" type="file" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Tag number <span class="text-danger">*</span></label>
                                <input class="form-control" name="tag_number" type="number" value="{{ old('tag_number', $cow->tag_number) }}" required="">
                                @error('tag_number') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Milk (Litr)</label>
                                <input type="number" class="form-control" name="milk" value="{{ old('milk', $cow->milk) }}" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Age</label>
                                <input class="form-control" name="age" onkeypress="return onlyDecimal(event)" type="number" value="{{ old('age', $cow->age) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mg-b-20">
                                <label class="">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text" name="date" id="datepicker" value="{{ old('date', optional($cow->date)->format('m/d/Y')) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Father</label>
                                <select class="form-control select2" name="father" id="father">
                                    <option value="0">Select father</option>
                                    @if(isset($fathers))
                                        @foreach($fathers as $key => $value)
                                            <option value="{{ $key }}" {{ old('father', $cow->father) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Mother</label>
                                <select class="form-control select2" name="mother" id="mother">
                                    <option value="0">Select mother</option>
                                    @if(isset($mothers))
                                        @foreach($mothers as $key => $value)
                                            <option value="{{ $key }}" {{ old('mother', $cow->mother) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Grade</label>
                                <input class="form-control" name="grade" type="text" value="{{ old('grade', $cow->grade) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Gender</label>
                                <select class="form-control select2" name="gender" id="gender">
                                    <option value="0">Select gender</option>
                                    <option value="1" {{ old('gender', $cow->gender) == 1 ? 'selected' : '' }}>Male</option>
                                    <option value="2" {{ old('gender', $cow->gender) == 2 ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="">Remark</label>
                                <textarea class="form-control" name="remark" id="" cols="30" rows="5">{{ old('remark', $cow->remark) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('cowshed.cows.index') }}" class="btn btn-primary">Back</a>
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

        $('.fc-datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            defaultDate: 0, // Set defaultDate to 0 for today
        });
    });
</script>
@endsection