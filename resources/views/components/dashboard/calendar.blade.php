<!-- Include FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css" rel="stylesheet">

<!-- FullCalendar Script -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        if (!calendarEl) {
            console.error("Calendar element not found!");
            return;
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            aspectRatio: 2, // Adjust as needed
            height: 'auto'  // Makes the calendar fit inside its container
        });

        calendar.render();
    });
</script>

<!-- Page Layout -->
<div class="flex h-screen">
    <div class="flex-1 flex flex-col">
        <nav class="bg-white p-4 shadow-md flex justify-center items-center">
            <h2 class="text-lg font-semibold">Admin</h2>
        </nav>

        <div class="flex-1 p-6 bg-gray-400 overflow-hidden">
            <!-- Calendar Container -->
            <div id="calendar" class="bg-white p-4 rounded-lg shadow w-full h-full min-h-[500px]"></div>
        </div>
    </div>
</div>
