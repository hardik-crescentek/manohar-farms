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

class SendCameraRechargeNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cameraName,$cameraSimNumber; // Declare the property

    /**
     * Create a new job instance.
     */
    public function __construct($cameraName,$cameraSimNumber)
    {
        $this->cameraName = ucwords($cameraName);
        $this->cameraSimNumber = ucwords($cameraSimNumber);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            $usertoken = User::whereNotNull('device_token')->pluck('device_token')->all();
            sendNotification($usertoken, 'Manohar Farms', "Camera Recharge Pending Of {$this->cameraName} {$this->cameraSimNumber}");
        } catch(\Exception $e) {
            Log::error('SendCameraRechargeNotificationJob - ' . $e->getMessage());
        }
    }
}
