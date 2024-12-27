<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JivamrutBarrel;
use App\Models\JivamrutFertilizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class JivamrutFertilizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jivamrutFertilizers = JivamrutFertilizer::with(['removedBarrels', 'barrelsCount'])
        ->orderBy('id', 'desc')
        ->get();

        foreach ($jivamrutFertilizers as $fertilizer) {
            $fertilizer->removed_barrels_sum = $fertilizer->removeBarrelsSum();
            $fertilizer->total_barrels_sum = $fertilizer->addBarrelsSum();
            $fertilizer->current_barrels_sum = $fertilizer->total_barrels_sum - $fertilizer->removed_barrels_sum;
        }
                            
        $jivamrutFertilizers = $jivamrutFertilizers;
        return view('jivamrut-fertilizer.list', compact('jivamrutFertilizers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jivamrut-fertilizer.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'barrels' => 'required'
        ]);

        $jivamrutCreate = JivamrutFertilizer::create([
            'name' => $request->name,
            'size' => $request->size,
            'ingredients' => $request->labels,
            'ingredients_value' => $request->values,
            'barrels' => $request->barrels,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if(isset($request->barrels)) {

            $barrelsCount = $request->barrels;

            // for ($i = 0; $i < $barrelsCount; $i++) {
                // Convert arrays to strings and concatenate them
                $labelsString = implode(', ', $request->labels);
                $valuesString = implode(', ', $request->values);
                $ingredients = $labelsString . ' ' . $valuesString;
                $barrelsCreate = JivamrutBarrel::create([
                    'jivamrut_fertilizer_id' => $jivamrutCreate->id,
                    'barrel_qty' => $request->barrels,
                    'ingredients' => $ingredients,
                    'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL,
                    'status' => 0
                ]);
            // }
        }

        if($jivamrutCreate) {
            return redirect()->route('jivamrut-fertilizer.index')->with(['success' => true, 'message' => 'Jivamrut Fertilizer created successfully.']);
        } else {
            return redirect()->route('jivamrut-fertilizer.index')->with(['error' => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $jivamrutFertilizer = JivamrutFertilizer::withCount(['removedBarrels as removed_barrels_count', 'barrelsCount as total_barrels_count'])->findOrFail($id);
        // $data['jivamrutFertilizer'] = $jivamrutFertilizer;

        // return view('jivamrut-fertilizer.show', $data);

        $jivamrutFertilizer = JivamrutFertilizer::withCount(['removedBarrels as removed_barrels_count', 'barrelsCount as total_barrels_count'])->findOrFail($id);

        // Calculate the total barrels
        $totalBarrels = $jivamrutFertilizer->addBarrelsSum();
        $removedBarrels = $jivamrutFertilizer->removeBarrelsSum();
        $currentBarrels = $totalBarrels - $removedBarrels;
            
        $data = [
            'jivamrutFertilizer' => $jivamrutFertilizer,
            'totalBarrels' => $totalBarrels,
            'removedBarrels' => $removedBarrels,
            'currentBarrels' => $currentBarrels,
        ];
        return view('jivamrut-fertilizer.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jivamrutFertilizer = JivamrutFertilizer::findOrFail($id);
        return view('jivamrut-fertilizer.edit', compact('jivamrutFertilizer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'barrels' => 'required'
        ]);

        $jivamrutFertilizer = JivamrutFertilizer::findOrFail($id);
        $jivamrutFertilizer->update([
            'name' => $request->name,
            'size' => $request->size,
            'ingredients' => $request->labels,
            'ingredients_value' => $request->values,
            'date' => $request->date,
            'barrels' => $request->barrels
        ]);

        if($jivamrutFertilizer) {
            return redirect()->route('jivamrut-fertilizer.index')->with(['success' => true, 'message' => 'Jivamrut Fertilizer updated successfully!']);
        } else {
            return redirect()->route('jivamrut-fertilizer.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jivamrutFertilizer = JivamrutFertilizer::findOrFail($id);
        $jivamrutFertilizer->delete();

        if($jivamrutFertilizer) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    public function saveBarrelEntries(Request $request) {

        $jivamrutFerti = JivamrutFertilizer::where('id', $request->jivamrut_fertilizer_id)->first();
        $jivamrutBarrel = JivamrutBarrel::where([['jivamrut_fertilizer_id', $request->jivamrut_fertilizer_id], ['status', 0]])->count();

        if(isset($jivamrutFerti->barrels) && $jivamrutFerti->barrels > $jivamrutBarrel) {

            $jivamrutBarrel = JivamrutBarrel::create([
                'jivamrut_fertilizer_id' => $request->jivamrut_fertilizer_id,
                'name' => $request->name,
                'ingredients' => $request->ingredients,
                'barrel_qty' => $request->barrel_qty,
                'status' => 0,
                'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
            ]);

            if ($jivamrutBarrel) {
                return redirect()->route('jivamrut-fertilizer.show', $request->jivamrut_fertilizer_id)->with(['success' => true, 'message' => 'Jivamrut Barrel created successfully.']);
            } else {
                return redirect()->route('jivamrut-fertilizer.show', $request->jivamrut_fertilizer_id)->with(['error' => true, 'message' => 'Failed to create Jivamrut Barrel.']);
            }

        } else {
            return redirect()->route('jivamrut-fertilizer.show', $request->jivamrut_fertilizer_id)->with(['error' => true, 'message' => 'More than '. $jivamrutFerti->barrels .' Entries are not allowed.']);
        }
    }

    public function updateBarrelStatus(Request $request) {

        $id = $request->id;
        $status = $request->status;

        $jivamrutBarrelUpdate = JivamrutBarrel::where('id', $id)->update([
            'status' => $status
        ]);

        if($jivamrutBarrelUpdate) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    public function getBarrelsTables(Request $request) {
        $id = $request->id;

        $jivamrutBarrelsCurrent = JivamrutBarrel::where([['jivamrut_fertilizer_id', $id], ['status', 0]])->orderBy('id', 'desc')->get();
        $currentData['jivamrutBarrelsCurrent'] = $jivamrutBarrelsCurrent;

        $data['currentTable'] = View::make('jivamrut-fertilizer.Ajax.current-table', $currentData)->render();

        return $data;
    }

    public function getRemovedBarrelsTables(Request $request) {

        $id = $request->id;

        $jivamrutBarrelsCurrent = JivamrutBarrel::where([['jivamrut_fertilizer_id', $id], ['status', 1]])->orderBy('id', 'desc')->get();
        $currentData['jivamrutBarrelsCurrent'] = $jivamrutBarrelsCurrent;

        $data['currentTable'] = View::make('jivamrut-fertilizer.Ajax.removed-current-table', $currentData)->render();

        return $data;
    }

    public function updateBarrelEntries(Request $request, $id) {

        $jivamrutBarrel = JivamrutBarrel::where('id', $id)->first();

        $jivamrutBarrelUpdate = $jivamrutBarrel->update([
            'name' => $request->name,
            'ingredients' => $request->ingredients,
            'barrel_qty' => $request->barrel_qty,
            'date' => isset($request->date) && $request->date != NULL ? date('Y-m-d', strtotime($request->date)) : NULL
        ]);

        if ($jivamrutBarrelUpdate) {
            return redirect()->route('jivamrut-fertilizer.show', $jivamrutBarrel->jivamrut_fertilizer_id)->with(['success' => true, 'message' => 'Jivamrut Barrel updated successfully.']);
        } else {
            return redirect()->route('jivamrut-fertilizer.show', $jivamrutBarrel->jivamrut_fertilizer_id)->with(['error' => true, 'message' => 'Failed to create Jivamrut Barrel.']);
        }
    }

    public function removeBarrel(Request $request, $id)
    {
        $request->validate([
            'removed_date' => 'required|date',
        ]);
    
        $jivamrutCreate = JivamrutBarrel::create([
            'removed_date' =>  date('Y-m-d', strtotime($request->removed_date)),
            'date' =>  date('Y-m-d', strtotime($request->removed_date)),
            'barrel_qty' => $request->barrel_qty,
            'ingredients' => $request->ingredients,
            'ingredients_value' => $request->values,
            'status' => 1,
            'jivamrut_fertilizer_id' => $request->jivamrut_fertilizer_id,
        ]);

        if($jivamrutCreate){
            return redirect()->route('jivamrut-fertilizer.show', $request->jivamrut_fertilizer_id)->with(['success' => true, 'message' => 'Removed Barrel Successfully.']);
        } else {
            return redirect()->route('jivamrut-fertilizer.show', $request->jivamrut_fertilizer_id)->with(['error' => true, 'message' => 'Failed to removed Barrel.']);
        }
    
    }
}
