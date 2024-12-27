@extends('layouts-verticalmenu-light.master')
@section('css')
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Edit Admin</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admins.index') }}"> Admins</a></li>
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
                    <h6 class="main-content-label">Admin Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('admins.update', $admin->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" required="" type="text" value="{{ old('name', $admin->name) }}">
                                @error('name') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Email <span class="text-danger">*</span></label>
                                <div class="pos-relative">
                                    <input class="form-control pd-r-80" name="email" required="" type="email" value="{{ old('email', $admin->email) }}">
                                    @error('email') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Password</label>
                                <input class="form-control" name="password" type="password">
                                <small>leave empty if don't want to change password</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Lands</label>
                                <select name="lands[]" id="lands" class="form-control select2" multiple>
                                    @if(isset($lands) && !empty($lands))
                                        @foreach($lands as $slug => $name)
                                            @if($admin->hasPermissionTo($slug))
                                                <option value="{{ $slug }}" selected>{{ $name }}</option>
                                            @else
                                                <option value="{{ $slug }}">{{ $name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    @if(isset($modules) && !$modules->isEmpty())
                        <div class="row row-sm mt-2">
                            <div>
                                <h6 class="main-content-label mb-1">Assign module</h6>
                                <p class="text-muted card-sub-title"> </p>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-nowrap text-md-nowrap table-bordered mg-b-0">
                                    <thead>
                                        <tr>
                                            <th class="wd-60p">Module name</th>
                                            <th class="wd-10p">Add</th>
                                            <th class="wd-10p">Edit</th>
                                            <th class="wd-10p">Delete</th>
                                            <th class="wd-10p">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($modules as $key => $module)
                                            @php
                                                $addSlug = $module->slug.'-add';
                                                $editSlug = $module->slug.'-edit';
                                                $deleteSlug = $module->slug.'-delete';
                                                $viewSlug = $module->slug.'-view';
                                            @endphp
                                            <tr>
                                                <th scope="row"> {{ ucfirst($module->name) }}</th>
                                                <td>
                                                    <label class="ckbox">
                                                        <input type="checkbox" name="permissions[]" class="add" value="{{ $addSlug }}" {{ $admin->can($addSlug) ? 'checked' : '' }} ><span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="ckbox">
                                                        <input type="checkbox" name="permissions[]" class="edit" value="{{ $editSlug }}" {{ $admin->can($editSlug) ? 'checked' : '' }} ><span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="ckbox">
                                                        <input type="checkbox" name="permissions[]" class="delete" value="{{ $deleteSlug }}" {{ $admin->can($deleteSlug) ? 'checked' : '' }} ><span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="ckbox">
                                                        <input type="checkbox" name="permissions[]" class="view" value="{{ $viewSlug }}" {{ $admin->can($viewSlug) ? 'checked' : '' }} ><span></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('admins.index') }}" class="btn btn-primary">Back</a>
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
</script>
@endsection