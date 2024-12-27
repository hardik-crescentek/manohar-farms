@extends('layouts-verticalmenu-light.master')
@section('css')
<style>
    .todo-list {
        display: flex;
        justify-content: space-between;
        padding: 20px;
    }

    .todo-box {
        width: 100%;
        border: 1px solid #ccc;
        padding: 5px;
        height: 300px;
        overflow-y: auto;
        z-index: 1000;
    }

    .todo-item {
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        padding: 5px;
        margin-bottom: 5px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
    }

    .todo-item.completed {
        background-color: #d4edda;
    }

    .todo-title {
        flex-grow: 1; /* Title takes up remaining space */
    }

    .todo-date {
        margin-left: 10px; /* Add space between title and date */
    }
</style>
@endsection
@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Tasks</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tasks</li>
        </ol>
    </div>
</div>
<!-- End Page Header -->

@include('common.alerts')

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-6">
        <div class="card custom-card">
            <div class="card-body">
                <h2>Pending Tasks</h2> <!-- Title for Pending Tasks -->
                <div class="todo-list">
                    <div id="pending" class="todo-box">
                        <!-- Initial pending tasks -->
                        @foreach ($pendingTasks as $task)
                            <div class="todo-item" data-id="{{ $task->id }}">
                                <div class="todo-title">{{ $task->title }}</div>
                                <div class="todo-date">{{ $task->date }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card custom-card">
            <div class="card-body">
                <h2>Completed Tasks</h2> <!-- Title for Completed Tasks -->
                <div class="todo-list">
                    <div id="completed" class="todo-box">
                        <!-- Initial completed tasks -->
                        @foreach ($completedTasks as $task)
                            <div class="todo-item completed" data-id="{{ $task->id }}">
                                <div class="todo-title">{{ $task->title }}</div>
                                <div class="todo-date">{{ $task->date }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
@endsection
@section('script')
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include jQuery UI library -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        // Enable draggable functionality
        $('.todo-item').draggable({
            revert: 'invalid',
            cursor: 'move',
            helper: 'clone'
        });

        // Enable droppable functionality for pending and completed boxes
        $('.todo-box').droppable({
            accept: '.todo-item',
            drop: function(event, ui) {
                var draggedItem = ui.draggable; // Get the dragged item
                var id = draggedItem.data('id');
                draggedItem.detach(); // Detach the dragged item from its original location
                $(this).append(draggedItem); // Append the dragged item to the new location
                ui.helper.remove(); // Remove the cloned helper item
                if ($(this).attr('id') === 'completed') {
                    draggedItem.addClass('completed');
                    changeStatus(id, 1);
                } else {
                    draggedItem.removeClass('completed');
                    changeStatus(id, 0);
                }
            }
        });
    });

    function changeStatus(id, status) {
        $.ajax({
            url: "{{ route('tasks.status-update') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status,
                id: id
            },
            success: function() {

            }
        });
    }
</script>
@endsection