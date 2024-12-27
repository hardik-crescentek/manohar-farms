@extends('layouts-verticalmenu-light.master')
@section('css')
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Edit Staff</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('staffs.index') }}"> Staff</a></li>
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
                    <h6 class="main-content-label">Staffs Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('staffs.update', $staff->id) }}" enctype="multipart/form-data">
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
                                <img src="{{ asset('uploads/staffs/'.$staff->image) }}" alt="" width="150">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Type </label>
                            <div class="custom-radio-div">
                                <label class="rdiobox d-inline-block mr-4" for="salaried">
                                    <input type="radio" class="type" name="type" value="1" id="salaried" {{ $staff->type == 1 ? 'checked' : '' }}> <span>Salaried</span>
                                </label>
                                <label class="rdiobox d-inline-block" for="on-demand">
                                    <input type="radio" class="type" name="type" value="2" id="on-demand" {{ $staff->type == 2 ? 'checked' : '' }}> <span>On demand</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 {{ $staff->type != 1 ? 'd-none' : '' }} salaried-container">
                            <div class="form-group">
                                <label class="">Salary</label>
                                <input class="form-control" name="salary" type="text" onkeypress="return onlyNumbers(event)" value="{{ old('salary', $staff->salary) }}">
                            </div>
                        </div>
                        <div class="col-md-6 {{ $staff->type != 2 ? 'd-none' : '' }} demand-container">
                            <div class="form-group">
                                <label class="">Rate / day</label>
                                <input class="form-control" name="rate_per_day" type="text" onkeypress="return onlyNumbers(event)" value="{{ old('rate_per_day', $staff->rate_per_day) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span> </label>
                                <input class="form-control" name="name" required="" type="text" value="{{ old('name', $staff->name) }}">
                                @error('name') <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">Phone <span class="text-danger">*</span> </label>
                                <input class="form-control" name="phone" required="" type="text" onkeypress="return validatePhoneNumber(event)" value="{{ old('phone', $staff->phone) }}">
                                @error('phone') <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">Email</label>
                                <input class="form-control" name="email" type="email" value="{{ old('email', $staff->email) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Joining date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" placeholder="YYYY/MM/DD" type="text" name="joining_date" id="joining_date" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Resign date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" placeholder="YYYY/MM/DD" type="text" name="resign_date" id="resign_date" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Role</label>
                                <input class="form-control" name="role" type="text" value="{{ old('role', $staff->role) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Address</label>
                                <textarea class="form-control" name="address" id="address" rows="5">{{ old('address', $staff->address) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('staffs.index') }}" class="btn btn-primary">Back</a>
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
        $('#joining_date').datepicker({
            changeMonth: true,
            changeYear: true,
            format: "d-m-yyyy"
        });
        $('#joining_date').datepicker("setDate", new Date('{{ date("Y,m,d", strtotime($staff->joining_date)) }}'));

        $('#resign_date').datepicker({
            changeMonth: true,
            changeYear: true,
            format: "d-m-yyyy"
        });
        $('#resign_date').datepicker("setDate", new Date('{{ date("Y,m,d", strtotime($staff->resign_date)) }}'));
    });

    $('.type').change(function() {
        $('.salaried-container').toggleClass('d-none');
        $('.demand-container').toggleClass('d-none');
    });
</script>
@endsection