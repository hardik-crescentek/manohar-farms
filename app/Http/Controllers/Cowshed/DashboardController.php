<?php

namespace App\Http\Controllers\Cowshed;

use App\Http\Controllers\Controller;
use App\Models\Cow;
use App\Models\CowshedExpense;
use App\Models\CowshedStaff;
use App\Models\Customer;
use App\Models\MilkDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard() {

        $data = [];

        $totalCows = Cow::count();
        $data['totalCows'] = $totalCows;

        $totalExpenses = CowshedExpense::sum('amount');
        $data['totalExpenses'] = $totalExpenses;

        $totalStaff = CowshedStaff::count();
        $data['totalStaff'] = $totalStaff;

        $totalCustomer = Customer::count();
        $data['totalCustomer'] = $totalCustomer;

        if(Auth::user()->hasrole('super-admin')) {
            return view('cowshed.dashboard.super-admin', $data);
        } else {
            return view('cowshed.dashboard.admin', $data);
        }
    }
}
