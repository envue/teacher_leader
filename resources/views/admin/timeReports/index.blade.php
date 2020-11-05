@extends('layouts.admin')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="row mb-3">
    <div class="col-12">
        <h3 class="page-title">Time report</h3>
    </div>
</div>
<form method="get">
<div class="row">
    
        <div class="col-lg-3 col-md-4 col-12">
            <label for='dates' class='control-label'>Dates</label>
            <input type="text" class="form-control" name="date_filter" id="date_filter"/>
        </div>
        <!--
        @can('user_access')
        <div class="col-md-2 col-xs-12">
            <label for='team member'class='control-label'>Team Member</label>
            <select style="width: 100%;" class="form-control select2 {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id" placeholder="All Team Members">
                @foreach($users as $id => $user)
                    <option value="{{ $id }}">{{ $user }}</option>
                @endforeach
            </select>
        </div>@endcan
        -->

        <div class="col-lg-3 col-md-4 col-12">
            <label for='work_type_filter'class='control-label'>Work Types</label>
            <select style="width: 100%;" class="form-control select2 {{ $errors->has('work_type_filter') ? 'is-invalid' : '' }}" name="work_type_filter" id="work_type_filter" placeholder="All Team Members">
                @foreach($work_types as $id => $work_type)
                    <option value="{{ $id }}" {{ old('work_type_filter', Request::get('work_type_filter')) == $id ? "selected" :""}}>{{ $work_type }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-2 col-md-4 col-12">
            <label for='population_type_filter'class='control-label'>Population Types</label>
            <select style="width: 100%;" class="form-control select2 {{ $errors->has('population_type_filter') ? 'is-invalid' : '' }}" name="population_type_filter" id="population_type_filter" placeholder="All Types">
                @foreach($population_types as $id => $population_type)
                    <option value="{{ $id }}" {{ old('population_type_filter', Request::get('population_type_filter')) == $id ? "selected" :""}}>{{ $population_type }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-2 col-md-4 col-12">
            <label for='caseload_type_filter'class='control-label'>Caseload Types</label>
            <select style="width: 100%;" class="form-control select2 {{ $errors->has('caseload_type_filter') ? 'is-invalid' : '' }}" name="caseload_type_filter" id="caseload_type_filter" placeholder="All Types">
                @foreach($caseload_types as $id => $caseload_type)
                    <option value="{{ $id }}" {{ old('caseload_type_filter', Request::get('caseload_type_filter')) == $id ? "selected" :""}}>{{ $caseload_type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-4 col-12">
            <label class="control-label">&nbsp;</label><br>
            <button type="submit" name="filter_submit" value="Filter" class="btn btn-primary">Filter</button>
            </form>
            <button class="btn btn-success" onClick="window.print()">Print</button>
        </div>
</div>

<br>
      
<div class = "row">
    <div class = "col-12 col-xl-8">
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Time by Work Type</h3>
                <div class="card-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <!-- <span class="label label-primary">Label</span> -->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <canvas id="worktypeChart"> </canvas>
            </div>
            <div class="card-footer bg-white top-border-none">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Work type</th>
                        <th>Minutes</th>
                        <th>Percent</th>
                    </tr>
                    @foreach($work_type_time as $work_type)
                    <tr>
                        <td>{{ $work_type['name'] }}</td>
                        <td>{{ $work_type['time'] }}</td>
                        <td>{{ number_format( $work_type['time'] / $workTypeMinutes * 100, 2 ) . '%' }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            
        </div>
        <!-- /.card -->
    </div>
    <div class = "col-12 col-xl-4 col-md-6">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">Time by Population</h3>
                <div class="card-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <!-- <span class="label label-primary">Label</span> -->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <canvas id="populationChart"> </canvas>
            </div>
            <div class="card-footer bg-white top-border-none">
                <table id="projecttable" class="table table-bordered table-striped">
                        <tr>
                            <th>Population type</th>
                            <th>Minutes</th>
                            <th>Percent</th>
                        </tr>
                        @foreach($population_type_time as $population_type)
                    <tr>
                        <td>{{ $population_type['name'] }}</td>
                        <td>{{ $population_type['time'] }}</td>
                        <td>{{ number_format( $population_type['time'] / $populationTypeMinutes * 100, 2 ) . '%' }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <!-- /.card -->
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">Caseload vs. Non-Caseload</h3>
                <div class="card-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <!-- <span class="label label-primary">Label</span> -->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <canvas id="caseloadChart"> </canvas>
            </div>
            <div class="card-footer bg-white top-border-none">
                <table id="projecttable" class="table table-bordered table-striped">
                        <tr>
                            <th>Caseload type</th>
                            <th>Minutes</th>
                            <th>Percent</th>
                        </tr>
                        @foreach($caseload_type_time as $caseload)
                    <tr>
                        <td>{{ $caseload['name'] }}</td>
                        <td>{{ $caseload['time'] }}</td>
                        <td>{{ number_format( $caseload['time'] / $caseloadTypeMinutes * 100, 2 ) . '%' }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@stop

@section('scripts')
    @parent

    <!-- Include Required Prerequisites -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>-->
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    

    <script type="text/javascript">
        $(function () {
            let dateInterval = getQueryParameter('date_filter');
            let start = moment().startOf('isoWeek');
            let end = moment().endOf('isoWeek');
            if (dateInterval) {
                dateInterval = dateInterval.split(' - ');
                start = dateInterval[0];
                end = dateInterval[1];
            }        
           
           
            $('#date_filter').daterangepicker({
                "showDropdowns": true,
                "showWeekNumbers": true,
                "alwaysShowCalendars": true,
                startDate: start,
                endDate: end,
                locale: {
                    format: 'MM/DD/YY',
                    firstDay: 1,
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                    'All time': [moment().subtract(30, 'year').startOf('month'), moment().endOf('month')],
                }
            });
        });
        function getQueryParameter(name) {
            const url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script>

    <!-- Chartjs script -->
    <script>
        var workTypeData = {!! json_encode($workTypeData)  !!};
        var workTypeLabels = {!! json_encode($workTypeLabels)  !!};
        var workTypeColors = {!! json_encode($workTypeColors)  !!};
        var populationTypeLabels = {!! json_encode($populationTypeLabels)  !!};
        var populationTypeData = {!! json_encode($populationTypeData)  !!};
        var caseloadTypeLabels = {!! json_encode($caseloadTypeLabels)  !!};
        var caseloadTypeData = {!! json_encode($caseloadTypeData)  !!};
        
        var ctx = document.getElementById("worktypeChart").getContext('2d');
        var populationChart = new Chart(ctx, {
            type: 'horizontalBar',
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
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                legend: {
                    display: true,
                    labels: {
                    boxWidth: 0,
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                            var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = parseFloat((currentValue/total*100).toFixed(1));
                            return currentValue + ' (' + percentage + '%)';
                        },
                        title: function(tooltipItem, data) {
                            return data.labels[tooltipItem[0].index];
                        }
                    }
                },
            }
        });
        var ctx = document.getElementById("populationChart").getContext('2d');
        var populationChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: populationTypeLabels,
                datasets: [{
                    label: '# of Minutes',
                    data: populationTypeData,
                    backgroundColor: [
                        '#6610f2',  //indigo
                        '#d81b60',  //maroon
                        '#001f3f',  //navy
                        '#3c8dbc',  //lightblue
                        '#ff851b',  //orange
                        '#39cccc',  //teal
                        '#605ca8',  //purple
                        '#e83e8c',  //pink
                        '#3d9970',  //olive
                        '#343a40',  //gray
                        '#007bff',  //blue
                        '#28a745',  //green
                        '#dc3545',  //red
                        '#000000',  //black
                    ],
                    borderWidth: 1
                }]
            },
            options: {
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
        var ctx = document.getElementById("caseloadChart").getContext('2d');
        var caseloadChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: caseloadTypeLabels,
                datasets: [{
                    label: '# of Minutes',
                    data: caseloadTypeData,
                    backgroundColor: [
                        '#007bff',  //blue
                        '#28a745',  //green
                        '#dc3545',  //red
                        '#ff851b',  //orange
                        '#39cccc',  //teal
                        '#605ca8',  //purple
                        '#e83e8c',  //pink
                        '#3d9970',  //olive
                        '#343a40',  //gray
                        '#6610f2',  //indigo
                        '#d81b60',  //maroon
                        '#001f3f',  //navy
                        '#3c8dbc',  //lightblue
                        '#000000',  //black                        
                    ],
                    borderWidth: 1
                }]
            },
            options: {
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