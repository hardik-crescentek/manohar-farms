<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camera;
use Illuminate\Http\Request;

class CamerasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cameras = Camera::orderBy('id', 'desc')->get();
        $data['cameras'] = $cameras;

        return view('cameras.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cameras.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'camera_location' => 'required',
            'amount' => 'required',
            'purchase_date' => 'required'
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('cameras', $request->image);
        }

        $createCamera = Camera::create([
            'name' => $request->name,
            'image' => $fileName,
            'camera_location' => $request->camera_location,
            'amount' => $request->amount,
            'purchase_date' => isset($request->purchase_date) && $request->purchase_date != NULL ? date('Y-m-d', strtotime($request->purchase_date)) : NULL,
            'memory_detail' => $request->memory_detail,
            'sim_number' => $request->sim_number,
            'camera_company_name' => $request->camera_company_name,
            'service_person_name' => $request->service_person_name,
            'service_person_number' => $request->service_person_number,
            'recharge_notification' => $request->recharge_notification,
            'last_cleaning_date' => isset($request->last_cleaning_date) && $request->last_cleaning_date != NULL ? date('Y-m-d', strtotime($request->last_cleaning_date)) : NULL,
        ]);


        if($createCamera) {
            return redirect()->route('cameras.index')->with(['success' => true, 'message' => 'Camera Details added successfully!']);
        } else {
            return redirect()->route('cameras.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cameras = Camera::where('id', $id)->first();
        $data['cameras'] = $cameras;
        return view('cameras.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'camera_location' => 'required',
            'amount' => 'required',
            'purchase_date' => 'required'
        ]);

        $updateCamera = Camera::where('id', $id)->update([
            'name' => $request->name,
            'camera_location' => $request->camera_location,
            'amount' => $request->amount,
            'purchase_date' => isset($request->purchase_date) && $request->purchase_date != NULL ? date('Y-m-d', strtotime($request->purchase_date)) : NULL,
            'memory_detail' => $request->memory_detail,
            'sim_number' => $request->sim_number,
            'camera_company_name' => $request->camera_company_name,
            'service_person_name' => $request->service_person_name,
            'service_person_number' => $request->service_person_number,
            'recharge_notification' => $request->recharge_notification,
            'last_cleaning_date' => isset($request->last_cleaning_date) && $request->last_cleaning_date != NULL ? date('Y-m-d', strtotime($request->last_cleaning_date)) : NULL,
        ]);

         if($request->hasFile('image')){
            $camera = Camera::where('id', $id)->first();

            if(isset($camera->image) && $camera->image != null) {
    
                $fileName = fileUpload('cameras', $request->image, $camera->image);
    
            } else {
    
                $fileName = fileUpload('cameras', $request->image);
            }

            $camera->image = $fileName;
            $camera->save();
        }

        if($updateCamera) {
            return redirect()->route('cameras.index')->with(['success' => true, 'message' => 'Camera Dateails updated successfully!']);
        } else {
            return redirect()->route('cameras.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteCamera = Camera::where('id', $id)->delete();

        if($deleteCamera) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
