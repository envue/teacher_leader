@extends('layouts.admin')
@section('content')
<!--<meta name="csrf-token" content="{{ csrf_token() }}">-->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css"/>
<style type="text/css"> 
    .bootstrap-switch { 
        float:right; margin-left: 10px; 
        margin-top: -5px; 
    }
    .fc-v-event {
        background-color: --primary!important;
        border-color: --primary!important;
    }
    .fc-v-event .fc-event-main {
        color: #ffffff!important;
    }
</style>
<div class="row">
    <div class="col-6">
        <h3 class="page-title">{{ trans('global.systemCalendar') }}</h3>
    </div>
    @can ('google_calendar_access')
    
    <div id="google-calendar-options" class="col-6">
        @isset ($googleCalendarID)
        <input id="google-calendar-toggle" style="float: right;" type="checkbox" data-toggle="switch" data-inverse="true">
        <h5 class="float-right">Google Calendar</h5>
        @else
        <a class="btn btn-primary float-right" style="margin-top: -5px;" href="{{ route('profile.password.edit') }}">
            Connect Google Calendar
        </a>
        @endisset
    </div>
    @endcan
</div>
<div class="card">
    <div class="card-body">
        <div id='calendar'></div>
    </div>
</div>
<!-- Create Event Modal -->
<div class="modal fade" id="ajaxModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="form">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modelHeading"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        
        <form id="eventForm" name="eventForm">
            <input type="hidden" name="event_id" id="event_id">
            <div class="row">
                <div class="col-md-6 col-xs-12 form-group">
                    <label class="required" for="start_time">{{ trans('cruds.timeEntry.fields.start_time') }}</label>
                    <input data-date-format="MM/DD/YYYY hh:mm A" class="form-control datetime" type="text" name="start_time" id="start_time" value="{{ old('start_time') }}" required>
                </div>
                <div class="col-md-6 col-xs-12 form-group">
                    <label class="required" for="end_time">{{ trans('cruds.timeEntry.fields.end_time') }}</label>
                    <input data-date-format="MM/DD/YYYY hh:mm A" class="form-control datetime" type="text" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-12">
                    <label class="required" for="work_type_id">{{ trans('cruds.timeEntry.fields.work_type') }}</label>
                    <select style="width: 100%;" class="form-control select2" name="work_type_id" id="work_type_id" placeholder="Please select" required>
                            <option></option>
                        @foreach($work_types as $id => $work_type) 
                            <option value="{{ $id }}" title="{{ $work_type['description'] ?? " " }}" population="{{ $work_type['use_population_type'] }}" caseload="{{ $work_type['use_caseload_type'] }}">{{ $work_type['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id= "population_caseload_row" class="row">
                <div id="population_type_field" class="form-group col-6">
                    <label for="population_type_id">{{ trans('cruds.timeEntry.fields.population_type') }}</label>
                    <select style="width: 100%;" class="form-control select2" name="population_type_id" id="population_type_id">
                        @foreach($population_types as $id => $population_type)
                            <option value="{{ $id }}">{{ $population_type }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="caseload_type_field" class="form-group col-6">
                    <label for="caseload_type_id">{{ trans('cruds.timeEntry.fields.caseload_type') }}</label>
                    <select style="width: 100%;" class="form-control select2" name="caseload_type_id" id="caseload_type_id">
                        @foreach($caseload_types as $id => $caseload_type)
                            <option value="{{ $id }}">{{ $caseload_type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.timeEntry.fields.description') }}</label>
                <input class="form-control" type="text" name="description" id="description" value="{{ old('description', '') }}" placeholder="Short description for this entry">
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.timeEntry.fields.notes') }}</label>
                <textarea class="form-control" rows="3" name="notes" placeholder="Additional information for this entry." id="notes">{{ old('notes') }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <div id="create-event-actions" class="form-group">   
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
            </div>
            <div id="update-event-actions" class="form-group">
                <button type="submit" class="btn btn-danger mr-auto" id="deleteBtn" value="delete">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="updateBtn" value="update">Save changes</button>
            </div>
        </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




@endsection

@section('scripts')
@parent
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>-->
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/gcal.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
<script>
        
        $(document).ready(function(){
            
            // Turn User Google Calendar On and Off
            $('#google-calendar-toggle').bootstrapSwitch({
                onSwitchChange: function(e, state) {
                    if (state) {
                        $('#calendar').fullCalendar( 'addEventSource', {
                            googleCalendarId: '{{$googleCalendarID}}',
                            className: 'gcal-event',
                            color: '#e7e7e7',
                            borderColor: '#d2d6de',
                            textColor: '#333333',
                        }); 
                    } else {
                        $('#calendar').fullCalendar( 'removeEventSource', '{{$googleCalendarID}}' );
                    }
                }
            });

            //Placeholder for work-type field
            $("#work_type_id").select2({
                placeholder: "Please select",
                allowClear: true
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            // Full calendar JS and Options
            var scrollTime = moment().format("HH") + ":00:00";

            $('#calendar').fullCalendar({
                googleCalendarApiKey: '{{$googleCalendarAPI}}',
                eventSources: [
                    '{{ url('admin/system-calendar/getevents') }}',                 
                ],
                // put your options and callbacks here
                header: {
                    right: 'prev,next today',
                    center: 'title',
                    left: 'month,agendaWeek,agendaDay',
                },
                textColor:'#ffffff',
                defaultView: 'agendaWeek',
                allDaySlot: false,
                minTime: "06:00:00",
                selectable: true,
                selectHelper: true,
                selectOverlap: false,
                editable: true,
                slotDuration: '00:15:00',
                height: 700,
                eventOverlap: false,
                weekends: false,

                // When calendar event is clicked
                eventClick: function(calEvent, jsEvent, view) {
                    var startDate = moment(calEvent.start).format('MM/DD/YYYY hh:mm A');
                    var endDate = moment(calEvent.end).format('MM/DD/YYYY hh:mm A');
                    jsEvent.preventDefault();
                    
                    $('#eventForm').trigger("reset");
                    $('#eventForm #start_time').val(startDate);
                    $('#eventForm #end_time').val(endDate);
                    $('#ajaxModal').modal();
                    
                    //check if this is a system event or Google event and return appropirate actions & field values
                    
                    if (calEvent.work_type){
                        
                        $('#modelHeading').html("Edit Entry");
                        $('#eventForm #work_type_id').val(calEvent.work_type).change();
                        $('#eventForm #population_type_id').val(calEvent.population_type).change();
                        $('#eventForm #caseload_type_id').val(calEvent.caseload_type).change();
                        $('#eventForm #description').val(calEvent.description);
                        $('#eventForm #notes').val(calEvent.notes);
                        $('#eventForm #event_id').val(calEvent.id);
                        $('#create-event-actions').hide();
                        $('#update-event-actions').show();
                    }

                    else {

                        $('#modelHeading').html("Copy Google Event");
                        $('#eventForm #work_type_id').change();
                        $('#eventForm #population_type_id').change();
                        $('#eventForm #caseload_type_id').change();
                        $('#eventForm #notes').val(calEvent.description);
                        $('#eventForm #description').val(calEvent.title);
                        $('#update-event-actions').hide();
                        $('#create-event-actions').show();
                        $('#saveBtn').html('Copy event');
                    } 
                },
                
                // When calendar event is dropped to new location
                eventDrop: function(calEvent, delta, revertFunc) {

                    var startDate = moment(calEvent.start).format('YYYY-MM-DD HH:mm:ss');
                    var endDate = moment(calEvent.end).format('YYYY-MM-DD HH:mm:ss');

                    $.ajax({
                        type:'POST',
                        url: 'system-calendar/' + calEvent.id,
                        dataType:"json",
                        data: {
                            _method : "PUT",
                            'start_time': startDate,
                            'end_time': endDate,   
                        },
                        success: function(response){
                            console.log(response);
                        }
                    });
                },

                // When calendar event is resized
                eventResize: function(calEvent, delta, revertFunc) {

                    var startDate = moment(calEvent.start).format('YYYY-MM-DD HH:mm:ss');
                    var endDate = moment(calEvent.end).format('YYYY-MM-DD HH:mm:ss');

                    $.ajax({
                        type:'POST',
                        url: 'system-calendar/' + calEvent.id,
                        dataType:"json",
                        data: {
                            _method : "PATCH",
                            'start_time': startDate,
                            'end_time': endDate,    
                        },
                        success: function(response){
                            console.log(response);
                        }
                    });
                }, 

                //When time slot is selected by clicking and dragging
                select: function(start, end) {
                    var startDate = moment(start).format('MM/DD/YYYY hh:mm A');
                    var endDate = moment(end).format('MM/DD/YYYY hh:mm A');
                    
                    $('#eventForm').trigger("reset");
                    $('#modelHeading').html("Create New Entry");
                    $('#event_id').val('');
                    $('#work_type_id').change();
                    $('#population_type_id').change();
                    $('#caseload_type_id').change();
                    $(".modal-body #start_time").val(startDate);
                    $(".modal-body #end_time").val(endDate);
                    $('#update-event-actions').hide();
                    $('#create-event-actions').show();
                    $('#saveBtn').html('Create Event')
                    $('#ajaxModal').modal();
                }
            });
            // end of full calendar script and options

            
            // Create or Update Events via Ajax
            $('#eventForm').submit(function (e) {
                e.preventDefault();

                id = $("#event_id").val();
                
                //check if event is new or existing and assign variables
                if (id == ""){
                    var url = "{{ route('admin.system-calendar.store') }}";
                    var type = "POST";
                } else {
                    var url = 'system-calendar/form_update/' + id;
                    var type = "PUT";
                }   
                
                //process ajax request
                $.ajax({
                    data: $('#eventForm').serialize(),
                    url: url,
                    type: type,
                    dataType: 'json',
                    success: function (data) {
                
                        $('#eventForm').trigger("reset");
                        $("#ajaxModal").modal('hide');
                        $('#calendar').fullCalendar( 'refetchEvents' );
                        console.log(data);
                    
                    }
                });
            });
            
            // Delete Event Ajax
            $('#deleteBtn').click(function (e) {
                e.preventDefault();
                id = $("#event_id").val()
                didConfirm = confirm("Are you sure you want to permanently delete this entry?")

                $.ajax({
                    data: $('#eventForm').serialize(),
                    type:"DELETE",
                    url:'system-calendar/' + id,
                    dataType: 'json',
                    success: function (data) {
                
                        $('#eventForm').trigger("reset");
                        $("#ajaxModal").modal('hide');
                        $('#calendar').fullCalendar( 'refetchEvents' );
                    
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            //Conditionally show/hide fields based on work type options
            $("#work_type_id").change(function () {
             var caseload = $('option:selected', this).attr('caseload');
             var population =$('option:selected', this).attr('population');

                if (caseload == 1) {
                    $('#caseload_type_field').show();
                } else {
                    $('#caseload_type_field').hide();
                    $('#caseload_type_id').val('').trigger('change');
                }
                if (population == 1) {
                    $('#population_type_field').show();
                } else {
                    $('#population_type_field').hide();
                    $('#population_type_id').val('').trigger('change')
                };
                
            }).change(); // automatically execute the on change function on page load
        });
    </script>
@stop