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
        $daily_time = [];
        
        foreach ($time_entries as $time_entry) {
            $begin = Carbon::parse($time_entry->start_time, 'Europe/Vilnius');
            $end   = Carbon::parse($time_entry->end_time, 'Europe/Vilnius');
            $day = $begin->format('m/d');
            $diff = $begin->diffInMinutes($end);
            $time_entries_total_minutes+= $diff;
            if (!isset($work_type_time[$time_entry->work_type->id])) {
                $work_type_time[$time_entry->work_type->id] = [
                    'name' => $time_entry->work_type->name,
                    'time' => $diff,
                    'color'=> $time_entry->work_type->color,
                ];
            } else {
                $work_type_time[$time_entry->work_type->id]['time'] += $diff;
            }
                     
            if (!isset($daily_time[$day])) {
                $daily_time[$day] = [
                    'date' => $day,
                    'time' => $diff,
                ];
            } else {
                $daily_time[$day]['time'] += $diff;
            } 

        }

        ksort($daily_time);
        

        // Chart data
        $workTypeLabels = array_column($work_type_time, 'name');
        $workTypeData = array_column($work_type_time, 'time');
        $workTypeColors = array_column($work_type_time, 'color');
        $dailyTimeLabels = array_column($daily_time, 'date');
        $dailyTimeData = array_column($daily_time, 'time');

        

        return view('home', compact('dailyTimeLabels', 'dailyTimeData','carbon_date_from', 'carbon_date_to','time_entries_count', 'time_entries_total_minutes','workTypeLabels','workTypeData','workTypeColors'));
    }
}
