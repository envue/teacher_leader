<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeEntry;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Gate;

class TimeReportController extends Controller
{
    public function index(Request $r)
    {

        if (! Gate::allows('time_report_access')) {
            return abort(401);
        }
        $users = \App\Models\User::get()->pluck('name', 'id')->prepend('All users','');

        $work_types = \App\Models\TimeWorkType::get()->pluck('name', 'id')->prepend('All types','');
        $population_types = \App\Models\TimePopulationType::get()->pluck('name', 'id')->prepend('All types','');
        $caseload_types = \App\Models\TimeCaseloadType::get()->pluck('name', 'id')->prepend('All types','');

        if (isset($r->date_filter)) {
            $parts = explode(' - ' , $r->date_filter);
            $from = Carbon::parse($parts[0])->startOfDay();
            $to = Carbon::parse($parts[1])->endOfDay();
        } else {
            $carbon_date_from = new Carbon('last Monday');
            $from = $carbon_date_from->startOfDay();
            $carbon_date_to = new Carbon('this Sunday');
            $to = $carbon_date_to->endOfDay();
        }
        
        $time_entries = TimeEntry::with('work_type','population_type','caseload_type')->whereBetween('start_time', [$from, $to]);

        /*
        if (!empty($r->user_id)) {
            $time_entries->where('created_by_id', '=', $r->user_id);
        }
        */

        if (!empty($r->work_type_filter)) {
            $time_entries->where('work_type_id', '=', $r->work_type_filter);
        }
        
        if (!empty($r->caseload_type_filter)) {
            $time_entries->where('caseload_type_id', '=', $r->caseload_type_filter);
        }

        if (!empty($r->population_type_filter)) {
            $time_entries->where('population_type_id', '=', $r->population_type_filter);
        }
    
        $time_entries_work_type = $time_entries->whereNotNull('work_type_id')->get();

        $work_type_time = [];
        
        foreach ($time_entries_work_type as $time_entry) {
            $begin = Carbon::parse($time_entry->start_time, 'America/Chicago');
            $end   = Carbon::parse($time_entry->end_time, 'America/Chicago');
            $diff  = $begin->diffInMinutes($end);
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

        $time_entries_populations = $time_entries->whereNotNull ('population_type_id')->get();
        
        $population_type_time = [];
        
        foreach ($time_entries_populations as $time_entry) {
            $begin = Carbon::parse($time_entry->start_time, 'Europe/Vilnius');
            $end   = Carbon::parse($time_entry->end_time, 'Europe/Vilnius');
            $diff  = $begin->diffInMinutes($end);

            
            if (!isset($population_type_time[$time_entry->population_type->id])) {
                $population_type_time[$time_entry->population_type->id] = [
                    'name' => $time_entry->population_type->name,
                    'time' => $begin->diffInMinutes($end),
                ];
            } else {
                $population_type_time[$time_entry->population_type->id]['time'] += $begin->diffInMinutes($end);
            }            
        }

        $time_entries_caseload = $time_entries->whereNotNull ('caseload_type_id')->get();
        
        $caseload_type_time = [];
        
        foreach ($time_entries_caseload as $time_entry) {
            $begin = Carbon::parse($time_entry->start_time, 'Europe/Vilnius');
            $end   = Carbon::parse($time_entry->end_time, 'Europe/Vilnius');
            $diff  = $begin->diffInMinutes($end);
            if (!isset($caseload_type_time[$time_entry->caseload_type->id])) {
                $caseload_type_time[$time_entry->caseload_type->id] = [
                    'name' => $time_entry->caseload_type->name,
                    'time' => $begin->diffInMinutes($end),
                ];
            } else {
                $caseload_type_time[$time_entry->caseload_type->id]['time'] += $begin->diffInMinutes($end);
            }            
        }

        // Chart data
        $workTypeLabels = array_column($work_type_time, 'name');
        $workTypeData = array_column($work_type_time, 'time');
        $workTypeColors = array_column($work_type_time, 'color');
        $populationTypeLabels = array_column($population_type_time, 'name');
        $populationTypeData = array_column($population_type_time, 'time');
        $caseloadTypeLabels = array_column($caseload_type_time, 'name');
        $caseloadTypeData = array_column($caseload_type_time, 'time');

        //total minutes for calculating percent in chart
        $workTypeMinutes = array_sum($workTypeData);
        $populationTypeMinutes = array_sum($populationTypeData);
        $caseloadTypeMinutes = array_sum($caseloadTypeData);

        return view('admin.timeReports.index', compact(
            'users',
            'population_types', //list of types for form
            'population_type_time', //array of both time and types
            'populationTypeData', //array of total minutes by types
            'populationTypeLabels', //array of types for chart labels
            'populationTypeMinutes', //array of minutes for table
            'caseload_types', //list of caseload types for form
            'caseload_type_time',
            'caseloadTypeData',
            'caseloadTypeData',
            'caseloadTypeLabels',
            'caseloadTypeMinutes',
            'work_types',     
            'work_type_time',
            'workTypeData',
            'workTypeLabels',          
            'workTypeMinutes',
            'workTypeColors'
        ));
    }
}