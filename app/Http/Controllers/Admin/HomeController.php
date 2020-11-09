<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\TimeEntry;
use Carbon\Carbon;

class HomeController
{
    public function index()
    {
        //$articles = simplexml_load_file('https://schoolsocialwork.net/feed/'); 
        
        $carbon_date_from = new Carbon('last Sunday', 'America/Chicago');
        $from = $carbon_date_from->startOfDay();
        $carbon_date_to = new Carbon('this Saturday', 'America/Chicago');
        $to = $carbon_date_to->endOfDay();

        $time_entries = TimeEntry::whereBetween('start_time', [$from, $to])->get();

        $time_entries_count = $time_entries->count();

        $time_entries_total_minutes = 0;

        $work_type_time = [];
        $daily_time = [];
        
        foreach ($time_entries as $time_entry) {
            $begin = Carbon::parse($time_entry->start_time, 'America/Chicago');
            $end   = Carbon::parse($time_entry->end_time, 'America/Chicago');
            $day = $begin->format('m/d/y');
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

        $todays_total_minutes = $daily_time[Carbon::now()->format('m/d/y')]['time'] ?? 0;
        

        // Chart data
        $workTypeLabels = array_column($work_type_time, 'name');
        $workTypeData = array_column($work_type_time, 'time');
        $workTypeColors = array_column($work_type_time, 'color');
        $dailyTimeLabels = array_column($daily_time, 'date');
        $dailyTimeData = array_column($daily_time, 'time');

        

        return view('home', compact('dailyTimeLabels', 'dailyTimeData','carbon_date_from', 'carbon_date_to','time_entries_count','todays_total_minutes', 'time_entries_total_minutes','workTypeLabels','workTypeData','workTypeColors'));
    }
}
