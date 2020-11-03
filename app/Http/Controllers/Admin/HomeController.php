<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\TimeEntry;
use Carbon\Carbon;

class HomeController
{
    public function index()
    {
        $carbon_date_from = new Carbon('last Monday');
        $from = $carbon_date_from->startOfDay();
        $carbon_date_to = new Carbon('this Sunday');
        $to = $carbon_date_to->endOfDay();

        $time_entries = TimeEntry::whereBetween('start_time', [$from, $to])->get();

        $time_entries_count = $time_entries->count();

        $time_entries_minutes = 0;

        foreach ($time_entries as $time_entry) {
            $begin = Carbon::parse($time_entry->start_time, 'America/Chicago');
            $end   = Carbon::parse($time_entry->end_time, 'America/Chicago');

            $time_entries_minutes+= $begin->diffInMinutes($end);
        }       

        return view('home', compact('time_entries_count', 'time_entries_minutes'));
    }
}
