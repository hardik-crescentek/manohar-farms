<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FertilizerEntry;
use App\Models\JivamrutEntry;
use App\Models\Land;
use App\Models\LandPart;
use App\Models\WaterEntry;
use Carbon\Carbon;
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

    // public function getLatestOpenValve($id)
    // {
    //     try {
    //         // Fetch the land details
    //         $land = Land::find($id);

    //         if (!$land) {
    //             return response()->json([
    //                 'status' => 404,
    //                 'message' => 'Land not found.',
    //                 'data' => null,
    //             ], 404);
    //         }

    //         // Fetch the latest entry from each table
    //         $latestWaterEntry = WaterEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();
    //         $latestJivamrutEntry = JivamrutEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();
    //         $latestFertilizerEntry = FertilizerEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();

    //         // Find the latest of all three entries
    //         $latestEntry = collect([$latestWaterEntry, $latestJivamrutEntry, $latestFertilizerEntry])
    //             ->filter() // Remove null values
    //             ->sortByDesc(fn($entry) => $entry->created_at) // Sort by created_at descending
    //             ->first();

    //         // Check if a latest entry exists
    //         if ($latestEntry) {
    //             $latestLandPart = LandPart::find($latestEntry->land_part_id);

    //             $response = [
    //                 'landName' => $land->name,
    //                 'entry' => $latestEntry,
    //                 'landPartName' => $latestLandPart[0]->name ?? 'Unknown',
    //                 'formattedTime' => $latestEntry->time, // Assuming `time` is a direct attribute
    //             ];

    //             return response()->json([
    //                 'status' => 200,
    //                 'message' => 'Latest open valve fetched successfully.',
    //                 'data' => $response,
    //             ], 200);
    //         }

    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'No entries found for the given land.',
    //             'data' => [
    //                 'landName' => $land->name,
    //             ],
    //         ], 404);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'An error occurred while fetching the latest entry.',
    //             'errors' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function getLatestOpenValve($id)
    {
        try {
            $land = Land::find($id);
            if (!$land) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Land not found.',
                    'data' => null,
                ], 404);
            }

            // Latest entries
            $latestWaterEntry = WaterEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();
            $latestJivamrutEntry = JivamrutEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();
            $latestFertilizerEntry = FertilizerEntry::where('land_id', $id)->orderBy('created_at', 'desc')->first();

            // Latest entries with land part names
            $latestEntries = collect([
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

            // Prepare the final API response
            return response()->json([
                'status' => 200,
                'message' => 'Land map data fetched successfully.',
                'data' => [
                    'land' => $land,
                    'latestEntries' => $latestEntries,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching the land map data.',
                'errors' => $e->getMessage(),
            ], 500);
        }
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
}
