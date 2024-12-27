<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VermiCompost;
use Illuminate\Http\Request;

class VermiCompostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vermiComposts = VermiCompost::orderBy('id', 'desc')->get();
        return view('vermi-compost.list', compact('vermiComposts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vermi-compost.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'date' => 'required',
        ]);

        $vermiCompost = VermiCompost::create([
            'name' => $request->name,
            'water' => $request->water,
            'soil' => $request->soil,
            'soil_details' => $request->soil_details,
            'worms' => $request->worms,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($vermiCompost) {
            return redirect()->route('vermi-compost.index')->with(['success' => true, 'message' => 'Vermi Compost bed created successfully.']);
        } else {
            return redirect()->route('vermi-compost.index')->with(['error' => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vermiCompost = VermiCompost::findOrFail($id);
        return view('vermi-compost.show', compact('vermiCompost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vermiCompost = VermiCompost::findOrFail($id);
        return view('vermi-compost.edit', compact('vermiCompost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'date' => 'required',
        ]);

        $vermiCompostUpdate = VermiCompost::findOrFail($id);
        $vermiCompostUpdate->update([
            'name' => $request->name,
            'water' => $request->water,
            'soil' => $request->soil,
            'soil_details' => $request->soil_details,
            'worms' => $request->worms,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($vermiCompostUpdate) {
            return redirect()->route('vermi-compost.index')->with(['success' => true, 'message' => 'Vermi Compost bed updated successfully!']);
        } else {
            return redirect()->route('vermi-compost.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vermiCompost = VermiCompost::findOrFail($id);
        $vermiCompost->delete();

        if($vermiCompost) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    // update status 
    public function updateStatus(Request $request, $id)
    {
        $vermiCompost = VermiCompost::findOrFail($id);
        $vermiCompost->update([
            'status' => $request->status,
            'completed_date' => isset($request->completed_date) && $request->completed_date != NULL ? date('Y-m-d', strtotime($request->completed_date)) : NULL
        ]);

        return response()->json(['success' => true]);
    }
}
