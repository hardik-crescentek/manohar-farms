<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Diesel;
use App\Models\DieselEntry;
use App\Models\Expense;
use App\Models\FertilizerPesticide;
use App\Models\Land;
use App\Models\LandPart;
use App\Models\Plant;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Models\Water;
use PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function getReport() {

        try {
            $current = Carbon::now();
            $currentDate = Carbon::now()->format('Y-m-d');

            // Calculate the previous month and year
            $prevMonth = $current->subMonth()->format('m');
            $prevYear = $current->subMonth()->format('Y');

            $totalExpense = Expense::sum('amount');
            $allReports['totalExpense'] = number_format($totalExpense, 0);

            $totalWaterExpense = Water::sum('price');
            $allReports['totalWaterExpense'] = number_format($totalWaterExpense, 0);

            $totalBillExpense = Bill::sum('amount');
            $allReports['totalBillExpense'] = number_format($totalBillExpense, 0);

            $totalDieselExpense = DieselEntry::sum('amount');
            $allReports['totalDieselExpense'] = number_format($totalDieselExpense, 0);

            $totalStaffExpenseQuery = Staff::select(DB::raw('SUM(COALESCE(salary, 0) + COALESCE(rate_per_day, 0)) AS total_expense'))->first();
            $totalStaffExpense = $totalStaffExpenseQuery->total_expense ?? 0;
            $allReports['totalStaffExpense'] = number_format($totalStaffExpense, 0);

            $totalPlantExpense = Plant::sum('price');
            $allReports['totalPlantExpense'] = number_format($totalPlantExpense, 0);

            $totalSalariedStaffExpense = Staff::where('type', 1)->sum('salary');
            $allReports['totalSalariedStaffExpense'] = number_format($totalSalariedStaffExpense, 0);

            $totalOndemandStaffExpense = Staff::where('type', 2)->sum('rate_per_day');
            $allReports['totalOndemandStaffExpense'] = number_format($totalOndemandStaffExpense, 0);

            $totalFertilizerExpense = FertilizerPesticide::sum('price');
            $allReports['totalFertilizerExpense'] = number_format($totalFertilizerExpense, 0);

            // expense
            $expense['totalExpense'] = $totalExpense;

            $currentMonthExpense = Expense::whereMonth('date', date('m'))->sum('amount');
            $expense['currentMonthExpense'] = number_format($currentMonthExpense, 0);

            $prevMonthExpense = Expense::whereMonth('date', $prevMonth)->sum('amount');
            $expense['prevMonthExpense'] = number_format($prevMonthExpense, 0);

            $currentYearExpense = Expense::whereYear('date', date('Y'))->sum('amount');
            $expense['currentYearExpense'] = number_format($currentYearExpense, 0);

            // water
            $water['totalWater'] = number_format($totalWaterExpense, 0);

            $currentMonthWater = Water::whereMonth('date', date('m'))->sum('price');
            $water['currentMonthWater'] = number_format($currentMonthWater, 0);

            $prevMonthWater = Water::whereMonth('date', $prevMonth)->sum('price');
            $water['prevMonthWater'] = number_format($prevMonthWater, 0);

            $currentYearWater = Water::whereYear('date', date('Y'))->sum('price');
            $water['currentYearWater'] = number_format($currentYearWater, 0);

            // diesel
            $diesel['totalDiesel'] = number_format($totalDieselExpense, 0);

            $currentMonthDiesel = DieselEntry::whereMonth('date', date('m'))->sum('amount');
            $diesel['currentMonthDiesel'] = number_format($currentMonthDiesel, 0);

            $prevMonthDiesel = DieselEntry::whereMonth('date', $prevMonth)->sum('amount');
            $diesel['prevMonthDiesel'] = number_format($prevMonthDiesel, 0);

            $currentYearDiesel = DieselEntry::whereYear('date', date('Y'))->sum('amount');
            $diesel['currentYearDiesel'] = number_format($currentYearDiesel, 0);

            // bill
            $bill['totalBills'] = number_format($totalBillExpense, 0);

            $currentMonthBill = Bill::where('period_start', date('m'))->sum('amount');
            $bill['currentMonthBill'] = number_format($currentMonthBill, 0);

            $prevMonthBill = Bill::whereMonth('period_start', $prevMonth)->sum('amount');
            $bill['prevMonthBill'] = number_format($prevMonthBill, 0);

            $currentYearBill = Bill::whereYear('period_start', date('Y'))->sum('amount');
            $bill['currentYearBill'] = number_format($currentYearBill, 0);

            // plant
            $plant['totalPlants'] = number_format($totalPlantExpense, 0);

            $currentMonthPlants = Plant::whereMonth('date', date('m'))->sum('price');
            $plant['currentMonthPlants'] = number_format($currentMonthPlants, 0);

            $prevMonthPlants = Plant::whereMonth('date', $prevMonth)->sum('price');
            $plant['prevMonthPlants'] = number_format($prevMonthPlants, 0);

            $currentYearPlants = Plant::whereYear('date', date('Y'))->sum('price');
            $plant['currentYearPlants'] = number_format($currentYearPlants, 0);

            // staff
            $staff['totalStaff'] = number_format($totalStaffExpense, 0);

            $currentMonthStaffQuery = Staff::whereDate('joining_date', '<=', now())
                        ->where(function ($query) {
                            $query->whereNull('resign_date')->orWhereDate('resign_date', '>=', now());
                        })
                        ->select(DB::raw('SUM(COALESCE(salary, 0) + COALESCE(rate_per_day, 0)) AS total_salary'))
                        ->first();
            $currentMonthTotalSalary = $currentMonthStaffQuery->total_salary ?? 0;

            $prevMonthStaffQuery = Staff::whereMonth('joining_date', '<=', $prevMonth)
                        ->where(function ($query) use ($prevMonth) {
                            $query->whereNull('resign_date')->orWhereMonth('resign_date', '>=', $prevMonth);
                        })
                        ->select(DB::raw('SUM(COALESCE(salary, 0) + COALESCE(rate_per_day, 0)) AS total_salary'))
                        ->first();
            $prevMonthTotalSalary = $prevMonthStaffQuery->total_salary ?? 0;

            $currentYearStaffQuery = Staff::whereYear('joining_date', '<=', date('Y'))
                            ->where(function ($query) {
                                $query->whereNull('resign_date')->orWhereDate('resign_date', '>=', now());
                            })
                            ->select(DB::raw('SUM(COALESCE(salary, 0) + COALESCE(rate_per_day, 0)) AS total_salary'))
                            ->first();
            $currentYearStaff = $currentYearStaffQuery->total_salary ?? 0;

            $staff['currentMonthStaff'] = number_format($currentMonthTotalSalary, 0);
            $staff['prevMontStaff'] = number_format($prevMonthTotalSalary, 0);
            $staff['currentYearStaff'] = number_format($currentYearStaff, 0);

            //fertilizer
            $fertilizer['totalFertilizer'] = number_format($totalFertilizerExpense, 0);

            $currentMonthFertilizer = FertilizerPesticide::whereMonth('date', date('m'))->sum('price');
            $fertilizer['currentMonthFertilizer'] = number_format($currentMonthFertilizer, 0);

            $prevMonthFertilizer = FertilizerPesticide::whereMonth('date', $prevMonth)->sum('price');
            $fertilizer['prevMonthFertilizer'] = number_format($prevMonthFertilizer, 0);

            $currentYearFertilizer = FertilizerPesticide::whereYear('date', date('Y'))->sum('price');
            $fertilizer['currentYearFertilizer'] = number_format($currentYearFertilizer, 0);

            $data['allReports'] = $allReports;
            $data['expenseReport'] = $expense;
            $data['waterReports'] = $water;
            $data['dieselReports'] = $diesel;
            $data['billReports'] = $bill;
            $data['plantReports'] = $plant;
            $data['staffReports'] = $staff;
            $data['fertilizerReports'] = $fertilizer;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getHomeReport(Request $request) {

        try {
            $totalExpense = Expense::sum('amount');
            $data['totalExpense'] = number_format($totalExpense, 0);

            $totalWaterExpense = Water::sum('price');
            $data['totalWaterExpense'] = number_format($totalWaterExpense, 0);

            $totalStaffExpenseQuery = Staff::select(DB::raw('SUM(COALESCE(salary, 0) + COALESCE(rate_per_day, 0)) AS total_expense'))->first();
            $totalStaffExpense = $totalStaffExpenseQuery->total_expense ?? 0;
            $allReports['totalStaffExpense'] = number_format($totalStaffExpense, 0);

            $totalPlantExpense = Plant::sum('price');
            $data['totalPlantExpense'] = number_format($totalPlantExpense, 0);

            $totalDieselExpense = DieselEntry::sum('amount');
            $data['totalDieselExpense'] = number_format($totalDieselExpense, 0);

            $totalBillExpense = Bill::sum('amount');
            $data['totalBillExpense'] = number_format($totalBillExpense, 0);

            $totalVehicles = Vehicle::where('type', 1)->count();
            $data['totalVehicles'] = $totalVehicles;

            $totalPlots = LandPart::count();
            $data['totalPlots'] = $totalPlots;

            $totalPlant = Plant::count();
            $data['totalPlant'] = $totalPlant;

            $totalFP = FertilizerPesticide::count();
            $data['totalFP'] = $totalFP;

            $totalStaffMember = Staff::count();
            $data['totalStaffMember'] = $totalStaffMember;

            $totalSalariedStaffExpense = Staff::where('type', 1)->sum('salary');
            $data['totalSalariedStaffExpense'] = number_format($totalSalariedStaffExpense, 0);

            $totalOndemandStaffExpense = Staff::where('type', 2)->sum('rate_per_day');
            $data['totalOndemandStaffExpense'] = number_format($totalOndemandStaffExpense, 0);

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getExpensesReport(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Expense::orderBy('id', 'desc');

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);
            }

            $expenses = $query->get();
            $data['expenses'] = $expenses;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getExpensesPdf(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Expense::orderBy('id', 'desc');

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);

                $pdfData['from'] = date('d-m-Y', strtotime($startDate));
                $pdfData['to'] = date('d-m-Y', strtotime($endDate));
            }

            $expenses = $query->get();

            if ($expenses->isEmpty()) {
                return response()->json(['status' => 404, 'message' => 'No data found', 'data' => []], 404);
            }

            $pdfData['expenses'] = $expenses;

            $pdf = PDF::loadView('reports.Pdf.expenses', $pdfData);
            $fileName = time().'_expenses_report.pdf';
            $path = public_path('reports/'.$fileName);
            $pdf->save($path);

            $url = url('reports/'.$fileName);
            $data['url'] = $url;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getWaterReport(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Water::orderBy('id', 'desc');

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);
            }

            if ($request->land_id != null) {
                $query->where('land_id', $request->land_id);
            }

            $water = $query->get();
            $data['water'] = $water;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getWaterPdf(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Water::orderBy('id', 'desc');

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);

                $pdfData['from'] = date('d-m-Y', strtotime($startDate));
                $pdfData['to'] = date('d-m-Y', strtotime($endDate));
            }

            if ($request->land_id != null) {
                $query->where('land_id', $request->land_id);

                $landDetail = Land::where('id', $request->land_id)->first();
                $pdfData['landDetail'] = $landDetail;
            }

            $water = $query->get();

            if ($water->isEmpty()) {
                return response()->json(['status' => 404, 'message' => 'No data found', 'data' => []], 404);
            }

            $pdfData['water'] = $water;

            $pdf = PDF::loadView('reports.Pdf.water', $pdfData);
            $fileName = time().'_water_report.pdf';
            $path = public_path('reports/'.$fileName);
            $pdf->save($path);

            $url = url('reports/'.$fileName);
            $data['url'] = $url;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getDieselReport(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = DieselEntry::orderBy('id', 'desc');

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);
            }

            if ($request->vehicle_id != null) {
                $query->where('vehicle_id', $request->vehicle_id);
            }

            $diesel = $query->get();
            $data['diesel'] = $diesel;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getDieselPdf(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = DieselEntry::orderBy('id', 'desc');
            if ($request->vehicle_id != null) {
                $query->where('vehicle_id', $request->vehicle_id);

                $vehicle = Vehicle::where('id', $request->vehicle_id)->first();
                $pdfData['vehicle'] = $vehicle;
            }

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);

                $pdfData['from'] = date('d-m-Y', strtotime($startDate));
                $pdfData['to'] = date('d-m-Y', strtotime($endDate));
            }

            $diesel = $query->get();

            if ($diesel->isEmpty()) {
                return response()->json(['status' => 404, 'message' => 'No data found', 'data' => []], 404);
            }

            $pdfData['diesel'] = $diesel;

            $pdf = PDF::loadView('reports.Pdf.diesel', $pdfData);
            $fileName = time().'_diesel_report.pdf';
            $path = public_path('reports/'.$fileName);
            $pdf->save($path);

            $url = url('reports/'.$fileName);
            $data['url'] = $url;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getBillReport(Request $request) {

        try {
            $startDate = $request->startDate;
            $endDate = $request->endDate;

            $query = Bill::orderBy('id', 'desc');

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('period_start', [$from, $to]);
            }

            if ($request->land_id != null) {
                $query->where('land_id', $request->land_id);
            }

            $bills = $query->get();
            $data['bills'] = $bills;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getBillPdf(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Bill::orderBy('id', 'desc');
            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('period_start', [$from, $to]);

                $pdfData['from'] = date('d-m-Y', strtotime($startDate));
                $pdfData['to'] = date('d-m-Y', strtotime($endDate));
            }

            if ($request->land_id != null) {
                $query->where('land_id', $request->land_id);

                $landDetail = Land::where('id', $request->land_id)->first();
                $pdfData['landDetail'] = $landDetail;
            }

            $bills = $query->get();

            if ($bills->isEmpty()) {
                return response()->json(['status' => 404, 'message' => 'No data found', 'data' => []], 404);
            }

            $pdfData['bills'] = $bills;

            $pdf = PDF::loadView('reports.Pdf.bill', $pdfData);
            $fileName = time().'_bill_report.pdf';
            $path = public_path('reports/'.$fileName);
            $pdf->save($path);

            $url = url('reports/'.$fileName);
            $data['url'] = $url;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getPlantsReport(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Plant::orderBy('id', 'desc');
            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);
            }

            $plants = $query->get();
            $data['plants'] = $plants;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getPlantsPdf(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Plant::orderBy('id', 'desc');
            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);

                $pdfData['from'] = date('d-m-Y', strtotime($startDate));
                $pdfData['to'] = date('d-m-Y', strtotime($endDate));
            }

            $plants = $query->get();

            if ($plants->isEmpty()) {
                return response()->json(['status' => 404, 'message' => 'No data found', 'data' => []], 404);
            }

            $pdfData['plants'] = $plants;

            $pdf = PDF::loadView('reports.Pdf.plant', $pdfData);
            $fileName = time().'_plants_report.pdf';
            $path = public_path('reports/'.$fileName);
            $pdf->save($path);

            $url = url('reports/'.$fileName);
            $data['url'] = $url;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getStaffsReport(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Staff::orderBy('id', 'desc');

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));

                $query->where(function ($query) use ($from, $to) {
                    $query->where(function ($query) use ($from, $to) {
                        $query->whereNull('resign_date')->whereDate('joining_date', '<=', $to);
                    })->orWhere(function ($query) use ($from, $to) {
                        $query->where('joining_date', '<=', $to)->where('resign_date', '>=', $from);
                    });
                });
            }

            if($request->type != null) {
                $query->where('type', $request->type);
            }

            $staff = $query->get();
            $data['staff'] = $staff;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getStaffsPdf(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Staff::orderBy('id', 'desc');

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));

                $query->where(function ($query) use ($from, $to) {
                    $query->where(function ($query) use ($from, $to) {
                        $query->whereNull('resign_date')->whereDate('joining_date', '<=', $to);
                    })->orWhere(function ($query) use ($from, $to) {
                        $query->where('joining_date', '<=', $to)->where('resign_date', '>=', $from);
                    });
                });

                $pdfData['from'] = date('d-m-Y', strtotime($startDate));
                $pdfData['to'] = date('d-m-Y', strtotime($endDate));
            }

            if($request->type == 1 || $request->type == 2) {
                $query->where('type', $request->type);

                if($request->type == 1) {
                    $pdfData['type'] = 'Salaried';
                } 
                if($request->type == 2) {
                    $pdfData['type'] = 'On-demand';
                }
            }

            $staff = $query->get();

            if ($staff->isEmpty()) {
                return response()->json(['status' => 404, 'message' => 'No data found', 'data' => []], 404);
            }

            $pdfData['staffs'] = $staff;

            $pdf = PDF::loadView('reports.Pdf.staffs', $pdfData);
            $fileName = time().'_staff_report.pdf';
            $path = public_path('reports/'.$fileName);
            $pdf->save($path);

            $url = url('reports/'.$fileName);
            $data['url'] = $url;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getFertilizerReport(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = FertilizerPesticide::orderBy('id', 'desc');
            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);
            }

            $fertilizers = $query->get();
            $data['fertilizers'] = $fertilizers;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getFertilizerPdf(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = FertilizerPesticide::orderBy('id', 'desc');
            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);

                $pdfData['from'] = date('d-m-Y', strtotime($startDate));
                $pdfData['to'] = date('d-m-Y', strtotime($endDate));
            }

            $fertilizerPesticides = $query->get();

            if ($fertilizerPesticides->isEmpty()) {
                return response()->json(['status' => 404, 'message' => 'No data found', 'data' => []], 404);
            }

            $pdfData['fertilizerPesticides'] = $fertilizerPesticides;

            $pdf = PDF::loadView('reports.Pdf.fertilizer-pesticides', $pdfData);
            $fileName = time().'_fertilizer_report.pdf';
            $path = public_path('reports/'.$fileName);
            $pdf->save($path);

            $url = url('reports/'.$fileName);
            $data['url'] = $url;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getDieselManagementReport(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Diesel::orderBy('id', 'desc');

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);
            }

            $diesels = $query->get();
            $data['diesels'] = $diesels;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function getDieselManagementPdf(Request $request) {

        try {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query = Diesel::orderBy('id', 'desc');

            if ($startDate != null && $endDate != null) {
                $from = date('Y-m-d', strtotime($startDate));
                $to = date('Y-m-d', strtotime($endDate));
                $query->whereBetween('date', [$from, $to]);

                $pdfData['from'] = date('d-m-Y', strtotime($startDate));
                $pdfData['to'] = date('d-m-Y', strtotime($endDate));
            }

            $diesels = $query->get();

            if ($diesels->isEmpty()) {
                return response()->json(['status' => 404, 'message' => 'No data found', 'data' => []], 404);
            }

            $pdfData['diesels'] = $diesels;

            $pdf = PDF::loadView('reports.Pdf.diesel-management', $pdfData);
            $fileName = time().'_diesel_report.pdf';
            $path = public_path('reports/'.$fileName);
            $pdf->save($path);

            $url = url('reports/'.$fileName);
            $data['url'] = $url;

            return response()->json(['status' => 200, 'data' => $data], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}
