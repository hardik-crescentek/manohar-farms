<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $staffs = Staff::orderBy('id', 'desc')->get();
            $totalStaff = Staff::count();
            $totalSalariedStaff = Staff::where('type', 1)->count();
            $totalOndemandStaff = Staff::where('type', 2)->count();

            $data['totalStaff'] = $totalStaff;
            $data['totalSalariedStaff'] = $totalSalariedStaff;
            $data['totalOndemandStaff'] = $totalOndemandStaff;
            $data['staffs'] = $staffs;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:120',
                'phone' => 'required',
                'email' => 'required|email|unique:staffs,email',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $imageName = '';
            if ($request->image != '') {
                $imageName = apiFileUpload('staffs', $request->image);
            }

            $createStaff = new Staff();
            $createStaff->image = $imageName;
            $createStaff->type = $request->type;
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

            return response()->json(['status' => 200, 'message' => 'Staff added successfully!', 'data' => $createStaff], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $staff = Staff::find($id);

            if (!$staff) {
                throw new \Exception('Staff not found');
            }

            return response()->json(['status' => 200, 'data' => $staff], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 404, 'message' => $e->getMessage(), 'data' => []], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:120',
                'phone' => 'required',
                'email' => 'required|email|unique:staffs,email,' . $id,
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $updateStaff = Staff::where('id', $id)->first();
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

            if ($request->image != '') {
                $staff = Staff::find($id);
                $fileName = apiFileUpload('staffs', $request->image, $staff->image ?? null);
                $staff->image = $fileName;
                $staff->save();
            }

            return response()->json(['status' => 200, 'message' => 'Staff updated successfully!', 'data' => $updateStaff], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleteStaff = Staff::where('id', $id)->delete();

            if ($deleteStaff) {
                return response()->json(['status' => 200, 'message' => 'Staff deleted successfully', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting staff');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
