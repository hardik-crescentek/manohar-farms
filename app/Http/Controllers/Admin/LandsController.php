<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FertilizerEntry;
use App\Models\FlushHistory;
use App\Models\JivamrutEntry;
use App\Models\Land;
use App\Models\LandPart;
use App\Models\Plant;
use App\Models\PlotFertilizer;
use App\Models\Water;
use App\Models\WaterEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class LandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lands = Land::with('plant')->orderBy('id', 'desc')->get();
        $data['lands'] = $lands;

        return view('lands.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $plants = Plant::pluck('name', 'id')->toArray();
        $data['plants'] = $plants;

        return view('lands.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120',
            'plant_id' => 'required'
        ]);

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('lands', $request->image);
        }

        $slug = Str::slug($request->name);

        Permission::create(['name' => $slug]);

        $createLand = Land::create([
            'image' => $fileName,
            'name' => $request->name,
            'slug' => $slug,
            'plant_id' => $request->plant_id,
            'address' => $request->address,
            'plants' => $request->plants,
            'wells' => $request->wells,
            'pipeline' => $request->pipeline
        ]);

        if ($createLand) {
            return redirect()->route('lands.index')->with(['success' => true, 'message' => 'Land added successfully!']);
        } else {
            return redirect()->route('lands.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $land = Land::where('id', $id)->first();
        $data['land'] = $land;

        $plants = Plant::pluck('name', 'id')->toArray();
        $data['plants'] = $plants;

        return view('lands.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'plant_id' => 'required'
        ]);

        $oldLand = Land::where('id', $id)->first();

        $slug = Str::slug($request->name);
        Permission::where('name', $oldLand->slug)->update(['name' => $slug]);

        $updateLand = Land::where('id', $id)->update([
            'name' => $request->name,
            'slug' => $slug,
            'plant_id' => $request->plant_id,
            'address' => $request->address,
            'plants' => $request->plants,
            'wells' => $request->wells,
            'pipeline' => $request->pipeline
        ]);

        if ($request->hasFile('image')) {
            $land = Land::where('id', $id)->first();

            if (isset($land->image) && $land->image != null) {

                $fileName = fileUpload('lands', $request->image, $land->image);
            } else {

                $fileName = fileUpload('lands', $request->image);
            }

            $land->image = $fileName;
            $land->save();
        }

        if ($updateLand) {
            return redirect()->route('lands.index')->with(['success' => true, 'message' => 'Land updated successfully!']);
        } else {
            return redirect()->route('lands.index')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteLand = Land::where('id', $id)->delete();

        if ($deleteLand) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    // public function landMaps(Request $request, $id)
    // {
    //     // Total water used (in hours)
    //     $totalWaterUsed = WaterEntry::where('land_id', $id)->sum('hours');
    //     $data['totalWaterUsed'] = $totalWaterUsed;

    //     // Current month's water usage
    //     $currentMonthWaterUsed = WaterEntry::where('land_id', $id)
    //         ->whereMonth('date', date('m'))
    //         ->sum('hours');
    //     $data['currentMonthWaterUsed'] = $currentMonthWaterUsed;

    //     // Total water expense
    //     $totalWaterExpense = Water::where('land_id', $id)->sum('price');
    //     $data['totalWaterExpense'] = $totalWaterExpense;

    //     // Current month's water expense
    //     $currentMonthWaterExpense = Water::where('land_id', $id)
    //         ->whereMonth('date', date('m'))
    //         ->sum('price');
    //     $data['currentMonthWaterExpense'] = $currentMonthWaterExpense;

    //     // Land details
    //     $land = Land::where('id', $id)->first();
    //     $data['land'] = $land;

    //     // Land parts
    //     $landParts = LandPart::where('land_id', $id)->get();
    //     $data['landParts'] = $landParts;

    //     // Flush history
    //     $flushHistory = FlushHistory::where('land_id', $id)->get();
    //     $data['flushHistory'] = $flushHistory;

    //     // Plot Fertilizer history
    //     $PlotFertilizer = PlotFertilizer::where('land_id', $id)->get();
    //     $data['PlotFertilizer'] = $PlotFertilizer;

    //     // Fetch the latest entry from each table
    //     $latestWaterEntry = WaterEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();
    //     $latestJivamrutEntry = JivamrutEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();
    //     $latestFertilizerEntry = FertilizerEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();

    //     // Find the latest of all three entries
    //     $latestEntry = collect([$latestWaterEntry, $latestJivamrutEntry, $latestFertilizerEntry])
    //         ->filter() // Remove null values
    //         ->sortByDesc(fn($entry) => $entry->created_at) // Sort by created_at descending
    //         ->first();

    //     if ($latestEntry) {
    //         $latestLandPart = LandPart::find($latestEntry->land_part_id);
    //         $latestEntry->time = Carbon::parse($latestEntry->time);

    //         $data['latestEntry'] = [
    //             'entry' => $latestEntry,
    //             'landPartName' => $latestLandPart[0]->name ?? 'Unknown',
    //             'formattedTime' => $latestEntry->formatted_time, // Using the accessor
    //         ];
    //         // dd($data['latestEntry']);
    //     } else {
    //         $data['latestEntry'] = null;
    //     }

    //     // Pass data to the view
    //     return view('lands.maps', $data);
    // }

    public function landMaps(Request $request, $id)
    {
        // Total water used (in hours)
        $totalWaterUsed = WaterEntry::where('land_id', $id)->sum('hours');
        $data['totalWaterUsed'] = $totalWaterUsed;

        // Current month's water usage
        $currentMonthWaterUsed = WaterEntry::where('land_id', $id)
            ->whereMonth('date', date('m'))
            ->sum('hours');
        $data['currentMonthWaterUsed'] = $currentMonthWaterUsed;

        // Total water expense
        $totalWaterExpense = Water::where('land_id', $id)->sum('price');
        $data['totalWaterExpense'] = $totalWaterExpense;

        // Current month's water expense
        $currentMonthWaterExpense = Water::where('land_id', $id)
            ->whereMonth('date', date('m'))
            ->sum('price');
        $data['currentMonthWaterExpense'] = $currentMonthWaterExpense;

        // Land details
        $land = Land::where('id', $id)->first();
        $data['land'] = $land;

        // Land parts
        $landParts = LandPart::where('land_id', $id)->get();
        $data['landParts'] = $landParts;

        // Flush history
        $flushHistory = FlushHistory::where('land_id', $id)->get();
        $data['flushHistory'] = $flushHistory;

        // Plot Fertilizer history
        $PlotFertilizer = PlotFertilizer::where('land_id', $id)->get();
        $data['PlotFertilizer'] = $PlotFertilizer;

        // Fetch the latest entry from each table
        $latestWaterEntry = WaterEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();
        $latestJivamrutEntry = JivamrutEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();
        $latestFertilizerEntry = FertilizerEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();

        // Prepare all latest entries for display
        $data['latestEntries'] = collect([
            [
                'type' => 'WaterEntry',
                'entry' => $latestWaterEntry,
                'landParts' => $latestWaterEntry ? $this->getLandPartNames($latestWaterEntry->land_part_id) : 'N/A',
                'time' => $latestWaterEntry && $latestWaterEntry->time ? Carbon::parse($latestWaterEntry->time)->format('H:i:s') : 'N/A',
                'date' => $latestWaterEntry && $latestWaterEntry->date ? Carbon::parse($latestWaterEntry->date)->format('Y-m-d') : 'N/A',
            ],
            [
                'type' => 'JivamrutEntry',
                'entry' => $latestJivamrutEntry,
                'landParts' => $latestJivamrutEntry ? $this->getLandPartNames($latestJivamrutEntry->land_part_id) : 'N/A',
                'time' => $latestJivamrutEntry && $latestJivamrutEntry->time ? Carbon::parse($latestJivamrutEntry->time)->format('H:i:s') : 'N/A',
                'date' => $latestJivamrutEntry && $latestJivamrutEntry->date ? Carbon::parse($latestJivamrutEntry->date)->format('Y-m-d') : 'N/A',
            ],
            [
                'type' => 'FertilizerEntry',
                'entry' => $latestFertilizerEntry,
                'landParts' => $latestFertilizerEntry ? $this->getLandPartNames($latestFertilizerEntry->land_part_id) : 'N/A',
                'time' => $latestFertilizerEntry && $latestFertilizerEntry->time ? Carbon::parse($latestFertilizerEntry->time)->format('H:i:s') : 'N/A',
                'date' => $latestFertilizerEntry && $latestFertilizerEntry->date ? Carbon::parse($latestFertilizerEntry->date)->format('Y-m-d') : 'N/A',
            ],
        ])->toArray();

        return view('lands.maps', $data);
    }


    private function getLandPartNames($landPartIds)
    {
        // If land_part_id is a string (JSON), decode it into an array
        $landPartIdsArray = is_string($landPartIds) ? json_decode($landPartIds, true) : $landPartIds;

        // Fetch land part names for the given land part ids
        $landParts = LandPart::whereIn('id', $landPartIdsArray)->pluck('name')->toArray();

        // Return the land part names as a comma-separated string
        return implode(', ', $landParts);
    }

    public function saveDocuments(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:pdf', // Adjust the allowed file types and size
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Save the file to a designated folder
            $file->move(public_path('uploads/lands'), $filename);

            $lands = Land::where('id', $request->id)->update([
                'documents' => $filename
            ]);

            return response()->json(['message' => 'File uploaded successfully'], 200);
        }

        return response()->json(['error' => 'No file provided'], 400);
    }

    public function storeLandPart(Request $request)
    {

        $fileName = fileUpload('land_parts', $request->image);

        $createLandPart = LandPart::create([
            'image' => $fileName,
            'land_id' => $request->land_id,
            'name' => $request->name,
            'plants' => $request->plants,
            'color' => $request->color
        ]);

        if ($createLandPart) {
            return redirect()->route('lands.maps', $request->land_id)->with(['success' => true, 'message' => 'Land part added successfully!']);
        } else {
            return redirect()->route('lands.maps', $request->land_id)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    public function updatePart(Request $request)
    {

        $id = $request->landpart_id;
        $land_id = $request->land_id;

        $updatePart = LandPart::where([['id', $id], ['land_id', $land_id]])->update([
            'name' => $request->name,
            'plants' => $request->plants,
            'color' => $request->color
        ]);

        if ($request->hasFile('image')) {
            $land = LandPart::where([['id', $id], ['land_id', $land_id]])->first();

            if (isset($land->image) && $land->image != null) {

                $fileName = fileUpload('land_parts', $request->image, $land->image);
            } else {

                $fileName = fileUpload('land_parts', $request->image);
            }

            $land->image = $fileName;
            $land->save();
        }

        if ($updatePart) {
            return redirect()->route('lands.maps', $land_id)->with(['success' => true, 'message' => 'Land part updated successfully!']);
        } else {
            return redirect()->route('lands.maps', $land_id)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    public function destroyPart(string $id)
    {

        $deleteLandPart = LandPart::where('id', $id)->delete();

        if ($deleteLandPart) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    public function landPartDetails($id)
    {

        $totalWaterUsage = WaterEntry::where('land_part_id', $id)->count();
        $data['totalWaterUsage'] = $totalWaterUsage;

        $monthlyWaterUsage = WaterEntry::where('land_part_id', $id)->whereMonth('date', date('m'))->count();
        $data['monthlyWaterUsage'] = $monthlyWaterUsage;

        // $totalLitrUsed = WaterEntry::where('land_part_id', $id)->sum('volume');
        $totalLitrUsed = WaterEntry::where('land_id', $id)->sum('hours');
        $data['totalLitrUsed'] = $totalLitrUsed;

        // $monthlyLitrUsed = WaterEntry::where('land_part_id', $id)->whereMonth('date', date('m'))->sum('volume');
        $monthlyLitrUsed = WaterEntry::where('land_id', $id)->whereMonth('date', date('m'))->sum('hours');
        $data['monthlyLitrUsed'] = $monthlyLitrUsed;

        $waterEntries = WaterEntry::where('land_part_id', $id)->get();
        $data['waterEntries'] = $waterEntries;

        $partDetail = LandPart::with('land')->where('id', $id)->first();
        $data['partDetail'] = $partDetail;

        $landParts = LandPart::where('land_id', $partDetail->land->id)->get();
        $data['landParts'] = $landParts;

        $partDetail = LandPart::findOrFail($id);

        $latestEntry = WaterEntry::where('land_part_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        $data['latestEntry'] = $latestEntry;

        $latestEntry = JivamrutEntry::where('land_part_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        $data['latestEntry'] = $latestEntry;

        $latestEntry = FertilizerEntry::where('land_part_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        $data['latestEntry'] = $latestEntry;

        return view('land-parts.details', $data);
    }

    public function getWatersTable(Request $request)
    {

        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $landPartId = $request->landPartId;

        $query = WaterEntry::whereJsonContains('land_part_id', $landPartId)->orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $waterEntries = $query->get();
        $data['waterEntries'] = $waterEntries;

        return View::make('land-parts.Ajax.water-table', $data);
    }

    public function saveWaterEntries(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'land_id' => 'required',
            'land_part_id' => 'required',
            'date' => 'required'
        ]);


        $createWaterEntry = WaterEntry::create([
            'user_id' => Auth::user()->id,
            'land_id' => $request->land_id,
            'land_part_id' => $request->land_part_id,
            'date' => date('Y-m-d', strtotime($request->date)),
            'time' => date('H:i:s', strtotime($request->time)),
            'person' => $request->person,
            'volume' => $request->volume,
            'hours' => $request->hours
        ]);

        $latestEntry = WaterEntry::where('land_part_id', $request->land_part_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($createWaterEntry) {
            return redirect()->route('land-parts.details', $request->land_part)
                ->with([
                    'success' => true,
                    'message' => 'Water entry added successfully!',
                    'latestEntry' => $latestEntry
                ]);
        } else {
            return redirect()->route('land-parts.details', $request->land_part)
                ->with(['error' => true, 'message' => 'Something went wrong!']);
        }
    }

    public function getJivamrutTable(Request $request)
    {

        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $landPartId = $request->landPartId;

        $query = JivamrutEntry::whereJsonContains('land_part_id', $landPartId)->orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $jivamrutEntries = $query->get();
        $data['jivamrutEntries'] = $jivamrutEntries;

        return View::make('land-parts.Ajax.jivamrut-table', $data);
    }

    public function saveJivamrutEntries(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'land_id' => 'required',
            'land_part_id' => 'required',
            'date' => 'required|date',
            // 'size' => 'nullable|string',
            // 'barrels' => 'nullable|integer',
            // 'time' => 'nullable|date_format:H:i',
            // 'person' => 'nullable|string',
            // 'volume' => 'nullable|numeric',
        ]);

        $createJivamrutEntry = JivamrutEntry::create([
            'user_id' => Auth::id(),
            'land_id' => $request->land_id,
            'land_part_id' => $request->land_part_id,
            'date' => date('Y-m-d', strtotime($request->date)),
            'time' => date('H:i:s', strtotime($request->time)),
            'size' => $request->size,
            'barrels' => $request->barrels,
            'person' => $request->person,
            'volume' => $request->volume,
        ]);

        if ($createJivamrutEntry) {
            return redirect()->route('land-parts.details', $request->land_part)
                ->with([
                    'success' => true,
                    'message' => 'Jivamrut entry added successfully!'
                ]);
        } else {
            return redirect()->route('land-parts.details', $request->land_part)
                ->with(['error' => true, 'message' => 'Something went wrong!']);
        }
    }

    public function getFertilizerTable(Request $request)
    {

        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $landPartId = $request->landPartId;

        $query = FertilizerEntry::whereJsonContains('land_part_id', $landPartId)->orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $fertilizerEntries = $query->get();
        $data['fertilizerEntries'] = $fertilizerEntries;

        return View::make('land-parts.Ajax.fertilizer-table', $data);
    }

    public function saveFertilizerEntries(Request $request)
    {

        $request->validate([
            'land_id' => 'required',
            'land_part_id' => 'required',
            'date' => 'required'
        ]);

        $createFertilizerEntry = FertilizerEntry::create([
            'user_id' => Auth::user()->id,
            'land_id' => $request->land_id,
            'land_part_id' => $request->land_part_id,
            'fertilizer_name' => $request->fertilizer_name,
            'date' => date('Y-m-d', strtotime($request->date)),
            'time' => date('H:i:s', strtotime($request->time)),
            'person' => $request->person,
            'qty' => $request->qty,
            'remarks' => $request->remarks,
        ]);

        if ($createFertilizerEntry) {
            return redirect()->route('land-parts.details', $request->land_part)->with(['success' => true, 'message' => 'Fertilizer Entry added successfully!']);
        } else {
            return redirect()->route('land-parts.details', $request->land_part)->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }
}
