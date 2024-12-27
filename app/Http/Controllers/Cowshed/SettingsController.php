<?php

namespace App\Http\Controllers\Cowshed;

use App\Http\Controllers\Controller;
use App\Models\CowshedSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function settings() {

        $cowshedSetting = CowshedSetting::find(1);
        $data['setting'] = $cowshedSetting;

        return view('cowshed.settings.index', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'milk_price' => 'required',
        ]);

        $cowshedSetting = CowshedSetting::where('id', $id)->update([
            'milk_price' => $request->milk_price
        ]);

        if($cowshedSetting) {
            return redirect()->route('cowshed.settings')->with(['success' => true, 'message' => 'Setting updated successfully!']);
        } else {
            return redirect()->route('cowshed.settings')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }
}
