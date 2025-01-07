@extends('layouts-verticalmenu-light.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />
    <!-- InternalFancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">

    <style>
        .ui-datepicker {
            z-index: 9999 !important;
            top: 235px !important;
        }
    </style>
@endsection
@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('lands.index') }}">Lands</a></li>
                <li class="breadcrumb-item active" aria-current="page">Map</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    @include('common.alerts')

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="{{ route('plants-reports.index') }}">
                        <!-- <label class="main-content-label mb-3 pt-1">Total Water used (Litr)</label> -->
                        <label class="main-content-label mb-3 pt-1">Total Water used (Hours)</label>
                        <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{ number_format($totalWaterUsed, 0) }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="{{ route('plants-reports.index') }}">
                        <!-- <label class="main-content-label mb-3 pt-1">This month Water used (Litr)</label> -->
                        <label class="main-content-label mb-3 pt-1">This month Water used (Hours)</label>
                        <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{ number_format($currentMonthWaterUsed, 0) }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="{{ route('plants-reports.index') }}">
                        <label class="main-content-label mb-3 pt-1">Total water expenses</label>
                        <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">₹{{ number_format($totalWaterExpense, 0) }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="javascript:;">
                        <label class="main-content-label mb-3 pt-1">This month water expenses</label>
                        <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">₹{{ number_format($currentMonthWaterExpense, 0) }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="javascript:;">
                        <label class="main-content-label mb-3 pt-1">Total wells</label>
                        <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{ $land->wells }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card custom-card">
                <div class="card-body">
                    <a class="card-order" href="javascript:;">
                        <label class="main-content-label mb-3 pt-1">Total pipelines</label>
                        <h2 class="text-right"><i class="mdi mdi-water icon-size float-left text-primary"></i><span
                                class="font-weight-bold">{{ $land->pipeline }}</span></h2>
                        <p class="mb-0 mt-4 text-muted"> - <span class="float-right"> </span></p>
                    </a>
                </div>
            </div>
        </div>

        {{-- @if ($latestEntry)
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <div class="card custom-card">
                    <div class="card-body">
                        <a class="card-order" href="javascript:;">
                            <label class="main-content-label mb-3 pt-1">Last Open Valve in
                                ({{ $land->name ?? 'N/A' }})</label>

                            <!-- Farm Information -->
                            <h2 class="text-right">
                                <i class="mdi mdi-water icon-size float-left text-primary"></i>
                                <span class="font-weight-bold">{{ $latestEntry['landPartName'] ?? 'N/A' }}</span>
                            </h2>
                            <p class="mb-2 text-muted">
                                {{ $latestEntry['entry']->time->format('h:i A') ?? 'N/A' }}
                                <span
                                    class="float-right">{{ optional($latestEntry['entry']->date)->format('d-m-Y') ?? 'N/A' }}</span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <p class="text-muted text-center">No water entry records found.</p>
            </div>
        @endif --}}

        {{-- Test Code --}}

        {{-- @if ($latestEntries && count($latestEntries) > 0)
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <a class="card-order" href="javascript:;">
                            <!-- Label for the last open valve -->
                            <label class="main-content-label mb-3 pt-1">
                                Last Open Valve in ({{ isset($land->name) ? $land->name : 'N/A' }})
                            </label>
                        </a>

                        <!-- Row for the three sections -->
                        <div class="row flex-wrap">
                            @foreach ($latestEntries as $entry)
                                <!-- Check if the type has valid data -->
                                @if (!empty($entry['entry']))
                                    <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                        <div class="d-flex flex-column ">
                                            <!-- Type and Valve -->
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted">
                                                    {{ isset($entry['type']) ? $entry['type'] : 'N/A' }}
                                                </span>
                                                <span class="text-muted">
                                                    {{ isset($entry['landParts']) ? $entry['landParts'] : 'N/A' }}
                                                </span>
                                            </div>

                                            <!-- Date and Time -->
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted">
                                                    {{ isset($entry['date']) && $entry['date'] != 'N/A' ? \Carbon\Carbon::parse($entry['date'])->format('d-m-Y') : 'N/A' }}
                                                </span>
                                                <span class="text-muted">
                                                    {{ isset($entry['time']) && $entry['time'] != 'N/A' ? \Carbon\Carbon::parse($entry['time'])->format('h:i A') : 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <p class="text-muted text-center">No water entry records found.</p>
            </div>
        @endif --}}

        @if ($latestEntries && count($latestEntries) > 0)
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            @foreach ($latestEntries as $entry)
                                @if (!empty($entry['entry']))
                                    @php
                                        // Determine the column size dynamically
                                        $colSize = match (count($latestEntries)) {
                                            1 => 'col-12', // Full-width for 1 entry
                                            2 => 'col-6', // Half-width for 2 entries
                                            default => 'col-md-4', // 4-columns for 3 or more entries
                                        };
                                    @endphp
                                    <div class="{{ $colSize }} mb-2">
                                        <div class="d-flex flex-column p-2 ">
                                            <!-- Type Name at the top -->
                                            <label class="main-content-label text-center">
                                                Last Open Valve in ({{ isset($entry['type']) ? $entry['type'] : 'N/A' }})
                                            </label>

                                            <!-- Valve (Land Parts) -->
                                            <div class="text-center">
                                                <span class="text-muted">
                                                    {{ isset($entry['landParts']) ? $entry['landParts'] : 'N/A' }}
                                                </span>
                                            </div>

                                            <!-- Date and Time -->
                                            <div class="d-flex justify-content-between mt-2">
                                                <span class="text-muted">
                                                    {{ isset($entry['date']) && $entry['date'] != 'N/A' ? \Carbon\Carbon::parse($entry['date'])->format('d-m-Y') : 'N/A' }}
                                                </span>
                                                <span class="text-muted">
                                                    {{ isset($entry['time']) && $entry['time'] != 'N/A' ? \Carbon\Carbon::parse($entry['time'])->format('h:i A') : 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <p class="text-muted text-center">No water entry records found.</p>
            </div>
        @endif
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="main-content-label">Lands Map</h6>
                    </div>
                    @if (isset($land->documents) && $land->documents != null)
                        <div class="col-md-12">
                            <iframe src="{{ asset('uploads/lands/' . $land->documents) }}" width="100%" height="600px"
                                style="border: none;" path="test"></iframe>
                        </div>
                    @endif
                    <div class="col-md-12 mt-4">
                        <div>
                            <input id="lands" type="file" name="file" accept=".pdf">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="main-content-label">Lands Parts</h6>
                        @if (Auth::user()->hasrole('super-admin') || Auth::user()->can('lands-add'))
                            <a href="javascript:;" class="btn btn-primary" data-target="#addLandPart"
                                data-toggle="modal">Add Part</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="land-parts-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>No of plants</th>
                                    <th>Color</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($landParts) && !$landParts->isEmpty())
                                    @foreach ($landParts as $key => $item)
                                        <tr class="tr-{{ $item->id }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td> <img src="{{ asset('uploads/land_parts/' . $item->image) }}"
                                                    alt="" width="50"></td>
                                            <td> <a
                                                    href="{{ route('land-parts.details', $item->id) }}">{{ $item->name }}</a>
                                            </td>
                                            <td>{{ $item->plants }}</td>
                                            <td>{{ $item->color }}</td>
                                            <td>
                                                @if (Auth::user()->hasrole('super-admin') || Auth::user()->can('lands-edit'))
                                                    <a href="javascript:;" title="Edit"
                                                        data-target="#editLandPart{{ $item->id }}"
                                                        data-toggle="modal"> <i class="fa fa-pen text-primary mr-2"></i>
                                                    </a>

                                                    <div class="modal" id="editLandPart{{ $item->id }}">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content modal-content-demo">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title">Edit Land part</h6><button
                                                                        aria-label="Close" class="close"
                                                                        data-dismiss="modal" type="button"><span
                                                                            aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <form class="parsley-validate" method="post"
                                                                    action="{{ route('land-parts.update', $item->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="row row-sm">
                                                                            <input type="hidden" name="land_id"
                                                                                value="{{ $land->id }}">
                                                                            <input type="hidden" name="landpart_id"
                                                                                value="{{ $item->id }}">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="">Name <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input class="form-control"
                                                                                        name="name" required=""
                                                                                        type="text"
                                                                                        value="{{ $item->name }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="">No of
                                                                                        plants</label>
                                                                                    <input class="form-control"
                                                                                        name="plants" type="text"
                                                                                        value="{{ $item->plants }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="">Color</label>
                                                                                    <input class="form-control"
                                                                                        name="color" type="text"
                                                                                        value="{{ $item->color }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="">Image</label>
                                                                                    <input class="form-control"
                                                                                        name="image" type="file"
                                                                                        accept="image/*">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn ripple btn-primary"
                                                                            type="submit">Save changes</button>
                                                                        <button class="btn ripple btn-secondary"
                                                                            data-dismiss="modal"
                                                                            type="button">Close</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->hasrole('super-admin') || Auth::user()->can('lands-delete'))
                                                    <a href="javascript:;" class="delete-land-part"
                                                        data-id="{{ $item->id }}"
                                                        data-route="{{ route('land-parts.destroy', $item->id) }}"
                                                        data-toggle="tooltip" title="Delete"> <i
                                                            class="fa fa-trash text-danger"></i> </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- fertilizer Entries Start --}}
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="main-content-label">Fertilizer Entries</h6>
                        <a href="javascript:;" class="btn btn-primary" data-target="#addFertilizerEntry"
                            data-toggle="modal">Add Fertilizer Entry</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="fertilizer-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Valves</th>
                                    <th>Fertilizer Name</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($PlotFertilizer as $entry)
                                    <tr class="tr-{{ $entry->id }}">
                                        <td>{{ $entry->id }}</td>
                                        <td>{{ implode(', ', $entry->landPartNames()) }}</td>
                                        <td>{{ $entry->fertilizer_name }}</td>
                                        <td>{{ $entry->quantity }}</td>
                                        <td>{{ $entry->date->format('d-m-Y') }}</td>
                                        <td>{{ $entry->time }}</td>
                                        <td>
                                            <a href="javascript:;" title="Edit"
                                                data-target="#editFertilizerEntry{{ $entry->id }}"
                                                data-toggle="modal">
                                                <i class="fa fa-pen text-primary mr-2"></i>
                                            </a>

                                            <div class="modal editFertilizerEntry"
                                                id="editFertilizerEntry{{ $entry->id }}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">Edit Fertilizer Entry</h6>
                                                            <button aria-label="Close" class="close"
                                                                data-dismiss="modal" type="button"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <form class="parsley-validate" method="post"
                                                            action="{{ route('plot-fertilizer.update', $entry->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('put')
                                                            <div class="modal-body">
                                                                <div class="row row-sm">
                                                                    <input type="hidden" name="land_id"
                                                                        value="{{ $entry->land_id }}">
                                                                    <div class="col-md-12">
                                                                        <p class="mg-b-10">Valves</p>
                                                                        <select class="form-control select2"
                                                                            multiple="multiple" name="land_part_id[]">
                                                                            @if (isset($landParts) && !$landParts->isEmpty())
                                                                                @foreach ($landParts as $key => $item)
                                                                                    <option value="{{ $item->id }}"
                                                                                        {{ $entry->land_part_id != null && in_array($item->id, $entry->land_part_id) ? 'selected' : '' }}>
                                                                                        {{ $item->name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="fertilizer_name">Fertilizer
                                                                                Name</label>
                                                                            <input type="text" class="form-control"
                                                                                name="fertilizer_name"
                                                                                value="{{ $entry->fertilizer_name }}"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="quantity">Quantity</label>
                                                                            <input type="number" class="form-control"
                                                                                name="quantity"
                                                                                value="{{ $entry->quantity }}" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="date">Date</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text">
                                                                                        <i
                                                                                            class="fe fe-calendar lh--9 op-6"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <input class="form-control datepicker"
                                                                                    placeholder="DD/MM/YYYY"
                                                                                    type="text" name="date"
                                                                                    value="{{ isset($entry->date) ? $entry->date->format('d-m-Y') : '' }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="time">Time</label>
                                                                            <input type="time" class="form-control"
                                                                                name="time"
                                                                                value="{{ $entry->time }}" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn ripple btn-primary" type="submit">Save
                                                                    changes</button>
                                                                <button class="btn ripple btn-secondary"
                                                                    data-dismiss="modal" type="button">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="javascript:;" class="delete-fertilizer-entry"
                                                data-id="{{ $entry->id }}"
                                                data-route="{{ route('plot-fertilizer.destroy', $entry->id) }}"
                                                data-toggle="tooltip" title="Delete">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- fertilizer Entries End --}}

    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="main-content-label">Flush history</h6>
                        <a href="javascript:;" class="btn btn-primary" data-target="#addFlushEntry"
                            data-toggle="modal">Add Flush entry</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="flush-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Valves</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($flushHistory as $history)
                                    <tr class="tr-{{ $history->id }}">
                                        <td>{{ $history->id }}</td>
                                        <td>{{ implode(', ', $history->landPartNames()) }}</td>
                                        <td>{{ $history->date->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="javascript:;" title="Edit"
                                                data-target="#editFlushHistory{{ $history->id }}" data-toggle="modal">
                                                <i class="fa fa-pen text-primary mr-2"></i> </a>

                                            <div class="modal editFlushHistory" id="editFlushHistory{{ $history->id }}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">Edit Flush History</h6><button
                                                                aria-label="Close" class="close" data-dismiss="modal"
                                                                type="button"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <form class="parsley-validate" method="post"
                                                            action="{{ route('flush-history.update', $history->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('put')
                                                            <div class="modal-body">
                                                                <div class="row row-sm">
                                                                    <input type="hidden" name="land_id"
                                                                        value="{{ $history->land_id }}">
                                                                    <div class="col-md-12">
                                                                        <p class="mg-b-10">Valves</p>
                                                                        <select class="form-control select2"
                                                                            multiple="multiple" name="land_part_id[]">
                                                                            @if (isset($landParts) && !$landParts->isEmpty())
                                                                                @foreach ($landParts as $key => $item)
                                                                                    <option value="{{ $item->id }}"
                                                                                        {{ $history->land_part_id != null && in_array($item->id, $history->land_part_id) ? 'selected' : '' }}>
                                                                                        {{ $item->name }} </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="date">Date</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text">
                                                                                        <i
                                                                                            class="fe fe-calendar lh--9 op-6"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <input class="form-control datepicker"
                                                                                    placeholder="DD/MM/YYYY"
                                                                                    type="text" name="date"
                                                                                    id="editFlushdate"
                                                                                    value="{{ isset($history->date) && $history->date != null ? date('d-m-Y', strtotime($history->date)) : '' }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn ripple btn-primary" type="submit">Save
                                                                    changes</button>
                                                                <button class="btn ripple btn-secondary"
                                                                    data-dismiss="modal" type="button">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="javascript:;" class="delete-land-part"
                                                data-id="{{ $history->id }}"
                                                data-route="{{ route('flush-history.destroy', $history->id) }}"
                                                data-toggle="tooltip" title="Delete">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

@endsection

@section('modal')
    <div class="modal" id="addLandPart">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add Land part</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('land-parts.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row row-sm">
                            <input type="hidden" name="land_id" value="{{ $land->id }}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" name="name" required="" type="text"
                                        value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">No of plants</label>
                                    <input class="form-control" name="plants" type="text"
                                        value="{{ old('plants') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Color</label>
                                    <input class="form-control" name="color" type="text"
                                        value="{{ old('color') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="">Image</label>
                                    <input class="form-control" name="image" type="file" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">Save changes</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Fertilizer Model  --}}

    <div class="modal" id="addFertilizerEntry">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add Fertilizer Entry</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('plot-fertilizer.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row row-sm">
                            <input type="hidden" name="land_id" value="{{ $land->id }}">
                            <div class="col-md-12">
                                <p class="mg-b-10">Valves</p>
                                <select class="form-control select2" multiple="multiple" name="land_part_id[]">
                                    @if (isset($landParts) && !$landParts->isEmpty())
                                        @foreach ($landParts as $key => $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fertilizer_name">Fertilizer Name</label>
                                    <input type="text" class="form-control" name="fertilizer_name"
                                        id="fertilizer_name" placeholder="Enter fertilizer name" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" name="quantity" id="quantity"
                                        placeholder="Enter quantity" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text"
                                            name="date" id="date" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="time">Time</label>
                                    <input type="text" class="form-control" name="time" id="time" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">Save changes</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- End Model --}}

    <div class="modal" id="addFlushEntry">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add Flush entry</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('flush-history.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row row-sm">
                            <input type="hidden" name="land_id" value="{{ $land->id }}">
                            <div class="col-md-12">
                                <p class="mg-b-10">Valves</p>
                                <select class="form-control select2" multiple="multiple" name="land_part_id[]">
                                    @if (isset($landParts) && !$landParts->isEmpty())
                                        @foreach ($landParts as $key => $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text"
                                            name="date" id="date" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">Save changes</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- InternalFancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>

    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#global-loader").fadeOut("slow");

            $('.select2').select2();

            $('.datatable').on('click', '.delete-land-part', function() {
                var route = $(this).data('route');
                var id = $(this).data('id');
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this data!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: route,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    _method: 'DELETE'
                                },
                                success: function() {
                                    swal("Deleted!", "Your data has been deleted.",
                                        "success");
                                    $(".tr-" + id).remove();
                                }
                            });
                        } else {
                            swal("Cancelled", "Your data is safe :)", "error");
                        }
                    });
            });

            // Plot Fertilizer delete
            $('.datatable').on('click', '.delete-fertilizer-entry', function() {
                var route = $(this).data('route');
                var id = $(this).data('id');
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this data!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: route,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    _method: 'DELETE'
                                },
                                success: function() {
                                    swal("Deleted!", "Your data has been deleted.",
                                        "success");
                                    $(".tr-" + id).remove();
                                }
                            });
                        } else {
                            swal("Cancelled", "Your data is safe :)", "error");
                        }
                    });
            });
        });

        $('.datatable').DataTable({
            // scrollX: true
        });

        (function($) {
            //fancyfileuplod
            $('#lands').FancyFileUpload({
                url: '/lands/save-documents',
                params: {
                    _token: '{{ csrf_token() }}',
                    id: '{{ $land->id }}'
                },
                maxfilesize: 1000000
            });
        })(jQuery);

        $('#addFlushEntry').on('shown.bs.modal', function() {
            $(this).find('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });
        });

        $('.editFlushHistory').on('shown.bs.modal', function() {
            $(this).find('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });
        });

        $('#addFertilizerEntry').on('shown.bs.modal', function() {
            $(this).find('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });
        });

        $('.editFertilizerEntry').on('shown.bs.modal', function() {
            $(this).find('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy"
            });
        });
    </script>
@endsection
