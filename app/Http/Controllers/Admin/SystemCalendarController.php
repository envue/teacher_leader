<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\TimeCaseloadType;
use App\Models\TimeEntry;
use App\Models\TimePopulationType;
use App\Models\TimeWorkType;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTimeEntryRequest;
use App\Http\Requests\UpdateTimeEntryRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class SystemCalendarController extends Controller
{
    public function index()
    {
        
        $hidden_work_types = explode(',', Auth::user()->hidden_work_types);

        //Create an array of options with attributes
        $work_types = TimeWorkType::whereNotIn('id', $hidden_work_types)->get()
        ->mapWithKeys(function ($item) {
                        return [$item->id => ['name' => $item->name, 'title' => $item->description, 'use_caseload_type' => $item->use_caseload_type, 'use_population_type' => $item->use_population_type]];
                    })->all();

        $population_types = TimePopulationType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseload_types = TimeCaseloadType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $googleCalendarAPI  = \config("app.google_calendar_api");

        $googleCalendarID = Auth::user()->google_calendar;

        
        return view('admin.calendar.index', compact('work_types', 'population_types', 'caseload_types', 'googleCalendarAPI', 'googleCalendarID'));
    }

    /**
     * Format time entries as json event data for ajax call.
     */
    public function getEvents()
    {  
        $time_entries  = TimeEntry::with('work_type')->get();
        
        $events = []; 
        foreach ($time_entries as $time_entry) { 
           $id = $time_entry->getOriginal('id'); 

           if (! $id) {
               continue;
           }

           //$worktype  = $time_entry->work_type_id;
           
                 

           $events[]       = [ 
                'id'    => $id,
                'work_type' => $time_entry->work_type_id,
                'population_type' => $time_entry->population_type_id,
                'caseload_type'   => $time_entry->caseload_type_id,
                'description' => $time_entry->description,
                'title' => $time_entry->work_type->name.': '.$time_entry->description, 
                'start' => $time_entry->start_time,
                'end'   => $time_entry->end_time,
                'notes' => $time_entry->notes,
                'color' => $time_entry->work_type->color,
                'textColor' => 'white'
           ]; 
        }

        
        return $events;
    }

     /**
     * Store a newly created TimeEntry in storage when user submits the modal form.
     *
     * @param  \App\Http\Requests\StoreTimeEntriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimeEntryRequest $request)
    {
        abort_if(Gate::denies('time_entry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $time_entry = TimeEntry::create($request->all());

        return response()->json(['responseText' => 'Success!'], 200);
    }
    
    /**
     * Update TimeEntry in storage when event id dragged or resized.
     */
    public function update(Request $request, $id)
    {
        //
        if (! Gate::allows('time_entry_edit')) {
            return abort(401);
        }
        
        $time_entry = TimeEntry::where('id', $id)     
            ->update([    
            'start_time'=> $request->input('start_time'),
            'end_time'=> $request->input('end_time'),  
      ]);
              
        return response()->json(['responseText' => 'Success!'], 200);

    }

    /**
     * Delete TimeEntry from storage.
     */
    public function destroy($id)
    {
        //
        if (! Gate::allows('time_entry_delete')) {
            return abort(401);
        }
           
        $time_entry = TimeEntry::where('id', $id);
        $time_entry ->delete();

        return response()->json(['responseText' => 'Success!'], 200);
    }

    
    /**
     * Update TimeEntry when user clicks the event and submits the modal form.
     */
    public function formUpdate(UpdateTimeEntryRequest $request, $id)
    {
        //
        if (! Gate::allows('time_entry_edit')) {
            return abort(401);
        }
        
        $time_entry = TimeEntry::findOrFail($id);
        $time_entry->update($request->all());
      
        
        
        return response()->json(['responseText' => 'Success!'], 200);
    }

}
