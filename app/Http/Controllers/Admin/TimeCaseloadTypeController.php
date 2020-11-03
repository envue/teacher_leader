<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTimeCaseloadTypeRequest;
use App\Http\Requests\StoreTimeCaseloadTypeRequest;
use App\Http\Requests\UpdateTimeCaseloadTypeRequest;
use App\Models\TimeCaseloadType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TimeCaseloadTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('time_caseload_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TimeCaseloadType::with(['created_by'])->select(sprintf('%s.*', (new TimeCaseloadType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'time_caseload_type_show';
                $editGate      = 'time_caseload_type_edit';
                $deleteGate    = 'time_caseload_type_delete';
                $crudRoutePart = 'time-caseload-types';

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

        return view('admin.timeCaseloadTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('time_caseload_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.timeCaseloadTypes.create');
    }

    public function store(StoreTimeCaseloadTypeRequest $request)
    {
        $timeCaseloadType = TimeCaseloadType::create($request->all());

        return redirect()->route('admin.time-caseload-types.index');
    }

    public function edit(TimeCaseloadType $timeCaseloadType)
    {
        abort_if(Gate::denies('time_caseload_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeCaseloadType->load('created_by');

        return view('admin.timeCaseloadTypes.edit', compact('timeCaseloadType'));
    }

    public function update(UpdateTimeCaseloadTypeRequest $request, TimeCaseloadType $timeCaseloadType)
    {
        $timeCaseloadType->update($request->all());

        return redirect()->route('admin.time-caseload-types.index');
    }

    public function show(TimeCaseloadType $timeCaseloadType)
    {
        abort_if(Gate::denies('time_caseload_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeCaseloadType->load('created_by');

        return view('admin.timeCaseloadTypes.show', compact('timeCaseloadType'));
    }

    public function destroy(TimeCaseloadType $timeCaseloadType)
    {
        abort_if(Gate::denies('time_caseload_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timeCaseloadType->delete();

        return back();
    }

    public function massDestroy(MassDestroyTimeCaseloadTypeRequest $request)
    {
        TimeCaseloadType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
