<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTimeEntryRequest;
use App\Http\Requests\StoreTimeEntryRequest;
use App\Http\Requests\UpdateTimeEntryRequest;
use App\Models\TimeCaseloadType;
use App\Models\TimeEntry;
use App\Models\TimePopulationType;
use App\Models\TimeWorkType;
use App\Models\User;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TimeEntryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('time_entry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TimeEntry::with(['work_type', 'population_type', 'caseload_type', 'created_by'])->select(sprintf('%s.*', (new TimeEntry)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'time_entry_show';
                $editGate      = 'time_entry_edit';
                $deleteGate    = 'time_entry_delete';
                $crudRoutePart = 'time-entries';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('work_type_name', function ($row) {
                return $row->work_type ? $row->work_type->name : '';
            });

            $table->addColumn('population_type_name', function ($row) {
                return $row->population_type ? $row->population_type->name : '';
            });

            $table->addColumn('caseload_type_name', function ($row) {
                return $row->caseload_type ? $row->caseload_type->name : '';
            });

            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            
            $table->editColumn('notes', function ($row) {
                return $row->notes ? $row->notes : "";
            });
            

            $table->rawColumns(['actions', 'placeholder', 'work_type', 'population_type', 'caseload_type']);

            return $table->make(true);
        }
              
        $time_work_types       = TimeWorkType::get();
        $time_population_types = TimePopulationType::get();
        $time_caseload_types   = TimeCaseloadType::get();
        $users                 = User::get();

        return view('admin.timeEntries.index', compact('time_work_types', 'time_population_types', 'time_caseload_types', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('time_entry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $work_types = TimeWorkType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $population_types = TimePopulationType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseload_types = TimeCaseloadType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.timeEntries.create', compact('work_types', 'population_types', 'caseload_types'));
    }

    public function store(StoreTimeEntryRequest $request)
    {
        $timeEntry = TimeEntry::create($request->all());

        return redirect()->route('admin.time-entries.index');
    }

    public function edit(TimeEntry $timeEntry)
    {
        abort_if(Gate::denies('time_entry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hidden_work_types = explode(',', Auth::user()->hidden_work_types);

        //Create an array of options with attributes
        $work_types = TimeWorkType::whereNotIn('id', $hidden_work_types)->get()
        ->mapWithKeys(function ($item) {
                        return [$item->id => ['name' => $item->name, 'title' => $item->description, 'use_caseload_type' => $item->use_caseload_type, 'use_population_type' => $item->use_population_type]];
                    })->all();

        $population_types = TimePopulationType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseload_types = TimeCaseloadType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $timeEntry->load('work_type', 'population_type', 'caseload_type', 'created_by');

        return view('admin.timeEntries.edit', compact('work_types', 'population_types', 'caseload_types', 'timeEntry'));
    }

    public function update(UpdateTimeEntryRequest $request, TimeEntry $timeEntry)
    {
        $timeEntry->update($request->all());

        return redirect()->route('admin.time-entries.index');
    }

    public function show(TimeEntry $timeEntry)
    {
        abort_if(Gate::denies('time_entry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeEntry->load('work_type', 'population_type', 'caseload_type', 'created_by');

        return view('admin.timeEntries.show', compact('timeEntry'));
    }

    public function destroy(TimeEntry $timeEntry)
    {
        abort_if(Gate::denies('time_entry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeEntry->delete();

        return back();
    }

    public function massDestroy(MassDestroyTimeEntryRequest $request)
    {
        TimeEntry::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
