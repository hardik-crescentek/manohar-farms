<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleService;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::orderBy('id', 'desc')->get();
        $data['vehicles'] = $vehicles;

        return view('vehicles.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicles.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required|string',
            'number' => 'required|numeric',
        ]);


        $documentsFiles = $request->documents;
        $documentNames = [];
        if(isset($documentsFiles) && sizeof($documentsFiles) > 0) {
            foreach($documentsFiles as $file) {
                $fileName = fileUpload('vehicles_and_attachments', $file);
                $documentNames[] = $fileName;
            }
        }

        $createVehicle = Vehicle::create([
            'type' => $request->type,
            'number' => $request->number,
            'name' => $request->name,
            'documents' => $documentNames,
            'service_cycle_type' => $request->service_cycle_type,
            'vehicle_notification' => $request->vehicle_notification,
        ]);

        if($createVehicle) {
            return redirect()->route('vehicles.index')->with(['success' => true, 'message' => 'vehicles added successfully!']);
        } else {
            return redirect()->route('vehicles.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
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
        $vehicle = Vehicle::where('id', $id)->first();
        $data['vehicle'] = $vehicle;

        $vehicleServices = VehicleService::where('vehicle_id', $id)->orderBy('id', 'desc')->get();
        $data['vehicleServices'] = $vehicleServices;
        $serviceTypes = ['1'=> 'Days', '2' => 'Hours'];
        view()->share('serviceTypes',$serviceTypes);

        return view('vehicles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required|string',
            'number' => 'required|numeric',
        ]);


        $existingVehicle = Vehicle::where('id', $id)->first();
        $existingDoc = isset($existingVehicle->documents) && $existingVehicle->documents != null ? json_decode($existingVehicle->documents) : [];

        $documentsFiles = $request->documents;
        $documentNames = $existingDoc;
        if(isset($documentsFiles) && sizeof($documentsFiles) > 0) {
            foreach($documentsFiles as $file) {
                $fileName = fileUpload('vehicles_and_attachments', $file);
                $documentNames[] = $fileName;
            }
        }

        $updateVehicle = Vehicle::where('id', $id)->update([
            'type' => $request->type,
            'number' => $request->number,
            'name' => $request->name,
            'documents' => $documentNames,
            'service_cycle_type' => $request->service_cycle_type,
            'vehicle_notification' => $request->vehicle_notification,
        ]);

        if($updateVehicle) {
            return redirect()->route('vehicles.index')->with(['success' => true, 'message' => 'vehicle updated successfully!']);
        } else {
            return redirect()->route('vehicles.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteVehicle = Vehicle::where('id', $id)->delete();

        if($deleteVehicle) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    public function deleteDocument(Request $request) {

        $docname = $request->document;
        $id = $request->id;

        $vehicle = Vehicle::where('id', $id)->first();

        if($vehicle) {

            $documents = isset($vehicle->documents) && $vehicle->documents ? json_decode($vehicle->documents) : [];

            if(sizeof($documents) > 0) {

                if(file_exists(public_path('uploads/vehicles_and_attachments/'.$docname))) {
                    unlink(public_path('uploads/vehicles_and_attachments/'.$docname));
                }
                $position = array_search($docname, $documents);

                unset($documents[$position]);

                $updateVehicle = Vehicle::where('id', $id)->update([
                    'documents' => json_encode(array_values($documents))
                ]);

                return response()->json(['success' => true, 'message' => 'document deleted successful!']);
            }

            return response()->json(['error' => true, 'message' => 'something went wrong']);
        }

        return response()->json(['error' => true, 'message' => 'something went wrong']);
    }

    public function vehicleServiceStore(Request $request)
    {
        $vehicle_id = $request->vehicle_id;
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles_and_attachments,id',
            'date' => 'required|date',
            'service' => 'required'
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('vehicles_and_attachments', $request->image);
        }

        $createVehicleService = VehicleService::create([
            'vehicle_id' => $request->vehicle_id,
            'image' => $fileName,
            'date' => isset($request->date) && $request->date != null ? date('Y-m-d', strtotime($request->date)) : null,
            'price' => $request->price,
            'person' => $request->person,
            'service' => $request->service,
            'note' => $request->note,
        ]);

        if ($createVehicleService) {
            return redirect()->route('vehicles.edit', $vehicle_id)->with(['success' => true, 'message' => 'Vehicle service added successfully!']);
        } else {
            return redirect()->route('vehicles.edit', $vehicle_id)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function vehicleServiceUpdate(Request $request, string $id)
    {
        $vehicle_id = $request->vehicle_id;
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles_and_attachments,id',
            'date' => 'required|date',
        ]);

        $updateVehicleService = VehicleService::where('id', $id)->update([
            'vehicle_id' => $request->vehicle_id,
            'date' => isset($request->date) && $request->date != null ? date('Y-m-d', strtotime($request->date)) : null,
            'price' => $request->price,
            'person' => $request->person,
            'service' => $request->service,
            'note' => $request->note,
        ]);

        if($request->hasFile('image')){
            $service = VehicleService::where('id', $id)->first();
            if(isset($service->image) && $service->image != null) {
                $fileName = fileUpload('vehicles_and_attachments', $request->image, $service->image);
            } else {
                $fileName = fileUpload('vehicles_and_attachments', $request->image);
            }
            $service->image = $fileName;
            $service->save();
        }

        if ($updateVehicleService) {
            return redirect()->route('vehicles.edit', $vehicle_id)->with(['success' => true, 'message' => 'Vehicle service updated successfully!']);
        } else {
            return redirect()->route('vehicles.edit', $vehicle_id)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function vehicleServiceDestroy(string $id)
    {
        $deleteVehicleService = VehicleService::where('id', $id)->delete();

        if ($deleteVehicleService) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
