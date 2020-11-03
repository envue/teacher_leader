<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController
{
    public function index()
    {
        $settings1 = [
            'chart_title'        => 'Number of Entries by Work Type',
            'chart_type'         => 'bar',
            'report_type'        => 'group_by_relationship',
            'model'              => 'App\Models\TimeEntry',
            'group_by_field'     => 'name',
            'aggregate_function' => 'count',
            'filter_field'       => 'created_at',
            'filter_days'        => '90',
            'column_class'       => 'col-md-12',
            'entries_number'     => '5',
            'relationship_name'  => 'work_type',
        ];

        $chart1 = new LaravelChart($settings1);
/*
        $settings2 = [
            'chart_title'           => 'Number of time entries created this year by month',
            'chart_type'            => 'line',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\TimeEntry',
            'group_by_field'        => 'start_time',
            'group_by_period'       => 'month',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_period'         => 'year',
            //'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-12',
            'entries_number'        => '5',
        ];

        $chart2 = new LaravelChart($settings2); */

        return view('home', compact('chart1'));
    }
}
