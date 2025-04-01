<div class="container mx-auto px-4 py-8">
    <div class="flex border flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0 ">All Bookings</h1>
        <div class="flex space-x-3">
            <!-- Refresh -->
            <a href="#"@click.prevent="window.location.href = '{{ route('admin.admindashboard') }}?activeScreen=bookings'"
                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Refresh
            </a>

            <!-- Export -->
            <button
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Export
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <form id="filterForm" action="{{ route('orders.filter') }}" method="GET"
            class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="col-span-1">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partially Paid
                    </option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>
            </div>

            <div class="col-span-1">
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div class="col-span-1">
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div class="col-span-1 flex items-end">
                <button type="submit"
                    class="inline-flex justify-center w-full px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                    Filter Results
                </button>
            </div>
        </form>
    </div>

    @if ($orders->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="w-20 h-20 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                </path>
            </svg>
            <h3 class="mt-4 text-xl font-medium text-gray-900">No bookings found</h3>
            <p class="mt-2 text-gray-600">Try adjusting your search or filter parameters</p>
            <div class="mt-6">
                <a href="{{ route('admin.admindashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                    Reset Filters
                </a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow">
            <div class="px-4 sm:px-6 lg:px-8">
                <table id="ordersTable" class="min-w-full divide-y divide-gray-200 ">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Event Details
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors"
                                data-status="{{ strtolower($order->status) }}"
                                data-date="{{ \Carbon\Carbon::parse($order->event_date)->format('Y-m-d') }}">
                                <!-- Booking ID -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('order.show', $order->id) }}"
                                        class="hover:underline text-sm font-medium text-gray-900">
                                        #{{ $order->id }}
                                    </a>
                                    <div class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</div>
                                </td>

                                <!-- Customer Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $order->user->first_name }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Event Details -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->event_type }}</div>
                                    <div class="flex items-center text-xs text-gray-500 mt-1">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($order->event_date)->format('M d, Y') }}
                                    </div>
                                </td>

                                <!-- Total -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-medium text-gray-900">
                                        ₱{{ number_format($order->total, 2) }}
                                    </div>
                                    @if ($order->deposit_amount)
                                        <div class="text-xs text-gray-500">
                                            Deposit: ₱{{ number_format($order->deposit_amount, 2) }}
                                        </div>
                                    @endif

                                    @if ($order->penalty_fee > 0)
                                        <div class="text-xs text-red-500">
                                            Penalty: +₱{{ number_format($order->penalty_fee, 2) }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusStyles = [
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                            'partially paid' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                            'ongoing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                            'paid' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                            'completed' => ['bg' => 'bg-green-200', 'text' => 'text-green-800'],
                                            'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                        ];
                                        $status = $statusStyles[$order->status] ?? [
                                            'bg' => 'bg-gray-100',
                                            'text' => 'text-gray-800',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $status['bg'] }} {{ $status['text'] }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        {{-- Invoice --}}
                                        <a href="{{ route('order.invoice', $order->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 px-2 py-1 rounded-md hover:bg-indigo-50 transition-colors"
                                            title="Generate Invoice">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </a>

                                        {{-- Ongoing Action --}}
                                        @if ($order->status !== 'ongoing' && $order->status !== 'cancelled' && $order->status !== 'paid')
                                            <form action="{{ route('orders.mark-ongoing', $order->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-blue-600 hover:text-blue-900 px-2 py-1 rounded-md hover:bg-blue-50 transition-colors"
                                                    title="Mark as Ongoing">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 4v5h.582m15.836 2A9 9 0 111 12a9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Partially Paid Action --}}
                                        @if ($order->status !== 'partial' && $order->status !== 'cancelled' && $order->status !== 'paid')
                                            <form action="{{ route('orders.mark-partial', $order->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-orange-600 hover:text-orange-900 px-2 py-1 rounded-md hover:bg-orange-50 transition-colors"
                                                    title="Mark as Partially Paid">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 2a10 10 0 100 20 10 10 0 000-20z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 2v20">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Payment Status Toggle -->
                                        @if (!$order->paid)
                                            <form action="{{ route('orders.mark-paid', $order->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-green-600 hover:text-green-900 px-2 py-1 rounded-md hover:bg-green-50 transition-colors"
                                                    title="Mark as Paid">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('orders.mark-unpaid', $order->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 px-2 py-1 rounded-md hover:bg-red-50 transition-colors"
                                                    title="Mark as Unpaid">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        @if ($order->status !== 'completed' && $order->status !== 'cancelled')
                                            <form action="{{ route('orders.mark-completed', $order->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-purple-600 hover:text-purple-900 px-2 py-1 rounded-md hover:bg-purple-50 transition-colors"
                                                    title="Mark as Completed">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Cancel Booking -->
                                        @if ($order->status != 'cancelled')
                                            <form action="{{ route('order.cancel', $order->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 px-2 py-1 rounded-md hover:bg-red-50 transition-colors"
                                                    title="Cancel Booking">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        {{-- PENALTY BTN --}}
                                        <button type="button" onclick="openPenaltyModal({{ $order->id }})"
                                            class="text-red-600 hover:text-red-900 px-2 py-1 rounded-md hover:bg-red-50 transition-colors"
                                            title="Add Penalty">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </button>
    
                                        <!-- Penalty Modal-->
                                        <div id="penaltyModal-{{ $order->id }}" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex justify-center items-center">
                                            <div class="bg-white p-8 rounded-xl shadow-2xl w-96 border border-gray-100">
                                                <h2 class="text-xl font-bold text-gray-900 mb-6">Add Penalty</h2>
                                                <form action="{{ route('orders.add-penalty', $order->id) }}" method="POST">
                                                    @csrf
                                                    <div class="space-y-6">
                                                        <div>
                                                            <label class="block text-base font-medium text-gray-700 mb-2">
                                                                Penalty Amount (₱)
                                                            </label>
                                                            <input 
                                                                type="number" 
                                                                name="penalty_fee" 
                                                                step="0.01"
                                                                min="0"
                                                                placeholder="Enter amount..."
                                                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-500  transition-colors duration-200"
                                                                required>
                                                        </div>
                                                        
                                                        <div class="flex justify-end gap-3 mt-8">
                                                            <button 
                                                                type="button"
                                                                onclick="closePenaltyModal({{ $order->id }})"
                                                                class="px-4 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors duration-200">
                                                                Cancel
                                                            </button>
                                                            <button 
                                                                type="submit"
                                                                class="px-4 py-2.5 text-white bg-red-500 hover:bg-red-600 rounded-lg font-medium shadow-sm hover:shadow-red-200 transition-all duration-200">
                                                                Add Penalty
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> 
                                    {{-- end div of actions --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row items-center justify-between">
                        <div class="mb-4 sm:mb-0 text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $orders->firstItem() }}</span> to <span
                                class="font-medium">{{ $orders->lastItem() }}</span> of <span
                                class="font-medium">{{ $orders->total() }}</span> results
                        </div>
                        <div>
                            {{ $orders->onEachSide(1)->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- CALENDAR EVENTS --}}
    @php
        $calendarEvents = $orders
            ->map(function ($order) {
                $status = strtolower($order->status);
                // Set default color to blue
                $color = '#3b82f6';
                if ($status === 'pending') {
                    $color = '#FBBF24'; // Amber
                } elseif ($status === 'partially paid') {
                    $color = '#F59E0B'; // Orange
                } elseif ($status === 'ongoing') {
                    $color = '#60A5FA'; // Light blue
                } elseif ($status === 'paid') {
                    $color = '#10B981'; // Green
                } elseif ($status === 'completed') {
                    $color = '#34D399'; // Light green
                } elseif ($status === 'cancelled') {
                    $color = '#EF4444'; // Red
                }
                return [
                    'title' => $order->event_type, // e.g., "Birthday"
                    'start' => $order->event_date_start, // Format: YYYY-MM-DD
                    // End date is exclusive in FullCalendar.
                    'end' => \Carbon\Carbon::parse($order->event_date_end)->addDay()->toDateString(),
                    'start_time' => $order->event_start_time, // e.g., "00:24:00"
                    'end_time' => $order->event_start_end, // e.g., "15:24:00"
                    'status' => $order->status,
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                ];
            })
            ->toArray();
    @endphp

    {{-- CALENDAR BOOKINGS --}}
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center font-serif">Event Calendar</h1>

            <!-- Calendar Container -->
            <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
                <div id="calendar" class="p-4 md:p-6 min-h-[680px]"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        // penalty modal
        function openPenaltyModal(orderId) {
            document.getElementById(`penaltyModal-${orderId}`).classList.remove('hidden');
        }

        function closePenaltyModal(orderId) {
            document.getElementById(`penaltyModal-${orderId}`).classList.add('hidden');
        }
        //  function to convert "HH:mm:ss" into a 12-hour format with AM/PM.
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

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var events = @json($calendarEvents);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay listMonth'
                },
                views: {
                    listMonth: {
                        buttonText: 'List View'
                    }
                },
                contentHeight: 'auto',
                events: events,
                eventClassNames: 'hover:shadow-md transition-shadow',
                dayHeaderClassNames: 'text-gray-700 font-semibold',
                // AM/PM format.
                eventContent: function(arg) {
                    var title = arg.event.title;
                    var startTime = formatTime(arg.event.extendedProps.start_time);
                    var endTime = formatTime(arg.event.extendedProps.end_time);
                    return {
                        html: `<div class="px-2 py-1 text-sm font-medium">
                        ${title}<br>
                        <span class="text-xs text-white">${startTime} - ${endTime}</span>
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
                windowResize: function(view) {
                    if (window.innerWidth < 768) {
                        calendar.changeView('dayGridMonth');
                    }
                }
            });

            calendar.render();
        });
    </script>

    <style>
        .fc-toolbar-title {
            @apply text-xl font-bold text-gray-800 font-serif;
        }

        .fc-button-primary {
            @apply bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 shadow-sm font-medium rounded-lg transition-colors;
        }

        .fc-button-active {
            @apply bg-blue-100 text-blue-600 border-blue-200;
        }

        .fc-daygrid-day-number {
            @apply text-gray-600 font-medium;
        }

        .fc-daygrid-day {
            @apply hover:bg-gray-50 transition-colors;
        }

        .fc-event {
            @apply rounded-lg border-none shadow-sm;
        }

        .fc-today {
            @apply bg-blue-50;
        }
    </style>


</div>


<script>
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const statusFilter = document.getElementById('status').value.trim().toLowerCase();
        const dateFrom = document.getElementById('date_from').value;
        const dateTo = document.getElementById('date_to').value;

        const rows = document.querySelectorAll('#ordersTable tbody tr');

        rows.forEach(function(row) {
            const rowStatus = row.dataset.status;
            const rowDate = row.dataset.date;


            let showRow = true;

            if (statusFilter && rowStatus !== statusFilter) {
                showRow = false;
            }

            if (dateFrom && rowDate < dateFrom) {
                showRow = false;
            }

            if (dateTo && rowDate > dateTo) {
                showRow = false;
            }

            row.style.display = showRow ? '' : 'none';
        });
    });
</script>
