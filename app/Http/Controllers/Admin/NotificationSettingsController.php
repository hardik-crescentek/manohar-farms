<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationSetting;

class NotificationSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notificationSettings = NotificationSetting::find(1);
        $data['notification'] = $notificationSettings;

        return view('notification-settings.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notification-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'water' => 'required',
            'fertiliser' => 'required',
            'flushing' => 'required',
            'Jivamrut' => 'required',
            'vermi' => 'required',
            'plots_filter_cleaning' => 'required',
            'agenda_completion' => 'required',
            'diesel' => 'required',
        ]);

        NotificationSetting::create($request->all());

        return redirect()->route('notification-settings')->with('success', 'Notification setting created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotificationSetting  $notificationSetting
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationSetting $notificationSetting)
    {
        return view('notification-settings.show', compact('notificationSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotificationSetting  $notificationSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationSetting $notificationSetting)
    {
        return view('notification-settings.edit', compact('notificationSetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotificationSetting  $notificationSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationSetting $notificationSetting)
    {
        $request->validate([
            'water' => 'required',
            'fertiliser' => 'required',
            'flushing' => 'required',
            'Jivamrut' => 'required',
            'vermi' => 'required',
            'plots_filter_cleaning' => 'required',
            'agenda_completion' => 'required',
            'diesel' => 'required',
        ]);

        $notificationSetting->update($request->all());

        if($notificationSetting) {
            return redirect()->route('notification-settings')->with(['success' => true, 'message' => 'Notification setting updated successfully!']);
        } else {
            return redirect()->route('notification-settings')->with(['error'  => true, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotificationSetting  $notificationSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationSetting $notificationSetting)
    {
        $notificationSetting->delete();

        return redirect()->route('notification-settings.index')->with('success', 'Notification setting deleted successfully.');
    }
}
