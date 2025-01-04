<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Miscellaneous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MiscellaneousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $miscellaneouses = Miscellaneous::orderBy('id', 'desc')->get();
        return response()->json(['status' => true, 'message' => 'Success', 'data' => $miscellaneouses], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:5120',
            'year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'remarks' => 'nullable|string',
        ]);

        $imgName = '';
        if ($request->hasFile('image')) {
            $imgName = fileUpload('miscellaneouses/images', $request->image);
        }

        $pdfName = '';
        if ($request->hasFile('pdf')) {
            $pdfName = fileUpload('miscellaneouses/pdfs', $request->pdf);
        }

        $createMiscellaneous = Miscellaneous::create([
            'heading' => $request->heading,
            'image' => $imgName,
            'pdf' => $pdfName,
            'year' => $request->year,
            'remarks' => $request->remarks,
            'date' => isset($request->date) && $request->date != null ? date('Y-m-d', strtotime($request->date)) : null
        ]);

        if ($createMiscellaneous) {
            return response()->json(['status' => true, 'message' => 'Miscellaneous added successfully!', 'data' => $createMiscellaneous], 201);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong!', 'data' => []], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $miscellaneous = Miscellaneous::find($id);

        if ($miscellaneous) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => $miscellaneous], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Miscellaneous not found', 'data' => []], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'remarks' => 'nullable|string',
        ]);

        $miscellaneous = Miscellaneous::find($id);

        if (!$miscellaneous) {
            return response()->json(['status' => false, 'message' => 'Miscellaneous not found', 'data' => []], 404);
        }
        if (isset($miscellaneous->image) && $miscellaneous->image != null) {
            // File upload method to handle the file and delete the old file if any
            $fileName = fileUpload('miscellaneouses/images', $request->image, $miscellaneous->image);
        } else {
            // If no previous image, just upload the new one
            $fileName = fileUpload('miscellaneouses/images', $request->image);
        }

        $miscellaneous->update([
            'heading' => $request->heading,
            'year' => $request->year,
            'remarks' => $request->remarks,
            'date' => isset($request->date) && $request->date != null ? date('Y-m-d', strtotime($request->date)) : null
        ]);

        return response()->json(['status' => true, 'message' => 'Miscellaneous updated successfully!', 'data' => $miscellaneous], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $miscellaneous = Miscellaneous::find($id);

        if (!$miscellaneous) {
            return response()->json(['status' => false, 'message' => 'Miscellaneous not found', 'data' => []], 404);
        }
        $miscellaneous->delete();

        return response()->json(['status' => true, 'message' => 'Miscellaneous deleted successfully!', 'data' => []], 200);
    }
}

// Note: The `fileUpload` and `deleteFile` functions are assumed to be custom helper functions for handling file uploads and deletions. Ensure these are implemented in your project or replace with appropriate Laravel methods.
