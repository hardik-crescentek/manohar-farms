@extends('layouts-verticalmenu-light.master')
@section('css')
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('notification-settings') }}">Notification Settings</a></li>
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
                    <h6 class="main-content-label">Notification Settings</h6>
                </div>
                <form class="parsley-validate" method="POST" action="{{ route('notification-settings.update', 1) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Water Notification</label>
                                <div class="input-group">
                                    <input class="form-control" name="water" type="text" value="{{ old('water', $notification->water) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">days</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Fertiliser Notification</label>
                                <div class="input-group">
                                    <input class="form-control" name="fertiliser" type="text" value="{{ old('fertiliser', $notification->fertiliser) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">days</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Flushing Notification</label>
                                <div class="input-group">
                                    <input class="form-control" name="flushing" type="text" value="{{ old('flushing', $notification->flushing) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">days</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Jivamrut Notification</label>
                                <div class="input-group">
                                    <input class="form-control" name="Jivamrut" type="text" value="{{ old('Jivamrut', $notification->Jivamrut) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">days</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Vermi Notification</label>
                                <div class="input-group">
                                    <input class="form-control" name="vermi" type="text" value="{{ old('vermi', $notification->vermi) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">days</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Plots Filter Cleaning Notification</label>
                                <div class="input-group">
                                    <input class="form-control" name="plots_filter_cleaning" type="text" value="{{ old('plots_filter_cleaning', $notification->plots_filter_cleaning) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">days</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Agenda Completion Notification</label>
                                <div class="input-group">
                                    <input class="form-control" name="agenda_completion" type="text" value="{{ old('agenda_completion', $notification->agenda_completion) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">days</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Diesel Notification</label>
                                <div class="input-group">
                                    <input class="form-control" name="diesel" type="text" value="{{ old('diesel', $notification->diesel) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Litrs</span>
                                    </div>
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
</script>
@endsection