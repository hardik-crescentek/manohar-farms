<?php

namespace App\Http\Controllers\Cowshed;

use App\Http\Controllers\Controller;
use App\Models\GheeManagement;
use Illuminate\Http\Request;

class GheeManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gheeManagement = GheeManagement::all();
        return view('cowshed.ghee-management.index', compact('gheeManagement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cowshed.ghee-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'milk' => 'required|numeric',
            'ghee' => 'required|numeric',
            'date' => 'required|date',
        ]);

        GheeManagement::create([
            'milk' => $request->milk,
            'ghee' => $request->ghee,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        return redirect()->route('cowshed.ghee-management.index')->with('success', 'Ghee management record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GheeManagement $gheeManagement)
    {
        return view('cowshed.ghee-management.show', compact('gheeManagement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GheeManagement $gheeManagement)
    {
        return view('cowshed.ghee-management.edit', compact('gheeManagement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GheeManagement $gheeManagement)
    {
        $request->validate([
            'milk' => 'required|numeric',
            'ghee' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $gheeManagement->update([
            'milk' => $request->milk,
            'ghee' => $request->ghee,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        return redirect()->route('cowshed.ghee-management.index')->with('success', 'Ghee management record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GheeManagement $gheeManagement)
    {
        $gheeManagement->delete();

        return redirect()->route('cowshed.ghee-management.index')->with('success', 'Ghee management record deleted successfully.');
    }
}
