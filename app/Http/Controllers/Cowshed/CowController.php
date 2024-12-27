<?php

namespace App\Http\Controllers\Cowshed;

use App\Models\Cow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CowVaccination;
use Illuminate\Support\Facades\View;

class CowController extends Controller
{
    public function index()
    {
        $cows = Cow::with(['fatherName', 'motherName', 'children'])->get();
        $data['cows'] = $cows;
        return view('cowshed.cows.index', $data);
    }

    public function getCowTable(Request $request) {
        $type = $request->type;

        $query = Cow::orderBy('id', 'desc');

        if(isset($type) && $type == 1) {
            $query->where('milk', '>=', 1);
        } else if($type == 2) {
            $query->where('milk', '<', 1);
        }

        $cows = $query->get();
        $data['cows'] = $cows;

        return View::make('cowshed.cows.Ajax.table', $data);
    }

    public function create()
    {
        $mothers = Cow::where('gender', 2)->pluck('name', 'id')->toArray();
        $data['mothers'] = $mothers;

        $fathers = Cow::where('gender', 1)->pluck('name', 'id')->toArray();
        $data['fathers'] = $fathers;

        return view('cowshed.cows.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'tag_number' => 'required',
            // Add validation rules for other fields as needed
        ]);

        // dd(request()->all());

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('cows', $request->image);
        }

        $createCow = Cow::create([
            'name' => $request->name,
            // 'image' => isset($fileName) && $fileName != '' ? $fileName : NULL,
            'image' => $fileName,
            'mother' => $request->mother,
            'father' => $request->father,
            'tag_number' => $request->tag_number,
            'age' => $request->age,
            'grade' => $request->grade,
            'gender' => $request->gender,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
            'remark' => $request->remark,
            'milk' => $request->milk
        ]);

        if($createCow) {
            return redirect()->route('cowshed.cows.index')->with(['success' => true, 'message' => 'Cows Detail added successfully!']);
        } else {
            return redirect()->route('cowshed.cows.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    public function show(Cow $cow)
    {
        $vaccinations = CowVaccination::where('cow_id', $cow->id)->get();
        $data['vaccinations'] = $vaccinations;

        $calfs = Cow::where(function ($query) use ($cow) {
                    $query->where('mother', $cow->id)->orWhere('father', $cow->id);
                })->where('id', '!=', $cow->id)->get();
        $data['calfs'] = $calfs;

        $data['cow'] = $cow;

        return view('cowshed.cows.show', $data);
    }

    public function edit(Cow $cow)
    {
        $mothers = Cow::where([['gender', 2], ['id', '!=', $cow->id]])->pluck('name', 'id')->toArray();
        $data['mothers'] = $mothers;
        
        $fathers = Cow::where([['gender', 1], ['id', '!=', $cow->id]])->pluck('name', 'id')->toArray();
        $data['fathers'] = $fathers;

        $data['cow'] = $cow;

        return view('cowshed.cows.edit', $data);
    }

    public function update(Request $request, Cow $cow)
    {
        $request->validate([
            'name' => 'required',
            'tag_number' => 'required',
            // Add validation rules for other fields as needed
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $fileName = fileUpload('cows', $request->file('image'), $cow->image);
        } else {
            $fileName = $cow->image;
        }

        $updateCow = $cow->update([
            'name' => $request->name,
            'image' => $fileName,
            'mother' => $request->mother,
            'father' => $request->father,
            'tag_number' => $request->tag_number,
            'age' => $request->age,
            'grade' => $request->grade,
            'gender' => $request->gender,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
            'remark' => $request->remark,
            'milk' => $request->milk
        ]);

        if($updateCow) {
            return redirect()->route('cowshed.cows.index')->with(['success' => true, 'message' => 'Cows Detail updated successfully!']);
        } else {
            return redirect()->route('cowshed.cows.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    public function destroy(Cow $cow)
    {
        $cow->delete();

        if($cow) {
            return response()->json(['status' => true, 'message' => 'Grass management record deleted successfully', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    public function storeVaccination(Request $request) {

        $request->validate([
            'cow_id' => 'required',
        ]);

        CowVaccination::create([
            'cow_id' => $request->cow_id,
            'disease_name' => $request->disease_name,
            'medicine_name' => $request->medicine_name,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
            'doctor' => $request->doctor,
            'hospital' => $request->hospital
        ]);

        return redirect()->route('cowshed.cows.show', $request->cow_id)->with('success', 'Vaccinated added successfully.');
    }

    public function updateVaccination(Request $request, CowVaccination $cowVaccination) {

        $request->validate([
            'cow_id' => 'required',
        ]);

        $cowVaccination->update([
            'cow_id' => $request->cow_id,
            'disease_name' => $request->disease_name,
            'medicine_name' => $request->medicine_name,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
            'doctor' => $request->doctor,
            'hospital' => $request->hospital
        ]);

        return redirect()->route('cowshed.cows.show', $request->cow_id)->with('success', 'Vaccinated added successfully.');
    }
}
