<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\BookingSetting;
use App\Http\Controllers\Controller;

class BookingSettingController extends Controller
{


    public function edit()
    {
        $setting = BookingSetting::first();
        return view('admin.booking-settings.edit', compact('setting'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'service_start_time' => 'required|date_format:H:i',
            'service_end_time' => 'required|date_format:H:i|after:service_start_time',
            'events_per_day' => 'required|integer|min:1',
            'blocked_dates' => 'nullable|array',
            'blocked_dates.*' => 'date',
        ], [
            'service_start_time.date_format' => 'The service start time must be in 24-hour format (HH:MM).',
            'service_end_time.date_format' => 'The service end time must be in 24-hour format (HH:MM).',
            'service_end_time.after' => 'The end time must be after the start time.'
        ]);

        

        $setting = BookingSetting::updateOrCreate(
            ['id' => 1],
            [
                'service_start_time' => $request->service_start_time,
                'service_end_time' => $request->service_end_time,
                'events_per_day' => $request->events_per_day,
                'blocked_dates' => $request->blocked_dates,
                ]
            );
            return redirect()->back()->with('success', 'Booking settings updated successfully!');
    }
}
