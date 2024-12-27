<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceContact;
use Illuminate\Http\Request;

class ServiceContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceContact = ServiceContact::orderBy('id', 'desc')->get();
        $data['serviceContact'] = $serviceContact;

        return view('service-contacts.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service-contacts.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'company' => 'required',
            'category' => 'required',
            'phone' => 'required',
        ]);


        $createServiceContact = ServiceContact::create([
            'name' => $request->name,
            'company' => $request->company,
            'category' => $request->category,
            'designation' => $request->designation,
            'phone' => $request->phone,
        ]);


        if($createServiceContact) {
            return redirect()->route('service-contacts.index')->with(['success' => true, 'message' => 'Service Contact Details added successfully!']);
        } else {
            return redirect()->route('service-contacts.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceContact $serviceContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $serviceContact = ServiceContact::where('id', $id)->first();
        $data['serviceContact'] = $serviceContact;
        return view('service-contacts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        $request->validate([
            'name' => 'required|max:120',
        ]);

        $updateServiceContact = ServiceContact::where('id', $id)->update([
            'name' => $request->name,
            'company' => $request->company,
            'category' => $request->category,
            'designation' => $request->designation,
            'phone' => $request->phone,
        ]);


        if($updateServiceContact) {
            return redirect()->route('service-contacts.index')->with(['success' => true, 'message' => 'Service Contacts Dateails updated successfully!']);
        } else {
            return redirect()->route('service-contacts.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteServiceContact = ServiceContact::where('id', $id)->delete();

        if($deleteServiceContact) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
