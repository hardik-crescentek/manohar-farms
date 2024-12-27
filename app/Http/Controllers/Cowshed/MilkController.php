<?php

namespace App\Http\Controllers\Cowshed;

use App\Http\Controllers\Controller;
use App\Models\CowshedSetting;
use App\Models\Customer;
use App\Models\MilkDelivery;
use App\Models\MilkPayment;
use PDF;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Session;

class MilkController extends Controller
{
    public function dailyMilkIndex() {
        return view('cowshed.milk-management.daily-milk');
    }

    public function getDailyMilkTable(Request $request) {

        $date = $request->date;
        $data['date'] = $date;

        $dailyDeliveries =  MilkDelivery::with(['customer'])->where([['date', $date]])->get();
        $data['dailyDeliveries'] = $dailyDeliveries;

        return view('cowshed.milk-management.Ajax.daily-milk-table', $data);
    }

    public function getDeliveryPdf(Request $request) {

        $date = $request->date;

        $query = MilkDelivery::with(['customer'])->where('milk', '>', 0)->orderBy('id', 'desc');

        if ($date != null) {
            $date = date('Y-m-d', strtotime($date));
            $query->where('date', $date);
            $data['date'] = $date;
        }

        $dailyDeliveries = $query->get();
        $data['dailyDeliveries'] = $dailyDeliveries;

        $pdf = PDF::loadView('cowshed.milk-management.pdf.daily-deliveries', $data);

        return $pdf->download('milk-deliveries-'.$date.'.pdf');
    }

    public function updateDailyDelivery(Request $request) {

        $deliveryId = $request->deliveryId;
        $milk = $request->milk;

        $deliveryUpdate = MilkDelivery::where('id', $deliveryId)->update([
            'milk' => $milk
        ]);

        if($deliveryUpdate) {
            return response()->json(['status' => true, 'message' => 'Success', 'data' => []], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Error', 'data' => []], 201);
        }
    }

    public function milkPaymentsIndex() {
        $customers = Customer::pluck('name', 'id')->where('customer_type','customer')->toArray();
        // $customers = Customer::pluck('name', 'id')->toArray();
        $data['customers'] = $customers;

        return view('cowshed.milk-payment.payments', $data);
    }

    public function getMilkPaymentHistory(Request $request) {

        $query = MilkPayment::with('customer')->orderBy('id', 'desc');

        if ($request->date != null) {
            $date = explode('/', $request->date);
            $month = $date[0];
            $year = $date[1];

            $query->whereMonth('date', $month)->whereYear('date', $year);
        }

        $payments = $query->get();
        $data['payments'] = $payments;

        $totalLitrs = $query->sum('milk');
        $data['totalLitrs'] = $totalLitrs;

        $totalAmount = $query->sum('amount');
        $data['totalAmount'] = $totalAmount;

        return view('cowshed.milk-payment.Ajax.payments-table', $data);
    }

    public function getPaymentReport(Request $request) {

        $query = MilkPayment::with('customer')->orderBy('id', 'desc');

        if ($request->date != null) {
            $date = explode('/', $request->date);
            $month = $date[0];
            $year = $date[1];

            $query->whereMonth('date', $month)->whereYear('date', $year);

            $data['month'] = date("F", strtotime("2000-$month-01"));
            $data['year'] = date('Y', strtotime($year));
        }

        $payments = $query->get();
        $data['payments'] = $payments;

        $totalLitrs = $query->sum('milk');
        $data['totalLitrs'] = $totalLitrs;

        $totalAmount = $query->sum('amount');
        $data['totalAmount'] = $totalAmount;

        $pdf = PDF::loadView('cowshed.milk-payment.Pdf.payments', $data);

        return $pdf->download('milk-payments.pdf');
    }

    public function savePaymentImage(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
        ]);

        // Get the payment ID from the request
        $paymentId = $request->id;

        $fileName = '';
        if ($request->hasFile('image')) {
            $fileName = fileUpload('payments', $request->image);
        }

        // Update the payment record with the image filename
        $payment = MilkPayment::findOrFail($paymentId);
        $payment->image = $fileName;
        $payment->save();

        return response()->json(['success' => true]);
    }

    public function updatePaymentStatus(Request $request)
    {
        // Get the payment ID and new status from the request
        $paymentId = $request->id;
        $newStatus = $request->status;

        // Update the payment record with the new status
        $payment = MilkPayment::findOrFail($paymentId);
        $payment->status = $newStatus;
        $payment->save();

        return response()->json(['success' => true]);
    }

    public function saveInHouseDelivery(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'milk' => 'required|numeric',
        ]);
        $milk = request()->get('milk');
        $date = request()->get('date');

        $inHouseCustomer = Customer::where('customer_type','inhouse')->first();

        // Create a new milk delivery entry associated with the created customer
        if($inHouseCustomer){
            $milkDelivery = MilkDelivery::create([
                'customer_id' => $inHouseCustomer->id,
                'date' => $date,
                'milk' => $milk ?? 0
            ]);
        } else {
            return redirect()->route('cowshed.daily-milk.index')->with(['error' => true, 'message' => 'InHouse Customer Not Exist!']);
        }

        return redirect()->route('cowshed.daily-milk.index')->with(['success' => true, 'message' => 'InHouse Entry Added Successfully!']);
        // Optionally, you can return a success response or redirect to a success page
    }

}
