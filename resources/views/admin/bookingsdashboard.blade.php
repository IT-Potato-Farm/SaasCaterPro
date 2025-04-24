<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Dashboard</title>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="{{ asset('js/toprightalert.js') }}"></script>
    


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
    <script>
        function confirmDelete(form) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This order will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

            return false;
        }

        function confirmAction(message, event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });

            return false;
        }
    </script>
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


        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 border">
            <x-dashboard.header />


            <div class="container mx-auto px-4 py-8 ">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 ">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0 ">All Bookingas</h1>
                    <div class="flex space-x-3">
                        <!-- Refresh -->
                        <a href="{{ route('admin.bookings') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Refresh
                        </a>
                        {{-- <button onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                </path>
                            </svg>
                            Print
                        </button> --}}

                        <!-- Export -->
                        {{-- <button
                            class="hover:cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs hover:bg-gray-200 text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Export
                        </button> --}}
                    </div>
                </div>


                <!-- Filter Section -->
                <div class="mb-6 bg-white rounded-lg shadow-sm p-4 ">
                    <form id="filterForm" action="{{ route('orders.filter') }}" method="GET"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="col-span-1">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partially
                                    Paid
                                </option>
                                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>
                        </div>


                        <div class="col-span-1">
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date
                                From</label>
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
                                class="inline-flex justify-center w-full px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 hover:cursor-pointer active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                                Filter Results
                            </button>
                        </div>
                    </form>
                </div>

                @if ($orders->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg class="w-20 h-20 mx-auto text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">No bookings found</h3>
                        
                        <div class="mt-6">
                            <a href="{{ route('admin.admindashboard') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                                Reset Filters
                            </a>
                        </div>
                    </div>
                @else
                    {{-- <div class="bg-white rounded-lg shadow overflow-hidden"> --}}

                    <div class=" px-4 sm:px-6 lg:px-8 overflow-x-auto ">
                        <table id="ordersTable" class="min-w-full divide-y divide-gray-200 ">
                            <thead class="bg-gray-50 hidden sm:table-header-group">
                                <tr>
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order ID
                                    </th>
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Event Details
                                    </th>
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col"
                                        class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class=" px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors"
                                        data-status="{{ strtolower($order->status) }}"
                                        data-date="{{ \Carbon\Carbon::parse($order->event_date)->format('Y-m-d') }}">
                                        <!-- Mobile First Column (Order ID + Status) -->
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap sm:whitespace-normal">
                                            <div class="sm:hidden flex justify-between items-start ">
                                                <div>
                                                    <a href="{{ route('order.show', $order->id) }}"
                                                        class="hover:underline text-sm font-medium text-gray-900">
                                                        #{{ $order->id }}
                                                    </a>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $order->created_at->format('M d, Y') }}</div>
                                                </div>

                                            </div>
                                            <div class="hidden sm:block ">
                                                <a href="{{ route('order.show', $order->id) }}"
                                                    class="hover:underline text-sm font-medium text-gray-900">
                                                    #{{ $order->id }}
                                                </a>
                                                <div class="text-xs text-gray-500">
                                                    {{ $order->created_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Customer Info -->
                                        <td class="px-3 sm:px-6 py-4 ">
                                            <div class="flex items-center gap-3">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $order->user->first_name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">{{ $order->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Event Details -->
                                        <td class="px-3 sm:px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $order->event_type }}</div>
                                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($order->event_date_start)->format('M d, Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($order->event_date_end)->format('M d, Y') }}
                                            </div>
                                        </td>

                                        <!-- Total -->
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right">
                                            <div class="text-sm font-medium text-gray-900">
                                                ₱{{ number_format($order->total, 2) }}
                                            </div>
                                            {{-- @if ($order->deposit_amount)
                                                    <div class="text-xs text-gray-500">
                                                        Deposit: ₱{{ number_format($order->deposit_amount, 2) }}
                                                    </div>
                                                @endif --}}

                                            {{-- @if ($order->penalty_fee > 0)
                                                    <div class="text-xs text-red-500">
                                                        Penalty: +₱{{ number_format($order->penalty_fee, 2) }}
                                                    </div>
                                                @endif --}}
                                        </td>

                                        <!-- Status -->
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                           
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->bgColor }} {{ $order->textColor }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                        </td>



                                        <!-- Actions -->
                                        <td class=" px-3 sm:px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-1 sm:gap-2 items-center">
                                                <!-- Invoice -->
                                                <x-actions.invoice-button :order="$order" />
                                                <!-- Ongoing Action -->
                                                @if ($order->status !== 'ongoing' && $order->status !== 'cancelled' && $order->status !== 'paid')
                                                    <x-actions.ongoing-button :order="$order" />
                                                @endif

                                                <!-- Partially Paid Action -->
                                                @if ($order->status !== 'partial' && $order->status !== 'cancelled' && $order->status !== 'paid')
                                                    <x-actions.partial-button :order="$order" />
                                                @endif

                                                <!-- Payment Status Toggle -->
                                                @if (!$order->paid)
                                                    <x-actions.paid-button :order="$order" />
                                                @else
                                                    <x-actions.unpaid-button :order="$order" />
                                                @endif

                                                <!-- Mark Complete -->
                                                @if ($order->status !== 'completed' && $order->status !== 'cancelled')
                                                    <x-actions.completed-button :order="$order" />
                                                @endif

                                                <!-- Cancel Booking -->
                                                @if ($order->status != 'cancelled')
                                                    <x-actions.cancel-button :order="$order" />
                                                @endif

                                                <!-- Penalty Button -->
                                                <x-actions.penalty-button :order="$order" />


                                                <!-- Delete Button -->
                                                <x-actions.delete-button :order="$order" />

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p id="noResultsMessage" style="display: none;">No orders found for this filter.</p>

                    </div>

                    <!-- Pagination -->
                    @if ($orders->hasPages())
                        <div class="px-4 sm:px-6 py-4 border-t border-gray-200 bg-gray-50">
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
                    {{-- </div> --}}
                @endif

                {{-- CALENDAR EVENTS --}}
                @php
                    use Carbon\Carbon;
                    $calendarEvents = $orders
                        // SORT CALENDAR FORMAT PARA MAUNA UNG NKA BASED SA TIME
                        ->sortBy(function ($order) {
                            // Parse the full datetime (date + time) for accurate sorting
                            return Carbon::parse($order->event_date_start . ' ' . $order->event_start_time)->timestamp;
                        })

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
                            // Parse start date and time properly
                            return [
                                'title' => $order->event_type, // e.g., "Birthday"
                                'start' => $order->event_date_start, // Format: YYYY-MM-DD

                                'end' => Carbon::parse($order->event_date_end)->addDay()->toDateString(),
                                'start_time' => $order->event_start_time,
                                'end_time' => $order->event_start_end,
                                'status' => $order->status,
                                'backgroundColor' => $color,
                                'borderColor' => $color,
                            ];
                        })
                        ->values()
                        ->toArray();
                @endphp


                {{-- CALENDAR BOOKINGS --}}
                <div class="container mx-auto px-4 py-6 sm:py-8 ">
                    <div class="max-w-6xl mx-auto">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6 text-center font-serif">
                            Event Calendar
                        </h1>

                        <!-- Calendar Container -->
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                            <div id="calendar"
                                class="p-3 sm:p-4 md:p-6 min-h-[480px] sm:min-h-[600px] md:min-h-[680px]"></div>
                        </div>
                    </div>
                </div>

            </div>


        </main>

    </div>
    {{-- BOOKING CALENDAR JS --}}
    <script>
        window.calendarEvents = @json($calendarEvents);
    </script>
    <script src="{{ asset('js/calendar-event-booking.js') }}"></script>

    {{-- BOOKING FILTER --}}
    <script src="{{ asset('js/filter-booking.js') }}"></script>
</body>

</html>
