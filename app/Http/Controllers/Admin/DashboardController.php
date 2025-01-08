<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Camera;
use App\Models\Diesel;
use App\Models\DieselEntry;
use App\Models\Expense;
use App\Models\FertilizerPesticide;
use App\Models\Infrastructure;
use App\Models\Land;
use App\Models\Plant;
use App\Models\Staff;
use App\Models\User;
use App\Models\VehicleService;
use App\Models\Water;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use stdClass;

class DashboardController extends Controller
{
    // public function dashboard() {

    //     $staffsCount = Staff::count();
    //     $data['staffsCount'] = $staffsCount;

    //     $plantsCount = Plant::count();
    //     $data['plantsCount'] = $plantsCount;

    //     $totalExpense = Expense::sum('amount');
    //     $data['totalExpense'] = $totalExpense;

    //     $totalWaterExpense = Water::sum('price');
    //     $data['totalWaterExpense'] = $totalWaterExpense;

    //     $waterData = [];
    //     $dieselData = [];
    //     for($i = 1; $i <= 12; $i++) {
    //         $waterData[] = Water::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->sum('price');
    //         $dieselData[] = DieselEntry::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->sum('amount');
    //     }
    //     $waterObj = new \stdClass();
    //     $waterObj->name = "Water Expenses";
    //     $waterObj->data = $waterData;

    //     $dieselObj = new \stdClass();
    //     $dieselObj->name = "Diesel Expenses";
    //     $dieselObj->data = $dieselData;

    //     $yearlyExpensesSeriesAr[] = $waterObj;
    //     $yearlyExpensesSeriesAr[] = $dieselObj;

    //     $lands = Land::get();
    //     $landsArr = [];
    //     $mapWaterExpenseAr = [];
    //     $mapBillExpenseAr = [];
    //     foreach($lands as $key => $land) {

    //         $landsArr[] = $land->name;

    //         $mapWaterExpense = Water::where('land_id', $land->id)->sum('price');
    //         $mapWaterExpenseAr[] = $mapWaterExpense;

    //         $mapBillExpense = Bill::where('land_id', $land->id)->sum('amount');
    //         $mapBillExpenseAr[] = $mapBillExpense;
    //     }

    //     $mapWaterObj = new \stdClass();
    //     $mapWaterObj->name = "Water Expenses";
    //     $mapWaterObj->data = $mapWaterExpenseAr;

    //     $mapDieselObj = new \stdClass();
    //     $mapDieselObj->name = "Bill Expenses";
    //     $mapDieselObj->data = $mapBillExpenseAr;

    //     $mapWiseExpenses[] = $mapWaterObj;
    //     $mapWiseExpenses[] = $mapDieselObj;

    //     $data['yearlyExpensesSeries'] = json_encode($yearlyExpensesSeriesAr, true);
    //     $data['mapWiseExpensesSeries'] = json_encode($mapWiseExpenses, true);
    //     $data['landArr'] = json_encode($landsArr, true);

    //     if(Auth::user()->hasrole('super-admin')) {
    //         return view('dashboard.super-admin', $data);
    //     } else  {
    //         return view('dashboard.admin', $data);
    //     }
    // }

    public function dashboard()
    {
        // Initialize data array
        $data = [];
        $currentYear = date('Y');
        $currentMonth = date('m');

        // 1. Aggregate Counts and Metrics for Current Month
        $data['staffsCount'] = Staff::count();
        $data['plantsCount'] = Plant::count();
        $data['totalExpense'] = Expense::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('amount');
        $data['totalWaterExpense'] = Water::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('price');

        // 2. Yearly Expenses Series (Water and Diesel by month)
        $waterData = [];
        $dieselData = [];

        for ($month = 1; $month <= 12; $month++) {
            $waterData[] = Water::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('price');

            $dieselData[] = DieselEntry::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('amount');
        }

        $data['yearlyExpensesSeries'] = json_encode([
            ['name' => 'Water Expenses', 'data' => $waterData],
            ['name' => 'Diesel Expenses', 'data' => $dieselData],
        ]);

        // 3. Land-wise Expenses Mapping for Current Month
        $lands = Land::all();
        $landsArr = [];
        $mapWaterExpenseAr = [];
        $mapBillExpenseAr = [];

        foreach ($lands as $land) {
            $landsArr[] = $land->name;
            $mapWaterExpenseAr[] = Water::where('land_id', $land->id)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->sum('price');
            $mapBillExpenseAr[] = Bill::where('land_id', $land->id)
                ->where('status', 'paid')
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $currentMonth)
                ->sum('amount');
        }

        $data['mapWiseExpensesSeries'] = json_encode([
            ['name' => 'Water Expenses', 'data' => $mapWaterExpenseAr],
            ['name' => 'Bill Expenses', 'data' => $mapBillExpenseAr],
        ]);

        $data['landArr'] = json_encode($landsArr);

        // 4. Calculate Total Expenses for Current Month Dynamically
        $totalExpenses = collect([
            Plant::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('price'),
            FertilizerPesticide::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('price'),
            Staff::sum('salary'), // Staff salaries may not be monthly, adjust if necessary
            VehicleService::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('price'),
            Diesel::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('total_price'),
            DieselEntry::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('amount'),
            Water::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('price'),
            Bill::where('status', 'paid')->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('amount'),
            Expense::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('amount'),
            Infrastructure::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('amount'),
            Camera::whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->sum('amount'),
        ])->sum();

        $data['totalExpenses'] = number_format($totalExpenses, 2);

        // 5. Choose View Based on User Role
        $view = Auth::user()->hasRole('super-admin') ? 'dashboard.super-admin' : 'dashboard.admin';

        return view($view, $data);
    }




    public function syncPermissions(Request $request)
    {

        $admin = User::where('id', 1)->first();

        $permissions = Permission::pluck('id')->toArray();

        $admin->syncPermissions($permissions);

        echo 'successfully synced.';
    }
}
