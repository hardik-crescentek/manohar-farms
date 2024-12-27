<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\LandPart;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function getMaps() {
        try{
    		$maps = Land::all();
    		return [ 'status' => 200, 'message' => 'Success' ,'data' => $maps ];
    	}
    	catch (\Exception $e) {
    		return [ 'status' => 200, 'message' => 'error' ,'data' => null, 'errors' => $e->getMessage() ];
    	}
    }

    public function getValves($id) {
        try{
    		$valves = LandPart::where('land_id', $id)->get();
    		return [ 'status' => 200, 'message' => 'Success' ,'data' => $valves ];
    	}
    	catch (\Exception $e) {
    		return [ 'status' => 200, 'message' => 'error' ,'data' => null, 'errors' => $e->getMessage() ];
    	}
    }
}
