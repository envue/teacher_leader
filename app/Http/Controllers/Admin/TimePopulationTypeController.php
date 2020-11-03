<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTimePopulationTypeRequest;
use App\Http\Requests\StoreTimePopulationTypeRequest;
use App\Http\Requests\UpdateTimePopulationTypeRequest;
use App\Models\TimePopulationType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TimePopulationTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('time_population_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TimePopulationType::with(['created_by'])->select(sprintf('%s.*', (new TimePopulationType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'time_population_type_show';
                $editGate      = 'time_population_type_edit';
                $deleteGate    = 'time_population_type_delete';
                $crudRoutePart = 'time-population-types';

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

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.timePopulationTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('time_population_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.timePopulationTypes.create');
    }

    public function store(StoreTimePopulationTypeRequest $request)
    {
        $timePopulationType = TimePopulationType::create($request->all());

        return redirect()->route('admin.time-population-types.index');
    }

    public function edit(TimePopulationType $timePopulationType)
    {
        abort_if(Gate::denies('time_population_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timePopulationType->load('created_by');

        return view('admin.timePopulationTypes.edit', compact('timePopulationType'));
    }

    public function update(UpdateTimePopulationTypeRequest $request, TimePopulationType $timePopulationType)
    {
        $timePopulationType->update($request->all());

        return redirect()->route('admin.time-population-types.index');
    }

    public function show(TimePopulationType $timePopulationType)
    {
        abort_if(Gate::denies('time_population_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timePopulationType->load('created_by');

        return view('admin.timePopulationTypes.show', compact('timePopulationType'));
    }

    public function destroy(TimePopulationType $timePopulationType)
    {
        abort_if(Gate::denies('time_population_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timePopulationType->delete();

        return back();
    }

    public function massDestroy(MassDestroyTimePopulationTypeRequest $request)
    {
        TimePopulationType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
