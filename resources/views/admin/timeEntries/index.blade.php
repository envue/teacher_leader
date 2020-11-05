@extends('layouts.admin')
@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h3 class="page-title">Time entries</h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
        <div class="card-header">
                {{ trans('cruds.timeEntry.title_singular') }} {{ trans('global.list') }}
            </div>   
            <div class="card-body">
                <table id="Table" class="table table-bordered table-striped table-hover ajaxTable datatable datatable-TimeEntry">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.timeEntry.fields.start_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.timeEntry.fields.end_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.timeEntry.fields.work_type') }}
                            </th>
                            <th>
                                {{ trans('cruds.timeEntry.fields.population_type') }}
                            </th>
                            <th>
                                {{ trans('cruds.timeEntry.fields.caseload_type') }}
                            </th>
                            <th>
                                {{ trans('cruds.timeEntry.fields.description') }}
                            </th>
                            
                            <th>
                                {{ trans('cruds.timeEntry.fields.notes') }}
                            </th>
                            
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                        
                        <!--
                        <tr>
                            <td>
                            </td>
                            <td>
                                <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <select class="search">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach($time_work_types as $key => $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="search">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach($time_population_types as $key => $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="search">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach($time_caseload_types as $key => $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            <td>
                                <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                            </td>
                            
                            <td>
                            </td>
                        </tr>
                        -->
                    </thead>
                </table>
            
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('time_entry_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.time-entries.massDestroy') }}",
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
    buttons: dtButtons,
    responsive: true,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.time-entries.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'start_time', name: 'start_time' },
{ data: 'end_time', name: 'end_time' },
{ data: 'work_type_name', name: 'work_type.name' },
{ data: 'population_type_name', name: 'population_type.name' },
{ data: 'caseload_type_name', name: 'caseload_type.name' },
{ data: 'description', name: 'description' },
{ data: 'notes', name: 'notes' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-TimeEntry').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
  /*
  $('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value
      table
        .column($(this).parent().index())
        .search(value, strict)
        .draw()
  });
  */
});

</script>
@endsection