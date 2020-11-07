@extends('layouts.admin')
@section('content')
<!-- Page Header -->
<div class="row mb-3">
    <div class="col-lg-12">
        <h3 class="page-title">Dashboard</h3>
    </div>  
</div>
<!-- Info Boxes -->
<div class="row">
    <div class="col-md-3 col-6">

        <div class="small-box bg-primary">
            <div class="inner">
                <h4 class="home-widget"><strong>Calendar</strong></h4>
                <p>
                Create/edit time entries
                </p>
            </div>
            <div class="icon">
                <i class="fa fa-calendar"></i>
            </div>
            <a href="{{ route('admin.system-calendar.index') }}" class="small-box-footer">View Calendar <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box" style="background-color: #6610f2; color: #fff;">
            <div class="inner">
                <h4 class="home-widget"><strong>Time Entries</strong></h4>
                <p>
                Search and export entries
                </p>
            </div>
            <div class="icon">
                <i class="fa fa-clock"></i>
            </div>
            <a href="{{ route('admin.time-entries.index') }}" class="small-box-footer">View Entries <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box" style="background-color: #d81b60; color: #fff;">
            <div class="inner">
                <h4 class="home-widget"><strong>Work Types</strong></h4>
                <p>
                Customize your work types
                </p>
            </div>
            <div class="icon">
                <i class="fa fa-briefcase"></i>
            </div>
            <a href="{{ route('admin.time-work-types.index') }}" class="small-box-footer">View Work Types<i class="fa fa-arrow-circle-right"></i></a>
         </div>
    </div>
    <div class="col-md-3 col-6">

        <div class="small-box" style="background-color: #39cccc; color: #fff;">
            <div class="inner">
                <h4 class="home-widget"><strong>Time Report</strong></h4>
                <p>
                Generate a time report
                </p>
            </div>
            <div class="icon">
                <i class="fa fa-chart-line"></i>
            </div>
            <a href="{{ route('admin.time-reports.index') }}" class="small-box-footer">View Report<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daily Minutes ({{ $carbon_date_from->format('m/d/y') }} - {{ $carbon_date_to->format('m/d/y') }})</h3>     
            </div>
            <div class="card-body">
                    <canvas id="dailyTimeChart"></canvas>
            </div>
            <!--<div class="card-footer">
                <div class="row">
                  <div class="col-6">
                    <div class="description-block border-right">
                      <h3 class="description-header">{{ $time_entries_count }}</h3>
                      <span class="description-text">Number of Entries</span>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="description-block">
                      <h3 class="description-header">{{ $time_entries_total_minutes }}</h3>
                      <span class="description-text">Total Minutes</span>
                    </div>
                  </div>
                </div>
            </div> -->
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Work Type Minutes ({{ $carbon_date_from->format('m/d/y') }} - {{ $carbon_date_to->format('m/d/y') }})</h3>     
            </div>
            <div class="card-body">
                <canvas id="worktypeChart"></canvas>
            </div>
           <!-- <div class="card-footer">
                <div class="row">
                  <div class="col-6">
                    <div class="description-block border-right">
                      <h3 class="description-header">{{ $time_entries_count }}</h3>
                      <span class="description-text">Number of Entries</span>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="description-block">
                      <h3 class="description-header">{{ $time_entries_total_minutes }}</h3>
                      <span class="description-text">Total Minutes</span>
                    </div>
                  </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script>
    $(document).ready(function(){

        // Send user data to Gist
        gist.identify("{{ Auth::user()->id }}", {
            email: "{{ Auth::user()->email }}",
            name: "{{ Auth::user()->name }}",
            role: "{{ Auth::user()->role_id }}",
            last_app_use: {{ time() }},
        });
    });

    //Chartjs script
        var workTypeData = {!! json_encode($workTypeData)  !!};
        var workTypeLabels = {!! json_encode($workTypeLabels)  !!};
        var workTypeColors = {!! json_encode($workTypeColors)  !!};
        var dailyTimeLabels = {!! json_encode($dailyTimeLabels)  !!};
        var dailyTimeData = {!! json_encode($dailyTimeData)  !!};

        var ctx = document.getElementById("worktypeChart").getContext('2d');
        var worktypeChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: workTypeLabels,
                datasets: [{
                    label: 'Minutes',
                    data: workTypeData,
                    backgroundColor: workTypeColors,
                    borderWidth: 1
                }]
            },
            options: {                
                title: {
                    display: false,
                    text: 'Custom Chart Title'
                }, 
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                    boxWidth: 12,
                    }
                },
                animation: {
                    duration: 0
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                            var total = meta.total;
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = parseFloat((currentValue/total*100).toFixed(1));
                            return currentValue + ' (' + percentage + '%)';
                        },
                        title: function(tooltipItem, data) {
                            return data.labels[tooltipItem[0].index];
                        }
                    }
                },
            },            
        });
        
        var ctx = document.getElementById("dailyTimeChart").getContext('2d');
        var dailyTimeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dailyTimeLabels,
                datasets: [{
                    label: 'Minutes',
                    fill: 'false',
                    data: dailyTimeData,
                    borderColor: '#007bff',
                    borderWidth: 2
                }]
            },
            options: { 
                title: {
                    display: false,
                    text: 'Custom Chart Title'
                },              
                legend: {
                    display: false,
                    position: 'bottom',
                    labels: {
                    boxWidth: 12,
                    }
                },
                animation: {
                    duration: 0
                },
                
            },

            
            
        });   
</script>

@endsection