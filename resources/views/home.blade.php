@extends('layouts.admin')
@section('content')
@php
        $articles = simplexml_load_file('https://schoolsocialwork.net/feed/');   
@endphp

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
            <a href="{{ route('admin.system-calendar.index') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="{{ route('admin.time-entries.index') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="{{ route('admin.time-work-types.index') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="{{ route('admin.time-reports.index') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-primary"><i class="fas fa-calendar-day"></i></span>

        <div class="info-box-content">
        <span class="info-box-text">Today</span>
        <span class="info-box-number">{{$todays_total_minutes}} minutes recorded</span>

        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="background-color: #007bff!important; width: {{ number_format( $todays_total_minutes / 336 * 100, 0 ) . '%' }};"></div>
        </div>
        <span class="progress-description">
        {{ number_format( $todays_total_minutes / 336 * 100, 0 ) . '%' }} of daily goal of 336 minutes
        </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon" style="background-color: #6610f2; color: #fff"><i class="fas fa-calendar-week"></i></span>

        <div class="info-box-content">
        <span class="info-box-text">This Week ({{ $carbon_date_from->format('m/d/y') }} - {{ $carbon_date_to->format('m/d/y') }})</span>
        <span class="info-box-number">{{ $time_entries_total_minutes }} minutes recorded</span>

        <div class="progress" style="height: 4px;">
            <div class="progress-bar" style="background-color: #6610f2; width: {{ number_format( $time_entries_total_minutes / 1680 * 100, 0 ) . '%' }};"></div>
        </div>
        <span class="progress-description">
        {{ number_format( $time_entries_total_minutes / 1680 * 100, 0 ) . '%' }} of weekly goal of 1680 minutes
        </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
</div>


<!-- Charts Row -->
<div class="row">
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daily Minutes <small class="text-muted float-right">({{ $carbon_date_from->format('m/d/y') }} - {{ $carbon_date_to->format('m/d/y') }})</small></h3>     
            </div>
            <div class="card-body">
                    <canvas id="dailyTimeChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Work Type Minutes <small class="text-muted float-right">({{ $carbon_date_from->format('m/d/y') }} - {{ $carbon_date_to->format('m/d/y') }})</small></h3>     
            </div>
            <div class="card-body">
                <canvas id="worktypeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
<div class = "col-lg-6 col-12">
        <div class="card">
        <div class="card-header bg-dard">
            <h3 class="card-title">Helpful Resources</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <ul class="products-list product-list-in-card pl-2 pr-2"> 
            <li class="item">
                <div class="product-img">
                    <i class="fa fa-file-invoice fa-2x bg-primary p-3 white-text rounded"></i>
                </div>
                <div class="product-info pl-4">
                <a href="https://schoolsocialwork.net/how-school-social-workers-can-use-a-time-study-to-enhance-their-effectiveness/" class="product-title" target="_blank" >
                How School Social Workers Can Use a Time Student to Enhance Their Effectivness</a><br>
                <span class="text-muted description">
                Our step-by-step process for conducting a successful time-study and using the data to advocate for your role.
                </span>
                </div>
            </li>
            <!-- /.item -->
            <li class="item">
                <div class="product-img">
                    <i class="fa fa-file fa-2x bg-secondary p-3 white-text rounded"></i>
                </div>
                <div class="product-info pl-4">
                <a href="#" class="product-title" target="_blank" >
                Resource # 2</a><br>
                <span class="text-muted description">
                A description of this resource.
                </span>
                </div>
            </li>
            <li class="item">
                <div class="product-img">
                    <i class="fa fa-file-alt fa-2x bg-info p-3 white-text rounded"></i>
                </div>
                <div class="product-info pl-4">
                <a href="#" class="product-title" target="_blank" >
                Resource # 2</a><br>
                <span class="text-muted description">
                A description of this resource.
                </span>
                </div>
            </li>
            <li class="item">
                <div class="product-img">
                    <i class="fa fa-file-video fa-2x bg-danger p-3 white-text rounded"></i>
                </div>
                <div class="product-info pl-4">
                <a href="#" class="product-title" target="_blank" >
                Video Resource</a><br>
                <span class="text-muted description">
                A description of this resource.
                </span>
                </div>
            </li>
            <!-- /.item -->
            </ul>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box --> 
    </div>
    <!-- /. Column -->
    <div class = "col-lg-6 col-12">
        <div class="card">
        <div class="card-header bg-dard">
            <h3 class="card-title">Latest Blog Posts</h3>
            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <a class="btn btn-tool text-muted" href="https://schoolsocialwork.net" target="_blank">View All</a>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <ul class="products-list product-list-in-card pl-2 pr-2">
            @foreach($articles->channel->item as $item) 
            <li class="item">
                <div class="product-img">
                    <img src="{{$item->children( 'media', True )->content->attributes()['url']}}" alt="Product Image">
                </div>
                <div class="product-info">
                <a href="{{$item->link}}" class="product-title" target="_blank" >{{$item->title}}</a>
                <span class="product-description">
                        {{html_entity_decode($item->description)}}
                </span>
                </div>
            </li>
            <!-- /.item -->
            @endforeach
            </ul>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box --> 
    </div>
    <!-- /. Column -->
</div>
<!-- /.row -->
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
                    backgroundColor: '#007bff',
                    borderWidth: 2,
                    pointBorderWidth: 4,
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