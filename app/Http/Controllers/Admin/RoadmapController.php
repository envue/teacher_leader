<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class RoadmapController
{    
    public function index()
    {
        return view('roadmap');
    }
}
