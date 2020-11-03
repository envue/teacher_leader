@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-title">Roadmap</h3>
        <p>Welcome to our public roadmap! Here you can see what we're currently working on and have planned in the pipeline.</p>
        <p>View the <strong>Updates</strong> tab to see what we've recently released, and have your say on what we work on 
            next by voting for existing ideas or submitting new ideas from our <strong>Ideas</strong> tab.</p>
    </div>  
</div>
<div class="row">
    <div class="col-lg-12">
        <iframe src="https://app.productstash.io/roadmaps/5fa022670662250029f69c26/public" height="900" width="100%" frameborder="0"></iframe>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection