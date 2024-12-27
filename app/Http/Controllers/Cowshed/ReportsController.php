<?php

namespace App\Http\Controllers\Cowshed;

use App\Http\Controllers\Controller;
use App\Models\CowshedExpense;
use App\Models\CowshedSetting;
use App\Models\CowshedStaff;
use App\Models\MilkDelivery;
use App\Models\Customer;
use App\Models\GheeManagement;
use App\Models\GheeSelling;
use App\Models\GrassManagement;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\View;

class ReportsController extends Controller
{
    public function milkReport(Request $request) {

        $totalMilk = MilkDelivery::sum('milk');

        $currentMonthMilk = MilkDelivery::whereMonth('date', date('m'))->sum('milk');

        $currentMonthInHouseMilk =  MilkDelivery::whereMonth('date', date('m'))->whereHas('customer', function ($query) {
                                        $query->where('customer_type', 'inhouse');
                                    })->sum('milk');

        $currentYearInHouseMilk =  MilkDelivery::whereYear('date', date('Y'))->whereHas('customer', function ($query) {
                                        $query->where('customer_type', 'inhouse');
                                    })->sum('milk');

        $prevMonth = date('m') - 1;
        $prevMonthMilk = MilkDelivery::whereMonth('date', $prevMonth)->sum('milk');

        $currentYearMilk = MilkDelivery::whereYear('date', date('Y'))->sum('milk');

        $milkPrice = CowshedSetting::where('id', 1)->value('milk_price');

        $inhouseCustomers = Customer::where('customer_type', 'inhouse')->pluck('name', 'id')->toArray();
        $customers = Customer::pluck('name', 'id')->toArray();

        $data['customers'] = $inhouseCustomers + $customers;

        $totalEarning = $totalMilk * $milkPrice;
        $currentMonthEarning = $currentMonthMilk * $milkPrice;
        $prevMonthEarning = $prevMonthMilk * $milkPrice;
        $currentYearEarning = $currentYearMilk * $milkPrice;

        $data['totalMilk'] = $totalMilk;
        $data['currentMonthMilk'] = $currentMonthMilk;
        $data['currentMonthInHouseMilk'] = $currentMonthInHouseMilk;
        $data['currentYearInHouseMilk'] = $currentYearInHouseMilk;
        $data['prevMonthMilk'] = $prevMonthMilk;
        $data['currentYearMilk'] = $currentYearMilk;

        $data['totalEarning'] = number_format($totalEarning, 2);
        $data['currentMonthEarning'] = number_format($currentMonthEarning, 2);
        $data['prevMonthEarning'] = number_format($prevMonthEarning, 2);
        $data['currentYearEarning'] = number_format($currentYearEarning, 2);

        return view('cowshed.reports.milk', $data);
    }

    public function milkHistoryTable(Request $request) {

        $startDate = $request->startdate;
        $endDate = $request->enddate;

        $dates = [];
        $currentDate = strtotime($startDate);

        while ($currentDate <= strtotime($endDate)) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        $query = MilkDelivery::whereIn('date', $dates);

        if($request->customerId != '') {
            $query->where('customer_id', $request->customerId);
        }

        $deliveries = $query->get();
        $data['deliveries'] = $deliveries;

        return view('cowshed.reports.Ajax.delivery-history-table', $data);
    }

    public function getDeliveryReport(Request $request) {

        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = MilkDelivery::with('customer')->orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        if($request->customer_id != '') {
            $query->where('customer_id', $request->customer_id);
        }

        $deliveries = $query->get();
        $data['deliveries'] = $deliveries;

        $milkPrice = CowshedSetting::where('id', 1)->value('milk_price');
        $data['milkPrice'] = $milkPrice;

        $totalLitrs = $query->sum('milk');
        $data['totalLitrs'] = $totalLitrs;

        $totalAmount = $totalLitrs * $milkPrice;
        $data['totalAmount'] = $totalAmount;

        $pdf = PDF::loadView('cowshed.reports.pdf.milk-deliveries', $data);

        return $pdf->download('milk-deliveries-report.pdf');

        // return View::make('reports.Pdf.plant', $data);
        // return $pdf->stream();
    }

