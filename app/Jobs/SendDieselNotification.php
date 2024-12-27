<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\DieselNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDieselNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dieselLitrs;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $message
     * @return void
     */
    public function __construct($dieselLitrs)
    {
        $this->dieselLitrs = $dieselLitrs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $usertoken = User::whereNotNull('device_token')->pluck('device_token')->all();
            sendNotification($usertoken, 'Manohar Farms', $this->dieselLitrs . ' Litrs Diesel remaining');
        } catch(\Exception $e) {
            Log::error('SendFlushingNotificationJob - ' . $e->getMessage());
        }
    }
}
