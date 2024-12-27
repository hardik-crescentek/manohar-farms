<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infrastructure;
use Illuminate\Http\Request;

class InfrastructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infrastructures = Infrastructure::all();
        return view('infrastructure.index', compact('infrastructures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('infrastructure.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('infrastructures', $request->image);
        }

        $createInfrastructures = Infrastructure::create([
            'title' => $request->title,
            'land_id' => $request->land_id,
            'land_part_id' => $request->land_part_id,
            'image' => $fileName,
            'amount' => $request->amount,
            'payment_person' => $request->payment_person,
            'date' => isset($request->date) && $request->date != null ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($createInfrastructures) {
            return redirect()->route('infrastructure.index')->with(['success' => true, 'message' => 'Infrastructure added successfully!']);
        } else {
            return redirect()->route('infrastructure.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $infrastructure = Infrastructure::findOrFail($id);
        return view('infrastructure.show', compact('infrastructure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $infrastructure = Infrastructure::findOrFail($id);
        return view('infrastructure.edit', compact('infrastructure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $infrastructure = Infrastructure::findOrFail($id);
        $infrastructure->update([
            'title' => $request->title,
            'land_id' => $request->land_id,
            'land_part_id' => $request->land_part_id,
            'amount' => $request->amount,
            'payment_person' => $request->payment_person,
            'date' => isset($request->date) && $request->date != null ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($request->hasFile('image')){
            $infrastructure = Infrastructure::where('id', $id)->first();

            if(isset($infrastructure->image) && $infrastructure->image != null) {
                $fileName = fileUpload('infrastructures', $request->image, $infrastructure->image);
            } else {
                $fileName = fileUpload('infrastructures', $request->image);
            }

            $infrastructure->image = $fileName;
            $infrastructure->save();
        }

        if($infrastructure) {
            return redirect()->route('infrastructure.index')->with(['success' => true, 'message' => 'Infrastructure updated successfully!']);
        } else {
            return redirect()->route('infrastructure.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $infrastructure = Infrastructure::findOrFail($id);
        $infrastructure->delete();

        if($infrastructure) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
