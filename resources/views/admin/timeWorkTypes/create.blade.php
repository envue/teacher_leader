@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.min.css"/>
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.timeWorkType.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.time-work-types.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.timeWorkType.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.timeWorkType.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.timeWorkType.fields.description') }}</label>
                <span class="help-block">(optional)</span>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="color">Calendar Color</label>
                <span class="help-block">(optional - defaults to blue)</span>
                <div id="color-picker" class="input-group my-colorpicker2 colorpicker-element col-6" data-colorpicker-id="2" style="margin-bottom:10px;">
                    <input type="text" autocomplete="off" class="form-control" data-original-title="Color" title="Color" name="color" id="color" value="#007BFF" {{ old('color', '') }}>
                        <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                        </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('use_population_type') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="use_population_type" value="0">
                    <input class="form-check-input" type="checkbox" name="use_population_type" id="use_population_type" value="1" {{ old('use_population_type', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="use_population_type">{{ trans('cruds.timeWorkType.fields.use_population_type') }}</label>
                </div>
                @if($errors->has('use_population_type'))
                    <span class="text-danger">{{ $errors->first('use_population_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.timeWorkType.fields.use_population_type_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('use_caseload_type') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="use_caseload_type" value="0">
                    <input class="form-check-input" type="checkbox" name="use_caseload_type" id="use_caseload_type" value="1" {{ old('use_caseload_type', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="use_caseload_type">{{ trans('cruds.timeWorkType.fields.use_caseload_type') }}</label>
                </div>
                @if($errors->has('use_caseload_type'))
                    <span class="text-danger">{{ $errors->first('use_caseload_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.timeWorkType.fields.use_caseload_type_helper') }}</span>
            </div>
            @can('user_management_access')
            <div class="form-group">
                <div class="form-check {{ $errors->has('system_value') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="system_value" value="0">
                    <input class="form-check-input" type="checkbox" name="system_value" id="system_value" value="1" {{ old('system_value', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="system_value">System Value</label>
                </div>
                @if($errors->has('system_value'))
                    <span class="text-danger">{{ $errors->first('system_value') }}</span>
                @endif
                <span class="help-block">Creates a system wide value that is available to all users</span>
            </div>
            @endcan
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript">

$(function () {

    //color picker with addon
    $('.my-colorpicker2').colorpicker({
        fallbackColor: '#007bff',
        extensions: [
        {
          name: 'swatches', // extension name to load
          options: { // extension options
            colors: {
              'blue': '#007bff',
              'green': '#28a745',
              'red': '#dc3545',
              'indigo': '#6610f2',
              'maroon': '#d81b60',
              'navy': '#001f3f',
              'lightblue': '#3c8dbc',
              'orange': '#ff851b',
              'teal': '#39cccc',
              'purple': '#605ca8',
              'pink': '#e83e8c',
              'olive': '#3d9970',
              'gray': '#343a40',
              'black': '#000000'
            },
            namesAsValues: false
          }
        }
      ]
    });

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

  })
</script>
@endsection