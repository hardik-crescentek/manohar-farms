<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diesel;
use App\Models\DieselEntry;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DieselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diesels = Diesel::orderBy('id', 'desc')->get();
        $data['diesels'] = $diesels;

        return view('diesels.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('diesels.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'volume' => 'required|max:120',
            'price' => 'required'
        ]);

        $total = $request->volume * $request->price;

        $createDiesel = Diesel::create([
            'volume' => $request->volume,
            'price' => $request->price,
            'total_price' => $total,
            'payment_person' => $request->payment_person,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($createDiesel) {
            return redirect()->route('diesels.index')->with(['success' => true, 'message' => 'Diesels added successfully!']);
        } else {
            return redirect()->route('diesels.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
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
        $diesel = Diesel::where('id', $id)->first();
        $data['diesel'] = $diesel;

        return view('diesels.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'volume' => 'required|max:120',
            'price' => 'required'
        ]);

        $total = $request->volume * $request->price;

        $updateDiesel = Diesel::where('id', $id)->update([
            'volume' => $request->volume,
            'price' => $request->price,
            'total_price' => $total,
            'payment_person' => $request->payment_person,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if($updateDiesel) {
            return redirect()->route('diesels.index')->with(['success' => true, 'message' => 'Diesel updated successfully!']);
        } else {
            return redirect()->route('diesels.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteDiesel = Diesel::where('id', $id)->delete();

        if($deleteDiesel) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function dieselEntriesIndex()
    {
        $dieselEntry = DieselEntry::with('vehicle')->orderBy('id', 'desc')->get();
        $data['dieselEntry'] = $dieselEntry;

        return view('diesel-entries.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dieselEntriesCreate()
    {
        $vehicles = Vehicle::where('type', 1)->pluck('name', 'id')->toArray();
        $data['vehicles'] = $vehicles;

        return view('diesel-entries.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function dieselEntriesStore(Request $request)
    {
        $request->validate([
            'volume' => 'required',
            'vehicle_id' => 'required'
        ]);

        $createDieselEntry = DieselEntry::create([
            'vehicle_id' => $request->vehicle_id,
            'volume' => $request->volume,
            'payment_person' => $request->payment_person,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
            'amount' => $request->amount
        ]);

        if($createDieselEntry) {
            return redirect()->route('diesel-entries.index')->with(['success' => true, 'message' => 'diesel entry added successfully!']);
        } else {
            return redirect()->route('diesel-entries.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function dieselEntriesEdit(string $id)
    {
        $dieselEntry = DieselEntry::where('id', $id)->first();
        $data['dieselEntry'] = $dieselEntry;

        $vehicles = Vehicle::where('type', 1)->pluck('name', 'id')->toArray();
        $data['vehicles'] = $vehicles;

        return view('diesel-entries.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function dieselEntriesUpdate(Request $request, string $id)
    {
        $request->validate([
            'volume' => 'required',
            'vehicle_id' => 'required'
        ]);

        $updateDieselEntry = DieselEntry::where('id', $id)->update([
            'vehicle_id' => $request->vehicle_id,
            'volume' => $request->volume,
            'payment_person' => $request->payment_person,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
            'amount' => $request->amount
        ]);

        if($updateDieselEntry) {
            return redirect()->route('diesel-entries.index')->with(['success' => true, 'message' => 'Diesel Entry updated successfully!']);
        } else {
            return redirect()->route('diesel-entries.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function dieselEntriesDestroy(string $id)
    {
        $deleteDieselEntry = DieselEntry::where('id', $id)->delete();

        if($deleteDieselEntry) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
