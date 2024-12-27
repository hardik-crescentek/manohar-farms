@extends('layouts-verticalmenu-light.master')
@section('css')

@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('staffs.index') }}">Staffs</a></li>
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
                    <h6 class="main-content-label">Staffs Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('staffs.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-sm">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">Image </label>
                                <input class="form-control" name="image" type="file" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Type </label>
                            <div class="custom-radio-div">
                                <label class="rdiobox d-inline-block mr-4" for="salaried"><input type="radio" class="type" name="type" value="1" id="salaried" checked> <span>Salaried</span></label>
                                <label class="rdiobox d-inline-block" for="on-demand"><input type="radio" class="type" name="type" value="2" id="on-demand"> <span>On demand</span></label>
                            </div>
                        </div>
                        <div class="col-md-4 staff-type-container d-none">
                            <label for="">Staff Type </label>
                            <div class="custom-radio-div">
                                <label class="rdiobox d-inline-block mr-4" for="single"><input type="radio" class="staff_leader" name="staff_leader" value="0" id="single" checked> <span>Single staff</span></label>
                                <label class="rdiobox d-inline-block" for="leader"><input type="radio" class="staff_leader" name="staff_leader" value="1" id="leader"> <span>Leader</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span> </label>
                                <input class="form-control" name="name" required="" type="text" value="{{ old('name') }}">
                                @error('name') <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 salaried-container">
                            <div class="form-group">
                                <label class="">Salary</label>
                                <input class="form-control" name="salary" type="text" onkeypress="return onlyNumbers(event)" value="{{ old('salary') }}">
                            </div>
                        </div>
                        <div class="col-md-6 d-none demand-container">
                            <div class="form-group">
                                <label class="">Rate / day</label>
                                <input class="form-control" name="rate_per_day" type="text" onkeypress="return onlyNumbers(event)" value="{{ old('rate_per_day') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Email</label>
                                <input class="form-control" name="email" type="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Phone <span class="text-danger">*</span> </label>
                                <input class="form-control" name="phone" required="" type="text" onkeypress="return validatePhoneNumber(event)" value="{{ old('phone') }}">
                                @error('phone') <ul class="parsley-errors-list filled">
                                    <li class="parsley-required">{{ $message }}</li>
                                </ul> @enderror
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
                                    <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="joining_date" id="joining_date" value="">
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
                                    <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="resign_date" id="resign_date" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Role</label>
                                <input class="form-control" name="role" type="text" value="{{ old('role') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Address</label>
                                <textarea class="form-control" name="address" id="address" rows="5">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row team-detail d-none" id="team-row-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Staff Name <span class="text-danger">*</span> </label>
                                <input class="form-control" name="team_name[]" id="team_name_0" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Staff Role</label>
                                <input class="form-control" name="team_role[]" id="team_role_0" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Joining date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="team_joindate[]" id="team_joindate_0" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Resign date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="team_enddate[]" id="team_enddate_0" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-success add-row mt-4">+</button>
                                <button type="button" class="btn btn-danger remove-row mt-4" data-index="0">-</button>
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('staffs.index') }}" class="btn btn-primary">Back</a>
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
        $(document).on('click', '.add-row', function () {

            var rowHtml = `<div class="row team-detail" id="team-row-`+rowCounter+`">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Staff Name <span class="text-danger">*</span> </label>
                                        <input class="form-control" name="team_name[]" id="team_name_`+rowCounter+`" type="text" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">Staff Role</label>
                                        <input class="form-control" name="team_role[]" id="team_role_`+rowCounter+`" type="text" value="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="date">Joining date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fe fe-calendar lh--9 op-6"></i>
                                                </div>
                                            </div>
                                            <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="team_joindate[]" id="team_joindate_`+rowCounter+`" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="date">Resign date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fe fe-calendar lh--9 op-6"></i>
                                                </div>
                                            </div>
                                            <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="team_enddate[]" id="team_enddate_`+rowCounter+`" value="">
                                        </div>
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
            $(".team-detail:last").after(rowHtml);

            $("#team_joindate_" + rowCounter).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });

            $("#team_enddate_" + rowCounter).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });

            // Increment the row counter
            rowCounter++;
        });

        // Remove row
        $(document).on('click', '.remove-row', function () {
            if ($(".team-detail").length > 1) {
                var index = $(this).data('index');
                $("#team-row-"+index).remove();
            }
        });
    });

    $(function() {
        $('#joining_date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy"
        });
        $('#resign_date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy"
        });
        $("#team_joindate_0").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy"
        });
        $("#team_enddate_0").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy"
        });
    });

    $('.type').change(function() {
        var type = $(this).val();
        $('#single').prop('checked', true);
        if(type == 1) {
            $('.salaried-container').removeClass('d-none');
            $('.demand-container').addClass('d-none');
            $('.staff-type-container').addClass('d-none');
            $('.team-detail').addClass('d-none');
        } else {
            $('.salaried-container').addClass('d-none');
            $('.demand-container').removeClass('d-none');
            $('.staff-type-container').removeClass('d-none');
        }
    });

    $('.staff_leader').change(function() {
        var staffType = $(this).val();
        if(staffType == "1") {
            $('.team-detail').removeClass('d-none');
        } else {
            $('.team-detail').addClass('d-none');
        }
    });
</script>
@endsection