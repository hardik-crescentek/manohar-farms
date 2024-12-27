<?php

namespace App\Console;

use App\Jobs\SendAgendaCompleteNotificationJob;
use App\Jobs\SendDieselNotification;
use App\Jobs\SendFertilizerNotificationJob;
use App\Jobs\SendFlushingNotificationJob;
use App\Jobs\SendJivamrutNotificationJob;
use App\Jobs\SendPlotsFilterNotificationJob;
use App\Jobs\SendVermiNotificationJob;
use App\Jobs\SendWaterNotificationJob;
use App\Jobs\SendVehicleNotificationJob;
use App\Jobs\SendCameraRechargeNotificationJob;
use App\Jobs\SendBoreWellsFilterCleaningNotificationJob;
use App\Models\Camera;
use App\Models\FilterHistory;
use App\Models\CowshedSetting;
use App\Models\Customer;
use App\Models\DailyAttendance;
use App\Models\Diesel;
use App\Models\DieselEntry;
use App\Models\JivamrutBarrel;
use App\Models\JivamrutFertilizer;
use App\Models\MilkDelivery;
use App\Models\MilkPayment;
use App\Models\NotificationSetting;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Models\StaffMember;
use App\Models\VermiCompost;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {

        // $schedule->command('inspire')->hourly();

        $this->waterNotification($schedule);
        $this->vehicleNotification($schedule);
        $this->fertilizerNotification($schedule);
        $this->flushingNotification($schedule);
        $this->vermiNotification($schedule);
        $this->plotsFilterCleaningNotification($schedule);
        $this->agendaCompletionNotification($schedule);
        $this->cameraRechargeNotification($schedule);
        $this->boreWellsFilterCleaningNotification($schedule);

        $jivamrutDays = NotificationSetting::where('id', 1)->value('Jivamrut');
        $jivamrutCronExpression = "0 0 */{$jivamrutDays} * *";
        // $jivamrutMinutes = $jivamrutDays * 24 * 60;
        // $jivamrutCronExpression = "*/{$jivamrutMinutes} * * * *";
        $schedule->call(function () { $this->JivamrutNotification();})->cron($jivamrutCronExpression);

        // $schedule->call(function () { $this->saveDailyAttendance();})->dailyAt('0:00');
        $schedule->call(function () { $this->saveDailyAttendance();});
        $schedule->call(function () { $this->saveDailyMilkDelivery();})->dailyAt('0:00');
        $schedule->call(function () { $this->saveMilkPayments();})->monthlyOn(date('t'), '23:55');
        $schedule->call(function () { $this->changeVermiStatus();});
        $schedule->call(function () { $this->dieselNotification();});
    }

    protected function dieselNotification() {

        $litrDieselPurchased = Diesel::sum('volume');
        $litrDieselUsed = DieselEntry::sum('volume');

        $remainingDiesel = $litrDieselPurchased - $litrDieselUsed;

        $settingLitrs = NotificationSetting::where('id', 1)->value('diesel');

        if($remainingDiesel <= $settingLitrs) {

            SendDieselNotification::dispatch($settingLitrs);
        }
    }

    protected function waterNotification(Schedule $schedule) {

        $days = NotificationSetting::where('id', 1)->value('water');

        $cronExpression = "0 0 */{$days} * *";

        // $minutes = $days * 24 * 60;
        // $cronExpression = "*/{$minutes} * * * *";

        $schedule->call(function () {
            SendWaterNotificationJob::dispatch();
        })->cron($cronExpression);
    }

    protected function vehicleNotification(Schedule $schedule) {

        // day wised vehcile list get
        $dayServiceVehicles = Vehicle::where('service_cycle_type', 1)->get();

        if($dayServiceVehicles){
            foreach($dayServiceVehicles as $dv_key => $dv_val){
                $days = $dv_val->vehicle_notification;
                $vehName = $dv_val->name;
                $vehNumber = $dv_val->number;
                if($days){
                    \Log::info('call');
                    \Log::info($vehName);
                    \Log::info($vehNumber);

                    $cronExpression = "0 0 */{$days} * *";
                    // $minutes = 1;
                    // $cronExpression = "*/{$minutes} * * * *";

                    $schedule->call(function ()  use ($vehName,$vehNumber) {
                        SendVehicleNotificationJob::dispatch($vehName,$vehNumber);
                    })->cron($cronExpression);
                }
            }
        }

        // hours wised vehcile list get
        $hourServiceVehicles = Vehicle::where('service_cycle_type', 2)->get();

        if($hourServiceVehicles){
            foreach($hourServiceVehicles as $hv_key => $hv_val){
                $hours = $hv_val->vehicle_notification;
                $vehName = $hv_val->name;
                $vehNumber = $hv_val->number;
                if($days){
                    $cronExpression = "0 */{$hours} * * *";

                    $schedule->call(function ()  use ($vehName,$vehNumber) {
                        SendVehicleNotificationJob::dispatch($vehName,$vehNumber);
                    })->cron($cronExpression);
                }
            }
        }

    }

    protected function cameraRechargeNotification(Schedule $schedule) {
       
        // camera data list
        $cameraRechargeNotification = Camera::get();

        if($cameraRechargeNotification){
            foreach($cameraRechargeNotification as $camera_key => $camera_val){
                $days = $camera_val->recharge_notification;
                $cameraName = $camera_val->name;
                $cameraSimNumber = $camera_val->sim_number;
                $lastCleaningDate = $camera_val->last_cleaning_date;

                if(isset($days) && $days != '0' && isset($lastCleaningDate)){
                    \Log::info('if call camera');
                    $notificationDate = Carbon::parse($lastCleaningDate)->addDays($days);
        
                    // Check if notification date matches current date
                    \Log::info('$notificationDate  '.$notificationDate);
                    if($notificationDate->isToday()) {
                        \Log::info('Notification triggered for  camera' . $cameraName . ' at ' . now());
        
                        // Dispatch job for sending notification
                        SendCameraRechargeNotificationJob::dispatch($cameraName,$cameraSimNumber);
                    }
                } else if(isset($days) && $days != '0') {
                    \Log::info('else call camera');        
                    $cronExpression = "0 0 */{$days} * *";
        
                    $schedule->call(function ()  use ($cameraName) {
                        SendCameraRechargeNotificationJob::dispatch($cameraName,$cameraSimNumber);
                    })->cron($cronExpression);
                }

            }
        }

    }

    protected function boreWellsFilterCleaningNotification(Schedule $schedule) {

        // Fetch filter data list
        $boreWellsFilterNotification = FilterHistory::get();

        if($boreWellsFilterNotification){
            foreach($boreWellsFilterNotification as $filter_key => $filter_val){
                $days = $filter_val->filter_notification;
                $filterName = $filter_val->name;
                $lastCleaningDate = $filter_val->last_cleaning_date;

                if(isset($days) && $days != '0' && isset($lastCleaningDate)){
                    \Log::info('lastCleaningDate');
                    $notificationDate = Carbon::parse($lastCleaningDate)->addDays($days);

                    // Check if notification date matches current date
                    if($notificationDate->isToday()) {
                        \Log::info('Notification triggered for ' . $filterName . ' at ' . now());

                        // Dispatch job for sending notification
                        SendBoreWellsFilterCleaningNotificationJob::dispatch($filterName);
                    }
                } else {
                    \Log::info('call');

                    $cronExpression = "0 0 */{$days} * *";
                    $schedule->call(function ()  use ($filterName) {
                        SendBoreWellsFilterCleaningNotificationJob::dispatch($filterName);
                    })->cron($cronExpression);
                }
            }
        }

    }

    protected function fertilizerNotification(Schedule $schedule) {

        $days = NotificationSetting::where('id', 1)->value('fertiliser');

        $cronExpression = "0 0 */{$days} * *";

        // $minutes = $days * 24 * 60;
        // $cronExpression = "*/{$minutes} * * * *";

        $schedule->call(function () {
            SendFertilizerNotificationJob::dispatch();
        })->cron($cronExpression);
    }

    protected function flushingNotification(Schedule $schedule) {

        $days = NotificationSetting::where('id', 1)->value('flushing');

        $cronExpression = "0 0 */{$days} * *";

        // $minutes = $days * 24 * 60;
        // $cronExpression = "*/{$minutes} * * * *";

        $schedule->call(function () {
            SendFlushingNotificationJob::dispatch();
        })->cron($cronExpression);
    }

    protected function JivamrutNotification() {

        $fertilizerBarrelsCount = JivamrutFertilizer::get();

        foreach ($fertilizerBarrelsCount as $fertilizer) {
            $barrelCountWithStatusZero = JivamrutBarrel::where([['jivamrut_fertilizer_id', $fertilizer->id], ['status', 0]])->count();

            if ($fertilizer->barrels > $barrelCountWithStatusZero) {

                $title = 'Reminder to add barrels in '.$fertilizer->name;

                SendJivamrutNotificationJob::dispatch($title);
                break;
            }
        }
    }

    protected function vermiNotification(Schedule $schedule) {

        $days = NotificationSetting::where('id', 1)->value('vermi');

        $cronExpression = "0 0 */{$days} * *";

        // $minutes = $days * 24 * 60;
        // $cronExpression = "*/{$minutes} * * * *";

        $schedule->call(function () {
            SendVermiNotificationJob::dispatch();
        })->cron($cronExpression);
    }

    protected function plotsFilterCleaningNotification(Schedule $schedule) {

        $days = NotificationSetting::where('id', 1)->value('plots_filter_cleaning');

        $cronExpression = "0 0 */{$days} * *";

        // $minutes = $days * 24 * 60;
        // $cronExpression = "*/{$minutes} * * * *";

        $schedule->call(function () {
            SendPlotsFilterNotificationJob::dispatch();
        })->cron($cronExpression);
    }

    protected function agendaCompletionNotification(Schedule $schedule) {

        $days = NotificationSetting::where('id', 1)->value('agenda_completion');

        $cronExpression = "0 0 */{$days} * *";

        // $minutes = $days * 24 * 60;
        // $cronExpression = "*/{$minutes} * * * *";

        $schedule->call(function () {
            SendAgendaCompleteNotificationJob::dispatch();
        })->cron($cronExpression);
    }

    protected function saveDailyAttendance() {
        $date = now()->format('Y-m-d');
    
        // Get all active staff members
        $staffMembers = StaffMember::whereDate('join_date', '<=', $date)
                        ->where(function ($query) use ($date) {
                            $query->whereDate('end_date', '>=', $date)->orWhereNull('end_date');
                        })
                        ->get();
    
        // Get all active staff
        $staffs = Staff::whereDate('joining_date', '<=', $date)
                    ->where(function ($query) use ($date) {
                        $query->whereDate('resign_date', '>=', $date)->orWhereNull('resign_date');
                    })
                    ->get();
    
        // Loop through staff members
        foreach ($staffMembers as $member) {
            $this->saveAttendanceForEntity($member->id, $member->staff_id, $date); // Save attendance for StaffMember
        }
    
        // Loop through staff
        foreach ($staffs as $staff) {
            $this->saveAttendanceForEntity(null, $staff->id, $date); // Save attendance for Staff
        }
    }

    protected function saveAttendanceForEntity($staffMemberId, $staffId, $date) {
        Log::info($staffMemberId.' - '.$staffId.' - '.$date);
        // Check if either $staffMemberId or $staffId is provided
        if ($staffMemberId !== null) {
            // Create attendance record for StaffMember
            DailyAttendance::firstOrCreate([
                'staff_member_id' => $staffMemberId,
                'staff_id' => $staffId,
                'attendance_date' => $date,
            ]);
        } elseif ($staffId !== null) {
            // Create attendance record for Staff
            DailyAttendance::firstOrCreate([
                'staff_id' => $staffId,
                'staff_member_id' => null,
                'attendance_date' => $date,
            ]);
        }
    }

    protected function saveDailyMilkDelivery() {
        $date = now()->format('Y-m-d');

        $getCustomers = Customer::get();

        if ($getCustomers->isNotEmpty()) {
            foreach ($getCustomers as $customer) {

                $isExist = MilkDelivery::where([['customer_id', $customer->id], ['date', $date]])->first();

                if(!$isExist) {
                    MilkDelivery::create([
                        'customer_id' => $customer->id,
                        'date' => $date,
                        'milk' => $customer->milk
                    ]);
                }
            }
        }
    }

    protected function saveMilkPayments() {

        $month = date('m');
        $year = date('Y');

        $milkDeliveries = MilkDelivery::whereMonth('date', $month)->whereYear('date', $year)
                            ->select('customer_id', DB::raw('SUM(milk) as total_litrs'))
                            ->groupBy('customer_id')
                            ->get();

        $milkPrice = CowshedSetting::where('id', 1)->value('milk_price');

        if(isset($milkDeliveries) && !empty($milkDeliveries)) {
            foreach($milkDeliveries as $key => $milk) {

                $paymentExist = MilkPayment::where('customer_id', $milk->customer_id)->whereMonth('date', $month)->whereYear('date', $year)->first();

                if(empty($paymentExist)) {
                    $createPayment = MilkPayment::create([
                        'customer_id' => $milk->customer_id,
                        'milk' => $milk->total_litrs,
                        'amount' => $milk->total_litrs * $milkPrice,
                        'date' => date('Y-m-d'),
                        'status' => 0
                    ]);
                }
            }
        }
    }

    protected function changeVermiStatus() {

        $vermiCycle = NotificationSetting::where('id', 1)->value('vermi');

        $vermiComposts = VermiCompost::where('date', '<=', Carbon::now()->subDays($vermiCycle))->get();

        foreach ($vermiComposts as $vermiCompost) {
            $vermiCompost->status = 1;
            $vermiCompost->save();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
