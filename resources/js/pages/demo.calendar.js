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
        editable: false,
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
        events: `/room/${roomId}/events`,
        eventClick: function(info) {
            alert(info.event.title);            
        },
        dateClick: function(info) {
            const events = calendar.getEvents();
            const clickedDate = new Date(info.date).setHours(0, 0, 0, 0);
        
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (clickedDate < today) {
                return;
            }
        
            const isBooked = events.some(event => {
                const eventStart = new Date(event.start).setHours(0, 0, 0, 0);
                const eventEnd = new Date(event.end).setHours(0, 0, 0, 0);
                return clickedDate >= eventStart && clickedDate < eventEnd;
            });
        
            if (!isBooked) {
                const checkInInput = document.getElementById('check_in_date');
                checkInInput.value = info.dateStr;
                const modal = new bootstrap.Modal(document.getElementById('booking-modal'));
                modal.show();
            }
        },
        eventDidMount: function(info) {
            info.el.style.cursor = 'pointer';
        }
    });
    calendar.render();
});