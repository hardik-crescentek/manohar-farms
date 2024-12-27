<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Diesel;
use App\Models\DieselEntry;
use App\Models\Expense;
use App\Models\Land;
use App\Models\Plant;
use App\Models\Staff;
use App\Models\User;
use App\Models\Water;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use stdClass;

class DashboardController extends Controller
{
    public function dashboard() {

        $staffsCount = Staff::count();
        $data['staffsCount'] = $staffsCount;

        $plantsCount = Plant::count();
        $data['plantsCount'] = $plantsCount;

        $totalExpense = Expense::sum('amount');
        $data['totalExpense'] = $totalExpense;
        
        $totalWaterExpense = Water::sum('price');
        $data['totalWaterExpense'] = $totalWaterExpense;

        $waterData = [];
        $dieselData = [];
        for($i = 1; $i <= 12; $i++) {
            $waterData[] = Water::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->sum('price');
            $dieselData[] = DieselEntry::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->sum('amount');
        }
        $waterObj = new \stdClass();
        $waterObj->name = "Water Expenses";
        $waterObj->data = $waterData;

        $dieselObj = new \stdClass();
        $dieselObj->name = "Diesel Expenses";
        $dieselObj->data = $dieselData;

        $yearlyExpensesSeriesAr[] = $waterObj;
        $yearlyExpensesSeriesAr[] = $dieselObj;

        $lands = Land::get();
        $landsArr = [];
        $mapWaterExpenseAr = [];
        $mapBillExpenseAr = [];
        foreach($lands as $key => $land) {

            $landsArr[] = $land->name;

            $mapWaterExpense = Water::where('land_id', $land->id)->sum('price');
            $mapWaterExpenseAr[] = $mapWaterExpense;

            $mapBillExpense = Bill::where('land_id', $land->id)->sum('amount');
            $mapBillExpenseAr[] = $mapBillExpense;
        }

        $mapWaterObj = new \stdClass();
        $mapWaterObj->name = "Water Expenses";
        $mapWaterObj->data = $mapWaterExpenseAr;

        $mapDieselObj = new \stdClass();
        $mapDieselObj->name = "Bill Expenses";
        $mapDieselObj->data = $mapBillExpenseAr;

        $mapWiseExpenses[] = $mapWaterObj;
        $mapWiseExpenses[] = $mapDieselObj;

        $data['yearlyExpensesSeries'] = json_encode($yearlyExpensesSeriesAr, true);
        $data['mapWiseExpensesSeries'] = json_encode($mapWiseExpenses, true);
        $data['landArr'] = json_encode($landsArr, true);

        if(Auth::user()->hasrole('super-admin')) {
            return view('dashboard.super-admin', $data);
        } else  {
            return view('dashboard.admin', $data);
        }
    }

    public function syncPermissions(Request $request) {

        $admin = User::where('id', 1)->first();

        $permissions = Permission::pluck('id')->toArray();

        $admin->syncPermissions($permissions);

        echo 'successfully synced.';
    }
}
