<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendVehicleNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $vehName,$vehNumber; // Declare the property

    /**
     * Create a new job instance.
     */
    public function __construct($vehName,$vehNumber)
    {
        $this->vehName = ucwords($vehName);
        $this->vehNumber = ucwords($vehNumber);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            $usertoken = User::whereNotNull('device_token')->pluck('device_token')->all();
            sendNotification($usertoken, 'Manohar Farms', "Vehicle Service Pending for {$this->vehName} {$this->vehNumber}");
        } catch(\Exception $e) {
            Log::error('SendVehicleNotificationJob - ' . $e->getMessage());
        }
    }
}
