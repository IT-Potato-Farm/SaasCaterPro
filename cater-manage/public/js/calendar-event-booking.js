function openPenaltyModal(orderId) {
    document.getElementById(`penaltyModal-${orderId}`).classList.remove('hidden');
}

function closePenaltyModal(orderId) {
    document.getElementById(`penaltyModal-${orderId}`).classList.add('hidden');
}

function formatTime(timeString) {
    if (!timeString) return '';
    const [hours, minutes, seconds] = timeString.split(':');
    const date = new Date();
    date.setHours(hours);
    date.setMinutes(minutes);
    date.setSeconds(seconds);
    return date.toLocaleTimeString([], {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const events = window.calendarEvents || [];

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        events: events,
        contentHeight: 'auto',
        eventOrder: 'start',
        eventClassNames: 'hover:shadow transition-shadow text-xs sm:text-sm',
        dayHeaderClassNames: 'text-gray-700 font-semibold',
        eventContent: function (arg) {
            const title = arg.event.title;
            const startTime = formatTime(arg.event.extendedProps.start_time);
            const endTime = formatTime(arg.event.extendedProps.end_time);

            return {
                html: `<div class="px-1 sm:px-2 py-1 text-xs sm:text-sm font-medium">
                    ${title}<br>
                    <span class="text-[10px] sm:text-xs text-white">${startTime} - ${endTime}</span>
                </div>`
            };
        },
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
        },
        buttonText: {
            today: 'Today'
        },
        dayMaxEventRows: 3,
        fixedWeekCount: false,
        initialDate: new Date(),
        themeSystem: 'bootstrap5',
        windowResize: function () {
            const view = window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth';
            calendar.changeView(view);
        }
    });

    calendar.render();
});
