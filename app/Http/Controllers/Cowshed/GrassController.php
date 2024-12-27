<?php

namespace App\Http\Controllers\Cowshed;

use App\Http\Controllers\Controller;
use App\Models\GrassManagement;
use Illuminate\Http\Request;

class GrassController extends Controller
{
    public function index()
    {
        $grass = GrassManagement::all();
        return view('cowshed.grass.index', compact('grass'));
    }

    public function create()
    {
        return view('cowshed.grass.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required'
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('grass', $request->image);
        }

        GrassManagement::create([
            'type' => $request->type,
            'image' => $fileName,
            'volume' => $request->volume,
            'amount' => $request->amount,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
            'payment_person' => $request->payment_person,
        ]);

        return redirect()->route('cowshed.grass.index')->with(['success' => true, 'message' => 'Grass management record created successfully!']);
    }

    public function show($id)
    {
        $grass = GrassManagement::findOrFail($id);
        return view('cowshed.grass.show', compact('grass'));
    }

    public function edit($id)
    {
        $grass = GrassManagement::findOrFail($id);
        return view('cowshed.grass.edit', compact('grass'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string',
            'amount' => 'required'
        ]);

        $grassManagement = GrassManagement::findOrFail($id);
        $grassManagement->update([
            'type' => $request->type,
            'volume' => $request->volume,
            'amount' => $request->amount,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
            'payment_person' => $request->payment_person,
        ]);

        if($request->hasFile('image')){
            $grass = GrassManagement::where('id', $id)->first();

            if(isset($grass->image) && $grass->image != null) {
    
                $fileName = fileUpload('grass', $request->image, $grass->image);
    
            } else {
    
                $fileName = fileUpload('grass', $request->image);
            }

            $grass->image = $fileName;
            $grass->save();
        }

        return redirect()->route('cowshed.grass.index')->with(['success' => true, 'message' => 'Grass management record updated successfully!']);
    }

    public function destroy($id)
    {
        $grass = GrassManagement::findOrFail($id);
        $grass->delete();

        if($grass) {
            return response()->json(['status' => true, 'message' => 'Grass management record deleted successfully', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
