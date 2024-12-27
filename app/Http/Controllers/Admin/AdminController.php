<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::role('admin')->orderBy('id', 'desc')->get();
        $data['admins'] = $admins;

        return view('admins.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::get();
        $data['modules'] = $modules;

        $lands = Land::pluck('name', 'slug')->toArray();
        $data['lands'] = $lands;

        return view('admins.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8',
        ]);

        $createAdmin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $permissionsAr = $request->permissions;
        $lands = $request->lands;
        $permissions = array_merge($permissionsAr, $lands);
        $createAdmin->assignRole(2);
        $createAdmin->syncPermissions($permissions);

        if($createAdmin) {
            return redirect()->route('admins.index')->with(['success' => true, 'message' => 'Sub admin added successfully!']);
        } else {
            return redirect()->route('admins.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = User::with('permissions')->where('id', $id)->role('admin')->first();
        $data['admin'] = $admin;

        $modules = Module::get();
        $data['modules'] = $modules;

        $lands = Land::pluck('name', 'slug')->toArray();
        $data['lands'] = $lands;

        return view('admins.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'email'     => 'required|email|unique:users,email,'.$id,
        ]);

        $updateAr['name'] = $request->name;
        $updateAr['email'] = $request->email;

        if($request->password != '' || $request->password != null){
            $updateAr['password'] = Hash::make($request->password);
        }

        $updateAdmin = User::where('id', $id)->role('admin')->update($updateAr);

        $permissionsAr = $request->permissions;
        $lands = $request->lands;
        $permissions = array_merge($permissionsAr, $lands);
        
        $admin = User::where('id', $id)->role('admin')->first();
        $admin->syncPermissions($permissions);

        if($updateAdmin) {
            return redirect()->route('admins.index')->with(['success' => true, 'message' => 'Sub admin updated successfully!']);
        } else {
            return redirect()->route('admins.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteAdmin = User::where('id', $id)->delete();

        if($deleteAdmin) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
