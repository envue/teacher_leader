@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.timeWorkType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.time-work-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.timeWorkType.fields.id') }}
                        </th>
                        <td>
                            {{ $timeWorkType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeWorkType.fields.name') }}
                        </th>
                        <td>
                            {{ $timeWorkType->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeWorkType.fields.description') }}
                        </th>
                        <td>
                            {{ $timeWorkType->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeWorkType.fields.color') }}
                        </th>
                        <td>
                            {{ $timeWorkType->color }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeWorkType.fields.use_population_type') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $timeWorkType->use_population_type ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.timeWorkType.fields.use_caseload_type') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $timeWorkType->use_caseload_type ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.time-work-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection