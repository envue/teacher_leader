<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTimeWorkTypeRequest;
use App\Http\Requests\StoreTimeWorkTypeRequest;
use App\Http\Requests\UpdateTimeWorkTypeRequest;
use App\Models\TimeWorkType;
use App\Models\TimeEntry;
use Auth;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TimeWorkTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('time_work_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        //Create an array of options with attributes
        $user_hidden_work_types = explode(',', Auth::user()->hidden_work_types);
        
        $system_work_types = TimeWorkType::where('system_value', '=', 1)->get()
        ->mapWithKeys(function ($item) use ($user_hidden_work_types) {
                        return [$item->id => ['name' => $item->name, 'description' => $item->description, 'color' => $item->color, 'use_caseload_type' => ($item->use_caseload_type ? 'checked' : null), 
                        'use_population_type' => ($item->use_population_type ? 'checked' : null), 'checked' => (in_array($item->id, $user_hidden_work_types) ? 'checked': null)]];
                    })->all();;

        if ($request->ajax()) {
            
            if (auth()->user()->roles->contains(1)) { 
                $query = TimeWorkType::with(['created_by'])->select(sprintf('%s.*', (new TimeWorkType)->table));
            } else {
                $query = TimeWorkType::with(['created_by'])->where('created_by_id', '=', Auth::user()->id)->select(sprintf('%s.*', (new TimeWorkType)->table));
            }
            
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');


            $table->editColumn('actions', function ($row) {
                $viewGate      = 'time_work_type_show';
                $editGate      = 'time_work_type_edit';
                $deleteGate    = 'time_work_type_delete';
                $crudRoutePart = 'time-work-types';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });
            
            
            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            
            
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            
            $table->editColumn('color', function ($row) {
                return '<span style="background-color:'.($row->color).'; color: #ffffff;" class="badge">'.($row->color).'</span>';
            });
            $table->editColumn('use_population_type', function ($row) {
                return '<input type="checkbox" style="pointer-events: none;" ' . ($row->use_population_type ? 'checked' : null) . ' disabled >';
            });
            $table->editColumn('use_caseload_type', function ($row) {
                return '<input type="checkbox" style="pointer-events: none;" ' . ($row->use_caseload_type ? 'checked' : null) . ' disabled >';
            });

            $table->editColumn('system_value', function ($row) {
                return '<input type="checkbox" style="pointer-events: none;"  ' . ($row->system_value ? 'checked' : null) . ' disabled >';
            });

            $table->rawColumns(['actions', 'placeholder', 'use_population_type', 'use_caseload_type', 'system_value', 'color']);

            return $table->make(true);
        }

        return view('admin.timeWorkTypes.index', compact('system_work_types','user_hidden_work_types'));
    }

    public function create()
    {
        abort_if(Gate::denies('time_work_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.timeWorkTypes.create');
    }

    public function store(StoreTimeWorkTypeRequest $request)
    {
        $timeWorkType = TimeWorkType::create($request->all());

        return redirect()->route('admin.time-work-types.index');
    }

    public function edit(TimeWorkType $timeWorkType)
    {
        abort_if(Gate::denies('time_work_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeWorkType->load('created_by');

        return view('admin.timeWorkTypes.edit', compact('timeWorkType'));
    }

    public function update(UpdateTimeWorkTypeRequest $request, TimeWorkType $timeWorkType)
    {
        $timeWorkType->update($request->all());

        return redirect()->route('admin.time-work-types.index');
    }

    public function show(TimeWorkType $timeWorkType)
    {
        abort_if(Gate::denies('time_work_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeWorkType->load('created_by');

        return view('admin.timeWorkTypes.show', compact('timeWorkType'));
    }

    public function destroy(TimeWorkType $timeWorkType)
    {
        abort_if(Gate::denies('time_work_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        
        $relatedTimeEntries = TimeEntry::where('work_type_id', $timeWorkType->id)->count();
        
        if ($relatedTimeEntries > 0) {
            return back()->with('error','Cannot delete: this work type is used in '.$relatedTimeEntries.' time entries. First update or delete those time entries.');
        } 

        $timeWorkType->delete();

        return back();
        
    }

    public function massDestroy(MassDestroyTimeWorkTypeRequest $request)
    {
        TimeWorkType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
