@extends('layouts-verticalmenu-light.master')
@section('css')

@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('jivamrut-fertilizer.index') }}">Jivamrut fertilizer</a></li>
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
                    <h6 class="main-content-label">Jivamrut fertilizer Details</h6>
                </div>
                <form class="parsley-validate" method="post" action="{{ route('jivamrut-fertilizer.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" required="" type="text" value="{{ old('name') }}">
                                @error('name') <ul class="parsley-errors-list filled"> <li class="parsley-required">{{ $message }}</li> </ul> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Size (Litr)</label>
                                <input class="form-control" name="size" onkeypress="return onlyDecimal(event)" type="number" value="{{ old('size') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Barrels (Qty) <span class="text-danger">*</span></label>
                                <input class="form-control" name="barrels" required="" onkeypress="return onlyDecimal(event)" type="number" value="{{ old('barrels') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control datepicker" placeholder="YYYY/MM/DD" type="text" name="date" id="date" value="">
                                </div>
                            </div>
                        </div>
                        <div id="expense-fields" class="col-md-12">
                            <div class="expense-field row">
                                <div class="form-group col-md-4">
                                    <label for="label_1">Ingredients Label:</label>
                                    <input class="form-control" type="text" name="labels[]" id="label_1">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="value_1">Ingredients Value:</label>
                                    <input class="form-control" type="text" name="values[]" id="value_1">
                                </div>
                                <div class="form-group col-md-4 mt-4">
                                    <button type="button" class="btn btn-success add-expense">+</button>
                                    <button type="button" class="btn btn-danger remove-expense">-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mt-4">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <a href="{{ route('jivamrut-fertilizer.index') }}" class="btn btn-primary">Back</a>
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

    document.addEventListener('DOMContentLoaded', function() {
        const expenseFields = document.getElementById('expense-fields');
        const addExpenseButton = document.querySelector('.add-expense');

        let expenseCounter = 1;

        function addExpenseField() {
            expenseCounter++;

            const newExpenseField = document.createElement('div');
            newExpenseField.className = 'expense-field row';

            newExpenseField.innerHTML = `
            <div class="form-group col-md-4">
                <label for="label_${expenseCounter}">Ingredients Label:</label>
                <input class="form-control" type="text" name="labels[]" id="label_${expenseCounter}">
            </div>

            <div class="form-group col-md-4">
                <label for="value_${expenseCounter}">Ingredients Value:</label>
                <input class="form-control" type="text" name="values[]" id="value_${expenseCounter}">
            </div>

            <div class="form-group col-md-4 mt-4">
                <button type="button" class="btn btn-success add-expense">+</button>
                <button type="button" class="btn btn-danger remove-expense">-</button>
            </div>
        `;

            expenseFields.appendChild(newExpenseField);

            // Attach event listeners to the new buttons
            newExpenseField.querySelector('.add-expense').addEventListener('click', addExpenseField);
            newExpenseField.querySelector('.remove-expense').addEventListener('click', removeExpenseField);
        }

        function removeExpenseField(event) {
            event.target.closest('.expense-field').remove();
        }

        addExpenseButton.addEventListener('click', addExpenseField);
        expenseFields.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-expense')) {
                removeExpenseField(event);
            }
        });
    });
</script>
@endsection