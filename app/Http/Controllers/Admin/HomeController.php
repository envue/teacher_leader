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

        $time_entries_total_minutes = 0;

        $work_type_time = [];
        
        foreach ($time_entries as $time_entry) {
            $begin = Carbon::parse($time_entry->start_time, 'Europe/Vilnius');
            $end   = Carbon::parse($time_entry->end_time, 'Europe/Vilnius');
            $time_entries_total_minutes+= $begin->diffInMinutes($end);
            if (!isset($work_type_time[$time_entry->work_type->id])) {
                $work_type_time[$time_entry->work_type->id] = [
                    'name' => $time_entry->work_type->name,
                    'time' => $begin->diffInMinutes($end),
                    'color'=> $time_entry->work_type->color,
                ];
            } else {
                $work_type_time[$time_entry->work_type->id]['time'] += $begin->diffInMinutes($end);
            }           
        }

        // Chart data
        $workTypeLabels = array_column($work_type_time, 'name');
        $workTypeData = array_column($work_type_time, 'time');
        $workTypeColors = array_column($work_type_time, 'color');

        return view('home', compact('time_entries_count', 'time_entries_total_minutes','workTypeLabels','workTypeData','workTypeColors'));
    }
}
