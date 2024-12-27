<?php

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

function fileUpload($folder, $file, $oldfile = null)
{
    $fileName = NULL;
    $path = 'uploads/' . $folder;

    if (isset($file) && $file != null) {

        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path($path), $fileName);
    }

    if ($oldfile != null) {
        if (file_exists(public_path($path . '/' . $oldfile))) {
            unlink(public_path($path . '/' . $oldfile));
        }
    }

    return $fileName;
}

function apiFileUpload($folder, $file, $oldfile = null)
{

    $imageName = null;
    $path = 'uploads/' . $folder . '/';

    $binary  = base64_decode($file);
    $imageName = time() . '.jpg';
    file_put_contents(public_path($path) . $imageName, $binary);

    if ($oldfile != null) {
        if (file_exists(public_path($path . '/' . $oldfile))) {
            unlink(public_path($path . '/' . $oldfile));
        }
    }

    return $imageName;
}

function generateString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}


function generateInteger($n)
{
    $characters = '0123456789';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

function sendNotification(array $device_token, string $title, string $body)
{
    try {
        $SERVER_API_KEY = env('SERVER_API_KEY');

        $data = [
            "registration_ids" => $device_token,
            "notification" => [
                "title" => $title,
                "body" => $body,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        if (is_array($device_token) && !empty($device_token)) {

            foreach ($device_token as $key => $token) {

                $user = User::where('device_token', $token)->first();
                $createNotification = Notification::create([
                    'user_id' => $user->id,
                    'device_token' => $token,
                    'title' => $title,
                    'body' => $body,
                    'status' => 0
                ]);
            }
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        //Log::info('Notification sent: '. $body);
        return $response;
    } catch (\Exception $e) {
        Log::info('Notification Error: ' . $e->getMessage());
    }
}
