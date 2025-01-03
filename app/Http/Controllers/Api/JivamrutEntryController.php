<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FertilizerEntry;
use App\Models\JivamrutEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class JivamrutEntryController extends Controller
{
    public function saveJivamrutEntry(Request $request)
    {

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

            $createFertilizerEntry = JivamrutEntry::create([
                'user_id' => Auth::user()->id,
                'land_id' => $request->land_id,
                'land_part_id' => $request->land_part_id,
                'fertilizer_name' => $request->fertilizer_name,
                'date' => date('Y-m-d', strtotime($request->date)),
                'time' => date('H:i:s', strtotime($request->time)),
                'person' => $request->person,
                'qty' => $request->qty,
                'remarks' => $request->remarks
            ]);

            if ($createFertilizerEntry) {
                return response()->json(['status' => 200, 'message' => 'Jivamrut Entry added successfully!', 'data' => $createFertilizerEntry], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function getJivamrutPlotWise(Request $request, $id)
    {

        try {
            $jivamrutEntries = JivamrutEntry::whereJsonContains('land_part_id', $id)->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $jivamrutEntries], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
}
