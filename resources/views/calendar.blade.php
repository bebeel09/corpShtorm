@extends('layouts.app')


@section('additional_css')

<!-- fullCalendar -->
<!-- <link rel="stylesheet" href="{{ asset('vendor_components/fullcalendar/dist/fullcalendar.css') }}"> -->
<link rel="stylesheet" href="{{ asset('vendor_components/fullcalendar/css/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endsection



@section('content')
<div class="post">
	<h3 class="post_title">Календарь событий</h3>
	<div id="calendar"></div>
</div>

@endsection

@section('additional_js')
<script src="{{asset('vendor_components/moment/moment.min.js') }}"></script>
<script src="{{asset('vendor_components/fullcalendar/js/fullcalendar.min.js') }}"></script>


<script>
	// Any value represanting monthly repeat flag
	var REPEAT_MONTHLY = 1;
	// Any value represanting yearly repeat flag
	var REPEAT_YEARLY = 2;
	

	$("#calendar").fullCalendar({
		slotDuration: "00:15:00",
		minTime: "08:00:00",
		maxTime: "19:00:00",
		defaultView: "month",
		handleWindowResize: !0,
		// height: $(window).height() - 480,

		// resources: eventData,
		events: {!!$eventData!!},
		editable: 0,
		droppable: 0,
		eventLimit: 3,
		selectable: !0,
		eventDurationEditable: !1,
		// themeSystem: "bootstrap4",
		eventClick: function(calEvent, jsEvent, view) {
			alert(calEvent.title);
		},
		dayRender: function(date, cell) {
			// Get all events
			var events = $('#calendar').fullCalendar('clientEvents').length ? $('#calendar').fullCalendar('clientEvents') : defaultEvents;
			// Start of a day timestamp
			var dateTimestamp = date.hour(0).minutes(0);
			var recurringEvents = new Array();

			// find all events with monthly repeating flag, having id, repeating at that day few months ago  
			var monthlyEvents = events.filter(function(event) {
				return event.repeats === REPEAT_MONTHLY &&
					event.id &&
					moment(event.start).hour(0).minutes(0).diff(dateTimestamp, 'months', true) % 1 == 0
			});

			// find all events with monthly repeating flag, having id, repeating at that day few years ago  
			var yearlyEvents = events.filter(function(event) {
				return event.repeats === REPEAT_YEARLY &&
					event.id &&
					moment(event.start).hour(0).minutes(0).diff(dateTimestamp, 'years', true) % 1 == 0
			});

			recurringEvents = monthlyEvents.concat(yearlyEvents);

			$.each(recurringEvents, function(key, event) {
				var timeStart = moment(event.start);

				// Refething event fields for event rendering 
				var eventData = {
					id: event.id,
					allDay: event.allDay,
					title: event.title,
					description: event.description,
					start: date.hour(timeStart.hour()).minutes(timeStart.minutes()).format("YYYY-MM-DD"),
					end: event.end ? event.end.format("YYYY-MM-DD") : "",
					url: event.url,
					className: event.className,
					repeats: event.repeats
				};

				// Removing events to avoid duplication
				$('#calendar').fullCalendar('removeEvents', function(event) {
					return eventData.id === event.id &&
						moment(event.start).isSame(date, 'day');
				});
				// Render event
				$('#calendar').fullCalendar('renderEvent', eventData, true);

			});

		}
	})
</script>
@endsection