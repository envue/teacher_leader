@extends('layouts.admin')
@section('content')

@can('time_work_type_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <h3>Work types</h3>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8">
                <h5 class="font-weight-bold">My custom work types <br>
                <small class="text-muted">Define custom work types for time entries and reports.</small>
                </h5>
            </div>
            <div class="col-sm-4">
                <a class="btn btn-success btn-inline float-right" style="margin-top:10px;" href="{{ route('admin.time-work-types.create') }}">
                   + Add custom work type
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-TimeWorkType">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    @can('user_edit')
                    <th>
                        {{ trans('cruds.timeWorkType.fields.id') }}
                    </th>
                    @endcan
                    <th>
                        {{ trans('cruds.timeWorkType.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.timeWorkType.fields.description') }}
                    </th>
                    <th>
                        {{ trans('cruds.timeWorkType.fields.color') }}
                    </th>
                    <th>
                        Use Pop
                    </th>
                    <th>
                        Use Case
                    </th>
                    @can('user_edit')
                    <th>
                        System
                    </th>
                    @endcan
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-12">    
        <div class="card">
            <div class="card-header">
                <h5 class="font-weight-bold">System work types <br>
                <small class="text-muted">Show or hide the default system work types on time entry forms and report filters. 
                    Turning off a work type will not delete any time entries. 
                    Time entries already associated with these work types will continue to display on the calendar and reports.</small>
                </h5>
            </div>

            <div class="card-body">                
                <form method="POST" action="{{ route("profile.password.updateHiddenWorkTypes") }}">
                @csrf
                <div class="table-responsive">
                    <table class="table table-condensed  table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Work type</th>
                                <th>Description</th>
                                <th>Color</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($system_work_types as $id => $system_work_type)
                            <tr>
                                <td class="text-nowrap"> 
                                    <input class="switch-input" type="checkbox" id="{{ $system_work_type['name'] }}-{{ $id }}" name="hidden_work_types[]" value="{{ $id }}" data-toggle="toggle" data-size="sm">
                                    <label class="switch-label" style="font-style: strong; margin-left: 5px;"for="{{ $system_work_type['name'] }}">{{ $system_work_type['name'] }}</label>
                                </td>
                                <td>
                                    {{ $system_work_type['description'] }}
                                </td>
                                <td>
                                    <h5><span style="background-color:{{ $system_work_type['color'] }}; color: #ffffff;" class="badge">  {{ $system_work_type['color'] }}  </span></h5>
                                </td>
                            </tr>
                            @endforeach
                                                      
                        </tbody>
                    </table>
                </div>
                <div class="form-group" style="margin-bottom: 0px">
                    <button class="btn btn-danger" type="submit">
                        Save Settings
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    //Toogle Switches
    $('.switch-input').bootstrapToggle({
        on: 'Off',
        off: 'On',
        onstyle: 'light',
        offstyle: 'primary'
        });

    $('.switch-input').each(function( i ) {
    var val = $(this).val();
    var hiddenWorkTypes = "{{ $user_hidden_work_types }}";

    if (hiddenWorkTypes.includes(val) ) {
        $(this).bootstrapToggle('on');
    } 
    });
    
    //Datatables
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('time_work_type_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.time-work-types.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id
            });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}')

                return
            }

            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                headers: {'x-csrf-token': _token},
                method: 'POST',
                url: config.url,
                data: { ids: ids, _method: 'DELETE' }})
                .done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        let dtOverrideGlobals = {
            dom:
                @can('user_edit')
                "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                @endcan
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-4'i><'col-sm-8'p>>", 
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('admin.time-work-types.index') }}",
            columns: [
                { data: 'placeholder', name: 'placeholder' },
                @can('user_edit')
                { data: 'id', name: 'id' },
                @endcan
                { data: 'name', name: 'name', className: 'text-nowrap' },
                { data: 'description', name: 'description' },
                { data: 'color', name: 'color' },
                { data: 'use_population_type', name: 'use_population_type' },
                { data: 'use_caseload_type', name: 'use_caseload_type' },
                @can('user_edit')
                { data: 'system_value', name: 'system_value' },
                @endcan
                { data: 'actions', name: '{{ trans('global.actions') }}' }
                    ],
                    orderCellsTop: true,
                    order: [[ 1, 'desc' ]],
                    pageLength: 100,
        };
        let table = $('.datatable-TimeWorkType').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection