<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $vehicles = Vehicle::get();
            return response()->json(['status' => 200, 'data' => $vehicles], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required',
                'name' => 'required',
                'number' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $documentsFiles = $request->documents;
            $documentNames = [];
            if(isset($documentsFiles) && sizeof($documentsFiles) > 0) {
                foreach($documentsFiles as $file) {
                    $fileName = fileUpload('vehicles_and_attachments', $file);
                    $documentNames[] = $fileName;
                }
            }

            // $imageName = '';
            // if ($request->image != '') {
            //     $imageName = apiFileUpload('vehicles_and_attachments', $request->image);
            // }

            $createVehicle = Vehicle::create([
                'type' => $request->type,
                'number' => $request->number,
                'name' => $request->name,
                'documents' => $documentNames
            ]);

            if ($createVehicle) {
                return response()->json(['status' => 200, 'message' => 'Vehicle added successfully!', 'data' => $createVehicle], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            return response()->json(['status' => 200, 'data' => $vehicle], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 404, 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            return response()->json(['status' => 200, 'data' => $vehicle], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 404, 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required',
                'name' => 'required',
                'number' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $existingVehicle = Vehicle::findOrFail($id);
            $existingDoc = isset($existingVehicle->documents) && $existingVehicle->documents != null ? $existingVehicle->documents : [];

            $documentsFiles = $request->documents;
            $documentNames = $existingDoc;
            if(isset($documentsFiles) && sizeof($documentsFiles) > 0) {
                foreach($documentsFiles as $file) {
                    $fileName = fileUpload('vehicles_and_attachments', $file);
                    $documentNames[] = $fileName;
                }
            }

            $updateVehicle = $existingVehicle->update([
                'type' => $request->type,
                'number' => $request->number,
                'name' => $request->name,
                'documents' => $documentNames
            ]);

            // $vehicle = Vehicle::findOrFail($id);
            // if ($request->image != '') {
            //     $imageName = apiFileUpload('vehicles_and_attachments', $request->image, $vehicle->image ?? null);
            //     $vehicle->image = $imageName;
            //     $vehicle->save();
            // }

            if ($updateVehicle) {
                return response()->json(['status' => 200, 'message' => 'Vehicle updated successfully!', 'data' => $existingVehicle], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleteVehicle = Vehicle::where('id', $id)->delete();

            if ($deleteVehicle) {
                return response()->json(['status' => 200, 'message' => 'Vehicle deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting vehicle');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    /**
     * Delete a specific document from storage.
     */
    public function deleteDocument(Request $request)
    {
        try {
            $docname = $request->document;
            $id = $request->id;

            $vehicle = Vehicle::findOrFail($id);

            if ($vehicle) {
                $documents = isset($vehicle->documents) && $vehicle->documents ? $vehicle->documents : [];

                if (sizeof($documents) > 0) {
                    if(file_exists(public_path('uploads/vehicles_and_attachments/'.$docname))) {
                        unlink(public_path('uploads/vehicles_and_attachments/'.$docname));
                    }
                    $position = array_search($docname, $documents);
                    unset($documents[$position]);

                    $updateVehicle = $vehicle->update([
                        'documents' => array_values($documents)
                    ]);

                    return response()->json(['status' => 200, 'message' => 'Document deleted successfully!', 'data' => $vehicle], 200);
                }

                return response()->json(['status' => 404, 'message' => 'Something went wrong'], 404);
            }

            return response()->json(['status' => 404, 'message' => 'Something went wrong'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
}