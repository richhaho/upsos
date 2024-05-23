<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function addSchedule()
    {
        $schedules= Schedule::where('seller_id', Auth::user()->id)->get();
        return view('user.schedule.index',compact('schedules'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'day' => 'required',
            'schedule' => 'required',
        ]);

        $schedule = new Schedule();
        $schedule->day = $request->day;
        $schedule->seller_id = Auth::user()->id;
        $schedule->schedule = $request->schedule;
        $schedule->status = 1;
        $schedule->save();

        return redirect()->back()->with('success', 'Schedule added successfully');
    }

    public function editSchedule($id)
    {
        $schedule = Schedule::find($id);
        return view('user.schedule.edit', compact('schedule'));
    }
     
    public function updateSchedule(Request $request, $id) {

        $request->validate([
            'day' => 'required',
            'schedule' => 'required',
        ]);
        $schedule = Schedule::find($id);
        $schedule->day = $request->day;
        $schedule->seller_id = Auth::user()->id;
        $schedule->schedule = $request->schedule;
        $schedule->status = 1;
        $schedule->save();
        return redirect()->back()->with('success', 'Schedule updated successfully');
    }


    public function deleteSchedule($id)
    {
        $schedule = Schedule::find($id);
        $schedule->delete();
        return redirect()->back()->with('success', 'Schedule deleted successfully');
    }

    
}
