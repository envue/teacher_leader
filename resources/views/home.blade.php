@extends('layouts.admin')
@section('content')
<!-- Info Boxes -->
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-title">Dashboard</h3>
    </div>  
</div>

<div class="row">
    <div class="col-md-4 col-sm-6 col-12">
    <div class="info-box bg-info">
        <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

        <div class="info-box-content">
        <span class="info-box-text">Events Recorded</span>
        <span class="info-box-number">{{ $time_entries_count }}</span>
        <span class="progress-description">
            This Week
        </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-12">
    <div class="info-box bg-success">
        <span class="info-box-icon"><i class="far fa-clock"></i></span>

        <div class="info-box-content">
        <span class="info-box-text">Minutes Recorded</span>
        <span class="info-box-number">{{ $time_entries_minutes }}</span>
        <span class="progress-description">
            This Week
        </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-12">
    <div class="info-box bg-danger">
        <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

        <div class="info-box-content">
        <span class="info-box-text">Another Metric</span>
        <span class="info-box-number">1,410</span>
        <span class="progress-description">
            This Week
        </span>
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
                <h3 class="card-title">Card Title</h3>
            </div>

            <div class="card-body">
                
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Card Title</h3>     
            </div>
            <!-- 
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <li class="item">
                        <div class="product-img">
                            <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                        </div>
                        <div class="product-info">
                            <a href="javascript:void(0)" class="product-title">Samsung TV
                            <span class="badge badge-warning float-right">$1800</span></a>
                            <span class="product-description">
                            Samsung 32" 1080p 60Hz LED Smart HDTV.
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
            .card-body -->
            <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">View All Posts</a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

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
    </script>
@endsection