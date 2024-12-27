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

class SendBoreWellsFilterCleaningNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filterName; // Declare the property

    /**
     * Create a new job instance.
     */
    public function __construct($filterName)
    {
        $this->filterName = ucwords($filterName);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            $usertoken = User::whereNotNull('device_token')->pluck('device_token')->all();
            sendNotification($usertoken, 'Manohar Farms', "Filter Cleaning Pending Of {$this->filterName}");
        } catch(\Exception $e) {
            Log::error('SendBoreWellsFilterCleaningNotificationJob - ' . $e->getMessage());
        }
    }
}
