<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->hasrole('super-admin')) {

            $tasks = Task::with('manager')->latest()->get();
            return view('tasks.index', compact('tasks'));

        } else {

            $userId = Auth::user()->id;

            $pendingTasks = Task::with('manager')->where([['user_id', $userId], ['status', 0]])->latest()->get();
            $data['pendingTasks'] = $pendingTasks;

            $completedTasks = Task::with('manager')->where([['user_id', $userId], ['status', 1]])->latest()->get();
            $data['completedTasks'] = $completedTasks;

            return view('tasks.manager-view', $data);
        }   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $managers = User::role('admin')->pluck('name', 'id')->toArray();
        $data['managers'] = $managers; 

        return view('tasks.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required',
        ]);

        Task::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'status' => 0,
            'date' => isset($request->date) && $request->date != null ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $data['task'] = $task;

        $managers = User::role('admin')->pluck('name', 'id')->toArray();
        $data['managers'] = $managers;

        return view('tasks.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task->update([
            'title' => $request->title,
            'date' => isset($request->date) && $request->date != null ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function statusUpdate(Request $request) {

        $status = $request->status;
        $id = $request->id;

        $updateStatus = Task::where('id', $id)->update([
            'status' => $status
        ]);

        if ($updateStatus) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
