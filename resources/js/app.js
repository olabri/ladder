import './bootstrap';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import iCalendarPlugin from '@fullcalendar/icalendar';
import listPlugin from '@fullcalendar/list';

document.addEventListener('DOMContentLoaded', () => {
    const calendarElement = document.getElementById('events-calendar');

    if (!calendarElement) {
        return;
    }

    const calendar = new Calendar(calendarElement, {
        plugins: [dayGridPlugin, listPlugin, iCalendarPlugin],
        initialView: 'listSixMonths',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'listSixMonths,dayGridMonth',
        },
        views: {
            listSixMonths: {
                type: 'list',
                duration: { months: 6 },
                buttonText: '6 måneder',
            },
        },
        locale: 'nb',
        firstDay: 1,
        events: {
            url: calendarElement.dataset.icsUrl,
            format: 'ics',
        },
        eventDisplay: 'block',
        nowIndicator: true,
    });

    calendar.render();
});