    public function staffReport(Request $request) {

        $totalDemandStaffExpense = CowshedStaff::sum('rate_per_day');
        $data['totalDemandStaffExpense'] = $totalDemandStaffExpense;

        $totalSalariedStaffExpense = CowshedStaff::sum('salary');
        $data['totalSalariedStaffExpense'] = $totalSalariedStaffExpense;

        $totalSalariedStaff = CowshedStaff::where('type', 1)->count();
        $data['totalSalariedStaff'] = $totalSalariedStaff;

        $totalDemandStaff = CowshedStaff::where('type', 2)->count();
        $data['totalDemandStaff'] = $totalDemandStaff;

        return view('cowshed.reports.staffs', $data);
    }

    public function getStaffsTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = CowshedStaff::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('joining_date', [$from, $to]);
        }

        if(isset($request->type) && $request->type != '') {
            $query->where('type', $request->type);
        }

        $staffs = $query->get();
        $data['staffs'] = $staffs;

        return View::make('cowshed.reports.Ajax.staffs', $data);
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

        $query = CowshedStaff::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('joining_date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        if(isset($request->type) && $request->type != '') {
            $query->where('type', $request->type);

            if($request->type == 1) {
                $data['type'] = 'Salaried';
                $total = $query->sum('salary');
            } 
            if($request->type == 2) {
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

        $pdf = PDF::loadView('cowshed.reports.pdf.staffs', $data);

        return $pdf->download('staffs_report.pdf');
    }

    public function expensesIndex(Request $request)
    {
        $totalExpense = CowshedExpense::sum('amount');
        $data['totalExpense'] = $totalExpense;

        $currentMonthExpense = CowshedExpense::whereMonth('date', date('m'))->sum('amount');
        $data['currentMonthExpense'] = $currentMonthExpense;

        $prevMonth = date('m') - 1;
        $prevMonthExpense = CowshedExpense::whereMonth('date', $prevMonth)->sum('amount');
        $data['prevMonthExpense'] = $prevMonthExpense;

        $currentYearExpense = CowshedExpense::whereYear('date', date('Y'))->sum('amount');
        $data['currentYearExpense'] = $currentYearExpense;

        return view('cowshed.reports.expenses', $data);
    }

    public function getExpenseTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = CowshedExpense::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $expenses = $query->get();
        $data['expenses'] = $expenses;

        return View::make('cowshed.reports.Ajax.expenses', $data);
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

        $query = CowshedExpense::orderBy('id', 'desc');

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

        $pdf = PDF::loadView('cowshed.reports.pdf.expenses', $data);

        return $pdf->download('expenses.pdf');
    }

    public function grassReport() {

        $totalGrass = GrassManagement::sum('amount');
        $data['totalGrass'] = $totalGrass;

        $currentMonthGrass = GrassManagement::whereMonth('date', date('m'))->sum('amount');
        $data['currentMonthGrass'] = $currentMonthGrass;

        $prevMonth = date('m') - 1;
        $prevMonthGrass = GrassManagement::whereMonth('date', $prevMonth)->sum('amount');
        $data['prevMonthGrass'] = $prevMonthGrass;

        $currentYearGrass = GrassManagement::whereYear('date', date('Y'))->sum('amount');
        $data['currentYearGrass'] = $currentYearGrass;

        return view('cowshed.reports.grass', $data);
    }

    public function getGrassTable(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = GrassManagement::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $grass = $query->get();
        $data['grass'] = $grass;

        return View::make('cowshed.reports.Ajax.grass', $data);
    }

    public function generateGrassPdf(Request $request)
    {
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = GrassManagement::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        $grass = $query->get();
        $data['grass'] = $grass;

        $total = $query->sum('amount');
        $data['total'] = $total;

        $pdf = PDF::loadView('cowshed.reports.pdf.grass', $data);

        return $pdf->download('grass.pdf');
    }

    public function gheeReport() {

        $totalGhee = GheeManagement::sum('ghee');
        $data['totalGhee'] = $totalGhee;

        $currentMonthGhee = GheeManagement::whereMonth('date', date('m'))->sum('ghee');
        $data['currentMonthGhee'] = $currentMonthGhee;

        $prevMonth = date('m') - 1;
        $prevMonthGhee = GheeManagement::whereMonth('date', $prevMonth)->sum('ghee');
        $data['prevMonthGhee'] = $prevMonthGhee;

        $currentYearGhee = GheeManagement::whereYear('date', date('Y'))->sum('ghee');
        $data['currentYearGhee'] = $currentYearGhee;

        return view('cowshed.reports.ghee', $data);
    }

    public function getGheeTable(Request $request) {
        
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = GheeManagement::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $ghee = $query->get();
        $data['ghee'] = $ghee;

        $totalLitrs = $query->sum('ghee');
        $data['totalLitrs'] = $totalLitrs;

        return View::make('cowshed.reports.Ajax.ghee', $data);
    }

    public function generateGheePdf(Request $request) {
        
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = GheeManagement::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        $ghee = $query->get();
        $data['ghee'] = $ghee;

        $totalLitrs = $query->sum('ghee');
        $data['total'] = $totalLitrs;

        $pdf = PDF::loadView('cowshed.reports.pdf.ghee', $data);

        return $pdf->download('ghee-report.pdf');
    }

    public function gheeSellingReport() {

        $prevMonth = date('m') - 1;

        $totalGhee = GheeSelling::sum('quantity');
        $data['totalGhee'] = $totalGhee;

        $currentMonthGhee = GheeSelling::whereMonth('date', date('m'))->sum('quantity');
        $data['currentMonthGhee'] = $currentMonthGhee;

        $prevMonthGhee = GheeSelling::whereMonth('date', $prevMonth)->sum('quantity');
        $data['prevMonthGhee'] = $prevMonthGhee;

        $currentYearGhee = GheeSelling::whereYear('date', date('Y'))->sum('quantity');
        $data['currentYearGhee'] = $currentYearGhee;


        $totalAmount = GheeSelling::sum('total');
        $data['totalAmount'] = $totalAmount;

        $currentMonthAmount = GheeSelling::whereMonth('date', date('m'))->sum('total');
        $data['currentMonthAmount'] = $currentMonthAmount;

        $prevMonthAmount = GheeSelling::whereMonth('date', $prevMonth)->sum('total');
        $data['prevMonthAmount'] = $prevMonthAmount;

        $currentYearAmount = GheeSelling::whereYear('date', date('Y'))->sum('total');
        $data['currentYearAmount'] = $currentYearAmount;

        return view('cowshed.reports.ghee-selling', $data);
    }

    public function getGheeSellingTable(Request $request) {
        
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = GheeSelling::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date($startDate);
            $to = date($endDate);
            $query->whereBetween('date', [$from, $to]);
        }

        $gheeSellings = $query->get();
        $data['gheeSellings'] = $gheeSellings;

        $totalLitrs = $query->sum('quantity');
        $data['totalLitrs'] = $totalLitrs;

        $totalAmount = $query->sum('total');
        $data['totalAmount'] = $totalAmount;

        return View::make('cowshed.reports.Ajax.ghee-selling', $data);
    }

    public function generateGheeSellingPdf(Request $request) {
        
        $reportrange = $request->reportrange;
        $startDate = null;
        $endDate = null;
        if ($reportrange != '') {
            $reportrangeAr = explode(' - ', $reportrange);
            $startDate = $reportrangeAr[0];
            $endDate = $reportrangeAr[1];
        }

        $query = GheeSelling::orderBy('id', 'desc');

        if ($startDate != null && $endDate != null) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));

            $query->whereBetween('date', [$from, $to]);

            $data['from'] = date('d-m-Y', strtotime($startDate));
            $data['to'] = date('d-m-Y', strtotime($endDate));
        }

        $gheeSellings = $query->get();
        $data['gheeSellings'] = $gheeSellings;

        $totalLitrs = $query->sum('quantity');
        $data['totalLitrs'] = $totalLitrs;

        $totalAmount = $query->sum('total');
        $data['totalAmount'] = $totalAmount;

        $pdf = PDF::loadView('cowshed.reports.pdf.ghee-selling', $data);

        return $pdf->download('ghee-selling-report.pdf');
    }
}
