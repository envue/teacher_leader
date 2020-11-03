@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.timeEntry.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.time-entries.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="start_time">{{ trans('cruds.timeEntry.fields.start_time') }}</label>
                <input data-date-format="MM/DD/YYYY hh:mm A" class="form-control datetime {{ $errors->has('start_time') ? 'is-invalid' : '' }}" type="text" name="start_time" id="start_time" value="{{ old('start_time') }}" required>
                @if($errors->has('start_time'))
                    <span class="text-danger">{{ $errors->first('start_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.timeEntry.fields.start_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="end_time">{{ trans('cruds.timeEntry.fields.end_time') }}</label>
                <input data-date-format="MM/DD/YYYY hh:mm A" class="form-control datetime {{ $errors->has('end_time') ? 'is-invalid' : '' }}" type="text" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
                @if($errors->has('end_time'))
                    <span class="text-danger">{{ $errors->first('end_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.timeEntry.fields.end_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="work_type_id">{{ trans('cruds.timeEntry.fields.work_type') }}</label>
                <select class="form-control select2 {{ $errors->has('work_type') ? 'is-invalid' : '' }}" name="work_type_id" id="work_type_id" required>
                    @foreach($work_types as $id => $work_type)
                        <option value="{{ $id }}" {{ old('work_type_id') == $id ? 'selected' : '' }}>{{ $work_type }}</option>
                    @endforeach
                </select>
                @if($errors->has('work_type'))
                    <span class="text-danger">{{ $errors->first('work_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.timeEntry.fields.work_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="population_type_id">{{ trans('cruds.timeEntry.fields.population_type') }}</label>
                <select class="form-control select2 {{ $errors->has('population_type') ? 'is-invalid' : '' }}" name="population_type_id" id="population_type_id">
                    @foreach($population_types as $id => $population_type)
                        <option value="{{ $id }}" {{ old('population_type_id') == $id ? 'selected' : '' }}>{{ $population_type }}</option>
                    @endforeach
                </select>
                @if($errors->has('population_type'))
                    <span class="text-danger">{{ $errors->first('population_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.timeEntry.fields.population_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="caseload_type_id">{{ trans('cruds.timeEntry.fields.caseload_type') }}</label>
                <select class="form-control select2 {{ $errors->has('caseload_type') ? 'is-invalid' : '' }}" name="caseload_type_id" id="caseload_type_id">
                    @foreach($caseload_types as $id => $caseload_type)
                        <option value="{{ $id }}" {{ old('caseload_type_id') == $id ? 'selected' : '' }}>{{ $caseload_type }}</option>
                    @endforeach
                </select>
                @if($errors->has('caseload_type'))
                    <span class="text-danger">{{ $errors->first('caseload_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.timeEntry.fields.caseload_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.timeEntry.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.timeEntry.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.timeEntry.fields.notes') }}</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes') }}</textarea>
                @if($errors->has('notes'))
                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.timeEntry.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection