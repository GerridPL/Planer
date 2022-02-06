@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <h1 class="display-3 text-center">
                <i class="fas fa-calendar-alt"></i>
                Kalendarz
            </h1>
        </div>
    </div>
</div>
<hr><br>
<div id='calendar'></div>
@endsection

@section('js-scripts')
<script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        dayHeaderFormat: { weekday: 'long' },
        headerToolbar: {
            left: 'prev,next,today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,dayGridDay'
        },
        buttonText:
        {
            today: 'Dzisiaj',
            dayGridMonth: 'Miesiąc',
            dayGridWeek: 'Tydzień',
            dayGridDay: 'Dzień'
        },
        initialView: 'dayGridMonth',
        eventSources:[
            {
                url:'http://127.0.0.1:8000/calendar/0/getChecklists',
                method: 'GET',
                color: '#DB292F'
            },
            {
                url:'http://127.0.0.1:8000/calendar/1/getChecklists',
                method: 'GET',
                color: '#33B380'
            },
        ]
        });
        calendar.setOption('firstDay', 1);                // ustawienie pierwszego dnia tygodnia
        calendar.setOption('height', 650);                // wysokosc klendarza
        calendar.setOption('locale', 'pl');               // jezyk kalendarza
        calendar.setOption('displayEventTime', false);    // usuwa godziny
        calendar.setOption('navLinks', true);
        calendar.render();
    });

  </script>


@endsection
