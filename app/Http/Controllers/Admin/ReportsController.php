<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Camera;
use App\Models\Diesel;
use App\Models\DieselEntry;
use App\Models\Expense;
use App\Models\FertilizerEntry;
use App\Models\FertilizerPesticide;
use App\Models\Infrastructure;
use App\Models\JivamrutEntry;
use App\Models\JivamrutFertilizer;
use App\Models\Land;
use App\Models\Plant;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Models\VehicleService;
use App\Models\Water;
use App\Models\WaterEntry;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReportsController extends Controller
{
    public function reportsIndex(Request $request)
    {
        $totalExpense = Expense::sum('amount');
        $data['totalExpense'] = $totalExpense;

        $totalWaterExpense = Water::sum('price');
        $data['totalWaterExpense'] = $totalWaterExpense;

        $totalBillExpense = Bill::sum('amount');
        $data['totalBillExpense'] = $totalBillExpense;

        $totalDieselExpense = DieselEntry::sum('amount');
        $data['totalDieselExpense'] = $totalDieselExpense;

        $totalSalaryStaffExpense = Staff::sum('salary');
        $data['totalSalaryStaffExpense'] = $totalSalaryStaffExpense;

        $totalDayStaffExpense = Staff::sum('rate_per_day');
        $data['totalDayStaffExpense'] = $totalDayStaffExpense;

        $totalPlantExpense = Plant::sum('price');
        $data['totalPlantExpense'] = $totalPlantExpense;

        $totalFPamount = FertilizerPesticide::sum('price');
        $data['totalFPamount'] = $totalFPamount;

        $totalVSamount = VehicleService::sum('price');
        $data['totalVSamount'] = $totalVSamount;

        return view('reports.index', $data);
    }


    // Expenses
    public function expensesIndex(Request $request)
    {

        $totalExpense = Expense::sum('amount');
        $data['totalExpense'] = $totalExpense;

        $currentMonthExpense = Expense::whereMonth('date', date('m'))->sum('amount');
        $data['currentMonthExpense'] = $currentMonthExpense;

        $prevMonth = date('m') - 1;
        $prevMonthExpense = Expense::whereMonth('date', $prevMonth)->sum('amount');
        $data['prevMonthExpense'] = $prevMonthExpense;

        $currentYearExpense = Expense::whereYear('date', date('Y'))->sum('amount');
        $data['currentYearExpense'] = $currentYearExpense;

        return view('reports.expenses', $data);
    }

    public function getExpenseTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = Expense::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $expenses = $query->get();
        $data['expenses'] = $expenses;

        return View::make('reports.Ajax.expenses', $data);
    }

    public function generateExpensesPdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = Expense::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        $expenses = $query->get();
        $data['expenses'] = $expenses;

        $total = $query->sum('amount');
        $data['total'] = $total;

        $pdf = PDF::loadView('reports.Pdf.expenses', $data);

        return $pdf->download('expenses.pdf');
    }

    //Total System Expenses
    public function TotalexpensesIndex(Request $request)
    {
        // Summing up expenses for all models
        $models = [
            'Plants' => Plant::sum('price'),
            'Water Expenses' => Water::sum('price'),
            'Diesel' => Diesel::sum('total_price'),
            'Diesel Entries' => DieselEntry::sum('amount'),
            'Staff Salaries' => Staff::sum('salary'),
            'Vehicle Services' => VehicleService::sum('price'),
            'Bills' => Bill::where('status', 'paid')->sum('amount'),
            'Infrastructure' => Infrastructure::sum('amount'),
            'Cameras' => Camera::sum('amount'),
            'Fertilizer & Pesticides' => FertilizerPesticide::sum('price'),
            'Expenses' => Expense::sum('amount'),
        ];

        // Calculate total, current month, previous month, and current year expenses
        $totalExpense = array_sum($models); // Total expenses for all models

        // Current month expenses
        $currentMonthExpense = $this->getTotalMonthlyExpense(date('m'));

        // Previous month expenses
        $prevMonth = date('m') - 1;
        $prevMonthExpense = $this->getTotalMonthlyExpense($prevMonth);

        // Current year expenses
        $currentYearExpense = $this->getTotalYearlyExpense(date('Y'));

        // Return data to the view
        return view('reports.totalexpenses', compact('totalExpense', 'currentMonthExpense', 'prevMonthExpense', 'currentYearExpense'));
    }

    private function getTotalMonthlyExpense($month)
    {
        return Plant::whereMonth('created_at', $month)->sum('price') +
            Water::whereMonth('created_at', $month)->sum('price') +
            Diesel::whereMonth('created_at', $month)->sum('total_price') +
            DieselEntry::whereMonth('created_at', $month)->sum('amount') +
            Staff::whereMonth('created_at', $month)->sum('salary') +
            VehicleService::whereMonth('created_at', $month)->sum('price') +
            Bill::where('status', 'paid')->whereMonth('created_at', $month)->sum('amount') +
            Infrastructure::whereMonth('created_at', $month)->sum('amount') +
            Camera::whereMonth('created_at', $month)->sum('amount') +
            FertilizerPesticide::whereMonth('created_at', $month)->sum('price') +
            Expense::whereMonth('date', $month)->sum('amount');
    }

    private function getTotalYearlyExpense($year)
    {
        return Plant::whereYear('created_at', $year)->sum('price') +
            Water::whereYear('created_at', $year)->sum('price') +
            Diesel::whereYear('created_at', $year)->sum('total_price') +
            DieselEntry::whereYear('created_at', $year)->sum('amount') +
            Staff::whereYear('created_at', $year)->sum('salary') +
            VehicleService::whereYear('created_at', $year)->sum('price') +
            Bill::where('status', 'paid')->whereYear('created_at', $year)->sum('amount') +
            Infrastructure::whereYear('created_at', $year)->sum('amount') +
            Camera::whereYear('created_at', $year)->sum('amount') +
            FertilizerPesticide::whereYear('created_at', $year)->sum('price') +
            Expense::whereYear('date', $year)->sum('amount');
    }

    public function getTotalExpenseTable(Request $request)
    {
        // Initialize data array
        $data = [];

        // Handle date range filter
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        // Initialize default query for each model
        $models = [
            'Plants' => Plant::query(),
            'Water Expenses' => Water::query(),
            'Diesel' => Diesel::query(),
            'Diesel Entries' => DieselEntry::query(),
            'Staff Salaries' => Staff::query(),
            'Vehicle Services' => VehicleService::query(),
            'Bills' => Bill::where('status', 'paid'),
            'Infrastructure' => Infrastructure::query(),
            'Cameras' => Camera::query(),
            'Fertilizer & Pesticides' => FertilizerPesticide::query(),
            'Expenses' => Expense::query(),
        ];

        // Apply date filter if provided
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();

            foreach ($models as $key => $query) {
                // Adjust field for date filtering
                $field = ($key === 'Expenses' || $key === 'Diesel') ? 'date' : 'created_at';
                $models[$key] = $query->whereBetween($field, [$startDate, $endDate]);
            }
        }

        // Calculate totals
        $totals = [];
        foreach ($models as $key => $query) {
            // Adjust sum field for each model
            $sumField = match ($key) {
                'Plants', 'Water Expenses', 'Fertilizer & Pesticides' => 'price',
                'Diesel' => 'total_price',
                'Diesel Entries' => 'amount',
                'Staff Salaries' => 'salary',
                'Vehicle Services' => 'price',
                'Infrastructure', 'Cameras' => 'amount',
                'Bills' => 'amount',
                'Expenses' => 'amount',
            };

            $totals[$key] = $query->sum($sumField);
        }

        // Prepare data for rendering
        $data['headers'] = array_keys($totals);
        $data['expenses'] = array_values($totals);

        return view('reports.Ajax.totalexpenses', $data);
    }

    public function generateTotalExpensesPdf(Request $request)
    {
        // Initialize date range variables
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;

        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        // Prepare the query and totals for each category
        $models = [
            'Plants' => Plant::query(),
            'Water Expenses' => Water::query(),
            'Diesel' => Diesel::query(),
            'Diesel Entries' => DieselEntry::query(),
            'Staff Salaries' => Staff::query(),
            'Vehicle Services' => VehicleService::query(),
            'Bills' => Bill::where('status', 'paid'),
            'Infrastructure' => Infrastructure::query(),
            'Cameras' => Camera::query(),
            'Fertilizer & Pesticides' => FertilizerPesticide::query(),
            'Expenses' => Expense::query(),
        ];

        // Apply date filter if provided
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();

            foreach ($models as $key => $query) {
                $field = ($key === 'Expenses' || $key === 'Diesel') ? 'date' : 'created_at';
                $models[$key] = $query->whereBetween($field, [$startDate, $endDate]);
            }
        }

        // Calculate totals
        $totals = [];
        foreach ($models as $key => $query) {
            $sumField = match ($key) {
                'Plants', 'Water Expenses', 'Fertilizer & Pesticides' => 'price',
                'Diesel' => 'total_price',
                'Diesel Entries' => 'amount',
                'Staff Salaries' => 'salary',
                'Vehicle Services' => 'price',
                'Infrastructure', 'Cameras' => 'amount',
                'Bills' => 'amount',
                'Expenses' => 'amount',
            };

            $totals[$key] = $query->sum($sumField);
        }

        // Calculate the overall total expenses
        $total = array_sum($totals);

        // Prepare the data for the PDF view
        $data = [
            'totals' => $totals,
            'from' => isset($startDate) ? $startDate->format('d-m-Y') : null,
            'to' => isset($endDate) ? $endDate->format('d-m-Y') : null,
            'total' => $total,
        ];

        // Generate and download the PDF
        $pdf = PDF::loadView('reports.Pdf.totalexpenses', $data);
        return $pdf->download('total_expenses_report.pdf');
    }


    // water management
    public function waterIndex(Request $request)
    {
        $totalWater = Water::sum('price');
        $data['totalWater'] = $totalWater;

        $currentMonthWater = Water::whereMonth('date', date('m'))->sum('price');
        $data['currentMonthWater'] = $currentMonthWater;

        $prevMonth = date('m') - 1;
        $prevMonthWater = Water::whereMonth('date', $prevMonth)->sum('price');
        $data['prevMonthWater'] = $prevMonthWater;

        $currentYearWater = Water::whereYear('date', date('Y'))->sum('price');
        $data['currentYearWater'] = $currentYearWater;

        $lands = Land::pluck('name', 'id')->toArray();
        $data['lands'] = $lands;

        return view('reports.water', $data);
    }

    public function getWaterTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = Water::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        if ($request->land_id != null && $request->land_id != '') {
            $query->where('land_id', $request->land_id);
        }

        $water = $query->get();
        $data['water'] = $water;

        return View::make('reports.Ajax.water', $data);
    }

    public function generateWaterPdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = Water::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        if ($request->land_id != null) {
            $query->where('land_id', $request->land_id);

            $landDetail = Land::where('id', $request->land_id)->first();
            $data['landDetail'] = $landDetail;
        }

        $water = $query->get();
        $data['water'] = $water;

        $total = $query->sum('price');
        $data['total'] = $total;

        $pdf = PDF::loadView('reports.Pdf.water', $data);

        return $pdf->download('water_report.pdf');
    }


    //diesel Entries
    public function dieselIndex(Request $request)
    {

        $totalDiesel = DieselEntry::sum('amount');
        $data['totalDiesel'] = $totalDiesel;

        $currentMonthDiesel = DieselEntry::whereMonth('date', date('m'))->sum('amount');
        $data['currentMonthDiesel'] = $currentMonthDiesel;

        $prevMonth = date('m') - 1;
        $prevMonthDiesel = DieselEntry::whereMonth('date', $prevMonth)->sum('amount');
        $data['prevMonthDiesel'] = $prevMonthDiesel;

        $currentYearDiesel = DieselEntry::whereYear('date', date('Y'))->sum('amount');
        $data['currentYearDiesel'] = $currentYearDiesel;

        $vehicles = Vehicle::pluck('name', 'id')->toArray();
        $data['vehicles'] = $vehicles;

        return view('reports.diesel', $data);
    }

    public function getDieselTable(Request $request)
    {

        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = DieselEntry::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        if ($request->vehicle_id != null && $request->vehicle_id != '') {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        $diesel = $query->get();
        $data['diesel'] = $diesel;

        return View::make('reports.Ajax.diesel', $data);
    }

    public function generateDieselPdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = DieselEntry::orderBy('id', 'desc');

        if ($request->vehicle_id != null) {
            $query->where('vehicle_id', $request->vehicle_id);

            $vehicle = Vehicle::where('id', $request->vehicle_id)->first();
            $data['vehicle'] = $vehicle;
        }

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        $diesel = $query->get();
        $data['diesel'] = $diesel;

        $total = $query->sum('amount');
        $data['total'] = $total;

        $pdf = PDF::loadView('reports.Pdf.diesel', $data);

        return $pdf->download('diesel_report.pdf');
    }


    // bill management
    public function billIndex(Request $request)
    {
        $totalBills = Bill::sum('amount');
        $data['totalBills'] = $totalBills;

        $currentMonthBill = Bill::where('period_start', date('m'))->sum('amount');
        $data['currentMonthBill'] = $currentMonthBill;

        $prevMonth = date('m') - 1;
        $prevMonthBill = Bill::whereMonth('period_start', $prevMonth)->sum('amount');
        $data['prevMonthBill'] = $prevMonthBill;

        $currentYearBill = Bill::whereYear('period_start', date('Y'))->sum('amount');
        $data['currentYearBill'] = $currentYearBill;

        $lands = Land::pluck('name', 'id')->toArray();
        $data['lands'] = $lands;

        return view('reports.bill', $data);
    }

    public function getBillTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = Bill::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('period_start', [$from, $to]);
        }

        if ($request->land_id != null && $request->land_id != '') {
            $query->where('land_id', $request->land_id);
        }

        $bills = $query->get();
        $data['bills'] = $bills;

        return View::make('reports.Ajax.bill', $data);
    }

    public function generateBillPdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = Bill::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));
            $query->whereBetween('period_start', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        if ($request->land_id != null && $request->land_id != '') {
            $query->where('land_id', $request->land_id);
            $landDetail = Land::where('id', $request->land_id)->first();
            $data['landDetail'] = $landDetail;
        }

        $bills = $query->get();
        $data['bills'] = $bills;

        $total = $query->sum('amount');
        $data['total'] = $total;

        $pdf = PDF::loadView('reports.Pdf.bill', $data);

        // return View::make('reports.Pdf.bill', $data);
        // return $pdf->stream();

        return $pdf->download('bill_report.pdf');
    }


    // Plants report
    public function plantIndex(Request $request)
    {
        $totalPlants = Plant::sum('price');
        $data['totalPlants'] = $totalPlants;

        $currentMonthPlants = Plant::whereMonth('date', date('m'))->sum('price');
        $data['currentMonthPlants'] = $currentMonthPlants;

        $prevMonth = date('m') - 1;
        $prevMonthPlants = Plant::whereMonth('date', $prevMonth)->sum('price');
        $data['prevMonthPlants'] = $prevMonthPlants;

        $currentYearPlants = Plant::whereYear('date', date('Y'))->sum('price');
        $data['currentYearPlants'] = $currentYearPlants;

        return view('reports.plant', $data);
    }

    public function getPlantTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = Plant::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $plants = $query->get();
        $data['plants'] = $plants;

        return View::make('reports.Ajax.plant', $data);
    }

    public function generatePlantPdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = Plant::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        $plants = $query->get();
        $data['plants'] = $plants;

        $total = $query->sum('price');
        $data['total'] = $total;

        $pdf = PDF::loadView('reports.Pdf.plant', $data);

        // return View::make('reports.Pdf.plant', $data);
        // return $pdf->stream();
        return $pdf->download('plant_report.pdf');
    }


    // fertilizer pestisides report
    public function fertilizerPesticidesIndex(Request $request)
    {
        $totalFP = FertilizerPesticide::sum('price');
        $data['totalFP'] = $totalFP;

        $currentMonthFP = FertilizerPesticide::whereMonth('date', date('m'))->sum('price');
        $data['currentMonthFP'] = $currentMonthFP;

        $prevMonth = date('m') - 1;
        $prevMonthFP = FertilizerPesticide::whereMonth('date', $prevMonth)->sum('price');
        $data['prevMonthFP'] = $prevMonthFP;

        $currentYearFP = FertilizerPesticide::whereYear('date', date('Y'))->sum('price');
        $data['currentYearFP'] = $currentYearFP;

        return view('reports.fertilizer-pesticides', $data);
    }

    public function getFertilizerPesticidesTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = FertilizerPesticide::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $fertilizerPesticides = $query->get();
        $data['fertilizerPesticides'] = $fertilizerPesticides;

        return View::make('reports.Ajax.fertilizer-pesticides', $data);
    }

    public function generateFertilizerPesticidesPdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = FertilizerPesticide::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        $fertilizerPesticides = $query->get();
        $data['fertilizerPesticides'] = $fertilizerPesticides;

        $total = $query->sum('price');
        $data['total'] = $total;

        $pdf = PDF::loadView('reports.Pdf.fertilizer-pesticides', $data);

        return $pdf->download('fertilizer_pesticides_report.pdf');
    }


    // Staff report
    public function staffsIndex(Request $request)
    {
        $totalDemandStaffExpense = Staff::sum('rate_per_day');
        $data['totalDemandStaffExpense'] = $totalDemandStaffExpense;

        $totalSalariedStaffExpense = Staff::sum('salary');
        $data['totalSalariedStaffExpense'] = $totalSalariedStaffExpense;

        $totalSalariedStaff = Staff::where('type', 1)->count();
        $data['totalSalariedStaff'] = $totalSalariedStaff;

        $totalDemandStaff = Staff::where('type', 2)->count();
        $data['totalDemandStaff'] = $totalDemandStaff;

        return view('reports.staffs', $data);
    }

    public function getStaffsTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = Staff::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('joining_date', [$from, $to]);
        }

        if (isset($request->type) && $request->type != '') {
            $query->where('type', $request->type);
        }

        $staffs = $query->get();
        $data['staffs'] = $staffs;

        return View::make('reports.Ajax.staffs', $data);
    }

    public function generateStaffsPdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        $total = 0;

        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = Staff::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('joining_date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        if (isset($request->type) && $request->type != '') {
            $query->where('type', $request->type);

            if ($request->type == 1) {
                $data['type'] = 'Salaried';
                $total = $query->sum('salary');
            }
            if ($request->type == 2) {
                $data['type'] = 'On-demand';
                $total = $query->sum('rate_per_day');
            }
        } else {
            $salaryTotal = $query->sum('salary');
            $demandTotal = $query->sum('rate_per_day');

            $total = $salaryTotal + $demandTotal;
        }

        $staffs = $query->get();
        $data['staffs'] = $staffs;

        $data['total'] = $total;

        $pdf = PDF::loadView('reports.Pdf.staffs', $data);

        return $pdf->download('staffs_report.pdf');
    }

    // Vehicle services report
    public function vehicleServiceIndex(Request $request)
    {
        $totalServiceExpense = VehicleService::sum('price');
        $data['totalServiceExpense'] = $totalServiceExpense;

        $currentMonthServiceExpense = VehicleService::whereMonth('date', date('m'))->sum('price');
        $data['currentMonthServiceExpense'] = $currentMonthServiceExpense;

        $prevMonth = date('m') - 1;
        $prevMonthServiceExpense = VehicleService::whereMonth('date', $prevMonth)->sum('price');
        $data['prevMonthServiceExpense'] = $prevMonthServiceExpense;

        $currentYearServiceExpense = VehicleService::whereYear('date', date('Y'))->sum('price');
        $data['currentYearServiceExpense'] = $currentYearServiceExpense;

        return view('reports.vehicles-services', $data);
    }

    public function getVehicleServiceTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = VehicleService::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $vehicleServices = $query->get();
        $data['vehicleServices'] = $vehicleServices;

        return View::make('reports.Ajax.vehicles-services', $data);
    }

    public function generateVehicleServicePdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = VehicleService::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        $vehicleServices = $query->get();
        $data['vehicleServices'] = $vehicleServices;

        $total = $query->sum('price');
        $data['total'] = $total;

        $pdf = PDF::loadView('reports.Pdf.vehicles-services', $data);

        return $pdf->download('vehicle_services_report.pdf');
    }

    //diesel Management
    public function dieselManagementIndex(Request $request)
    {
        $totalDiesel = Diesel::sum('total_price');
        $data['totalDiesel'] = $totalDiesel;

        $currentMonthDiesel = Diesel::whereMonth('date', date('m'))->sum('total_price');
        $data['currentMonthDiesel'] = $currentMonthDiesel;

        $prevMonth = date('m') - 1;
        $prevMonthDiesel = Diesel::whereMonth('date', $prevMonth)->sum('total_price');
        $data['prevMonthDiesel'] = $prevMonthDiesel;

        $currentYearDiesel = Diesel::whereYear('date', date('Y'))->sum('total_price');
        $data['currentYearDiesel'] = $currentYearDiesel;

        return view('reports.diesel-management', $data);
    }

    public function getDieselManagementTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = Diesel::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $diesels = $query->get();
        $data['diesels'] = $diesels;

        return View::make('reports.Ajax.diesel-management', $data);
    }

    public function generateDieselManagementPdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = Diesel::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = $from;
            $data['to'] = $to;
        }

        $diesels = $query->get();
        $data['diesels'] = $diesels;

        $total = $query->sum('total_price');
        $data['total'] = $total;

        $pdf = PDF::loadView('reports.Pdf.diesel-management', $data);

        return $pdf->download('diesel_report.pdf');
    }


    // infrastructure report
    public function infrastructureIndex(Request $request)
    {
        $totalInfrastructure = Infrastructure::sum('amount');
        $data['totalInfrastructure'] = $totalInfrastructure;

        $currentMonthInfrastructure = Infrastructure::whereMonth('date', date('m'))->sum('amount');
        $data['currentMonthInfrastructure'] = $currentMonthInfrastructure;

        $prevMonth = date('m') - 1;
        $prevMonthInfrastructure = Infrastructure::whereMonth('date', $prevMonth)->sum('amount');
        $data['prevMonthInfrastructure'] = $prevMonthInfrastructure;

        $currentYearInfrastructure = Infrastructure::whereYear('date', date('Y'))->sum('amount');
        $data['currentYearInfrastructure'] = $currentYearInfrastructure;

        return view('reports.infrastructure', $data);
    }

    public function getInfrastructureTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = Infrastructure::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $infrastructures = $query->get();
        $data['infrastructures'] = $infrastructures;

        return View::make('reports.Ajax.infrastructure', $data);
    }

    public function generateInfrastructurePdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = Infrastructure::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        $infrastructures = $query->get();
        $data['infrastructures'] = $infrastructures;

        $total = $query->sum('amount');
        $data['total'] = $total;

        $pdf = PDF::loadView('reports.Pdf.infrastructure', $data);

        // return View::make('reports.Pdf.plant', $data);
        // return $pdf->stream();
        return $pdf->download('infrastructure_report.pdf');
    }

    // plot Report
    public function plotIndex(Request $request)
    {
        $totalLandCount = Land::count();
        $data['totalLandCount'] = $totalLandCount;

        $totalWaterVolume = WaterEntry::sum('volume');
        $data['totalWaterVolume'] = $totalWaterVolume;

        $totalJivamrutliter = JivamrutEntry::sum('size');
        $data['totalJivamrutliter'] = $totalJivamrutliter;

        $totalFertilizerQty = FertilizerEntry::sum('qty');
        $data['totalFertilizerQty'] = $totalFertilizerQty;

        $lands = Land::pluck('name', 'id')->toArray();
        $data['lands'] = $lands;

        return view('reports.plot', $data);
    }

    public function getPlotTable(Request $request)
    {
        $category = $request->category;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $landId = $request->land_id;

        // Initialize query variables as collections
        $entries = collect();
        $lands = collect();

        // Fetch lands (this will be used for all categories)
        $lands = Land::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })
            ->when($landId, function ($query) use ($landId) {
                $query->where('id', $landId);
            })
            ->get(); // Ensures lands is a collection

        // Apply filters for entries based on the category
        if ($category == 'water') {
            $entries = WaterEntry::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })
                ->when($landId, function ($query) use ($landId) {
                    $query->where('land_id', $landId);
                })
                ->get(); // Ensures entries is a collection
        } elseif ($category == 'fertilizer') {
            $entries = FertilizerEntry::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })
                ->when($landId, function ($query) use ($landId) {
                    $query->where('land_id', $landId);
                })
                ->get(); // Ensures entries is a collection
        } elseif ($category == 'jivamrut') {
            $entries = JivamrutEntry::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })
                ->when($landId, function ($query) use ($landId) {
                    $query->where('land_id', $landId);
                })
                ->get(); // Ensures entries is a collection
        }

        // Prepare data for the view
        $data = [
            'category' => $category,
            'entries' => $entries,
            'lands' => $lands,
        ];

        return View::make('reports.Ajax.plot', $data);
    }

    public function generatePlotPdf(Request $request)
    {
        // Extract filters
        $category = $request->category;
        $landId = $request->land_id;
        $reportrange = $request->reportrange;

        // Initialize date range
        $startDate = null;
        $endDate = null;
        if ($reportrange) {
            [$startDate, $endDate] = explode(' - ', $reportrange);
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
        }

        // Initialize query and fetch data based on category
        $entries = collect();
        if ($category === 'water') {
            $entries = WaterEntry::with('land')
                ->when($startDate && $endDate, fn($query) => $query->whereBetween('date', [$startDate, $endDate]))
                ->when($landId, fn($query) => $query->where('land_id', $landId))
                ->get();
        } elseif ($category === 'fertilizer') {
            $entries = FertilizerEntry::with('land')
                ->when($startDate && $endDate, fn($query) => $query->whereBetween('date', [$startDate, $endDate]))
                ->when($landId, fn($query) => $query->where('land_id', $landId))
                ->get();
        } elseif ($category === 'jivamrut') {
            $entries = JivamrutEntry::with('land')
                ->when($startDate && $endDate, fn($query) => $query->whereBetween('date', [$startDate, $endDate]))
                ->when($landId, fn($query) => $query->where('land_id', $landId))
                ->get();
        }

        // Fetch land details if landId is provided
        $landDetail = $landId ? Land::find($landId) : null;

        // Total calculation based on category
        $total = 0;
        if ($category === 'water') {
            $total = $entries->sum('volume'); // Adjust as per requirement
        } elseif ($category === 'fertilizer') {
            $total = $entries->sum('quantity'); // Adjust as per requirement
        } else {
            $total = $entries->sum('size');
        }

        // Prepare data for the view
        $data = [
            'category' => $category,
            'entries' => $entries,
            'landDetail' => $landDetail,
            'from' => $startDate ? date('d-m-Y', strtotime($startDate)) : null,
            'to' => $endDate ? date('d-m-Y', strtotime($endDate)) : null,
            'total' => $total,
        ];

        // Generate a dynamic filename
        $filename = 'Plot_Report_' . ucfirst($category);
        if ($landDetail) {
            $filename .= '_Land_' . str_replace(' ', '_', $landDetail->name);
        }
        if ($startDate && $endDate) {
            $filename .= '_' . $startDate . '_to_' . $endDate;
        }
        $filename .= '.pdf';

        // Generate PDF and return download
        $pdf = PDF::loadView('reports.Pdf.plot', $data);
        return $pdf->download($filename);
    }
}
