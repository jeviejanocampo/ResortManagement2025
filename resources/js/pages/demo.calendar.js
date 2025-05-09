import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    function getInitialView() {
        if(window.innerWidth >=768 && window.innerWidth < 1200) {
            return 'timeGridWeek';
        } else if(window.innerWidth <= 768) {
            return 'listMonth';
        } else {
            return 'dayGridMonth';
        }
    }

    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        timeZone: 'local',
        editable: true,
        selectable: true,
        initialView: getInitialView(),
        themeSystem: 'bootstrap',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        initialDate: new Date(),
        weekNumbers: true,
        dayMaxEvents: true,
        handleWindowResize: true,
        events: [
            
        ],
        dateClick: function(info) {
            // const checkInInput = document.getElementById('check_in_datepickr');
            // checkInInput._flatpickr.setDate(info.dateStr);

            const modal = new bootstrap.Modal(document.getElementById('booking-modal'));
            modal.show();
        }
    });
    calendar.render();
});