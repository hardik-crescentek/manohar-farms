<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FertilizerEntry;
use App\Models\JivamrutEntry;
use App\Models\Land;
use App\Models\LandPart;
use App\Models\WaterEntry;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function getMaps()
    {
        try {
            $maps = Land::all();
            return ['status' => 200, 'message' => 'Success', 'data' => $maps];
        } catch (\Exception $e) {
            return ['status' => 200, 'message' => 'error', 'data' => null, 'errors' => $e->getMessage()];
        }
    }

    public function getValves($id)
    {
        try {
            $valves = LandPart::where('land_id', $id)->get();
            return ['status' => 200, 'message' => 'Success', 'data' => $valves];
        } catch (\Exception $e) {
            return ['status' => 200, 'message' => 'error', 'data' => null, 'errors' => $e->getMessage()];
        }
    }

    public function getLatestOpenValve($id)
    {
        try {
            // Fetch the land details
            $land = Land::find($id);

            if (!$land) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Land not found.',
                    'data' => null,
                ], 404);
            }

            // Fetch the latest entry from each table
            $latestWaterEntry = WaterEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();
            $latestJivamrutEntry = JivamrutEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();
            $latestFertilizerEntry = FertilizerEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();

            // Find the latest of all three entries
            $latestEntry = collect([$latestWaterEntry, $latestJivamrutEntry, $latestFertilizerEntry])
                ->filter() // Remove null values
                ->sortByDesc(fn($entry) => $entry->created_at) // Sort by created_at descending
                ->first();

            // Check if a latest entry exists
            if ($latestEntry) {
                $latestLandPart = LandPart::find($latestEntry->land_part_id);

                $response = [
                    'landName' => $land->name,
                    'entry' => $latestEntry,
                    'landPartName' => $latestLandPart[0]->name ?? 'Unknown',
                    'formattedTime' => $latestEntry->time, // Assuming `time` is a direct attribute
                ];

                return response()->json([
                    'status' => 200,
                    'message' => 'Latest open valve fetched successfully.',
                    'data' => $response,
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => 'No entries found for the given land.',
                'data' => [
                    'landName' => $land->name,
                ],
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching the latest entry.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
}
