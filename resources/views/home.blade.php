@extends('layouts.admin')
@section('content')
<!-- Info Boxes -->
<div class="row mb-3">
    <div class="col-lg-12">
        <h3 class="page-title">Dashboard</h3>
    </div>  
</div>

<div class="row">
    <div class="col-md-4 col-sm-6 col-12">
    <div class="info-box bg-primary">
        <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

        <div class="info-box-content">
        <span class="info-box-text">Events recorded this week</span>
        <span class="info-box-number">{{ $time_entries_count }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-12">
    <div class="info-box" style="color: #fff; background-color: #d81b60;">
        <span class="info-box-icon"><i class="far fa-clock"></i></span>

        <div class="info-box-content">
        <span class="info-box-text">Minutes recorded this week</span>
        <span class="info-box-number">{{ $time_entries_total_minutes }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-12">
    <div class="info-box" style="color: #fff; background-color: #6610f2;">
        <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

        <div class="info-box-content">
        <span class="info-box-text">Another metric (placeholder)</span>
        <span class="info-box-number">1,410</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>   

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Content Area Title</h3>
            </div>

            <div class="card-body">
                <p>Area for content</p>  
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Minutes by Work Type</h3>     
            </div>
            <div class="card-body">
                <canvas id="worktypeChart"></canvas>
            </div>
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

        var ctx = document.getElementById("worktypeChart").getContext('2d');
        var worktypeChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: workTypeLabels,
                datasets: [{
                    label: '# of Minutes',
                    data: workTypeData,
                    backgroundColor: workTypeColors,
                    borderWidth: 1
                }]
            },
            options: {                
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

        
</script>
@endsection