<?php

namespace App\Http\Controllers\Cowshed;

use App\Http\Controllers\Controller;
use App\Models\CowshedStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class StaffController extends Controller
{
    public function index()
    {
        $cowshedStaff = CowshedStaff::all();
        return view('cowshed.staff.index', compact('cowshedStaff'));
    }

    public function create()
    {
        return view('cowshed.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'phone' => 'required',
            'email' => 'required|email|unique:staffs,email',
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('staffs', $request->image);
        }

        $createStaff = new CowshedStaff();
        $createStaff->image = $fileName;
        $createStaff->type = $request->type;
        $createStaff->is_leader = $request->staff_leader;
        $createStaff->role = $request->role;
        $createStaff->name = $request->name;
        $createStaff->phone = $request->phone;
        $createStaff->email = $request->email;
        $createStaff->address = $request->address;
        $createStaff->salary = $request->type == 1 ? $request->salary : null;
        $createStaff->rate_per_day = $request->type == 2 ? $request->rate_per_day : null;
        if($request->joining_date != null) {
            $createStaff->joining_date = date('Y-m-d', strtotime($request->joining_date));
        }
        if($request->resign_date != null) {
            $createStaff->resign_date = date('Y-m-d', strtotime($request->resign_date));
        }
        $createStaff->save();

        if($createStaff) {
            return redirect()->route('cowshed.staffs.index')->with(['success' => true, 'message' => 'Staff added successfully!']);
        } else {
            return redirect()->route('cowshed.staffs.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    public function show($id)
    {
        $cowshedStaff = CowshedStaff::findOrFail($id);
        return view('cowshed.staff.show', compact('cowshedStaff'));
    }

    public function edit($id)
    {
        $staff = CowshedStaff::findOrFail($id);
        return view('cowshed.staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'phone' => 'required',
            'email' => 'required|email|unique:staffs,email,' . $id,
        ]);

        $updateStaff = CowshedStaff::where('id', $id)->first();
        $updateStaff->type = $request->type;
        $updateStaff->role = $request->role;
        $updateStaff->name = $request->name;
        $updateStaff->phone = $request->phone;
        $updateStaff->email = $request->email;
        $updateStaff->address = $request->address;
        $updateStaff->salary = $request->type == 1 ? $request->salary : null;
        $updateStaff->rate_per_day = $request->type == 2 ? $request->rate_per_day : null;
        if($request->joining_date != null) {
            $updateStaff->joining_date = date('Y-m-d', strtotime($request->joining_date));
        }
        if($request->resign_date != null) {
            $updateStaff->resign_date = date('Y-m-d', strtotime($request->resign_date));
        }
        $updateStaff->save();

        if($request->hasFile('image')){
            $staff = CowshedStaff::where('id', $id)->first();
            if(isset($staff->image) && $staff->image != null) {

                $fileName = fileUpload('staffs', $request->image, $staff->image);

            } else {

                $fileName = fileUpload('staffs', $request->image);
            }
            $staff->image = $fileName;
            $staff->save();
        }

        if($updateStaff) {
            return redirect()->route('cowshed.staffs.index')->with(['success' => true, 'message' => 'Staff added successfully!']);
        } else {
            return redirect()->route('cowshed.staffs.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    public function destroy($id)
    {
        $cowshedStaff = CowshedStaff::findOrFail($id);
        $cowshedStaff->delete();

        if($cowshedStaff) {
            return response()->json(['status' => true, 'message' => 'Grass management record deleted successfully', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    public function getTable(Request $request) {

        $type = $request->type;

        $query = CowshedStaff::orderBy('id', 'desc');

        if(isset($type) && $type != 0) {
            $query->where('type', $type);
        }

        $staffs = $query->get();
        $data['staffs'] = $staffs;
        return View::make('cowshed.staff.Ajax.table', $data);
    }
}
