<?php

namespace App\Http\Controllers\Admin;

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
        $data['miscellaneous'] = $miscellaneouses;
        return view('miscellaneous.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('miscellaneous.add');
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
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if ($createMiscellaneous) {
            return redirect()->route('miscellaneous.index')->with(['success' => true, 'message' => 'Miscellaneous added successfully!']);
        } else {
            return redirect()->route('miscellaneous.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Miscellaneous $miscellaneous) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $miscellaneous = Miscellaneous::where('id', $id)->first();
        $data['miscellaneous'] = $miscellaneous;
        return view('miscellaneous.edit', $data);
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

        // Update the miscellaneous record
        $updateMiscellaneous = Miscellaneous::where('id', $id)->update([
            'heading' => $request->heading,
            'year' => $request->year,
            'remarks' => $request->remarks,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        // Handle image file upload if exists
        if ($request->hasFile('image')) {
            $miscellaneous = Miscellaneous::where('id', $id)->first();

            // Check if an image exists and delete the old one
            if (isset($miscellaneous->image) && $miscellaneous->image != null) {
                // File upload method to handle the file and delete the old file if any
                $fileName = fileUpload('miscellaneouses/images', $request->image, $miscellaneous->image);
            } else {
                // If no previous image, just upload the new one
                $fileName = fileUpload('miscellaneouses/images', $request->image);
            }

            // Update the image field in the database
            $miscellaneous->image = $fileName;
            $miscellaneous->save();
        }

        // Handle PDF file upload if exists
        if ($request->hasFile('pdf')) {
            $miscellaneous = Miscellaneous::where('id', $id)->first();

            // Check if a PDF exists and delete the old one
            if (isset($miscellaneous->pdf) && $miscellaneous->pdf != null) {
                // File upload method to handle the file and delete the old file if any
                $pdfName = fileUpload('miscellaneouses/pdfs', $request->pdf, $miscellaneous->pdf);
            } else {
                // If no previous PDF, just upload the new one
                $pdfName = fileUpload('miscellaneouses/pdfs', $request->pdf);
            }

            // Update the pdf field in the database
            $miscellaneous->pdf = $pdfName;
            $miscellaneous->save();
        }

        if ($updateMiscellaneous) {
            return redirect()->route('miscellaneous.index')->with(['success' => true, 'message' => 'Miscellaneous updated successfully!']);
        } else {
            return redirect()->route('miscellaneous.index')->with(['error' => true, 'message' => 'Something went wrong!']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteMiscellaneous = Miscellaneous::where('id', $id)->delete();

        if ($deleteMiscellaneous) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
