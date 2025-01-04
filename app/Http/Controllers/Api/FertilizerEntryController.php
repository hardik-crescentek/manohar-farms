<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FertilizerEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FertilizerEntryController extends Controller
{
    public function saveFertilizerEntry(Request $request) {

        try {
            $validator = Validator::make($request->all(), [
                'land_id' => 'required',
                'land_part_id' => 'required',
                'date' => 'required',
                'time' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $createFertilizerEntry = FertilizerEntry::create([
                'user_id' => Auth::user()->id,
                'land_id' => $request->land_id,
                'land_part_id' => $request->land_part_id,
                'fertilizer_name' => $request->fertilizer_name,
                'date' => date('Y-m-d', strtotime($request->date)),
                'time' => date('H:i:s', strtotime($request->time)),
                'person' => $request->person
            ]);

            if ($createFertilizerEntry) {
                return response()->json(['status' => 200, 'message' => 'Fertilizer Entry added successfully!', 'data' => $createFertilizerEntry], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function getFertilizerPlotWise(Request $request, $id) {

        try {
            $fertilizerEntries = FertilizerEntry::whereJsonContains('land_part_id', $id)->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $fertilizerEntries], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateFertilizerPlotWise(Request $request, $id)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'land_id' => 'required',
                'land_part_id' => 'required',
                'date' => 'required',
                'time' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            // Find the FertilizerEntry record
            $fertilizerEntry = FertilizerEntry::findOrFail($id);

            // Update the FertilizerEntry record
            $fertilizerEntry->update([
                'land_id' => $request->land_id,
                'land_part_id' => $request->land_part_id,
                'fertilizer_name' => $request->fertilizer_name,
                'date' => date('Y-m-d', strtotime($request->date)),
                'time' => date('H:i:s', strtotime($request->time)),
                'person' => $request->person
            ]);

            return response()->json(['status' => 200, 'message' => 'Fertilizer Entry updated successfully!', 'data' => $fertilizerEntry], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function destroyFertilizerPlotWise(string $id)
    {
        try {
            $deleteFertilizerEntries = FertilizerEntry::where('id', $id)->delete();

            if ($deleteFertilizerEntries) {
                return response()->json(['status' => 200, 'message' => 'Fertilizer Entry deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting FertilizerEntry Entry');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
