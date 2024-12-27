@extends('layouts-verticalmenu-light.master')
@section('css')

@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Edit Camera Details</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cameras.index') }}"> Camera Details</a></li>
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
                    <h6 class="main-content-label">Camera Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('cameras.update', $cameras->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" required="" type="text" value="{{ old('name', $cameras->name) }}">
                                @error('name') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
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
                                <label class="">Camera Location <span class="text-danger">*</span></label>
                                <input class="form-control" name="camera_location" required="" type="text" value="{{ old('camera_location',$cameras->camera_location) }}">
                                @error('camera_location') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Amount <span class="text-danger">*</span></label>
                                <input class="form-control" name="amount" type="text" onkeypress="return onlyDecimal(event)" value="{{ old('amount',$cameras->amount) }}" required="">
                                @error('amount') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Purchase Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="purchase_date" id="purchase_date" value="">
                                    @error('purchase_date') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Memory Details</label>
                                <input class="form-control" name="memory_detail" type="text" value="{{ old('memory_detail',$cameras->memory_detail) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Sim Number</label>
                                <input class="form-control" name="sim_number" type="text" value="{{ old('sim_number',$cameras->sim_number) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Camera Company Name</label>
                                <input class="form-control" name="camera_company_name" type="text" value="{{ old('camera_company_name',$cameras->camera_company_name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Service Person Name</label>
                                <input class="form-control" name="service_person_name" type="text" value="{{ old('service_person_name',$cameras->service_person_name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Service Person Number</label>
                                <input class="form-control" name="service_person_number" type="text" value="{{ old('service_person_number',$cameras->service_person_number) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Last Cleaning Date </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="last_cleaning_date" id="last_cleaning_date" value="">
                                    @error('last_cleaning_date') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Recharge Notification</label>
                                <div class="input-group">
                                    <input class="form-control" name="recharge_notification" type="text" value="{{ old('recharge_notification',$cameras->recharge_notification) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">days</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('cameras.index') }}" class="btn btn-primary">Back</a>
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
        $('#purchase_date').datepicker({
            changeMonth: true,
            changeYear: true,
            format: "dd-mm-yyyy" // corrected date format
        });
        $('#purchase_date').datepicker("setDate", new Date('{{ date("Y-m-d", strtotime($cameras->purchase_date)) }}')); // corrected date format
    });

    $(function() {
        $('#last_cleaning_date').datepicker({
            changeMonth: true,
            changeYear: true,
            format: "dd-mm-yyyy" // corrected date format
        });
        $('#last_cleaning_date').datepicker("setDate", new Date('{{ date("Y-m-d", strtotime($cameras->last_cleaning_date)) }}')); // corrected date format
    });

</script>
@endsection