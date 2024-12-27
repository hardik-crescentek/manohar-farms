<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::get();
        $data['modules'] = $modules;

        return view('modules.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.add');
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
            'name' => 'required|string|unique:modules',
        ]);

        $nameSlug = Str::slug($request->name);

        $creatModule = Module::create([
            'name' => $request->name,
            'slug' => $nameSlug
        ]);

        if($creatModule) {

            $permissions = [$nameSlug.'-add', $nameSlug.'-edit', $nameSlug.'-delete', $nameSlug.'-view'];

            foreach ($permissions as $permission) {
                Permission::updateOrCreate(['name' => $permission]);
            }

            return redirect()->route('modules.index')->with(['success' => true, 'message' => 'Module added successfully!']);
        } else {
            return redirect()->route('modules.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
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
        $module = Module::find($id);
        $data['module'] = $module;
        return view('modules.edit', $data);
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
            'name'     => 'required|string|unique:modules,name,'.$id,
        ]);

        $moduleData = Module::where('id', $id)->first();
        $oldSlugName = $moduleData->slug;

        $nameSlug = Str::slug($request->name);

        $updateModule = Module::where('id', $id)->update([
            'name' => $request->name,
            'slug' => $nameSlug
        ]);

        $permissions = [ $nameSlug.'-add', $nameSlug.'-edit', $nameSlug.'-delete', $nameSlug.'-view'];
        $wherePermissions = [ $oldSlugName.'-add', $oldSlugName.'-edit', $oldSlugName.'-delete', $oldSlugName.'-view'];

        foreach ($permissions as $key => $permission) {
            Permission::where('name', $wherePermissions[$key])->update(['name' => $permission]);
        }

        if($updateModule) {
            return redirect()->route('modules.index')->with(['success' => true, 'message' => 'Module updated successfully!']);
        } else {
            return redirect()->route('modules.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
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
        $deleteCategory = Module::where('id', $id)->delete();

        if($deleteCategory) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }
}
