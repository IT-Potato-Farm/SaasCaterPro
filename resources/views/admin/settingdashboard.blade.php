<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SET SERVICE TIME</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('js/toprightalert.js') }}"></script>
</head>

<body>



    @if (session('success'))
        <script>
            showSuccessToast('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            showErrorToast('{{ session('error') }}');
        </script>
    @endif
    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                {{-- <x-dashboard.header /> --}}

                <div class="container mx-auto px-4 py-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800">Adjust Service Time </h1>
                        </div>



                        <form action="{{ route('admin.booking-settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Service Start Time -->
                                <div>
                                    <label for="service_start_time"
                                        class="block text-sm font-medium text-gray-700 mb-1">
                                        Service Start Time
                                    </label>
                                    <input type="time" id="service_start_time" name="service_start_time"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        value="{{ old('service_start_time', $setting && $setting->service_start_time ? \Carbon\Carbon::parse($setting->service_start_time)->format('H:i') : '08:00') }}"
                                        required>
                                    @error('service_start_time')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Service End Time -->
                                <div>
                                    <label for="service_end_time" class="block text-sm font-medium text-gray-700 mb-1">
                                        Service End Time
                                    </label>
                                    <input type="time" id="service_end_time" name="service_end_time"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        value="{{ old('service_end_time', $setting && $setting->service_end_time ? \Carbon\Carbon::parse($setting->service_end_time)->format('H:i') : '20:00') }}"
                                        required>
                                    @error('service_end_time')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Events Per Day -->
                            <div class="mb-6">
                                <label for="events_per_day" class="block text-sm font-medium text-gray-700 mb-1">
                                    Maximum Events Per Day
                                </label>
                                <input type="number" id="events_per_day" name="events_per_day" min="1"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('events_per_day', $setting ? $setting->events_per_day : 2) }}"
                                    required>
                                @error('events_per_day')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <label for="rest_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Rest Time Between Events (in minutes)
                                </label>
                                <input type="number" name="rest_time" id="rest_time"
                                    value="{{ old('rest_time', $setting->rest_time ?? 60) }}"
                                    class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            </div>

                            <!-- Blocked Dates -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Blocked Dates (Unavailable for Booking)
                                </label>
                                <div id="blocked-dates-container">
                                    @foreach ($setting->blocked_dates ?? [] as $index => $date)
                                        <div class="flex items-center mb-2 blocked-date-row">
                                            <input type="text" name="blocked_dates[]" placeholder="Select a date"
                                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 hover:cursor-pointer focus:ring-blue-500 blocked-date-picker"
                                                value="{{ $date }}">
                                            <button type="button"
                                                class="ml-2 text-red-500 remove-date-btn hover:cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-blocked-date"
                                    class="mt-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded hover:cursor-pointer inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Add Date
                                </button>
                                @error('blocked_dates')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                @error('blocked_dates.*')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline hover:cursor-pointer">
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const container = document.getElementById('blocked-dates-container');

                        // Initialize Flatpickr for all existing inputs
                        function initFlatpickrForInputs() {
                            container.querySelectorAll('.blocked-date-picker').forEach(input => {
                                flatpickr(input, {
                                    dateFormat: "Y-m-d",
                                    minDate: "today",
                                    disableMobile: true
                                });
                            });
                        }

                        initFlatpickrForInputs();

                        // Add new date field
                        document.getElementById('add-blocked-date').addEventListener('click', function() {
                            const newDateRow = document.createElement('div');
                            newDateRow.className = 'flex items-center mb-2 blocked-date-row';
                            newDateRow.innerHTML = `
            <input type="text"
                   name="blocked_dates[]"
                   placeholder="Select a date"
                   class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 hover:cursor-pointer focus:ring-blue-500 blocked-date-picker">
            <button type="button"
                    class="ml-2 text-red-500 remove-date-btn hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        `;
                            container.appendChild(newDateRow);

                            // Initialize Flatpickr on the new input
                            flatpickr(newDateRow.querySelector('.blocked-date-picker'), {
                                dateFormat: "Y-m-d",
                                minDate: "today",
                                disableMobile: true
                            });

                            // Add event listener to new remove button
                            newDateRow.querySelector('.remove-date-btn').addEventListener('click', function() {
                                container.removeChild(newDateRow);
                            });
                        });

                        // Attach remove logic to existing buttons
                        container.querySelectorAll('.remove-date-btn').forEach(button => {
                            button.addEventListener('click', function() {
                                const row = this.closest('.blocked-date-row');
                                row.parentNode.removeChild(row);
                            });
                        });
                    });
                </script>

            </main>
        </div>

    </div>
</body>

</html>
